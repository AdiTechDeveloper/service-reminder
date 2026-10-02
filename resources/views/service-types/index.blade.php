@extends('layouts.crm')
@section('content')
<h4>Service Types</h4>
<form method="POST" action="{{ route('service-types.store') }}" class="input-group mb-3" style="max-width:420px">
    @csrf
    <input name="name" class="form-control" placeholder="e.g. Email Hosting, SSL" required>
    <button class="btn btn-primary">Add</button>
</form>
<div class="card"><ul class="list-group list-group-flush">
@foreach($types as $t)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>{{ $t->name }} <span class="badge bg-secondary">{{ $t->services_count }}</span></span>
        <form method="POST" action="{{ route('service-types.destroy', $t) }}">@csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger">Delete</button>
        </form>
    </li>
@endforeach
</ul></div>
@endsection
