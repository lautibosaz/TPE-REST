<?php

require_once 'apps/models/genero.model.php';
require_once 'apps/views/json.view.php';

class GeneroController {

    private $model;
    private $view;

    function __construct(){
        $this->model = new GeneroModel();
        $this->view = new JSONView();
    }

    function getAll($request, $response){

        $genero = $this->model->getGeneros();

        return $this->view->response($genero);
    }
    
    function get($request, $response){

        $id = $request->params->id;

        $genero = $this->model->getGeneroByID($id);

        if(!$genero){
            return  $this->view->response("El genero con el id $id no existe", 404);
        }

        return $this->view->response($genero);
    }

    function delete($request, $response){

        if (!isset($response->user) || $response->user == null) {
            return $this->view->response("Usuario no autenticado", 401);
        }

        $id = $request->params->id;

        $genero = $this->model->getGeneroByID($id);

        if(!$genero){
            return  $this->view->response("El genero con el id $id no existe", 404);
        }

        $this->model->eliminarGenero($id);

        $genero = $this->model->getGeneroByID($id);

        if($genero){
            return  $this->view->response("Error al eliminar el género, inténtelo nuevamente", 500);
        }

        return  $this->view->response("El genero con el id $id se elmiinó con éxito");
    }

    function create($request, $response){

        if (!isset($response->user) || $response->user == null) {
            return $this->view->response("Usuario no autenticado", 401);
        }

        if (empty($request->body->genero) || empty($request->body->descripcion)){
            return  $this->view->response("Faltan datos por completar", 400);
        }
        
        $genero = $request->body->genero;
        $descripcion = $request->body->descripcion;

        $id = $this->model->agregarGenero($genero, $descripcion);

        if (!$id){
            return  $this->view->response("Error al insertar genero", 500);
        }

        $genero = $this->model->getGeneroByID($id);

        return  $this->view->response($genero, 201);
    }

    function update($request, $response){

        if (!isset($response->user) || $response->user == null) {
            return $this->view->response("Usuario no autenticado", 401);
        }

        $id = $request->params->id;

        $Genero = $this->model->getGeneroByID($id);

        if(!$Genero){
            return  $this->view->response("El genero con el id $id no existe", 404);
        }

        if (empty($request->body->genero) || empty($request->body->descripcion)){
            return  $this->view->response("Faltan datos por completar", 400);
        }
        
        $genero = $request->body->genero;
        $descripcion = $request->body->descripcion;

        $this->model->editarGenero($genero, $descripcion, $id);

        $Genero = $this->model->getGeneroByID($id);

        return  $this->view->response($Genero);
    }
}