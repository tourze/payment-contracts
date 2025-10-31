<?php

declare(strict_types=1);

namespace Tourze\PaymentContracts\Interface;

interface PaymentManagerInterface
{
    /**
     * 发起支付
     *
     * @param array<string, mixed> $paymentData
     * @return array<string, mixed>
     */
    public function initiatePayment(array $paymentData): array;

    /**
     * 查询支付状态
     */
    public function getPaymentStatus(string $paymentId): string;

    /**
     * 取消支付
     */
    public function cancelPayment(string $paymentId): bool;
}
