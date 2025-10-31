<?php

declare(strict_types=1);

namespace Tourze\PaymentContracts\Event;

use Tourze\PaymentContracts\Enum\PaymentType;

/**
 * 支付参数请求事件
 *
 * 用于在支付流程中获取真实的支付网关参数
 */
class PaymentParametersRequestedEvent
{
    /**
     * @var array<string, mixed>|null 支付参数响应
     */
    private ?array $paymentParams = null;

    /**
     * @param string $paymentType 支付类型 (如: alipay, wechat_pay, bank_card)
     * @param float $amount 支付金额
     * @param string $orderNumber 支付订单编号
     * @param int|null $orderId 订单ID
     * @param string|null $orderState 订单状态
     * @param string|null $requestTime 请求时间
     * @param string|null $appId 应用ID
     * @param string|null $mchId 商户ID
     * @param string|null $description 支付描述
     * @param string|null $attach 附加数据
     * @param string|null $openId 用户OpenID
     * @param string|null $notifyUrl 回调通知URL
     * @param PaymentType|null $paymentTypeEnum 支付类型枚举
     */
    public function __construct(
        private readonly string $paymentType,
        private readonly float $amount,
        private readonly string $orderNumber,
        private readonly ?int $orderId = null,
        private readonly ?string $orderState = null,
        private readonly ?string $requestTime = null,
        private readonly ?string $appId = null,
        private readonly ?string $mchId = null,
        private readonly ?string $description = null,
        private readonly ?string $attach = null,
        private readonly ?string $openId = null,
        private readonly ?string $notifyUrl = null,
        private readonly ?PaymentType $paymentTypeEnum = null,
    ) {
    }

    /**
     * 获取支付类型
     */
    public function getPaymentType(): string
    {
        return $this->paymentType;
    }

    /**
     * 获取支付金额
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * 获取支付订单编号
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    /**
     * 获取订单ID
     */
    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    /**
     * 获取订单状态
     */
    public function getOrderState(): ?string
    {
        return $this->orderState;
    }

    /**
     * 获取请求时间
     */
    public function getRequestTime(): ?string
    {
        return $this->requestTime;
    }

    /**
     * 获取应用ID
     */
    public function getAppId(): ?string
    {
        return $this->appId;
    }

    /**
     * 获取商户ID
     */
    public function getMchId(): ?string
    {
        return $this->mchId;
    }

    /**
     * 获取支付描述
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * 获取附加数据
     */
    public function getAttach(): ?string
    {
        return $this->attach;
    }

    /**
     * 获取用户OpenID
     */
    public function getOpenId(): ?string
    {
        return $this->openId;
    }

    /**
     * 获取回调通知URL
     */
    public function getNotifyUrl(): ?string
    {
        return $this->notifyUrl;
    }

    /**
     * 获取支付类型枚举
     */
    public function getPaymentTypeEnum(): ?PaymentType
    {
        return $this->paymentTypeEnum;
    }

    /**
     * 获取额外参数（向后兼容方法）
     *
     * @return array<string, mixed>
     */
    public function getExtraParams(): array
    {
        return array_filter([
            'orderId' => $this->orderId,
            'orderState' => $this->orderState,
            'requestTime' => $this->requestTime,
            'appId' => $this->appId,
            'mchId' => $this->mchId,
            'description' => $this->description,
            'attach' => $this->attach,
            'openId' => $this->openId,
            'notifyUrl' => $this->notifyUrl,
            'paymentType' => $this->paymentTypeEnum,
        ], fn ($value) => null !== $value);
    }

    /**
     * 设置支付参数响应
     *
     * @param array<string, mixed> $params
     */
    public function setPaymentParams(array $params): void
    {
        $this->paymentParams = $params;
    }

    /**
     * 获取支付参数响应
     *
     * @return array<string, mixed>|null
     */
    public function getPaymentParams(): ?array
    {
        return $this->paymentParams;
    }

    /**
     * 检查是否已设置支付参数
     */
    public function hasPaymentParams(): bool
    {
        return null !== $this->paymentParams;
    }
}
