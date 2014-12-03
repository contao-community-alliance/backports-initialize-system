<?php

/**
 * Contao Composer Installer
 *
 * Copyright (C) 2013 Contao Community Alliance
 *
 * @package contao-composer
 * @author  Dominik Zogg <dominik.zogg@gmail.com>
 * @author  Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://c-c-a.org
 * @license LGPL-3.0+
 */

namespace ContaoCommunityAlliance\Contao\Backports\Test;

/**
 * Test the lazy init.
 */
class LazyInitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test lazy init for Contao <=3.0.
     *
     * @return void
     */
    public function testLazyInit()
    {
        define('VERSION', '3.0');

        require __DIR__ . '/../contao/config/config.php';

        $functions = spl_autoload_functions();

        $this->assertContains(
            array('ContaoCommunityAlliance\Contao\Backports\InitializeSystem', 'autoload'),
            $functions,
            'The InitializeSystem::autoload must registered under Contao <=3.0'
        );
    }

    /**
     * Test lazy init for Contao >=3.1.
     *
     * @return void
     */
    public function testNoInit()
    {
        define('VERSION', '3.1');

        require __DIR__ . '/../contao/config/config.php';

        $functions = spl_autoload_functions();

        $this->assertNotContains(
            array('ContaoCommunityAlliance\Contao\Backports\InitializeSystem', 'autoload'),
            $functions,
            'The InitializeSystem::autoload must not registered under Contao >=3.1, found: '
            . print_r($functions, true)
        );
    }
}
