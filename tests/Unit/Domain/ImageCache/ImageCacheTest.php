<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\ImageCache;

use DateTime;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\ImageCache\ImageCache;
use Romchik38\Site2\Domain\ImageCache\VO\Data;
use Romchik38\Site2\Domain\ImageCache\VO\Key;
use Romchik38\Site2\Domain\ImageCache\VO\Type;

use function date_format;

final class ImageCacheTest extends TestCase
{
    public function testCreate(): void
    {
        $key   = new Key('some<>key');
        $data  = new Data('abra-cadabra');
        $type  = new Type('webp');
        $model = ImageCache::create($key, $data, $type);

        $this->assertSame($key, $model->key);
        $this->assertSame($data, $model->data);
        $this->assertSame($type, $model->type);
        $this->assertSame(
            date_format(new DateTime(), 'Y-m-d H:i'),
            $model->createdAt->format('Y-m-d H:i')
        );
    }

    public function testFormatCreatedAt(): void
    {
        $key   = new Key('some<>key');
        $data  = new Data('abra-cadabra');
        $type  = new Type('webp');
        $model = ImageCache::create($key, $data, $type);

        $this->assertSame(
            $model->createdAt->format(ImageCache::SAVE_DATE_FORMAT),
            $model->formatCreatedAt()
        );
    }
}
