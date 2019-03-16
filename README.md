# Container

A simple and easy dependency container.

[![Build Status](https://travis-ci.org/SidRoberts/container.svg?branch=master)](https://travis-ci.org/SidRoberts/container)
[![GitHub tag](https://img.shields.io/github/tag/sidroberts/container.svg?maxAge=2592000)]()



## Installation

```bash
composer require sidroberts/container
```



## Usage

Let's start by defining some of our services.

First of all, we need to be able to access our configuration data:

```php
namespace MyApp\Service;

use Sid\Container\Service;
use Symfony\Component\Yaml\Yaml;
use Zend\Config\Config;

class ConfigService extends Service
{
    public function getName() : string
    {
        return "config";
    }

    public function isShared() : bool
    {
        return true;
    }

    public function resolve()
    {
        $config = new Config(
            Yaml::parse(
                file_get_contents(
                    "config/config.yaml"
                )
            )
        );

        return $config;
    }
}
```

Service classes have 3 methods:

* `getName()` allows you to specify the name that you'll use to access this service.

* `isShared()` allows you to reuse the same instance multiple times (`true`) or use the service as a singleton (`false`).

* `resolve()` is where you can actually write your service code.

A service may depend on another service in order to function.
By using the names from `getName()`, you can access other services via the `resolve()` method's parameters.
Here, we'll create another service that requires the 'config' service:

```php
namespace MyApp\Service;

use Pheanstalk\Pheanstalk;
use Sid\Container\Service;
use Zend\Config\Config;

class PheanstalkService extends Service
{
    public function getName() : string
    {
        return "pheanstalk";
    }

    public function isShared() : bool
    {
        return true;
    }

    public function resolve(Config $config)
    {
        $pheanstalk = new Pheanstalk(
            $config->pheanstalk->host,
            $config->pheanstalk->port
        );

        return $pheanstalk;
    }
}
```

The example above has used typehinting to ensure that `$config` is an instance of `Zend\Config\Config`.
This isn't necessary but it's for useful for IDE autocompletion and may help uncover possible bugs earlier.

Now we need to add these service classes to the container:

```php
use MyApp\Service\ConfigService;
use MyApp\Service\PheanstalkService;
use Sid\Container\Container;

$container = new Container();

$container->add(
    new ConfigService()
);

$container->add(
    new PheanstalkService()
);
```

Accessing services is now as simple as:

```php
$pheanstalk = $container->get("pheanstalk");
```

The container will handle all of the dependencies and either return the same instance or create a fresh instance depending on whether the service is shared or not.

If a service does not exist, `get()` will throw a `Sid\Container\Exception\ServiceNotFoundException`.
You can also check if a service exists using `has()` which will return a boolean:

```php
$container->has("myService");
```
