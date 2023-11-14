<?php
require_once './app/controller/controller.php';
include_once './app/model/subscripciones.model.php';
include_once './app/view/apiView.php';


class subscripcionesController extends controller
{

    private $model;

    function __construct()
    {
        parent::__construct();
        $this->model = new subscripcionesModel();
    }

    function ShowSubs($params = [])
    {
        if (empty($params)) {
            $subs = $this->model->getSubs();
            return $this->view->response($subs, 200);
        } else {
            $sub = $this->model->getSub($params[":ID"]);
            if (!empty($sub)) {
                return $this->view->response($sub, 200);
            }
        }
    }

    function addSubs()
    {
        $body = $this->getData();
        $tipo = $body->tipo;
        $caracteristicas = $body->caracteristicas;
        $duracion = $body->duracion;
        $precio = $body->precio;
        $this->model->createSub($tipo, $caracteristicas, $precio, $duracion);
        $this->view->response('la subscripcion fue agregada con exito', 201);
    }
    
    function deleteSubs($params = [])
    {
        $id = $params[':ID'];
        $sub = $this->model->getSub($id);
        if ($sub) {
            $this->model->deleteSub($id);
            $this->view->response("sub id=$id eliminado con éxito", 200);
        } else
            $this->view->response("sub id=$id not found", 404);
    }

    function updateSubs($params = []){
        $id = $params[':ID'];
        $sub = $this->model->getSub($id);

        if ($sub) {
            $body = $this->getData();
            $tipo = $body->tipo;
            $caracteristicas = $body->caracteristicas;
            $duracion = $body->duracion;
            $precio = $body->precio;
            $this->model->updateSub($tipo, $caracteristicas, $precio, $duracion,$id);
            $this->view->response("sub id=$id actualizada con éxito", 200);
        }
        else 
            $this->view->response("sub id=$id not found", 404);

    }





    function filtrar()
    {
        if (empty($_POST['filtro-precio-min'])) {
            $precioMin = 1;
        } else {
            $precioMin = $_POST['filtro-precio-min'];
        }
        if (empty($_POST['filtro-precio-max'])) {
            $precioMax = 999999;
        } else {
            $precioMax = $_POST['filtro-precio-max'];
        }
        if (empty($_POST['filtro-sector'])) {
            $sector = 'POPULAR';
        } else {
            $sector = $_POST['filtro-sector'];
        }
        if (empty($_POST['filtro-duracion-min'])) {
            $duracionMin = 0;
        } else {
            $duracionMin = $_POST['filtro-duracion-min'];
        }
        if (empty($_POST['filtro-duracion-max'])) {
            $duracionMax = 99;
        } else {
            $duracionMax = $_POST['filtro-duracion-max'];
        }
        $subscripciones = $this->model->getSubsFiltro($sector, $precioMin, $precioMax, $duracionMin, $duracionMax);
        $this->model->verificar();
        $Admin = $this->model->esAdmin();
    }
}
