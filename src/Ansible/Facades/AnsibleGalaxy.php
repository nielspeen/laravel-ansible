<?php

namespace Peen\Ansible\Facades;

use Illuminate\Support\Facades\Facade;

class AnsibleGalaxy extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ansible-galaxy';
    }
}
