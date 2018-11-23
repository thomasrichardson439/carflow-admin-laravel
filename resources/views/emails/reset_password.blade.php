@component('layouts.email-carflow')

    <h4 class="subtitle">Password reset</h4>

    <p>Hello,<br>
        You are receiving this email because we received a password reset request for your account.
    </p>

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
        <tbody>
        <tr>
            <td align="left">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td> <a href="{{ $actionUrl }}" target="_blank">{{ $actionText }}</a> </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

    <p class="signature">If you did not request a password reset, no further action is required.</p>

@endcomponent

