<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceTypeController extends Controller
{
    public function index()
    {
        ServiceType::ensureDefaults(auth()->id());
        $types = auth()->user()->serviceTypes()->withCount('services')->orderBy('name')->get();

        return view('service-types.index', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('service_types', 'name')->where('user_id', auth()->id())
            ],
        ]);

        $request->user()->serviceTypes()->create($data);

        return back()->with('ok', 'Service type Add Successfully');
    }

    public function destroy(ServiceType $service_type)
    {
        abort_unless($service_type->user_id === auth()->id(), 403);

        if ($service_type->services()->exists()) {

            return back()->withErrors([
                'name' => 'This service type is currently in use and cannot be deleted.'
            ]);
        }
        $service_type->delete();

        return back()->with('ok', 'Service type deleted successfully.');
    }
}
