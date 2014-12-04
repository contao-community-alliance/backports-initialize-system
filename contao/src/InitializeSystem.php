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
 * @author     Ruben Roegels, wiseape GmbH <ruben.roegels@wiseape.de>
 * @copyright  Contao Community Alliance <https://c-c-a.org>
 * @link       https://github.com/contao-community-alliance/backports-initialize-system
 * @license    http://opensource.org/licenses/LGPL-3.0 LGPL-3.0+
 * @filesource
 */

namespace ContaoCommunityAlliance\Contao\Backports;

/**
 * Class InitializeSystem.
 */
class InitializeSystem
{
    /**
     * Register autoloader for lazy initialisation.
     *
     * @return void
     */
    public static function lazyInit()
    {
        if (version_compare(VERSION, '3', '<')) {
            spl_autoload_unregister('__autoload');
        }

        spl_autoload_register(
            'ContaoCommunityAlliance\Contao\Backports\InitializeSystem::autoload',
            true,
            true
        );

        if (version_compare(VERSION, '3', '<')) {
            spl_autoload_register('__autoload');
        }
    }

    /**
     * Initialize when the RequestToken class get loaded.
     *
     * @param string $className The class name.
     *
     * @return bool
     */
    public static function autoload($className)
    {
        if ($className == 'RequestToken') {
            static::init();
            spl_autoload_unregister('ContaoCommunityAlliance\Contao\Backports\InitializeSystem::autoload');
        }

        return false;
    }

    /**
     * Init the global dependency container.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function init()
    {
        if (isset($GLOBALS['TL_HOOKS']['initializeSystem']) && is_array($GLOBALS['TL_HOOKS']['initializeSystem'])) {
            foreach ($GLOBALS['TL_HOOKS']['initializeSystem'] as $callback) {
                $class = new \ReflectionClass($callback[0]);

                if ($class->hasMethod('getInstance')) {
                    $object = $class->getMethod('getInstance')->invoke(null);
                } else {
                    $object = $class->newInstance();
                }

                $method = $class->getMethod($callback[1]);
                $method->invoke($object);
            }
        }
    }
}
