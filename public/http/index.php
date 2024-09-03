<?php

declare(strict_types=1);

require_once(__DIR__ . '/../../vendor/autoload.php');

$container = (require_once(__DIR__ . './../../app/bootstrap_http.php'))();



echo 'Hello';
