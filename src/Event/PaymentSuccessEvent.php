<?php

declare(strict_types=1);

namespace Tourze\PaymentContracts\Event;

use Tourze\PaymentContracts\Enum\PaymentType;

/**
 * 通用支付成功事件
 *
 * 用于解耦支付模块与订单模块，支付成功后发布此事件
 */
class PaymentSuccessEvent
{
    /**
     * @param PaymentType $paymentType 支付类型
     * @param string $orderNumber 订单编号
     * @param int $orderId 订单ID
     * @param string $transactionId 第三方交易号
     * @param float $amount 实际支付金额
     * @param \DateTimeInterface $payTime 支付时间
     * @param array<string, mixed> $rawData 原始回调数据
     */
    public function __construct(
        private readonly PaymentType $paymentType,
        private readonly string $orderNumber,
        private readonly int $orderId,
        private readonly string $transactionId,
        private readonly float $amount,
        private readonly \DateTimeInterface $payTime,
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
     * 获取第三方交易号
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * 获取实际支付金额
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * 获取支付时间
     */
    public function getPayTime(): \DateTimeInterface
    {
        return $this->payTime;
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
