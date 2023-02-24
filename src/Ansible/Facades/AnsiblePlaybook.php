<?php

namespace Peen\Ansible\Facades;

use Illuminate\Support\Facades\Facade;

class AnsiblePlaybook extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ansible-playbook';
    }
}
