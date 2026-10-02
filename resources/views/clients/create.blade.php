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

    .client-form-card {
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

    .required-mark {
        color: #dc3545;
    }

    .form-control {
        border-color: #dee2e6;
        border-radius: 8px;
        padding: 10px 12px;
    }

    .form-control:focus {
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
</style>

<div class="page-header">

    <h4>New Client</h4>

    <p>
        Add a new client and their contact information.
    </p>

</div>

<form method="POST"
      action="{{ route('clients.store') }}"
      class="client-form-card">

    @csrf

    <div class="form-section">

        <div class="row g-4">

            <div class="col-md-6">

                <label class="form-label">
                    Name <span class="required-mark">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-control"
                    placeholder="Enter client name"
                    required>

            </div>

            <div class="col-md-6">

                <label class="form-label">
                    Company
                </label>

                <input
                    type="text"
                    name="company"
                    value="{{ old('company') }}"
                    class="form-control"
                    placeholder="Enter company name">

            </div>

            <div class="col-md-6">

                <label class="form-label">
                    Phone
                </label>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    class="form-control"
                    placeholder="Enter phone number">

            </div>

            <div class="col-md-6">

                <label class="form-label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control"
                    placeholder="Enter email address">

            </div>

            <div class="col-12">

                <label class="form-label">
                    Address
                </label>

                <textarea
                    name="address"
                    class="form-control"
                    rows="3"
                    placeholder="Enter client address">{{ old('address') }}</textarea>

            </div>

        </div>

    </div>

    <div class="form-actions d-flex justify-content-between align-items-center">

        <a href="{{ route('clients.index') }}"
           class="btn btn-outline-secondary">
            Cancel
        </a>

        <button type="submit" class="btn btn-primary px-4">
            Save Client
        </button>

    </div>

</form>

@endsection