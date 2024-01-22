<p align="center">
    <img src="https://github.com/the-3labs-team/nova-busy-resource-field/raw/HEAD/art/banner.png" width="100%" 
    alt="Logo Nova Busy Resource Field by The3LabsTeam">
</p>

# Laravel Nova Busy Resource Field

Have you ever dreamed of having a mechanism in Laravel Nova that would allow you to know if a resource is occupied by
another user?

Introducing **Nova Resource Busy Field**, the first package for Laravel Nova that lets you know if a resource is
occupied by another user.

<p align="center">
    <img src="https://github.com/the-3labs-team/nova-busy-resource-field/raw/HEAD/art/demo.gif" width="100%" 
    alt="Demo Nova Busy Resource Field by The3LabsTeam">
</p>

From the secret labs of The3LabsTeam this is a completely opensource package designed to make life easier for those
using Laravel Nova as a multi-user CMS.

🌟 Here are some great features:

- It is model-agnostic, you can decide which resource will be considered "occupiable"
- Fully configurable, you can choose the threshold timeout and old logs to be deleted
- It is native to Laravel Nova, there is only one migration to launch
- It is fully reversible, no Laravel Nova models and/or views are touched
- Lets you know from the index of a resource if it is occupied
- Receive an alert if you enter an edit of a busy resource

## Installation

For install this package, in your `composer.json` add the repository:

```bash
composer require the-3labs-team/nova-busy-resource-field
```

You need to publish the migration file:

```bash
  php artisan vendor:publish --tag=nova-busy-resource-field-migrations
```

Also, you can publish the config file:

```bash
  php artisan vendor:publish --tag=nova-busy-resource-field-config
```

## Usage

First you need to make a model "busiable".
For example, if you want to make the Article model busiable, you need to add the
trait `The3labsTeam\NovaBusyResourceField\App\Traits\Busiable` to it:

```php
use The3labsTeam\NovaBusyResourceField\App\Traits\Busiable;

class Article extends Model{
    use Busiable;
}
```

Then, in your Nova resource, you can add the field:

```php
    use The3labsTeam\NovaBusyResourceField\NovaBusyResourceField;


    public function fields(NovaRequest $request)
    {
        return [
            // ...
            
            NovaBusyResourceField::make('')->withMeta([
                'saveEvery' => 30000 // In milliseconds
            ]),
            
            // ...
        ];
    }
```

For the best experience, you can delete old records in database.
For this, you need to add in your `App\Console\Kernel`, command for delete old records every minute.

```php
    $schedule->command('nova-busy-resource-field:run')->everyMinute()->withoutOverlapping();
```
