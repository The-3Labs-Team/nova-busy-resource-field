<?php

namespace The3labsTeam\NovaBusyResourceField\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BusyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nova-busy-resource-field:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('busiables')->where('updated_at', '<', now()->subSeconds(config('nova-busy-resource-field.treasure-old'))->format('Y-m-d H:i:s'))->delete();
    }
}
