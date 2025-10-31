<?php

declare(strict_types=1);

namespace Tourze\PaymentContracts\Tests\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PaymentContracts\Exception\InvalidAttachDataException;
use Tourze\PHPUnitBase\AbstractExceptionTestCase;

/**
 * @internal
 */
#[CoversClass(InvalidAttachDataException::class)]
class InvalidAttachDataExceptionTest extends AbstractExceptionTestCase
{
    public function testDefaultConstructor(): void
    {
        $exception = new InvalidAttachDataException();

        $this->assertSame('无效的附加数据格式', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
        $this->assertInstanceOf(\InvalidArgumentException::class, $exception);
    }

    public function testCustomMessage(): void
    {
        $message = 'Custom error message';
        $exception = new InvalidAttachDataException($message);

        $this->assertSame($message, $exception->getMessage());
    }

    public function testWithCodeAndPrevious(): void
    {
        $message = 'Test message';
        $code = 1001;
        $previous = new \Exception('Previous exception');

        $exception = new InvalidAttachDataException($message, $code, $previous);

        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($code, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
