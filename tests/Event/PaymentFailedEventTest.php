<?php

declare(strict_types=1);

namespace Tourze\PaymentContracts\Tests\Event;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\PaymentContracts\Enum\PaymentType;
use Tourze\PaymentContracts\Event\PaymentFailedEvent;

/**
 * @internal
 */
#[CoversClass(PaymentFailedEvent::class)]
class PaymentFailedEventTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $paymentType = PaymentType::WECHAT_MINI_PROGRAM;
        $orderNumber = 'ORD202401010001';
        $orderId = 123;
        $failReason = '支付验证失败';
        $rawData = ['error' => 'invalid_signature'];

        $event = new PaymentFailedEvent(
            $paymentType,
            $orderNumber,
            $orderId,
            $failReason,
            $rawData
        );

        $this->assertSame($paymentType, $event->getPaymentType());
        $this->assertSame($orderNumber, $event->getOrderNumber());
        $this->assertSame($orderId, $event->getOrderId());
        $this->assertSame($failReason, $event->getFailReason());
        $this->assertSame($rawData, $event->getRawData());
    }

    public function testConstructorWithoutRawData(): void
    {
        $paymentType = PaymentType::ALIPAY_APP;
        $orderNumber = 'ORD202401010002';
        $orderId = 456;
        $failReason = '余额不足';

        $event = new PaymentFailedEvent(
            $paymentType,
            $orderNumber,
            $orderId,
            $failReason
        );

        $this->assertSame($paymentType, $event->getPaymentType());
        $this->assertSame($orderNumber, $event->getOrderNumber());
        $this->assertSame($orderId, $event->getOrderId());
        $this->assertSame($failReason, $event->getFailReason());
        $this->assertSame([], $event->getRawData());
    }
}
