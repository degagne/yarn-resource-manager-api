## Installation
Add yarn-resource-manager-api package to your composer.json file.
```
{
    "require": {
        "degagne/yarn-resource-manager-api": "~1.0"
    }
}
```

or run
```composer require degagne/yarn-resource-manager-api```

## Basic Usage

```php
require_once(__DIR__ . '/vendor/autoload.php');

use YarnResourceManager\ResourceManager;

$parameters = [
        'user'              => 'jdoe',
        'limit'             => 10,
        'states'            => 'KILLED,FAILED,FINISHED',
        'startedTimeBegin'  => '2017-10-10 02:23:12',
        'applicationTypes'  => 'TEZ,SPARK'
];

$rm = new ResourceManager('api_url', 'port', 'format');
$rm->applications($parameters);
```
