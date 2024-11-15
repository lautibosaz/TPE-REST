<?php

require_once 'apps/models/pelicula.model.php';
require_once 'apps/models/genero.model.php';
require_once 'apps/views/json.view.php';

class PeliculaController
{

    private $model;
    private $modelGenero;
    private $view;

    function __construct(){
        $this->model = new PeliculaModel();
        $this->modelGenero = new GeneroModel();
        $this->view = new JSONView();
    }

    function getAll($request, $response){

        $filtrarGenero = null;
        if(isset($request->query->genero)){
            $nombre = $request->query->genero;
            $genero = $this->modelGenero->getGeneroByNombre($nombre);
            if(!$genero){
                return  $this->view->response("El genero $nombre no existe", 404);
            }
            $filtrarGenero = $nombre;
        } 

        $ordenar = null;
        if(isset($request->query->orderBy)){
            $ordenar = $request->query->orderBy;
        }

        $direccion = 'ASC';
        if (isset($request->query->direccion)) {
            $direccion = strtoupper($request->query->direccion) === 'DESC' ? 'DESC' : 'ASC';
        }

        $peliculas = $this->model->getPeliculas($filtrarGenero, $ordenar, $direccion);


        return $this->view->response($peliculas);
    }

    function get($request, $response){
        $id = $request->params->id;

        $pelicula = $this->model->getPeliculaByID($id);

        if(!$pelicula){
            return  $this->view->response("La película con el id $id no existe", 404);
        }

        return $this->view->response($pelicula);
    }

    function delete($request, $response){

        if (!isset($response->user) || $response->user == null) {
            return $this->view->response("Usuario no autenticado", 401);
        }

        $id = $request->params->id;

        $pelicula = $this->model->getPeliculaByID($id);

        if(!$pelicula){
            return  $this->view->response("La película con el id $id no existe", 404);
        }

        $this->model->eliminarPelicula($id);

        $pelicula = $this->model->getPeliculaByID($id);

        if($pelicula){
            return  $this->view->response("Error al eliminar la película, inténtelo nuevamente", 500);
        }

        return  $this->view->response("La película con el id $id se elmiinó con éxito");
    }

    function create($request, $response){

        if (!isset($response->user) || $response->user == null) {
            return $this->view->response("Usuario no autenticado", 401);
        }

        if(empty($request->body->nombreGenero) || empty($request->body->titulo) || empty($request->body->director) || empty($request->body->descripcion) || empty($request->body->calificacion) || empty($request->body->estreno)){
            return  $this->view->response("Faltan datos por completar", 400);
        }

        $nombreGenero = ucwords($request->body->nombreGenero);
        $titulo = $request->body->titulo;
        $director = $request->body->director;
        $descripcion = $request->body->descripcion;
        $calificacion = $request->body->calificacion;
        $estreno = $request->body->estreno;

        $genero = $this->modelGenero->getGeneroByNombre($nombreGenero);

        if(!$genero) {
            return $this->view->response("El género '$nombreGenero' no existe", 404);
        }

        $id = $this->model->agregarPelicula($nombreGenero, $titulo, $director, $descripcion, $calificacion, $estreno);

        if(!$id){
            return $this->view->response("Error al insertar pelicula", 500);
        }

        $pelicula = $this->model->getPeliculaByID($id);

        return $this->view->response($pelicula, 201);
    }

    function update($request, $response){

        if (!isset($response->user) || $response->user == null) {
            return $this->view->response("Usuario no autenticado", 401);
        }

        $id = $request->params->id;

        $pelicula = $this->model->getPeliculaByID($id);

        if(!$pelicula){
            return  $this->view->response("La película con el id $id no existe", 404);
        }

        if(empty($request->body->titulo) || empty($request->body->director) || empty($request->body->descripcion) || empty($request->body->calificacion) || empty($request->body->estreno)){
            return  $this->view->response("Faltan datos por completar", 400);
        }

        $titulo = $request->body->titulo;
        $director = $request->body->director;
        $descripcion = $request->body->descripcion;
        $calificacion = $request->body->calificacion;
        $estreno = $request->body->estreno;

        $this->model->editarPelicula($id, $titulo, $director, $descripcion, $calificacion, $estreno);

        $pelicula = $this->model->getPeliculaByID($id);

        return $this->view->response($pelicula);
    }
}