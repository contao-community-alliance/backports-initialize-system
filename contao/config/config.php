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

if (version_compare(VERSION, '3.1', '<')) {
    if (@include __DIR__ . '/../src/InitializeSystem.php') {
        ContaoCommunityAlliance\Contao\Backports\InitializeSystem::lazyInit();
    } else {
        trigger_error(
            'Could not find class ContaoCommunityAlliance\Contao\Backports\InitializeSystem, disabling the initializeSystem HOOK Backport',
            E_USER_WARNING
        );
    }
}
