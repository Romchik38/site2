<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\AdminVisitor;

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\AdminVisitor\AdminVisitor;
use Romchik38\Site2\Domain\AdminVisitor\VO\CsrfToken;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorUseRandomBytes;

final class VisitorTest extends TestCase
{
    public readonly CsrfTokenGeneratorInterface $csrfTokenGenerator;

    public function setUp(): void
    {
        $this->csrfTokenGenerator = new CsrfTokenGeneratorUseRandomBytes(32);
    }

    public function testConstructDefaultNull(): void
    {
        $token = new CsrfToken($this->csrfTokenGenerator->asBase64());
        $model = new AdminVisitor($token);
        $this->assertSame(null, $model->username);
        $this->assertSame(null, $model->message);
    }
}
