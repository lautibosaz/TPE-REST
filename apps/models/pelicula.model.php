<?php

class PeliculaModel{

    function connect(){

        $db = new PDO('mysql:host=localhost;' . 'dbname=pelicula;charset=utf8', 'root', '');
        return $db;
    }

    function getPeliculas($filtro, $orden, $direccion)
    {
        $db = $this->connect();
        
        $sql = 'SELECT * FROM peliculas';

        if($filtro != null){
            $sql .= ' INNER JOIN genero ON peliculas.id_genero = genero.id_genero 
        WHERE genero.genero = ?
        '; 
        }

        if($orden != null){
            switch($orden){
                case 'titulo' :
                    $sql .= ' ORDER BY titulo '. $direccion;
                    break;
                case 'director' :
                    $sql .= ' ORDER BY director '. $direccion;
                    break;
                case 'calificacion' :
                    $sql .= ' ORDER BY calificacion '. $direccion;
                    break;
                case 'descripcion' :
                    $sql .= ' ORDER BY descripcion '. $direccion;
                    break;
                case 'estreno' :
                    $sql .= ' ORDER BY estreno '. $direccion;
                    break;
            }
        }

        $query = $db->prepare($sql);
        
        if ($filtro != null) {
            $query->execute([$filtro]);
        } else {
            $query->execute();
        }    

        $peliculas = $query->fetchAll(PDO::FETCH_OBJ);

        return $peliculas;
    }

    function getPeliculaByID($id){
        
        $db = $this->connect();

        $query = $db->prepare('SELECT * from peliculas WHERE id_pelicula = ?');
        $query->execute([$id]);

        $pelicula = $query->fetchAll(PDO::FETCH_OBJ);

        return $pelicula;
    }

    function eliminarPelicula($id){
        
        $db = $this->connect();

        $query = $db->prepare('DELETE FROM peliculas WHERE id_pelicula = ?');
        $query->execute([$id]);
    }

    function agregarPelicula($nombreGenero, $titulo, $director, $descripcion, $calificacion, $estreno){

        $db = $this->connect();
    
        // Obtener el ID del género a partir del nombre
        $queryGenero = $db->prepare('SELECT id_genero FROM genero WHERE genero = ?');
        $queryGenero->execute([$nombreGenero]);
        $genero = $queryGenero->fetch(PDO::FETCH_OBJ);
    
        // Verificar si se encontró el género
        if (!$genero) {
            // Si el género no existe, retorna null o un error específico
            return null;
        }
    
        // Insertar la película con el id_genero obtenido
        $query = $db->prepare('INSERT INTO peliculas (id_genero, titulo, director, descripcion, calificacion, estreno) VALUES (?, ?, ?, ?, ?, ?)');
        $query->execute([$genero->id_genero, $titulo, $director, $descripcion, $calificacion, $estreno]);
    
        $id = $db->lastInsertId();
    
        return $id;
    }

    function editarPelicula($id, $titulo, $director, $descripcion, $calificacion, $estreno){

        $db = $this->connect();

        $query = $db->prepare('UPDATE peliculas SET titulo=?, director=?, descripcion=?, calificacion=?, estreno=? WHERE id_pelicula = ?');
        $query->execute([$titulo, $director, $descripcion, $calificacion, $estreno, $id]);

    }
}