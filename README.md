# envconfig

env-config is a JSON config file loader based on environment var.

## examples


```php
//Apache
//setEnv environment production

$conf = Config::get('environment','config', (__DIR__ . '/my_config_dir'));
$conf = Config::get('environment', 'config')

$dbname = $conf['database']['name'];
```


###todo

• add tests