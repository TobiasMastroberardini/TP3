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
    
    function mostrarMiPerfil(){
        $this->model->verificar();
        $nombre = $_SESSION['USER_NOMBRE'];
        $email = $_SESSION['USER_EMAIL'];
        $id = $_SESSION['USER_SUSCRIPCION'];
        $plan = $this->model->obtenerPlan($id);
        $Admin = $this->model->esAdmin();
        $this->view->mostrarMiPerfil($nombre,$email,$plan,$Admin);
    }

    function cambiarNombre(){
        session_start();
        $id = $_SESSION['USER_ID'];
        $nombre = $_POST['cambio-nombre'];
        $this->model->cambiarNombre($id,$nombre);
        header('Location: ' . BASE_URL . 'miPerfil');
    }

    function mostrarSocios()
    {
        $socios = $this->model->getSocios();
        $this->model->verificar();
        $Admin = $this->model->esAdmin();
        $this->view->MostrarUsuarios($socios, $Admin);
    }

    function eliminarSocio(){
        $id = $_POST['socio_id'];
        $this->model->borrarSocio($id);
        header('Location: ' . BASE_URL . 'verSocios');
    }

    function hacerAdmin(){
        $id = $_POST['socio_id'];
        $this->model->hacerAdmin($id);
        header('Location: ' . BASE_URL . 'verSocios');
    }

    function quitarAdmin(){
        $id = $_POST['socio_id'];
        $this->model->quitarAdmin($id);
        header('Location: ' . BASE_URL . 'verSocios');
    }

    function mostrarNoticias(){
        $this->model->verificar();
        $this->view->mostrarNoticias();
    }
}