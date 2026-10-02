@extends('layouts.crm')

@section('content')

@php
    $highlight = request('highlight');
@endphp

<style>
    .notification-header {
        background: linear-gradient(135deg, #212529, #343a40);
        color: #fff;
        border-radius: 14px;
        padding: 20px 24px;
        margin-bottom: 20px;
    }

    .notification-header h4 {
        margin: 0;
        font-weight: 600;
    }

    .notification-header p {
        margin: 5px 0 0;
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
    }

    .notification-card {
        display: block;
        text-decoration: none;
        color: inherit;
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 18px 20px;
        margin-bottom: 12px;
        transition: all 0.2s ease;
        position: relative;
    }

    .notification-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        border-color: #ced4da;
        color: inherit;
    }

    .notification-card.unread {
        border-left: 4px solid #ffc107;
        background: #fffdf5;
    }

    .notification-card.read {
        border-left: 4px solid #dee2e6;
    }

    .notification-card.highlighted {
        border: 2px solid #0d6efd;
        background: #f0f6ff;
        box-shadow: 0 8px 24px rgba(13, 110, 253, 0.15);
    }

    .notification-icon {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff3cd;
        color: #856404;
        font-size: 19px;
    }

    .notification-card.read .notification-icon {
        background: #f1f3f5;
        color: #6c757d;
    }

    .notification-title {
        font-weight: 600;
        font-size: 15px;
        color: #212529;
    }

    .notification-message {
        color: #495057;
        font-size: 14px;
        margin-top: 5px;
        line-height: 1.5;
    }

    .notification-time {
        color: #6c757d;
        font-size: 12px;
        white-space: nowrap;
    }

    .unread-dot {
        width: 8px;
        height: 8px;
        background: #ffc107;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }

    .highlight-badge {
        font-size: 11px;
        margin-left: 8px;
    }

    .notification-empty {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 14px;
        padding: 55px 20px;
        text-align: center;
    }

    .notification-empty-icon {
        font-size: 45px;
        margin-bottom: 12px;
    }

    .notification-empty h5 {
        margin-bottom: 5px;
        font-weight: 600;
    }

    .notification-empty p {
        color: #6c757d;
        margin: 0;
    }
</style>

<div class="notification-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>
            <h4>Notifications</h4>
            <p>Stay updated about your client service expiry reminders.</p>
        </div>

        <form method="POST" action="{{ route('notifications.readAll') }}">
            @csrf

            <button class="btn btn-light btn-sm">
                ✓ Mark All as Read
            </button>
        </form>

    </div>
</div>

<div>

@forelse($notifications as $n)

    @php
        $isHighlight = $highlight && $n->id === $highlight;
        $isUnread = !$n->read_at;
    @endphp

    <a
        id="n-{{ $n->id }}"
        href="{{ route('client-services.edit', $n->data['client_service_id']) }}"
        class="notification-card
            {{ $isHighlight ? 'highlighted' : ($isUnread ? 'unread' : 'read') }}"
    >

        <div class="d-flex gap-3">

            <div class="notification-icon">
                🔔
            </div>

            <div class="flex-grow-1">

                <div class="d-flex justify-content-between align-items-start gap-3">

                    <div class="notification-title">

                        @if($isUnread)
                            <span class="unread-dot"></span>
                        @endif

                        {{ $n->data['client'] }} —
                        {{ $n->data['service'] }}

                        @if($isHighlight)
                            <span class="badge bg-primary highlight-badge">
                                Selected
                            </span>
                        @endif

                    </div>

                    <div class="notification-time">
                        {{ $n->created_at->diffForHumans() }}
                    </div>

                </div>

                <div class="notification-message">
                    {{ $n->data['message'] }}
                </div>

                @if(!empty($n->data['expiry_date']))

                    <div class="mt-2">

                        <span class="badge bg-light text-dark border">
                            📅 Expiry: {{ \Carbon\Carbon::parse($n->data['expiry_date'])->format('d M Y') }}
                        </span>

                        @if(isset($n->data['days_left']))

                            @if($n->data['days_left'] > 0)

                                <span class="badge bg-warning text-dark">
                                    {{ $n->data['days_left'] }} days remaining
                                </span>

                            @elseif($n->data['days_left'] === 0)

                                <span class="badge bg-danger">
                                    Expires Today
                                </span>

                            @else

                                <span class="badge bg-dark">
                                    Expired
                                </span>

                            @endif

                        @endif

                    </div>

                @endif

            </div>

        </div>

    </a>

@empty

    <div class="notification-empty">

        <div class="notification-empty-icon">
            🔔
        </div>

        <h5>No Notifications</h5>

        <p>
            You don't have any service expiry notifications right now.
        </p>

    </div>

@endforelse

</div>

@if($notifications->hasPages())

    <div class="mt-4 d-flex justify-content-center">
        {{ $notifications->links() }}
    </div>

@endif

@if($highlight)

<script>
    document.getElementById('n-{{ $highlight }}')
        ?.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
</script>
@endif

@endsection