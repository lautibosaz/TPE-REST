<?php

class UserModel{

    function connect(){

        $db = new PDO('mysql:host=localhost;' . 'dbname=pelicula;charset=utf8', 'root', '');
        return $db;
    }

    function getDatosAdmin($usuario){

        $db = $this->connect();

        $query = $db->prepare('SELECT * FROM usuario WHERE user = ?');
        $query->execute([$usuario]);

        $datos = $query->fetch(PDO::FETCH_OBJ);

        return $datos;
    }
}