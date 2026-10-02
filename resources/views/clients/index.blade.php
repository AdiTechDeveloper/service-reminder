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

    .client-table-card {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 14px;
        overflow: hidden;
    }

    .client-table-card .table {
        margin-bottom: 0;
    }

    .client-table-card thead th {
        background: #f8f9fa;
        color: #495057;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        padding: 14px 16px;
        border-bottom: 1px solid #e9ecef;
    }

    .client-table-card tbody td {
        padding: 15px 16px;
        border-bottom: 1px solid #f0f1f2;
        vertical-align: middle;
    }

    .client-table-card tbody tr {
        transition: background 0.15s ease;
    }

    .client-table-card tbody tr:hover {
        background: #f8f9fa;
    }

    .client-name {
        font-weight: 600;
        color: #212529;
    }

    .company-name {
        font-size: 12px;
        color: #6c757d;
        margin-top: 3px;
    }

    .contact-text {
        color: #495057;
        font-size: 14px;
    }

    .service-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 28px;
        padding: 0 9px;
        border-radius: 20px;
        background: #e7f1ff;
        color: #0d6efd;
        font-size: 13px;
        font-weight: 600;
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
            <h4>Clients</h4>

            <p>
                Manage your clients and their associated services.
            </p>
        </div>

        <a href="{{ route('clients.create') }}"
           class="btn btn-primary">
            + Add Client
        </a>

    </div>

</div>

<div class="client-table-card">

    <div class="table-responsive">

        <table class="table align-middle">

            <thead>
                <tr>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Services</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>

            <tbody>

            @forelse($clients as $c)

                <tr>

                    <td>
                        <div class="client-name">
                            {{ $c->name }}
                        </div>
                    </td>

                    <td>
                        @if($c->company)
                            <div class="company-name">
                                {{ $c->company }}
                            </div>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>

                    <td>
                        @if($c->phone)
                            <span class="contact-text">
                                {{ $c->phone }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>

                    <td>
                        @if($c->email)
                            <span class="contact-text">
                                {{ $c->email }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>

                    <td>
                        <span class="service-count">
                            {{ $c->services_count }}
                        </span>
                    </td>

                    <td class="text-end action-buttons">

                        <form method="POST"
                              action="{{ route('clients.destroy', $c) }}"
                              class="d-inline"
                              onsubmit="return confirm('The client and all associated services will be deleted. Are you sure?')">

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
                                👥
                            </div>

                            <div class="fw-semibold text-dark mb-1">
                                No Clients Found
                            </div>

                            <div class="small">
                                Add a client to start managing their services.
                            </div>

                        </div>

                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@if($clients->hasPages())

    <div class="pagination-wrapper">
        {{ $clients->links() }}
    </div>

@endif

@endsection