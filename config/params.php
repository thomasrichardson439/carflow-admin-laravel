<?php

return [
    /**
     * Limits booking
     */
    'maxBookingInHours' => 12,

    /**
     * Email of manager who receive policy email
     */
    'userPolicyManagerEmail' => env('POLICY_MANAGER_EMAIL'),
    'userPolicyCcEmail' => env('POLICY_CC_EMAIL'),

    'googleMapsKey' => env('GOOGLE_MAPS_KEY', ''),
];