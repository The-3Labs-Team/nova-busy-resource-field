<p align="center">
    <img src="https://github.com/the-3labs-team/nova-busy-resource-field/raw/HEAD/art/banner.png" width="100%" 
    alt="Logo Nova Busy Resource Field by The3LabsTeam">
</p>

# Laravel Nova Busy Resource Field

[![Latest Version on Packagist](https://img.shields.io/packagist/v/the-3labs-team/nova-busy-resource-field.svg?style=flat-square)](https://packagist.org/packages/the-3labs-team/nova-busy-resource-field)
[![Maintainability](https://api.codeclimate.com/v1/badges/ce66e15115ca64d52c96/maintainability)](https://codeclimate.com/github/The-3Labs-Team/nova-busy-resource-field/maintainability)
[![Total Downloads](https://img.shields.io/packagist/dt/the-3labs-team/nova-busy-resource-field.svg?style=flat-square)](https://packagist.org/packages/the-3labs-team/nova-busy-resource-field)

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

Remember to launch the migrations:
```bash
php artisan migrate
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
## Sponsor

<div>  
    <a href="https://www.tomshw.it/" target="_blank" rel="noopener noreferrer">
        <img  src="https://3labs-assets.b-cdn.net/assets/logos/banner-github/toms.png" alt="Tom's Hardware - Notizie, recensioni, guide all'acquisto e approfondimenti per tutti gli appassionati di computer, smartphone, videogiochi, film, serie tv, gadget e non solo" />  
    </a>
    <a href="https://spaziogames.it/" target="_blank" rel="noopener noreferrer" >
        <img src="https://3labs-assets.b-cdn.net/assets/logos/banner-github/spazio.png" alt="Spaziogames - Tutto sul mondo dei videogiochi. Troverai tantissime anteprime, recensioni, notizie dei giochi per tutte le console, PC, iPhone e Android." />
    </a>
    <br/>
    <a href="https://cpop.it/" target="_blank" rel="noopener noreferrer" >
        <img src="https://3labs-assets.b-cdn.net/assets/logos/banner-github/cpop.png" alt="Cpop - News, recensioni, guide su fumetto, cinema & serie TV, gioco da tavolo e di ruolo e collezionismo. Tutto quello di cui hai bisogno per rimanere aggiornato sul mondo della cultura pop"/>
    </a>
    <a href="https://data4biz.com/" target="_blank" rel="noopener noreferrer" >
        <img src="https://3labs-assets.b-cdn.net/assets/logos/banner-github/d4b.png" alt="Data4Biz - Sito dedicato alla trasformazione digitale del business" />
    </a>
    <br/>
    <a href="https://soshomegarden.com/" target="_blank" rel="noopener noreferrer" >
        <img src="https://3labs-assets.b-cdn.net/assets/logos/banner-github/sos.png" alt="SOS Home & Garden - Realtà dedicata a 360 gradi ai settori della casa e del giardino." />
    </a>
    <a href="https://global.techradar.com/it-it" target="_blank" rel="noopener noreferrer" >
        <img src="https://3labs-assets.b-cdn.net/assets/logos/banner-github/techradar.png" alt="Techradar - Le ultime notizie e recensioni dal mondo della tecnologia, su computer, sistemi per la casa, gadget e altro." />
    </a>
    <br/>
    <a href="https://aibay.it/" target="_blank" rel="noopener noreferrer" >
        <img src="https://3labs-assets.b-cdn.net/assets/logos/banner-github/aibay.png" alt="Aibay - Scopri AiBay, il leader delle notizie sull'intelligenza artificiale. Resta aggiornato sulle ultime innovazioni, ricerche e tendenze del mondo AI con approfondimenti, interviste esclusive e analisi dettagliate." />
    </a>
    <a href="https://coinlabs.it/" target="_blank" rel="noopener noreferrer" >
        <img src="https://3labs-assets.b-cdn.net/assets/logos/banner-github/coinlabs.png" alt="Coinlabs - Notizie, analisi approfondite, guide e opinioni aggiornate sul mondo delle criptovalute, blockchain e finanza" />
    </a>

</div>

