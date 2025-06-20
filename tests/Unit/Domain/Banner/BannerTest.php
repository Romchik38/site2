<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Banner;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Banner\Banner;
use Romchik38\Site2\Domain\Banner\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Banner\Entities\Image;
use Romchik38\Site2\Domain\Banner\VO\Identifier as BannerId;
use Romchik38\Site2\Domain\Banner\VO\Name;
use Romchik38\Site2\Domain\Banner\VO\Priority;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;

final class BannerTest extends TestCase
{
    public function testConstruct(): void
    {
        $image    = new Image(new ImageId(1), true);
        $priority = new Priority(10);
        $banner   = new Banner(
            new BannerId(1),
            true,
            new Name('some banner'),
            $image,
            $priority
        );

        $this->assertSame(1, ($banner->id)());
        $this->assertSame(true, $banner->active);
        $this->assertSame('some banner', ($banner->name)());
        $this->assertSame($image, $banner->image);
    }

    public function testConstructThrowserrorOnNonActiveImage(): void
    {
        $image    = new Image(new ImageId(1), false);  // the problem
        $priority = new Priority(10);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Banner::ERROR_IMAGE_NOT_ACTIVE);

        new Banner(
            new BannerId(1),
            true,
            new Name('some banner'),
            $image,
            $priority
        );
    }

    public function testConstructThrowsErrorOnEmptyId(): void
    {
        $image    = new Image(new ImageId(1), true);
        $name     = new Name('some banner');
        $priority = new Priority(10);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Banner::ERROR_ID_IS_NULL);

        new Banner(
            null,
            true, // wrong, active banner must have an id
            $name,
            $image,
            $priority
        );
    }

    public function testActivate(): void
    {
        $image    = new Image(new ImageId(1), true);
        $priority = new Priority(10);

        $banner = new Banner(
            new BannerId(1),
            false,
            new Name('some banner'),
            $image,
            $priority
        );

        $this->assertSame(false, $banner->active);
        $banner->activate();
        $this->assertSame(true, $banner->active);
    }

    public function testActivateThrowsErrorOnNonActiveImage(): void
    {
        $image    = new Image(new ImageId(1), false);
        $priority = new Priority(10);

        $banner = new Banner(
            new BannerId(1),
            false,
            new Name('some banner'),
            $image,
            $priority
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage(Banner::ERROR_ACTIVATE_IMAGE_NOT_ACTIVE);
        $banner->activate();
    }

    public function testDeactivate(): void
    {
        $image    = new Image(new ImageId(1), true);
        $priority = new Priority(10);

        $banner = new Banner(
            new BannerId(1),
            true,
            new Name('some banner'),
            $image,
            $priority
        );

        $this->assertSame(true, $banner->active);
        $banner->deactivate();
        $this->assertSame(false, $banner->active);
    }

    public function testCreate(): void
    {
        $image    = new Image(new ImageId(1), true);
        $name     = new Name('some banner');
        $priority = new Priority(10);

        $model = Banner::create($name, $image, $priority);

        $this->assertSame(null, $model->id);
        $this->assertSame(false, $model->active);
        $this->assertSame($name, $model->name);
        $this->assertSame($image, $model->image);
    }
}
