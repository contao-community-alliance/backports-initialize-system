<?php

/**
 * Backports of the initializeSystem Hook for Contao Open Source CMS
 * Copyright (C) 2013 Contao Community Alliance
 *
 * PHP version 5
 *
 * @copyright  (c) 2013 Contao Community Alliance
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    backports-initialize-system
 * @license    LGPL-3.0+
 * @filesource
 */

namespace ContaoCommunityAlliance\Contao\Backports;

/**
 * Class InitializeSystem
 */
class InitializeSystem
{
	/**
	 * Lazy initialize
	 */
	static public function lazyInit()
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
	 * Initialize
	 *
	 * @param $className
	 *
	 * @return bool
	 */
	static public function autoload($className)
	{
		if ($className == 'RequestToken') {
			static::init();
			spl_autoload_unregister('ContaoCommunityAlliance\Contao\Backports\InitializeSystem::autoload');
		}
		return false;
	}

	/**
	 * Init the global dependency container.
	 */
	static public function init()
	{
		if (isset($GLOBALS['TL_HOOKS']['initializeSystem']) && is_array($GLOBALS['TL_HOOKS']['initializeSystem'])) {
			foreach ($GLOBALS['TL_HOOKS']['initializeSystem'] as $callback) {
				$class = new \ReflectionClass($callback[0]);
				if ($class->hasMethod('getInstance')) {
					$object = $class->getMethod('getInstance')->invoke(null);
				}
				else {
					$object = $class->newInstance();
				}

				$method = $class->getMethod($callback[1]);
				$method->invoke($object);
			}
		}
	}
}
