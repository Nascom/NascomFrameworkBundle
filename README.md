# NascomFrameworkBundle

Symfony2 Bundle with default setup for Nascom projects
[https://github.com/Nascom/NascomFrameworkBundle](https://github.com/thephpleague/tactician/)

## Installation

### Step 1: Download the Bundle
Open a command console, enter your project directory and execute the
following command to download the latest stable release for this bundle:

```bash
$ composer require nascom/framework-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle
Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            
            new League\Tactician\Bundle\TacticianBundle(),
            new Nascom\FrameworkBundle\NascomFrameworkBundle(),
        );
        
        // ...
    }
    
    // ...
}
```

Note that currently the TacticianBundle is a hard dependency, so you should make sure it's included as well...

## License
The MIT License (MIT). Please see [License File](LICENSE) for more information.
