<?php

// display a view 
function view(string $filename, array $data = [] ) : void{
    // create variables from the associative array
    foreach($data as $key => $value){
        $$key = $value;
    }

    require_once __DIR__ . '/../inc/' . $filename . '.php';
}

// return the error class if error is found in the array $errors
function error_class(array $errors, string $field) : string {
    return isset($errors[$field]) ? 'error' : '';
}

// return true if the request method is POST
function is_post_request() : bool {
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
}

// return true if the request method is GET
function is_get_request() : bool {
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'GET';
}

//redirect to another url
function redirect_to(string $url) : void{
    header('Location: '. $url);
    exit;
}

//redirect to a URL with data stored in the items array
function redirect_with(string $url, array $items ) : void{
    foreach ($items as $key => $value){
        $_SESSION[$key] = $value;
    }
    redirect_to($url);
}

// redirect to a URL With a flash message

function redirect_with_message(string $url, string $message, string $type = FLASH_SUCCESS){
    flash('flash_' .uniqid(), $message, $type);
    redirect_to($url);
}

// flash data specified by keys from the $_SESSION

function session_flash(...$keys) : array{
    $data = [];
    foreach($keys as $key){
        if(isset($_SESSION[$key])){
            $data[] = $_SESSION[$key];
            unset($_SESSION[$key]);
        }else{
            $data[]  = [];
        }
    }
    return $data;
}