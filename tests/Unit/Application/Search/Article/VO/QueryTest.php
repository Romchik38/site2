<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Application\Search\Article\VO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Application\Search\Article\VO\Query;

use function sprintf;

final class QueryTest extends TestCase
{
    public function testAscii(): void
    {
        $q  = 'some ascii text';
        $vo = new Query($q);

        $this->assertSame($q, $vo());
    }

    public function testUk(): void
    {
        $q  = 'якийсь запит';
        $vo = new Query($q);

        $this->assertSame($q, $vo());
    }

    public function testNumber(): void
    {
        $q  = 'закон поліція 2020';
        $vo = new Query($q);

        $this->assertSame($q, $vo());
    }

    public function testApostropheU2019(): void
    {
        $q  = 'інтерв’ю суддя';
        $vo = new Query($q);

        $this->assertSame($q, $vo());
    }

    public function testApostrophe(): void
    {
        $q  = 'інтерв\'ю суддя';
        $vo = new Query($q);

        $this->assertSame($q, $vo());
    }

    public function testApostropheU0060(): void
    {
        $q  = 'інтерв`ю суддя';
        $vo = new Query($q);

        $this->assertSame($q, $vo());
    }

    public function testReplaceMultipleSpaces(): void
    {
        $q  = 'суддя верховний  суд';
        $vo = new Query($q);

        $this->assertSame('суддя верховний суд', $vo());
    }

    public function testTrim(): void
    {
        $q  = '   суддя верховний суд ';
        $vo = new Query($q);

        $this->assertSame('суддя верховний суд', $vo());
    }

    public function testThrowsErrorTooLong(): void
    {
        $q = <<<Q
            Lorem ipsum dolor sit amet consectetur adipisicing elit Consequuntur ad 
            quibusdam eum assumenda quisquam dolores quo Architecto aut consequatur 
            voluptatum maxime quas ratione a obcaecati velit consequuntur voluptatem 
            accusamus minus Lorem ipsum dolor sit amet consectetur adipisicing elit 
            Consequuntur ad quibusdam eum assumenda quisquam dolores quo Architecto 
            aut consequatur voluptatum maxime quas ratione a obcaecati velit 
            consequuntur voluptatem accusamus minu
            Q;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Query::ERROR_MESSAGE);

        new Query($q);
    }

    public function testThrowsErrorDoubleApostrophe(): void
    {
        $q = 'hello\'\'world';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Query::ERROR_MESSAGE);

        new Query($q);
    }

    public function testThrowsErrorDoubleApostropheU2019(): void
    {
        $q = 'інтервʼʼю';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Query::ERROR_MESSAGE);

        new Query($q);
    }

    public function testThrowsErrorDoubleApostropheU0060(): void
    {
        $q = 'інтерв``ю';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Query::ERROR_MESSAGE);

        new Query($q);
    }

    public function testThrowsErrorTooLongWord(): void
    {
        $q = 'вasdfasdfadfasdfasdfasdfasdfasdfasdfasdfa adfasdf adfasdfas';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(Query::ERROR_WORD_LENGTH_MESSAGE, Query::MAX_WORD_LENGTH));

        new Query($q);
    }

    public function testThrowsErrorStartsWithApostrophe(): void
    {
        $q = '\'hello';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Query::ERROR_WORD_STARTS_MESSAGE);

        new Query($q);
    }

    public function testThrowsErrorStartsWithApostropheU2019(): void
    {
        $q = 'ʼhello';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Query::ERROR_WORD_STARTS_MESSAGE);

        new Query($q);
    }

    public function testThrowsErrorStartsWithApostropheU0060(): void
    {
        $q = '`hello';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Query::ERROR_WORD_STARTS_MESSAGE);

        new Query($q);
    }
}
