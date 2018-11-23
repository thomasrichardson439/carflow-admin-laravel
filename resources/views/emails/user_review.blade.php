@component('layouts.email-carflow')

    <h4 class="subtitle">ACCOUNT STATUS</h4>

    @if ($newUserStatus == ConstUserStatus::APPROVED)
        <p>Congrats {{ $user->full_name }}!<br>
            You're account was approved. Welcome to Car Flo! We look forward to having you as part of our community. The next step is to log in into our mobile app and
            start booking the hours you would like to drive/manage your reservations.
        </p>
    @endif

    @if ($newUserStatus == ConstUserStatus::REJECTED)
        <p>Hello {{ $user->full_name }}!<br>
            Unfortunately, your account was denided. Reason: <i>{{ $rejectReason }}</i>
        </p>
    @endif

@endcomponent

