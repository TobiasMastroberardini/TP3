<?php
require_once './app/model/page.model.php';
include_once './app/view/apiView.php';

class pageController {
    private $view;
    private $model;

    function __construct()
    {
        $this->model = new pageModel();
        $this->view = new apiView();
    }

    function ShowSocios($params = [])
    {
        if(empty($params)){
            $socios = $this->model->getSocios();
            return $this->view->response($socios,200);
          }
          else {
            $socio = $this->model->getSocio($params[":ID"]);
            if(!empty($socio)) {
              return $this->view->response($socio,200);
            }
      
    }}

    function addSocios(){
        $id = $_POST['socio_id'];
    }

    function deleteSocios($params = [])
    {
        $id = $params[':ID'];
        $socio = $this->model->getSocio($id);
        if ($socio) {
            $this->model->deleteSocio($id);
            $this->view->response("socio id=$id eliminado con éxito", 200);
        } else
            $this->view->response("socio id=$id not found", 404);
    }










    function hacerAdmin(){
        $id = $_POST['socio_id'];
        $this->model->hacerAdmin($id);
    }

    function quitarAdmin(){
        $id = $_POST['socio_id'];
        $this->model->quitarAdmin($id);
    }

    function mostrarNoticias(){
        $this->model->verificar();
    }
}