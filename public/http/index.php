<?php

declare(strict_types=1);

require_once(__DIR__ . '/../../vendor/autoload.php');

$container = (require_once(__DIR__ . './../../app/bootstrap_http.php'))();

// 1. parse url
$elements = explode('/', $_SERVER['REQUEST_URI']);

// two blank elements for /
if (count($elements) === 2 && $elements[0] === '' && $elements[1] === '') {
    $elements = [''];
}

// delete first blank item
array_shift($elements);

// 2. for / redirect to default root
if (count($elements) === 0) {
    header('Location: http://site2.com/en');
}

// 3. get root and method
$rootName = $elements[0];


echo 'Hello';
