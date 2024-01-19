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

You can use this field in your Nova resources like this:
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

and in your model extend the trait:

```php
use The3labsTeam\NovaBusyResourceField\App\Traits\Busiable;

class MyModel extends Model{
    use Busiable;
}
```

In the end, add in your App\Console\Kernel, command for delete old records every minute.

This command delete records older than seconds defined in config file.

```php
    $schedule->command('nova-busy-resource-field:run')->everyMinute()->withoutOverlapping();
```
