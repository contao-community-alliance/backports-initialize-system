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

if (version_compare(VERSION, '3.1', '<')) {
	$classExist = false;

	// Contao 2.11.x
	if (version_compare(VERSION, '3', '<')) {
		$functions = spl_autoload_functions();
		foreach ($functions as $function) {
			if (
				$function != '__autoload' &&
				call_user_func($function, 'ContaoCommunityAlliance\Contao\Backports\InitializeSystem')
			) {
				// due to inconsistent implementation, the classloader function may return true,
				// even if the class was not realy loaded
				// re-check with class_exists without trigger the autoloader chain
				$classExist = class_exists('ContaoCommunityAlliance\Contao\Backports\InitializeSystem', false);

				if ($classExist) {
					break;
				}
			}
		}
	}
	// Contao 3.0.x
	else {
		$classExist = class_exists('ContaoCommunityAlliance\Contao\Backports\InitializeSystem');
	}

	if ($classExist) {
		ContaoCommunityAlliance\Contao\Backports\InitializeSystem::lazyInit();
	}
	else {
		trigger_error(
			'Could not find class ContaoCommunityAlliance\Contao\Backports\InitializeSystem, disabling the initializeSystem HOOK Backport',
			E_USER_WARNING
		);
	}
}
