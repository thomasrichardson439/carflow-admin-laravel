@component('layouts.email-html')

    <p>Can you please add {{ $user->full_name }} to <b>{{ $policyNumber }}</b></p>
    <p><b>{{ $user->address }}</b></p>

    <br>

    <p>Sinceresly,</p>
    <p>Carl Nowicky</p>
    <p>Car Flo Inc.</p>
    <p>Cheaf Operating Officer</p>
    <p>T: (516)650-8604</p>
    <p>www.carflo.co</p>
@endcomponent

