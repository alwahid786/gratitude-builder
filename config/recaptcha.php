<?php

return [
    /*
    |--------------------------------------------------------------------------
    | reCAPTCHA Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your reCAPTCHA settings. You can get your
    | site key and secret key from https://www.google.com/recaptcha/admin
    |
    */

    'site_key' => env('RECAPTCHA_SITE_KEY', '6LfhyjolAAAAAHsmsc1Aflgn3UBj9LRoNlp-rjEo'),
    'secret_key' => env('RECAPTCHA_SECRET_KEY', '6LfhyjolAAAAAHsmsc1Aflgn3UBj9LRoNlp-rjEo'),
    'verify_url' => 'https://www.google.com/recaptcha/api/siteverify',
];