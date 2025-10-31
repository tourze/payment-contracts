<?php

declare(strict_types=1);

namespace Tourze\PaymentContracts\Tests\Event;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\PaymentContracts\Enum\PaymentType;
use Tourze\PaymentContracts\Event\PaymentSuccessEvent;

/**
 * @internal
 */
#[CoversClass(PaymentSuccessEvent::class)]
class PaymentSuccessEventTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $paymentType = PaymentType::WECHAT_MINI_PROGRAM;
        $orderNumber = 'ORD202401010001';
        $orderId = 123;
        $transactionId = 'WX123456789';
        $amount = 99.99;
        $payTime = new \DateTimeImmutable('2024-01-01 12:00:00');
        $rawData = ['key' => 'value'];

        $event = new PaymentSuccessEvent(
            $paymentType,
            $orderNumber,
            $orderId,
            $transactionId,
            $amount,
            $payTime,
            $rawData
        );

        $this->assertSame($paymentType, $event->getPaymentType());
        $this->assertSame($orderNumber, $event->getOrderNumber());
        $this->assertSame($orderId, $event->getOrderId());
        $this->assertSame($transactionId, $event->getTransactionId());
        $this->assertSame($amount, $event->getAmount());
        $this->assertSame($payTime, $event->getPayTime());
        $this->assertSame($rawData, $event->getRawData());
    }

    public function testConstructorWithoutRawData(): void
    {
        $paymentType = PaymentType::ALIPAY_H5;
        $orderNumber = 'ORD202401010002';
        $orderId = 456;
        $transactionId = 'ALI789012345';
        $amount = 199.99;
        $payTime = new \DateTimeImmutable('2024-01-02 15:30:00');

        $event = new PaymentSuccessEvent(
            $paymentType,
            $orderNumber,
            $orderId,
            $transactionId,
            $amount,
            $payTime
        );

        $this->assertSame($paymentType, $event->getPaymentType());
        $this->assertSame($orderNumber, $event->getOrderNumber());
        $this->assertSame($orderId, $event->getOrderId());
        $this->assertSame($transactionId, $event->getTransactionId());
        $this->assertSame($amount, $event->getAmount());
        $this->assertSame($payTime, $event->getPayTime());
        $this->assertSame([], $event->getRawData());
    }
}
