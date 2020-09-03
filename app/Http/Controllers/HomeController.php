<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $filename = base_path('resources/pendingProducts/' . date('y-m-d-H-i-s'). '.csv');
        file_put_contents($filename, $file);
        session()->flash('status', 'queued for importing');
        return redirect("home");
    }
}
