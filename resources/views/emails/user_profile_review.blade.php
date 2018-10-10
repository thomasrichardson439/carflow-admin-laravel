@component('mail::message')

    Hello!<br>
    <br>

    @if ($newUpdateStatus == \App\Models\UserProfileUpdate::STATUS_APPROVED)
        Your profile changes were approved!
        Profile data is updated.
    @endif

    @if ($newUpdateStatus == \App\Models\UserProfileUpdate::STATUS_REJECTED)
        Your profile changes were rejected!
        Old profile data was restored.
    @endif

    <br>
    <br>
    <br>
    Best regards,<br>
    <br>
    CarFlow<br>
    <br>

@endcomponent

