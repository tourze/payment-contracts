<?php

declare(strict_types=1);

namespace Tourze\PaymentContracts\ValueObject;

use Tourze\PaymentContracts\Exception\InvalidAttachDataException;

/**
 * 支付附加数据值对象
 *
 * 用于标准化支付请求中的 attach 字段格式
 */
class AttachData
{
    /**
     * @param int $orderId 订单ID
     * @param string $orderSn 订单编号
     * @param string $type 数据类型，默认为 'order'
     * @param array<string, mixed> $extra 额外数据
     */
    public function __construct(
        private readonly int $orderId,
        private readonly string $orderSn,
        private readonly string $type = 'order',
        private readonly array $extra = [],
    ) {
    }

    /**
     * 获取订单ID
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * 获取订单编号
     */
    public function getOrderSn(): string
    {
        return $this->orderSn;
    }

    /**
     * 获取数据类型
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * 获取额外数据
     *
     * @return array<string, mixed>
     */
    public function getExtra(): array
    {
        return $this->extra;
    }

    /**
     * 编码为 JSON 字符串
     */
    public function encode(): string
    {
        $data = [
            'order_id' => $this->orderId,
            'order_sn' => $this->orderSn,
            'type' => $this->type,
        ];

        if ([] !== $this->extra) {
            $data['extra'] = $this->extra;
        }

        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    /**
     * 从 JSON 字符串解码
     *
     * @throws \JsonException 当JSON格式无效时
     * @throws InvalidAttachDataException 当必需字段缺失时
     */
    public static function decode(string $attachJson): self
    {
        if ('' === $attachJson) {
            throw new InvalidAttachDataException('Attach data cannot be empty');
        }

        /** @var array<string, mixed> $data */
        $data = json_decode($attachJson, true, 512, JSON_THROW_ON_ERROR);

        if (!isset($data['order_id']) || !is_int($data['order_id'])) {
            throw new InvalidAttachDataException('Missing or invalid order_id in attach data');
        }

        if (!isset($data['order_sn']) || !is_string($data['order_sn'])) {
            throw new InvalidAttachDataException('Missing or invalid order_sn in attach data');
        }

        return new self(
            orderId: $data['order_id'],
            orderSn: $data['order_sn'],
            type: $data['type'] ?? 'order',
            extra: $data['extra'] ?? [],
        );
    }

    /**
     * 从旧格式的 attach 字符串解析（兼容性方法）
     * 格式：order_id_123
     */
    public static function fromLegacyFormat(string $attach): ?self
    {
        if (1 === preg_match('/^order_id_(\d+)$/', $attach, $matches)) {
            $orderId = (int) $matches[1];

            return new self(
                orderId: $orderId,
                orderSn: '', // 旧格式没有订单编号，需要从数据库查询
                type: 'order'
            );
        }

        return null;
    }

    /**
     * 尝试从字符串解析，优先使用新格式，失败则尝试旧格式
     */
    public static function parse(string $attach): ?self
    {
        try {
            return self::decode($attach);
        } catch (\JsonException|InvalidAttachDataException) {
            return self::fromLegacyFormat($attach);
        }
    }
}
