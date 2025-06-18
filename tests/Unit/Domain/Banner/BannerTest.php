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
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;

final class BannerTest extends TestCase
{
    public function testConstruct(): void
    {
        $image  = new Image(new ImageId(1), true);
        $banner = new Banner(
            new BannerId(1),
            true,
            new Name('some banner'),
            $image
        );

        $this->assertSame(1, ($banner->id)());
        $this->assertSame(true, $banner->active);
        $this->assertSame('some banner', ($banner->name)());
        $this->assertSame($image, $banner->image);
    }

    public function testConstructThrowserrorOnNonActiveImage(): void
    {
        $image = new Image(new ImageId(1), false);  // the problem

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Banner::ERROR_IMAGE_NOT_ACTIVE);

        new Banner(
            new BannerId(1),
            true,
            new Name('some banner'),
            $image
        );
    }

    public function testConstructThrowsErrorOnEmptyId(): void
    {
        $image = new Image(new ImageId(1), true);
        $name  = new Name('some banner');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Banner::ERROR_ID_IS_NULL);

        new Banner(
            null,
            true, // wrong, active banner must have an id
            $name,
            $image
        );
    }

    public function testActivate(): void
    {
        $image  = new Image(new ImageId(1), true);
        $banner = new Banner(
            new BannerId(1),
            false,
            new Name('some banner'),
            $image
        );

        $this->assertSame(false, $banner->active);
        $banner->activate();
        $this->assertSame(true, $banner->active);
    }

    public function testActivateThrowsErrorOnNonActiveImage(): void
    {
        $image  = new Image(new ImageId(1), false);
        $banner = new Banner(
            new BannerId(1),
            false,
            new Name('some banner'),
            $image
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage(Banner::ERROR_ACTIVATE_IMAGE_NOT_ACTIVE);
        $banner->activate();
    }

    public function testDeactivate(): void
    {
        $image  = new Image(new ImageId(1), true);
        $banner = new Banner(
            new BannerId(1),
            true,
            new Name('some banner'),
            $image
        );

        $this->assertSame(true, $banner->active);
        $banner->deactivate();
        $this->assertSame(false, $banner->active);
    }

    public function testCreate(): void
    {
        $image = new Image(new ImageId(1), true);
        $name  = new Name('some banner');

        $model = Banner::create($name, $image);

        $this->assertSame(null, $model->id);
        $this->assertSame(false, $model->active);
        $this->assertSame($name, $model->name);
        $this->assertSame($image, $model->image);
    }
}
