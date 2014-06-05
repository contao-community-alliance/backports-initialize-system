Backports: initializeSystem Hook
================================

Allows you to use the `$GLOBALS['TL_HOOKS']['initializeSystem']` Hook on Contao 2.11 and 3.0.

Known limitations
-----------------

On Contao 3.1 or newer, the [initializeSystem](https://github.com/contao/core/blob/3.1.0/system/initialize.php#L230)
Hooks is called immediately before the `initconfig.php` is included, at the near end of the `initialize.php`.

This backport use an autoloader injection and will be loaded when the `RequestToken` class [get loaded](https://github.com/contao/core/blob/3.0.0/system/initialize.php#L94)
in the mid of the `initialize.php`. That means, that the timezone is not set, `TL_PATH` is not defined and no `$GLOBALS['TL_LANGUAGE']` is set!

When you use this backport, you need to deal with this limitation ;-)
