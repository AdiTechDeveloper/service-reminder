@extends('layouts.crm')

@section('content')

<style>
    .dashboard-header {
        background: linear-gradient(135deg, #212529, #343a40);
        color: #fff;
        border-radius: 14px;
        padding: 22px 24px;
        margin-bottom: 20px;
    }

    .dashboard-header h4 {
        margin: 0;
        font-weight: 600;
    }

    .dashboard-header p {
        margin: 5px 0 0;
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
    }

    .stat-card {
        border: 1px solid #e9ecef;
        border-radius: 14px;
        background: #fff;
        transition: all 0.2s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.07);
    }

    .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-number {
        font-size: 30px;
        font-weight: 700;
        line-height: 1;
        color: #212529;
    }

    .stat-label {
        color: #6c757d;
        font-size: 14px;
        margin-top: 7px;
    }

    .icon-primary {
        background: #e7f1ff;
        color: #0d6efd;
    }

    .icon-warning {
        background: #fff3cd;
        color: #856404;
    }

    .icon-danger {
        background: #f8d7da;
        color: #842029;
    }

    .section-card {
        border: 1px solid #e9ecef;
        border-radius: 14px;
        overflow: hidden;
        background: #fff;
    }

    .section-card .card-header {
        background: #fff;
        border-bottom: 1px solid #e9ecef;
        padding: 16px 20px;
        font-weight: 600;
    }

    .table > :not(caption) > * > * {
        padding: 14px 16px;
    }

    .table tbody tr {
        transition: background 0.15s ease;
    }

    .table tbody tr:hover {
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

    .empty-state {
        padding: 45px 20px;
        text-align: center;
        color: #6c757d;
    }

    .empty-icon {
        font-size: 38px;
        margin-bottom: 10px;
    }
</style>

<div class="dashboard-header">
    <h4>Service Dashboard</h4>
    <p>Monitor your client services and upcoming expiry dates.</p>
</div>

<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="stat-card">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <div class="stat-number">
                            {{ $total }}
                        </div>

                        <div class="stat-label">
                            Total Services
                        </div>
                    </div>

                    <div class="stat-icon icon-primary">
                        📋
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <div class="stat-number">
                            {{ $expiring }}
                        </div>

                        <div class="stat-label">
                            Expiring Within 10 Days
                        </div>
                    </div>

                    <div class="stat-icon icon-warning">
                        ⏰
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <div class="stat-number">
                            {{ $expired }}
                        </div>

                        <div class="stat-label">
                            Expired Services
                        </div>
                    </div>

                    <div class="stat-icon icon-danger">
                        ⚠️
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

<div class="section-card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <div>
            <div>Upcoming Expiries</div>
            <small class="text-muted fw-normal">
                Next 30 days and expired services
            </small>
        </div>

        <a href="{{ route('client-services.index') }}"
           class="btn btn-sm btn-outline-primary">
            View All Services
        </a>

    </div>

    <div class="table-responsive">

        <table class="table mb-0 align-middle">

            <thead class="table-light">
                <tr>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

            @forelse($upcoming as $s)

                <tr>

                    <td>
                        <div class="client-name">
                            {{ $s->client->name }}
                        </div>

                        @if($s->client->company)
                            <div class="small text-muted">
                                {{ $s->client->company }}
                            </div>
                        @endif
                    </td>

                    <td>
                        <div class="service-name">
                            {{ $s->serviceType->name }}
                        </div>

                        @if($s->title)
                            <div class="small text-muted">
                                {{ $s->title }}
                            </div>
                        @endif
                    </td>

                    <td>
                        {{ $s->expiry_date->format('d M Y') }}
                    </td>

                    <td>
                        <x-days-badge :service="$s" />
                    </td>

                    <td class="text-nowrap">

                        <a href="{{ route('client-services.edit', $s) }}"
                           class="btn btn-sm btn-outline-primary">
                            Renew / Edit
                        </a>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5">

                        <div class="empty-state">

                            <div class="empty-icon">
                                ✅
                            </div>

                            <div class="fw-semibold text-dark">
                                No Upcoming Expiries
                            </div>

                            <div class="small">
                                There are no upcoming or expired services.
                            </div>

                        </div>

                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection