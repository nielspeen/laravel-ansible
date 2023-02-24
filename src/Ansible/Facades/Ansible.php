<?php

namespace Peen\Ansible\Facades;

use Illuminate\Support\Facades\Facade;

class Ansible extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ansible';
    }
}
