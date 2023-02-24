<?php

namespace Peen\Ansible\Utils;

class Env
{
    public static function isWindows(): bool
    {
        return defined('PHP_WINDOWS_VERSION_BUILD');
    }
}
