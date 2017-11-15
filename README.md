# MySQL lock mechanism for Laravel
 
# Installation

Require this package in your `composer.json` and update composer. Run the following command:
```php
composer require tsfcorp/mysql-lock
```

After updating composer, the service provider will automatically be registered and enabled, along with the facade, using Auto-Discovery

# Usage Instructions

`MysqlLock` library can be used when you don't want two processes to overlap
```php
if ( ! MysqlLock::get($lock_name))
{
    // a lock already exists. Please try again later
}

```

Make sure that at the end of your script to always release the lock:

```php
MysqlLock::release($lock_name);
```


