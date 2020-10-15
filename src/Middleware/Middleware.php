<?php
/**
 * Created by PhpStorm.
 * User: websis
 * Date: 09/10/20
 * Time: 11:07
 */

namespace App\Middleware;


class Middleware
{

    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }
}