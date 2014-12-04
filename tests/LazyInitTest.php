<?php

/**
 * This file is part of contao-community-alliance/backports-initialize-system.
 *
 * (c) Contao Community Alliance <https://c-c-a.org>
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    contao-community-alliance/backports-initialize-system
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @copyright  Contao Community Alliance <https://c-c-a.org>
 * @link       https://github.com/contao-community-alliance/backports-initialize-system
 * @license    http://opensource.org/licenses/LGPL-3.0 LGPL-3.0+
 * @filesource
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
