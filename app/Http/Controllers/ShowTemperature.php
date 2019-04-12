<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShowTemperature extends Controller
{
    /**
     * Show ttemperature
     *
     * @return View
     */
    public function __invoke()
    {
        return view('show_temperature.show');
    }
}
