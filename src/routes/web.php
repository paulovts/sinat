<?php

use App\Controllers;

$app->get('/', Controllers\IndexController::class . ':home');