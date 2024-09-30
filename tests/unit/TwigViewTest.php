<?php

declare(strict_types=1);

use Romchik38\Site2\Views\Html\TwigView;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Romchik38\Server\Services\Translate\Translate;
use PHPUnit\Framework\TestCase;
use Romchik38\Server\Views\Http\Errors\ViewBuildException;

class TwigViewTest extends TestCase {
    public function testConstruct(){
        $loader = new FilesystemLoader();
        $twigEnv = new Environment($loader);
        
        $translate = $this->createMock(Translate::class);

        $this->expectException(ViewBuildException::class);
        $view = new TwigView($twigEnv, null, $translate);
        $view->toString();
    }
}
