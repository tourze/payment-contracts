<?php

declare(strict_types=1);

namespace Tourze\PaymentContracts\Enum;

use Tourze\EnumExtra\Itemable;
use Tourze\EnumExtra\ItemTrait;
use Tourze\EnumExtra\Labelable;
use Tourze\EnumExtra\Selectable;
use Tourze\EnumExtra\SelectTrait;

/**
 * 支付类型枚举
 *
 * 统一管理所有支付渠道类型
 */
enum PaymentType: string implements Labelable, Itemable, Selectable
{
    use ItemTrait;
    use SelectTrait;

    case WECHAT_MINI_PROGRAM = 'wechat_mini_program';
    case WECHAT_OFFICIAL_ACCOUNT = 'wechat_official_account';
    case WECHAT_JSAPI = 'wechat_jsapi';
    case WECHAT_APP = 'wechat_app';
    case ALIPAY_H5 = 'alipay_h5';
    case ALIPAY_APP = 'alipay_app';

    // 兼容旧版本的支付方式
    case LEGACY_WECHAT_PAY = 'wechat_pay';
    case LEGACY_ALIPAY = 'alipay';
    case BANK_CARD = 'bank_card';
    case BALANCE = 'balance';

    public function getLabel(): string
    {
        return match ($this) {
            self::WECHAT_MINI_PROGRAM => '微信小程序支付',
            self::WECHAT_OFFICIAL_ACCOUNT => '微信公众号支付',
            self::WECHAT_JSAPI => '微信JSAPI支付',
            self::WECHAT_APP => '微信APP支付',
            self::ALIPAY_H5 => '支付宝H5支付',
            self::ALIPAY_APP => '支付宝APP支付',
            self::LEGACY_WECHAT_PAY => '微信支付（通用）',
            self::LEGACY_ALIPAY => '支付宝（通用）',
            self::BANK_CARD => '银行卡支付',
            self::BALANCE => '余额支付',
        };
    }

    /**
     * 判断是否为微信支付相关类型
     */
    public function isWechatPayment(): bool
    {
        return match ($this) {
            self::WECHAT_MINI_PROGRAM,
            self::WECHAT_OFFICIAL_ACCOUNT,
            self::WECHAT_JSAPI,
            self::WECHAT_APP,
            self::LEGACY_WECHAT_PAY => true,
            default => false,
        };
    }

    /**
     * 判断是否为支付宝相关类型
     */
    public function isAlipayPayment(): bool
    {
        return match ($this) {
            self::ALIPAY_H5,
            self::ALIPAY_APP,
            self::LEGACY_ALIPAY => true,
            default => false,
        };
    }

    /**
     * 判断是否为第三方支付
     */
    public function isThirdPartyPayment(): bool
    {
        return $this->isWechatPayment() || $this->isAlipayPayment();
    }

    /**
     * 获取支付渠道标识
     */
    public function getChannel(): string
    {
        return match ($this) {
            self::WECHAT_MINI_PROGRAM,
            self::WECHAT_OFFICIAL_ACCOUNT,
            self::WECHAT_JSAPI,
            self::WECHAT_APP,
            self::LEGACY_WECHAT_PAY => 'wechat',
            self::ALIPAY_H5,
            self::ALIPAY_APP,
            self::LEGACY_ALIPAY => 'alipay',
            self::BANK_CARD => 'bank',
            self::BALANCE => 'balance',
        };
    }

    /**
     * 从字符串值创建枚举（向后兼容）
     */
    public static function fromValue(string $value): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }

        return null;
    }

    /**
     * 获取所有支付类型的值数组
     *
     * @return array<string>
     */
    public static function getValues(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}
