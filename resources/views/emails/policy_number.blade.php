@component('layouts.email-html')

    <p>Can you please add {{ $user->full_name }} to <b>{{ $policyNumber }}</b></p>
    <p>Mailing address: <b>{{ $user->address }}</b></p>

    <br>

    <p>Sincerely,</p>
    <p>Carl Nowicki</p>
    <p>Car Flo Inc.</p>
    <p>Chief Operating Officer</p>
    <p>T: (516) 650-8604</p>
    <p><a href="http://www.carflo.co">www.carflo.co</a></p>
@endcomponent