<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileSettingsController extends Controller
{
    /**
     * Show the profile settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('configuration.profile-settings');
    }
}
