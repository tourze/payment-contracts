<?php

declare(strict_types=1);

namespace Tourze\PaymentContracts\Exception;

/**
 * 无效附加数据异常
 */
class InvalidAttachDataException extends \InvalidArgumentException
{
    public function __construct(string $message = '无效的附加数据格式', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
