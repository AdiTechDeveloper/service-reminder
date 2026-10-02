<?php

namespace App\Http\Controllers;

use App\Models\ClientService;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientServiceController extends Controller
{
    public function index()
    {
        $services = auth()->user()->clientServices()
            ->with(['client', 'serviceType'])->orderBy('expiry_date')->paginate(20);

        return view('client-services.index', compact('services'));
    }

    public function create()
    {
        return view('client-services.form', $this->formData(new ClientService));
    }

    public function store(Request $request)
    {
        $request->user()->clientServices()->create($this->validated($request));

        return redirect()->route('client-services.index')->with('ok', 'Service added Successfully.');
    }

    public function edit(ClientService $client_service)
    {
        $this->authorizeOwner($client_service);

        return view('client-services.form', $this->formData($client_service));
    }

    public function update(Request $request, ClientService $client_service)
    {
        $this->authorizeOwner($client_service);
        $client_service->update($this->validated($request));

        return redirect()->route('client-services.index')->with('ok', 'Service update Successfully.');
    }

    public function destroy(ClientService $client_service)
    {
        $this->authorizeOwner($client_service);
        $client_service->delete();

        return back()->with('ok', 'Service delete Successfully.');
    }

    private function authorizeOwner(ClientService $service): void
    {
        abort_unless($service->user_id === auth()->id(), 403);
    }

    private function formData(ClientService $service): array
    {
        ServiceType::ensureDefaults(auth()->id());

        return [
            'service' => $service,
            'clients' => auth()->user()->clients()->orderBy('name')->get(),
            'types'   => auth()->user()->serviceTypes()->orderBy('name')->get(),
        ];
    }

    private function validated(Request $request): array
    {
        $uid = auth()->id();

        return $request->validate([
            'client_id'       => ['required', Rule::exists('clients', 'id')->where('user_id', $uid)],
            'service_type_id' => ['required', Rule::exists('service_types', 'id')->where('user_id', $uid)],
            'title'           => 'nullable|string|max:255',
            'start_date'      => 'required|date',
            'expiry_date'     => 'required|date|after_or_equal:start_date',
            'notes'           => 'nullable|string|max:2000',
        ]);
    }
}
