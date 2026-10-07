@extends('layouts.crm')

@section('content')

@php
$editing = $service->exists;
@endphp

<style>
    .page-header {
        background: linear-gradient(135deg, #212529, #343a40);
        color: #fff;
        border-radius: 14px;
        padding: 22px 24px;
        margin-bottom: 20px;
    }

    .page-header h4 {
        margin: 0;
        font-weight: 600;
    }

    .page-header p {
        margin: 5px 0 0;
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
    }

    .service-form-card {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 14px;
        overflow: hidden;
    }

    .form-section {
        padding: 24px;
    }

    .form-label {
        font-weight: 500;
        color: #343a40;
        margin-bottom: 7px;
    }

    .form-control,
    .form-select {
        border-color: #dee2e6;
        border-radius: 8px;
        padding: 10px 12px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.12);
    }

    .form-help {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }

    .form-actions {
        padding: 18px 24px;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }

    .required-mark {
        color: #dc3545;
    }
</style>

<div class="page-header">
    <h4>
        {{ $editing ? 'Edit / Renew Service' : 'Add New Client Service' }}
    </h4>

    <p>
        {{ $editing
            ? 'Update the service details or renew its expiry date.'
            : 'Add a new service and configure its expiry date.' }}
    </p>
</div>

<form method="POST"
    action="{{ $editing ? route('client-services.update', $service) : route('client-services.store') }}"
    class="service-form-card">

    @csrf

    @if($editing)
    @method('PUT')
    @endif

    <div class="form-section">

        <div class="row g-4">

            <div class="col-md-6">

                <label class="form-label">
                    Client <span class="required-mark">*</span>
                </label>

                <select name="client_id" class="form-select" required>

                    <option value="">
                        -- Select Client --
                    </option>

                    @foreach($clients as $c)

                    <option value="{{ $c->id }}"
                        @selected(old('client_id', $service->client_id) == $c->id)>
                        {{ $c->name }}
                        {{ $c->company ? '('.$c->company.')' : '' }}
                    </option>

                    @endforeach

                </select>

                @if($clients->isEmpty())

                <div class="form-text text-danger">
                    No clients available.
                    <a href="{{ route('clients.create') }}">
                        Add a client first
                    </a>.
                </div>

                @else

                <div class="form-help">
                    Select the client who owns this service.
                </div>

                @endif

            </div>

            <div class="col-md-6">

                <label class="form-label">
                    Service Type <span class="required-mark">*</span>
                </label>

                <div
                    class="border rounded p-3 flex"
                    style="max-height: 180px; overflow-y: auto;">

                    @foreach($types as $t)

                    <div class="form-check mb-2">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="service_type_ids[]"
                            value="{{ $t->id }}"
                            id="service_type_{{ $t->id }}"
                            @checked(in_array($t->id, old('service_type_ids', $selectedTypes ?? [])))
                        >

                        <label
                            class="form-check-label"
                            for="service_type_{{ $t->id }}">
                            {{ $t->name }}
                        </label>
                    </div>

                    @endforeach

                </div>

                <div class="form-help">
                    Select one or more services.
                </div>

            </div>

            <div class="col-12">

                <label class="form-label">
                    Service Title
                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $service->title) }}"
                    class="form-control"
                    placeholder="example.com">

                <div class="form-help">
                    Optional. You can enter a domain name, plan name, project name, etc.
                </div>

            </div>

            <div class="col-md-6">

                <label class="form-label">
                    Start Date <span class="required-mark">*</span>
                </label>

                <input
                    type="date"
                    name="start_date"
                    value="{{ old('start_date', optional($service->start_date)->toDateString()) }}"
                    class="form-control"
                    required>

            </div>

            <div class="col-md-6">

                <label class="form-label">
                    Expiry Date <span class="required-mark">*</span>
                </label>

                <input
                    type="date"
                    name="expiry_date"
                    value="{{ old('expiry_date', optional($service->expiry_date)->toDateString()) }}"
                    class="form-control"
                    required>

                <div class="form-help">
                    Notifications will be sent before this date.
                </div>

            </div>

            <div class="col-12">

                <label class="form-label">
                    Notes
                </label>

                <textarea
                    name="notes"
                    rows="3"
                    class="form-control"
                    placeholder="Add any additional information about this service...">{{ old('notes', $service->notes) }}</textarea>

            </div>

        </div>

    </div>

    <div class="form-actions d-flex justify-content-between align-items-center">

        <a href="{{ route('client-services.index') }}"
            class="btn btn-outline-secondary">
            Cancel
        </a>

        <button type="submit" class="btn btn-primary px-4">
            {{ $editing ? 'Update Service' : 'Save Service' }}
        </button>

    </div>

</form>

@endsection