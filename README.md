<p align="center">
    <img src="https://github.com/the-3labs-team/nova-busy-resource-field/raw/HEAD/art/banner.png" width="100%" 
    alt="Logo Nova Busy Resource Field by The3LabsTeam">
</p>

# Nova Busy Resource Field

Nova Busy Resource Field is a Laravel Nova field that allows you to see if a resource is busy by another user.

## Installation

For install this package, in your composer.json add the repository:

```json
"the-3labs-team/nova-busy-resource-field": "^0.0",
{
"type": "vcs",
"url": "https://github.com/The-3Labs-Team/nova-busy-resource-field.git"
}
```

Publish the migration file:

```bash
  php artisan vendor:publish --tag=nova-busy-resource-field-migrations
```

Publish the config file:

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
            
            NovaBusyResourceField::make('Busy')->withMeta([
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
