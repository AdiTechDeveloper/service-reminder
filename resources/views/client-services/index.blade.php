@extends('layouts.crm')

@section('content')

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

    .service-table-card {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 14px;
        overflow: hidden;
    }

    .service-table-card .table {
        margin-bottom: 0;
    }

    .service-table-card thead th {
        background: #f8f9fa;
        color: #495057;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        padding: 14px 16px;
        border-bottom: 1px solid #e9ecef;
    }

    .service-table-card tbody td {
        padding: 15px 16px;
        border-bottom: 1px solid #f0f1f2;
        vertical-align: middle;
    }

    .service-table-card tbody tr {
        transition: background 0.15s ease;
    }

    .service-table-card tbody tr:hover {
        background: #f8f9fa;
    }

    .client-name {
        font-weight: 600;
        color: #212529;
    }

    .service-name {
        font-weight: 500;
        color: #212529;
    }

    .secondary-text {
        font-size: 12px;
        color: #6c757d;
        margin-top: 3px;
    }

    .date-text {
        white-space: nowrap;
        color: #495057;
        font-size: 14px;
    }

    .action-buttons {
        white-space: nowrap;
    }

    .empty-state {
        padding: 50px 20px;
        text-align: center;
        color: #6c757d;
    }

    .empty-icon {
        font-size: 40px;
        margin-bottom: 10px;
    }

    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
</style>

<div class="page-header">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>
            <h4>Client Services</h4>

            <p>
                Manage client services, expiry dates and renewals.
            </p>
        </div>

        <a href="{{ route('client-services.create') }}"
           class="btn btn-primary">
            + Add Service
        </a>

    </div>

</div>

<div class="service-table-card">

    <div class="table-responsive">

        <table class="table align-middle">

            <thead>
                <tr>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Start Date</th>
                    <th>Expiry Date</th>
                    <th>Remaining</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>

            <tbody>

            @forelse($services as $s)

                <tr>

                    <td>

                        <div class="client-name">
                            {{ $s->client->name }}
                        </div>

                        @if($s->client->company)
                            <div class="secondary-text">
                                {{ $s->client->company }}
                            </div>
                        @endif

                    </td>

                    <td>

                        <div class="service-name">
                            {{ $s->serviceType->name }}
                        </div>

                        @if($s->title)
                            <div class="secondary-text">
                                {{ $s->title }}
                            </div>
                        @endif

                    </td>

                    <td>
                        <span class="date-text">
                            {{ $s->start_date->format('d M Y') }}
                        </span>
                    </td>

                    <td>
                        <span class="date-text">
                            {{ $s->expiry_date->format('d M Y') }}
                        </span>
                    </td>

                    <td>
                        <x-days-badge :service="$s" />
                    </td>

                    <td class="text-end action-buttons">

                        <a href="{{ route('client-services.edit', $s) }}"
                           class="btn btn-sm btn-outline-primary">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('client-services.destroy', $s) }}"
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this service?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-sm btn-outline-danger">
                                Delete
                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6">

                        <div class="empty-state">

                            <div class="empty-icon">
                                📋
                            </div>

                            <div class="fw-semibold text-dark mb-1">
                                No Services Found
                            </div>

                            <div class="small">
                                Add a client service to start tracking expiry dates.
                            </div>

                        </div>

                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@if($services->hasPages())

    <div class="pagination-wrapper">
        {{ $services->links() }}
    </div>

@endif

@endsection