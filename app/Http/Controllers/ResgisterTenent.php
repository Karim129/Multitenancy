<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\Password;
use Stancl\Tenancy\Database\Models\Domain;

class ResgisterTenent extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tenants.index')->with('tenants', Tenant::with('domains')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenants.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'company_name' => ['required', 'unique:tenants,id', 'string', 'max:255'],
            'domain' => ['required', 'string', 'max:255'],
        ]);

        // Check if the domain is already occupied
        $fullDomain = $request->domain . "." . config('tenancy.central_domains')[2];
        $existingDomain = Domain::where('domain', $fullDomain)->first();

        if ($existingDomain) {
            return redirect()->back()->withErrors(['domain' => 'The ' . $request->domain . ' domain is occupied by another tenant.'])->withInput();
        }
        // dd($request->all());

        try {
            $tenant1 = Tenant::create(['id' => $request->company_name]);
            $tenant1->domains()->create(['domain' => $fullDomain]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while creating the tenant: ' . $e->getMessage()])->withInput();
        }
        // Call the Artisan command to generate the script
        Artisan::call('setup:domain', [
            'domain' => $fullDomain,
            'projectDir' => base_path()
        ]);


    $scriptPath = storage_path('scripts/setup-domain.bat');
    return to_route('tenants.index')->with('tenant', $tenant1)->with('scriptPath', $scriptPath);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect(URL::to($id . config('tenancy.central_domains')[-1]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {

    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
