<?php

declare(strict_types=1);

namespace Tourze\PaymentContracts\Tests\Enum;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PaymentContracts\Enum\PaymentType;
use Tourze\PHPUnitEnum\AbstractEnumTestCase;

/**
 * PaymentType 枚举测试
 * @internal
 */
#[CoversClass(PaymentType::class)]
class PaymentTypeTest extends AbstractEnumTestCase
{
    public function testGetLabel(): void
    {
        $this->assertSame('微信小程序支付', PaymentType::WECHAT_MINI_PROGRAM->getLabel());
        $this->assertSame('微信公众号支付', PaymentType::WECHAT_OFFICIAL_ACCOUNT->getLabel());
        $this->assertSame('微信JSAPI支付', PaymentType::WECHAT_JSAPI->getLabel());
        $this->assertSame('微信APP支付', PaymentType::WECHAT_APP->getLabel());
        $this->assertSame('支付宝H5支付', PaymentType::ALIPAY_H5->getLabel());
        $this->assertSame('支付宝APP支付', PaymentType::ALIPAY_APP->getLabel());
        $this->assertSame('微信支付（通用）', PaymentType::LEGACY_WECHAT_PAY->getLabel());
        $this->assertSame('支付宝（通用）', PaymentType::LEGACY_ALIPAY->getLabel());
        $this->assertSame('银行卡支付', PaymentType::BANK_CARD->getLabel());
        $this->assertSame('余额支付', PaymentType::BALANCE->getLabel());
    }

    public function testIsWechatPayment(): void
    {
        $this->assertTrue(PaymentType::WECHAT_MINI_PROGRAM->isWechatPayment());
        $this->assertTrue(PaymentType::WECHAT_OFFICIAL_ACCOUNT->isWechatPayment());
        $this->assertTrue(PaymentType::WECHAT_JSAPI->isWechatPayment());
        $this->assertTrue(PaymentType::WECHAT_APP->isWechatPayment());
        $this->assertTrue(PaymentType::LEGACY_WECHAT_PAY->isWechatPayment());

        $this->assertFalse(PaymentType::ALIPAY_H5->isWechatPayment());
        $this->assertFalse(PaymentType::ALIPAY_APP->isWechatPayment());
        $this->assertFalse(PaymentType::LEGACY_ALIPAY->isWechatPayment());
        $this->assertFalse(PaymentType::BANK_CARD->isWechatPayment());
        $this->assertFalse(PaymentType::BALANCE->isWechatPayment());
    }

    public function testIsAlipayPayment(): void
    {
        $this->assertTrue(PaymentType::ALIPAY_H5->isAlipayPayment());
        $this->assertTrue(PaymentType::ALIPAY_APP->isAlipayPayment());
        $this->assertTrue(PaymentType::LEGACY_ALIPAY->isAlipayPayment());

        $this->assertFalse(PaymentType::WECHAT_MINI_PROGRAM->isAlipayPayment());
        $this->assertFalse(PaymentType::WECHAT_OFFICIAL_ACCOUNT->isAlipayPayment());
        $this->assertFalse(PaymentType::WECHAT_JSAPI->isAlipayPayment());
        $this->assertFalse(PaymentType::WECHAT_APP->isAlipayPayment());
        $this->assertFalse(PaymentType::LEGACY_WECHAT_PAY->isAlipayPayment());
        $this->assertFalse(PaymentType::BANK_CARD->isAlipayPayment());
        $this->assertFalse(PaymentType::BALANCE->isAlipayPayment());
    }

    public function testIsThirdPartyPayment(): void
    {
        $this->assertTrue(PaymentType::WECHAT_MINI_PROGRAM->isThirdPartyPayment());
        $this->assertTrue(PaymentType::WECHAT_OFFICIAL_ACCOUNT->isThirdPartyPayment());
        $this->assertTrue(PaymentType::WECHAT_JSAPI->isThirdPartyPayment());
        $this->assertTrue(PaymentType::WECHAT_APP->isThirdPartyPayment());
        $this->assertTrue(PaymentType::LEGACY_WECHAT_PAY->isThirdPartyPayment());
        $this->assertTrue(PaymentType::ALIPAY_H5->isThirdPartyPayment());
        $this->assertTrue(PaymentType::ALIPAY_APP->isThirdPartyPayment());
        $this->assertTrue(PaymentType::LEGACY_ALIPAY->isThirdPartyPayment());

        $this->assertFalse(PaymentType::BANK_CARD->isThirdPartyPayment());
        $this->assertFalse(PaymentType::BALANCE->isThirdPartyPayment());
    }

