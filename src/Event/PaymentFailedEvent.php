<?php

declare(strict_types=1);

namespace Tourze\PaymentContracts\Event;

use Tourze\PaymentContracts\Enum\PaymentType;

/**
 * 通用支付失败事件
 *
 * 用于解耦支付模块与订单模块，支付失败后发布此事件
 */
class PaymentFailedEvent
{
    /**
     * @param PaymentType $paymentType 支付类型
     * @param string $orderNumber 订单编号
     * @param int $orderId 订单ID
     * @param string $failReason 失败原因
     * @param array<string, mixed> $rawData 原始回调数据
     */
    public function __construct(
        private readonly PaymentType $paymentType,
        private readonly string $orderNumber,
        private readonly int $orderId,
        private readonly string $failReason,
        private readonly array $rawData = [],
    ) {
    }

    /**
     * 获取支付类型
     */
    public function getPaymentType(): PaymentType
    {
        return $this->paymentType;
    }

    /**
     * 获取订单编号
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    /**
     * 获取订单ID
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * 获取失败原因
     */
    public function getFailReason(): string
    {
        return $this->failReason;
    }

    /**
     * 获取原始回调数据
     *
     * @return array<string, mixed>
     */
    public function getRawData(): array
    {
        return $this->rawData;
    }
}
