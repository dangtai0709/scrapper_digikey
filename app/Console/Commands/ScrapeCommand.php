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
        // $bot = new \App\Scraper\Digikey();
        // // $bot->scrape();
        // $bot->searchByTag("S25FL064LABNFI043");
        // return 0;
        $path = base_path("resources/pendingProducts/*.csv");
        $data = [];
        //run 2 loops at a time
        foreach (array_slice(glob($path), 0, 2) as $file) {
            //read the data into an array
            $dataFile = array_map('str_getcsv', file($file));
            foreach ($dataFile as $row) {
                $string = trim(preg_replace('/\s\s+/', ' ', $row));
                $data[] = $bot->searchByTag($string);
            }
            $data = array_merge(...$data);
            //delete the file
            unlink($file);
            //call function export csv
            $filename = base_path('resources/productsFile/' . date('y-m-d-H-i-s') . '.csv');
            file_put_contents($filename, $data);
        }
    }
}
