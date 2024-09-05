<?php

namespace App\Http\Controllers;
use App\Models\Company;

use Illuminate\Http\Request;

class CompanyInfoController extends Controller
{
    public function index()
    {
        return view('configuration.company-info'); // Assurez-vous que cette vue existe
    }
}