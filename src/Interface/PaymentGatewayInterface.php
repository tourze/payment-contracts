<?php

declare(strict_types=1);

namespace Tourze\PaymentContracts\Interface;

interface PaymentGatewayInterface
{
    /**
     * 获取支付参数
     *
     * @param array<string, mixed> $params 支付请求参数
     * @return array<string, mixed>
     */
    public function getPaymentParams(array $params): array;

    /**
     * 获取支持的支付类型
     */
    public function getSupportedPaymentType(): string;

    /**
     * 验证支付参数
     *
     * @param array<string, mixed> $params
     */
    public function validatePaymentParams(array $params): bool;
}
