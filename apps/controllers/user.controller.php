<?php

require_once 'apps/models/user.model.php';
require_once 'apps/views/json.view.php';
require_once 'libraries/jwt.php';

class UserController{
    
    private $model;
    private $view;

    function __construct(){
        $this->model = new UserModel();
        $this->view = new JSONView();
    }

    function getToken($request, $response){

        $header = $_SERVER['HTTP_AUTHORIZATION'];

        $header = explode(' ', $header);

        if(count($header) != 2){
            return $this->view->response("Datos ingresados incorrectos", 401);
        }

        if($header[0] != 'Basic'){
            return $this->view->response("Datos ingresados incorrectos", 401);
        }

        $usuario_contraseña = base64_decode($header[1]);
        $usuario_contraseña = explode(':', $usuario_contraseña);

        $user = $this->model->getDatosAdmin($usuario_contraseña[0]);

        if($user == null || !password_verify($usuario_contraseña[1], $user->contraseña)){
            return $this->view->response("Datos ingresados incorrectos", 401);
        }

        $token = createJWT(array(
            'sub' => $user->id_usuario,
            'role' => 'admin',
            'iat' => time(),
            'exp' => time() + 120,
            'Saludo' => 'Hola '.$user->user,
        ));


        return $this->view->response($token);
    }
}