    public function testGetChannel(): void
    {
        $this->assertSame('wechat', PaymentType::WECHAT_MINI_PROGRAM->getChannel());
        $this->assertSame('wechat', PaymentType::WECHAT_OFFICIAL_ACCOUNT->getChannel());
        $this->assertSame('wechat', PaymentType::WECHAT_JSAPI->getChannel());
        $this->assertSame('wechat', PaymentType::WECHAT_APP->getChannel());
        $this->assertSame('wechat', PaymentType::LEGACY_WECHAT_PAY->getChannel());

        $this->assertSame('alipay', PaymentType::ALIPAY_H5->getChannel());
        $this->assertSame('alipay', PaymentType::ALIPAY_APP->getChannel());
        $this->assertSame('alipay', PaymentType::LEGACY_ALIPAY->getChannel());

        $this->assertSame('bank', PaymentType::BANK_CARD->getChannel());
        $this->assertSame('balance', PaymentType::BALANCE->getChannel());
    }

    public function testFromValue(): void
    {
        $this->assertSame(PaymentType::WECHAT_MINI_PROGRAM, PaymentType::fromValue('wechat_mini_program'));
        $this->assertSame(PaymentType::WECHAT_OFFICIAL_ACCOUNT, PaymentType::fromValue('wechat_official_account'));
        $this->assertSame(PaymentType::WECHAT_JSAPI, PaymentType::fromValue('wechat_jsapi'));
        $this->assertSame(PaymentType::WECHAT_APP, PaymentType::fromValue('wechat_app'));
        $this->assertSame(PaymentType::ALIPAY_H5, PaymentType::fromValue('alipay_h5'));
        $this->assertSame(PaymentType::ALIPAY_APP, PaymentType::fromValue('alipay_app'));
        $this->assertSame(PaymentType::LEGACY_WECHAT_PAY, PaymentType::fromValue('wechat_pay'));
        $this->assertSame(PaymentType::LEGACY_ALIPAY, PaymentType::fromValue('alipay'));
        $this->assertSame(PaymentType::BANK_CARD, PaymentType::fromValue('bank_card'));
        $this->assertSame(PaymentType::BALANCE, PaymentType::fromValue('balance'));

        $this->assertNull(PaymentType::fromValue('invalid_payment_type'));
    }

    public function testGetValues(): void
    {
        $expectedValues = [
            'wechat_mini_program',
            'wechat_official_account',
            'wechat_jsapi',
            'wechat_app',
            'alipay_h5',
            'alipay_app',
            'wechat_pay',
            'alipay',
            'bank_card',
            'balance',
        ];

        $this->assertSame($expectedValues, PaymentType::getValues());
    }

    public function testEnumValues(): void
    {
        $this->assertSame('wechat_mini_program', PaymentType::WECHAT_MINI_PROGRAM->value);
        $this->assertSame('wechat_official_account', PaymentType::WECHAT_OFFICIAL_ACCOUNT->value);
        $this->assertSame('wechat_jsapi', PaymentType::WECHAT_JSAPI->value);
        $this->assertSame('wechat_app', PaymentType::WECHAT_APP->value);
        $this->assertSame('alipay_h5', PaymentType::ALIPAY_H5->value);
        $this->assertSame('alipay_app', PaymentType::ALIPAY_APP->value);
        $this->assertSame('wechat_pay', PaymentType::LEGACY_WECHAT_PAY->value);
        $this->assertSame('alipay', PaymentType::LEGACY_ALIPAY->value);
        $this->assertSame('bank_card', PaymentType::BANK_CARD->value);
        $this->assertSame('balance', PaymentType::BALANCE->value);
    }

    public function testTraitsImplementation(): void
    {
        $this->assertIsArray(PaymentType::cases());
        $this->assertCount(10, PaymentType::cases());
    }

    public function testToArray(): void
    {
        $result = PaymentType::WECHAT_MINI_PROGRAM->toArray();
        $this->assertIsArray($result);
        $this->assertArrayHasKey('value', $result);
        $this->assertArrayHasKey('label', $result);
        $this->assertSame('wechat_mini_program', $result['value']);
        $this->assertSame('微信小程序支付', $result['label']);

        foreach (PaymentType::cases() as $case) {
            $result = $case->toArray();
            $this->assertIsArray($result);
            $this->assertArrayHasKey('value', $result);
            $this->assertArrayHasKey('label', $result);
            $this->assertSame($case->value, $result['value']);
            $this->assertSame($case->getLabel(), $result['label']);
        }
    }
}
