<?php

require __DIR__ . '/../src/bootstrap.php';

$errors = [];
$inputs = [];

if (is_post_request()) {

    $fields = [
        'username' => 'string | required | alphanumeric | between: 3, 25',
        'password' => 'string | required'
    ];

    // custom messages
    $messages = [];

    [$inputs, $errors] = filter($_POST, $fields, $messages);

    if ($errors) {
        redirect_with('login.php', [
            'inputs' => $inputs,
            'errors' => $errors
        ]);
    }

    if (login($inputs['username'], $inputs['password'])) {
        redirect_to('dashboard.php');
    } else {
        $errors['login'] = 'Invalid username or password';
        redirect_with('login.php', [
            'inputs' => $inputs,
            'errors' => $errors
        ]);
    }

} else if (is_get_request()) {
    [$inputs, $errors] = session_flash('inputs', 'errors');
}