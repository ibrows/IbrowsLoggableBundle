IbrowsLoggableBundle
=============================

Symfony Bundle that will track every Entity change on your Project and save it to a log table. Your Project gets some kind of confirmability with this Bundle.

It also provides some methods to get back an entity to an earlier version.

## Requirements

- PHP 8.1 or higher
- Symfony 6.4 or higher

Install & setup the bundle
--------------------------

1. Add IbrowsLoggableBundle in your composer.json:

	```json
	{
	    "require": {
	        "ibrows/loggable-bundle": "~1.0"
	    }
	}
	```

2. Now tell composer to download the bundle by running the command:

    ```bash
    $ composer require ibrows/loggable-bundle
    ```

    Composer will install the bundle to your project's vendor directory (PSR-4).

3. Add the bundles to your bundles configuration

    ```php
    // config/bundles.php
    return [
        // ...
        Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle::class => ['all' => true],
        Ibrows\LoggableBundle\IbrowsLoggableBundle::class => ['all' => true],
        // ...
    ];
    ```

4. Recommended config of stof_doctrine_extensions

    ```yaml
    # config/packages/stof_doctrine_extensions.yaml
    stof_doctrine_extensions:
        orm:
            default:
                softdeleteable: true
                loggable: true
        class:
            loggable: Ibrows\LoggableBundle\Listener\LoggableListener
    ```

5. Optional: Configure IbrowsLoggableBundle

    ```yaml
    # config/packages/ibrows_loggable.yaml
    ibrows_loggable:
        changeable:
            catch_exception: false
            change_entity_class: 'Ibrows\LoggableBundle\Entity\ChangeSet'
        loggable:
            default_log_entry_class: 'Ibrows\LoggableBundle\Entity\Log'
            log_parent_entry_class: 'Ibrows\LoggableBundle\Entity\LogMany2Many'
            log_collection_entry_class: 'Ibrows\LoggableBundle\Entity\LogParent'
            enabled: true
            use_only_single_ids: true
            default_all_versioned: true
    ```
