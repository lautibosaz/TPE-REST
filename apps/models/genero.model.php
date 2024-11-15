<?php 

class GeneroModel {

    function connect(){

        $db = new PDO('mysql:host=localhost;' . 'dbname=pelicula;charset=utf8', 'root', '');
        return $db;
    }

    function getGeneros(){

        $db = $this->connect();

        $query = $db-> prepare('SELECT * from genero');
        $query -> execute();

        $generos = $query->fetchAll(PDO::FETCH_OBJ);

        return $generos;
    }

    function getGeneroByID($idGenero){

        $db = $this->connect();

        $query = $db->prepare('SELECT * FROM genero WHERE id_genero = ?');
        $query->execute([$idGenero]);

        $genero = $query->fetch(PDO::FETCH_OBJ);

        return $genero;
    }

    function getGeneroByNombre($nombreGenero) {

        $db = $this->connect();

        $query = $db->prepare('SELECT * FROM genero WHERE genero = ?'); 
        $query->execute([$nombreGenero]);

        $genero = $query->fetch(PDO::FETCH_OBJ); 

        return $genero;
    }

    function eliminarGenero($idGenero){
        $db = $this->connect();

        $query = $db->prepare('DELETE FROM genero WHERE id_genero = ?');
        $query->execute([$idGenero]);
    }

    public function agregarGenero($genero, $descripcion){
        $db = $this->connect();

        $query = $db->prepare('INSERT INTO `genero`(`genero`, `descripcion`) VALUES (?, ?)');
        $query->execute([$genero, $descripcion]);

        $id = $db->lastInsertId();

        return $id;
    }

    public function editarGenero($genero, $descripcion, $idGenero){

        $db = $this->connect();

        $query = $db->prepare('UPDATE genero SET genero=?, descripcion=? WHERE id_genero = ?');
        $query->execute([$genero, $descripcion, $idGenero]);

    }
}