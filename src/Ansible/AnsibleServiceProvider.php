<?php

namespace Peen\Ansible;

use Illuminate\Support\ServiceProvider;
use Peen\Ansible\Command\AnsibleGalaxy;
use Peen\Ansible\Command\AnsiblePlaybook;

class AnsibleServiceProvider extends ServiceProvider
{

    protected $commands = [
//        Send::class,
    ];

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/ansible.php' => config_path('ansible.php'),
        ], 'ansible-config');

//        $this->app->when(MatrixChannel::class)
//            ->needs(MatrixClient::class)
//            ->give(function () {
//                $matrixClientConfig = config('matrix-notifications');
//
//                return new MatrixClient(
//                    $matrixClientConfig['home_server'],
//                    $matrixClientConfig['username'],
//                    $matrixClientConfig['password'],
//                    $matrixClientConfig['device_id'],
//                );
//            });
//
    }

    public function register()
    {
        $this->commands($this->commands);

        $this->mergeConfigFrom(
            __DIR__.'/../../config/ansible.php', 'ansible'
        );

        $this->app->bind('ansible-playbook', function($app) {
            return new AnsiblePlaybook();
        });

        $this->app->bind('ansible-galaxy', function($app) {
            return new AnsibleGalaxy();
        });

    }
}
