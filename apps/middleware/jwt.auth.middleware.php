<?php 

class JWTAuthMiddleware {

    function run($request, $response){

        $header = $_SERVER['HTTP_AUTHORIZATION'];
        $header = explode(' ', $header);

        if(count($header) != 2){
            return;
        }
        if($header[0] != 'Bearer'){
            return;
        }

        $jwt = $header[1];
        $response->user = validateJWT($jwt);
    }
}