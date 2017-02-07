<?php

require __DIR__ . '/../app/AutoLoader.php';

// Autoloader classes
$autoloader = new \app\AutoLoader();
$autoloader->addNamespace('app\\lib', realpath(__DIR__ . '/../app/lib'));
$autoloader->register();
