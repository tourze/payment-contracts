<?php

declare(strict_types=1);

namespace Tourze\PaymentContracts\Tests\ValueObject;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\PaymentContracts\Exception\InvalidAttachDataException;
use Tourze\PaymentContracts\ValueObject\AttachData;

/**
 * @internal
 */
#[CoversClass(AttachData::class)]
class AttachDataTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $attachData = new AttachData(123, 'ORD001', 'order', ['key' => 'value']);

        $this->assertSame(123, $attachData->getOrderId());
        $this->assertSame('ORD001', $attachData->getOrderSn());
        $this->assertSame('order', $attachData->getType());
        $this->assertSame(['key' => 'value'], $attachData->getExtra());
    }

    public function testEncode(): void
    {
        $attachData = new AttachData(123, 'ORD001', 'order', ['key' => 'value']);
        $json = $attachData->encode();

        $decoded = json_decode($json, true);
        $this->assertSame([
            'order_id' => 123,
            'order_sn' => 'ORD001',
            'type' => 'order',
            'extra' => ['key' => 'value'],
        ], $decoded);
    }

    public function testEncodeWithoutExtra(): void
    {
        $attachData = new AttachData(123, 'ORD001');
        $json = $attachData->encode();

        $decoded = json_decode($json, true);
        $this->assertSame([
            'order_id' => 123,
            'order_sn' => 'ORD001',
            'type' => 'order',
        ], $decoded);
    }

    public function testDecodeSuccess(): void
    {
        $json = '{"order_id":123,"order_sn":"ORD001","type":"order","extra":{"key":"value"}}';
        $attachData = AttachData::decode($json);

        $this->assertSame(123, $attachData->getOrderId());
        $this->assertSame('ORD001', $attachData->getOrderSn());
        $this->assertSame('order', $attachData->getType());
        $this->assertSame(['key' => 'value'], $attachData->getExtra());
    }

    public function testDecodeWithEmptyString(): void
    {
        $this->expectException(InvalidAttachDataException::class);
        $this->expectExceptionMessage('Attach data cannot be empty');

        AttachData::decode('');
    }

    public function testDecodeWithMissingOrderId(): void
    {
        $this->expectException(InvalidAttachDataException::class);
        $this->expectExceptionMessage('Missing or invalid order_id in attach data');

        AttachData::decode('{"order_sn":"ORD001"}');
    }

    public function testDecodeWithMissingOrderSn(): void
    {
        $this->expectException(InvalidAttachDataException::class);
        $this->expectExceptionMessage('Missing or invalid order_sn in attach data');

        AttachData::decode('{"order_id":123}');
    }

    public function testFromLegacyFormatSuccess(): void
    {
        $attachData = AttachData::fromLegacyFormat('order_id_123');

        $this->assertNotNull($attachData);
        $this->assertSame(123, $attachData->getOrderId());
        $this->assertSame('', $attachData->getOrderSn());
        $this->assertSame('order', $attachData->getType());
    }

    public function testFromLegacyFormatFailed(): void
    {
        $attachData = AttachData::fromLegacyFormat('invalid_format');

        $this->assertNull($attachData);
    }

    public function testParseNewFormat(): void
    {
        $json = '{"order_id":123,"order_sn":"ORD001","type":"order"}';
        $attachData = AttachData::parse($json);

        $this->assertNotNull($attachData);
        $this->assertSame(123, $attachData->getOrderId());
        $this->assertSame('ORD001', $attachData->getOrderSn());
    }

    public function testParseLegacyFormat(): void
    {
        $attachData = AttachData::parse('order_id_123');

        $this->assertNotNull($attachData);
        $this->assertSame(123, $attachData->getOrderId());
    }

    public function testParseInvalidFormat(): void
    {
        $attachData = AttachData::parse('invalid_format');

        $this->assertNull($attachData);
    }
}
