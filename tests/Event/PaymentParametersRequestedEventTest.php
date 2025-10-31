<?php

declare(strict_types=1);

namespace Tourze\PaymentContracts\Tests\Event;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\PaymentContracts\Event\PaymentParametersRequestedEvent;

/**
 * @internal
 */
#[CoversClass(PaymentParametersRequestedEvent::class)]
class PaymentParametersRequestedEventTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $paymentType = 'wechat_pay';
        $amount = 99.99;
        $orderNumber = 'ORD202401010001';
        $orderId = 123;
        $openId = 'openid123';
        $description = '测试订单';
        $appId = 'wx123456789';

        $event = new PaymentParametersRequestedEvent(
            paymentType: $paymentType,
            amount: $amount,
            orderNumber: $orderNumber,
            orderId: $orderId,
            openId: $openId,
            description: $description,
            appId: $appId
        );

        $this->assertSame($paymentType, $event->getPaymentType());
        $this->assertSame($amount, $event->getAmount());
        $this->assertSame($orderNumber, $event->getOrderNumber());
        $this->assertSame($orderId, $event->getOrderId());
        $this->assertSame($openId, $event->getOpenId());
        $this->assertSame($description, $event->getDescription());
        $this->assertSame($appId, $event->getAppId());

        // 测试向后兼容的 getExtraParams 方法
        $extraParams = $event->getExtraParams();
        $this->assertArrayHasKey('orderId', $extraParams);
        $this->assertArrayHasKey('openId', $extraParams);
        $this->assertArrayHasKey('description', $extraParams);
        $this->assertArrayHasKey('appId', $extraParams);
        $this->assertSame($orderId, $extraParams['orderId']);
        $this->assertSame($openId, $extraParams['openId']);

        $this->assertFalse($event->hasPaymentParams());
        $this->assertNull($event->getPaymentParams());
    }

    public function testSetAndGetPaymentParams(): void
    {
        $event = new PaymentParametersRequestedEvent(
            paymentType: 'alipay',
            amount: 50.0,
            orderNumber: 'ORD202401010002'
        );

        $paymentParams = [
            'paymentId' => 'PAY123456',
            'paymentUrl' => 'https://pay.example.com',
        ];

        $event->setPaymentParams($paymentParams);

        $this->assertTrue($event->hasPaymentParams());
        $this->assertSame($paymentParams, $event->getPaymentParams());
    }

    public function testEmptyExtraParams(): void
    {
        $event = new PaymentParametersRequestedEvent(
            paymentType: 'bank_card',
            amount: 100.0,
            orderNumber: 'ORD202401010003'
        );

        // 当所有可选参数都为 null 时，getExtraParams 应该返回空数组
        $this->assertSame([], $event->getExtraParams());
    }

    public function testNullableFields(): void
    {
        $event = new PaymentParametersRequestedEvent(
            paymentType: 'wechat_pay',
            amount: 100.0,
            orderNumber: 'ORD202401010004',
            orderId: null,
            orderState: null,
            openId: null
        );

        $this->assertNull($event->getOrderId());
        $this->assertNull($event->getOrderState());
        $this->assertNull($event->getOpenId());
        $this->assertNull($event->getAppId());
        $this->assertNull($event->getMchId());
        $this->assertNull($event->getDescription());
        $this->assertNull($event->getAttach());
        $this->assertNull($event->getNotifyUrl());
        $this->assertNull($event->getPaymentTypeEnum());
    }
}
