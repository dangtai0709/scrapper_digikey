<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Scraper\Digikey;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function parseImport()
    {
        request()->validate([
            'file' => 'required|mimes:csv,txt',
        ]);
        //get file from upload
        $path = request()->file('file')->getRealPath();

        $file = file($path);
        $bot = new Digikey();
        $data = [];
        foreach($file as $row){
            $string = trim(preg_replace('/\s\s+/', ' ', $row));
            $data[] = $bot->searchByTag($string);
        }
        $data = array_merge(...$data);
        dd($data);
        return redirect("home");
    }
}
