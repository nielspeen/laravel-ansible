<?php

namespace Peen\Ansible\Exception;

use RuntimeException;

class CommandException extends RuntimeException
{
    protected $code = 500;
}
