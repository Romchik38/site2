<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Visitor;

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\User\VO\Username;
use Romchik38\Site2\Domain\Visitor\Visitor;
use Romchik38\Site2\Domain\Visitor\VO\CsrfToken;
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
        $model = new Visitor($token);
        $this->assertSame(null, $model->username);
        $this->assertSame(null, $model->message);
    }

    public function testAcceptWithTerms(): void
    {
        $username = new Username('user_1');
        $token    = new CsrfToken($this->csrfTokenGenerator->asBase64());
        $model    = new Visitor($token, $username);

        $this->assertSame(false, $model->isAcceptedTerms);
        $model->acceptWithTerms();
        $this->assertSame(true, $model->isAcceptedTerms);
    }
}
