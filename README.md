# EnvironmentExtension [![License][license-image]][license-url] [![Version][packagist-image]][packagist-url] [![Travis-CI][travis-image]][travis-url] 

Allows to use the symfony [env parameter syntax][env-docu-url] in the behat config

## Usage

1. Install it:
    
    ```bash
    $ composer require tourstream/environment-extension --dev
    ```

2. Enable and configure environment extension in your Behat configuration:
    
    ```yaml
    # behat.yml
    default:
        # ...
        extensions:
            Tourstream\Behat\EnvironmentExtension: # the default configuration:
                env_file: '%paths.base%/.env' #default path
    ```

3. EnvironmentExtension should be the last extensions, so that all parameters are already known. Otherwise it can happen, that not all `%env()%` are resolved

## Configuration reference

 - `env_file` - a dot env file, contains environment variables which should be also used, the file is not required

[env-docu-url]: https://symfony.com/doc/current/configuration.html

[packagist-image]: https://poser.pugx.org/tourstream/environment-extension/v/stable
[packagist-url]: https://packagist.org/packages/tourstream/environment-extension

[travis-image]: https://travis-ci.org/tourstream/EnvironmentExtension.svg?branch=master
[travis-url]: https://travis-ci.org/tourstream/EnvironmentExtension

[license-image]: https://poser.pugx.org/tourstream/environment-extension/license
[license-url]: https://github.com/tourstream/EnvironmentExtension/blob/master/LICENSE