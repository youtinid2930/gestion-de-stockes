<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Depot;
use Illuminate\Http\Request;

class DepotSettingsController extends Controller
{
    /**
     * Show the depot settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the current authenticated user
        $user = Auth::user();
        
        // Check if the user has a depot_id set and it's not zero
        if ($user->depot_id && $user->depot_id != 0) {
            // Retrieve the depot by depot_id
            $depot = Depot::find($user->depot_id);
        } else {
            // No depot information or depot_id is 0
            $depot = null;
        }


        return view('configuration.depot-settings', compact('depot'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'addresse' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        // Get the current authenticated user
        $user = Auth::user();

        // Check if the depot already exists
        if ($user->depot_id && $user->depot_id != 0) {
            // Update existing depot
            $depot = Depot::find($user->depot_id);
            if ($depot) {
                $depot->update([
                    'name' => $request->input('name'),
                    'adresse' => $request->input('addresse'),
                    'type' => $request->input('type'),
                ]);
            }
        } else {
            // Create a new depot
            $depot = Depot::create([
                'name' => $request->input('name'),
                'adresse' => $request->input('addresse'),
                'type' => $request->input('type'),
            ]);

            // Update user's depot_id
            $user->depot_id = $depot->id;
            $user->save();
        }

        // Redirect with a success message
        return redirect()->route('depot.settings')->with('success', 'Depot settings saved successfully.');
    }
}
