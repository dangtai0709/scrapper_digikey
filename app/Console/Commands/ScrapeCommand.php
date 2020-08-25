<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScrapeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:digikey';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Product Attributes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bot = new \App\Scraper\Digikey();
        // $bot->scrape();
        $bot->search();
        return 0;
    }
}
