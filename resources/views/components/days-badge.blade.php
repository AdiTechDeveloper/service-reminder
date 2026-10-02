@props(['service'])

@php
    $d = $service->days_left;
@endphp

@if($d < 0)

    <span class="badge bg-dark">
        Expired ({{ abs($d) }} days ago)
    </span>

@elseif($d === 0)

    <span class="badge bg-danger">
        Expires Today
    </span>

@elseif($d <= 3)

    <span class="badge bg-danger">
        {{ $d }} days remaining
    </span>

@elseif($d <= 10)

    <span class="badge bg-warning text-dark">
        {{ $d }} days remaining
    </span>

@else

    <span class="badge bg-success">
        {{ $d }} days remaining
    </span>

@endif