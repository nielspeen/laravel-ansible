# laravel-ansible

This is a Laravel wrapper for the ansible provisioning tool. Currently supports the `ansible-playbook` and `ansible-galaxy` commands.

## Prerequisites
 * Laravel 9
 * Ansible (accessible and executable by your Laravel/webserver user)

## Setup

Install the example configuration file:
`php artisan vendor:publish --tag=ansible-config`

The configuration may contain multiple instances. For example:

```
"instances" => [
        "default" => [
            'playbooks_path' => resource_path('playbooks'),
            'galaxy_command' => '/usr/bin/ansible-galaxy',
            'playbook_command' => '/usr/bin/ansible-playbook',
        ],
        "legacy" => [
            'playbooks_path' => resource_path('playbooks-legacy'),
            'galaxy_command' => '/usr/local/ansible/legacy/ansible-galaxy',
            'playbook_command' => '/usr/local/ansible/legacy/ansible-playbook-old',
        ]
    ]
```

Laravel Ansible defaults to the **default** instance when none is specified.

## Usage

Instantiate a playbook by using the Ansible facade:

```php
$playbook = Ansible::playbook();

$playbook = Ansible::use('legacy')->playbook();
```

### Playbooks

Then you can use the object just like in your previous ansible deployment.
If you don't specify an inventory file with ```->inventoryFile('filename')```, the wrapper tries to determine one, based on your playbook name: 

```php
Ansible::playbook()
    ->play('mydeployment.yml') // based on deployment root 
    ->user('maschmann')
    ->extraVars(['project_release' => 20150514092022])
    ->limit('test')
    ->execute();
```

This will create following ansible command:

```bash
$ ansible-playbook mydeployment.yml -i mydeployment --user=maschmann --extra-vars="project-release=20150514092022" --limit=test
```

For the execute command you can use a callback to get real-time output of the command:

```php
Ansible::playbook()
    ->play('mydeployment.yml') // based on deployment root 
    ->user('maschmann')
    ->extraVars(['project_release' => 20150514092022])
    ->limit('test')
    ->execute(function ($type, $buffer) {
        if (Process::ERR === $type) {
            echo 'ERR > '.$buffer;
        } else {
            echo 'OUT > '.$buffer;
        }
    });
```
If no callback is given, the method will return the ansible-playbook output as a string, so you can either ```echo``` or directly pipe it into a log/whatever.

You can also pass an external YML/JSON file as extraVars containing a complex data structure to be passed to Ansible:

```php
Ansible::playbook()
    ->play('mydeployment.yml') // based on deployment root 
    ->extraVars('/path/to/your/extra/vars/file.yml')
    ->execute();
```

You can have a Json output adding json() option that enable 'ANSIBLE_STDOUT_CALLBACK=json' env vars to make a json output in ansible.

```php
Ansible::playbook()
    ->json()
    ->play('mydeployment.yml') // based on deployment root 
    ->extraVars('/path/to/your/extra/vars/file.yml')
    ->execute();
```

### Galaxy

The syntax follows ansible's syntax with one deviation: list is a reserved keyword in php (array context) and
therefore I had to rename it to "modulelist()".

```php
Ansible::galaxy()
    ->init('my_role')
    ->initPath('/tmp/my_path') // or default ansible roles path
    ->execute();
```
would generate:

```bash
$ ansible-galaxy init my_role --init-path=/tmp/my_path
```

You can access all galaxy commands:

 * `init()`
 * `info()`
 * `install()`
 * `help()`
 * `modulelist()`
 * `remove()`

You can combine the calls with their possible arguments, though I don't have any logic preventing e.g. ```--force``` from being applied to e.g. info().

Possible arguments/options:

 * `initPath()`
 * `offline()`
 * `server()`
 * `force()`
 * `roleFile()`
 * `rolesPath()`
 * `ignoreErrors()`
 * `noDeps()`



### Process timeout

Default process timeout is set to 300 seconds. If you need more time to execute your processes: Adjust the timeout :-) 

```php
Ansible::galaxy()
    ->setTimeout(600)
    …
```

## License

laravel-ansible is licensed under the MIT license. See the [LICENSE](LICENSE) for the full license text.

## Credits

Based on [php-ansible](https://github.com/maschmann/php-ansible) [v4.0.0](https://github.com/maschmann/php-ansible/tree/v4.0.0) by [Marc Aschmann](https://github.com/maschmann),
who thanks [xabbuh](https://github.com/xabbuh), [emielmolenaar](https://github.com/emielmolenaar), [saverio](https://github.com/saverio), [soupdiver](https://github.com/soupdiver), [linaori](https://github.com/linaori), [paveldanilin](https://github.com/paveldanilin) and many others! 
