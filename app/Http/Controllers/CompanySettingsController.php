<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanySettingsController extends Controller
{
     /**
     * Show the company settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('configuration.company-settings');
    }
}
