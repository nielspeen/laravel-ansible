<?php

return [
    "instances" => [
        "default" => [
            'playbooks_path' => resource_path('playbooks'),
            'galaxy_command' => '/usr/bin/ansible-galaxy',
            'playbook_command' => '/usr/bin/ansible-playbook',
        ]
    ]
];
