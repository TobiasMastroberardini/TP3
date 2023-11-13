<?php
include_once './app/model/subscripciones.model.php';
include_once './app/view/apiView.php';


class subscripcionesController
{

    private $model;
    private $view;

    function __construct()
    {
        $this->model = new subscripcionesModel();
        $this->view = new apiView();
    }

    function ShowSubs($params = [])
    {
        if(empty($params)){
            $subs = $this->model->getSubs();
            return $this->view->response($subs,200);
          }
          else {
            $sub = $this->model->getSub($params[":ID"]);
            if(!empty($sub)) {
              return $this->view->response($sub,200);
            }
      
    }

    function filtrar(){
        if(empty ($_POST['filtro-precio-min'])){
            $precioMin = 1;
        } else {
            $precioMin = $_POST['filtro-precio-min'];
        }
        if(empty ($_POST['filtro-precio-max'])){
            $precioMax = 999999;
        } else {
            $precioMax = $_POST['filtro-precio-max'];
        }
        if(empty ($_POST['filtro-sector'])){
            $sector = 'POPULAR';
        } else {
            $sector = $_POST['filtro-sector'];
        }
        if(empty ($_POST['filtro-duracion-min'])){
            $duracionMin = 0;
        } else {
            $duracionMin = $_POST['filtro-duracion-min'];
        }
        if(empty ($_POST['filtro-duracion-max'])){
            $duracionMax = 99;
        } else {
            $duracionMax = $_POST['filtro-duracion-max'];
        }
        $subscripciones = $this->model->getSubsFiltro($sector,$precioMin,$precioMax,$duracionMin,$duracionMax);
        $this->model->verificar();
        $Admin = $this->model->esAdmin();
        $this->view->ShowSubs($subscripciones,$Admin);
    }

    function agregarSub(){
        if(!empty($_POST['nuevo-nombre']) && !empty($_POST['nuevo-sector']) && !empty($_POST['nuevo-precio']) && !empty($_POST['nuevo-duracion'])){
            $nombre = $_POST['nuevo-nombre'];
            $sector = $_POST['nuevo-sector'];
            $precio = $_POST['nuevo-precio'];
            $duracion = $_POST['nuevo-duracion'];
            $this->model->agregarSub($nombre,$sector,$precio,$duracion);    
            header('Location: ' . BASE_URL . 'verSuscripciones');
        }
        else{
            header('Location: ' . BASE_URL . 'verSuscripciones');
        }
    }
        function eliminarSub(){
            $id = $_POST['id_a_eliminar'];
            $this->model->borrarSub($id);
            header('Location: ' . BASE_URL . 'verSuscripciones');
        }
}
}