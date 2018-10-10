@component('mail::message')

    Hello!<br>
    <br>

    @if ($newUserStatus == \ConstUserStatus::APPROVED)
        Your account was approved!<br>
        Now you can use all functions from CarFlow application!<br>
    @endif

    @if ($newUserStatus == \ConstUserStatus::REJECTED)
        Your documents was rejected!<br>
        Please provide valid drive documents!<br>
    @endif

    <br>
    <br>
    <br>
    Best regards,<br>
    <br>
    CarFlow<br>
    <br>

@endcomponent

