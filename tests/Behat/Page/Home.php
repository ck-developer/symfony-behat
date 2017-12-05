<?php

namespace App\Tests\Behat\Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

/**
 * Class Home
 */
class Home extends Page
{
    protected $path = '/';

    protected $elements = [
        'title' => ['css' => 'h1'],
    ];
}
