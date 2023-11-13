<?php
require_once './app/model/auth.model.php';
include_once './app/view/apiView.php';

class authController {
    private $view;
    private $model;

    function __construct()
    {
        $this->model = new authModel();
        $this->view = new apiView();
    }

    function MostrarRegistro(){
        $this->view->MostrarRegistro();
    }

    function MostrarInicio(){
        $this->view->MostrarInicio();
    }

    function registrar(){
        if(!empty ($_POST['nombre-registro']) && !empty($_POST['email-registro']) && !empty($_POST['contraseña-registro']) && !empty($_POST['subscripcion-registro'])){
            $nombre = $_POST['nombre-registro'];
            $email = $_POST['email-registro'];
            $contraseña = password_hash($_POST['contraseña-registro'], PASSWORD_BCRYPT);
            $subscripcion = $_POST['subscripcion-registro'];
            $this->model->guardarUsuario($nombre,$email,$contraseña,$subscripcion);
            header('Location: ' . BASE_URL);
        }
        else{
            $this->view->MostrarRegistro("complete todos los campos de registro");
        }
    }

    function iniciarSesion(){
        $email = $_POST['email'];
        $password = $_POST['contraseña'];
    
        if (empty($email) || empty($password)) {
            $this->view->mostrarInicio('Complete todos los datos');
            return;
        }
        $user = $this->model->obtenerEmail($email);
        if ($user && (password_verify($password, $user->contraseña))) {
            $this->model->iniciarSesion($user);
            header('Location: ' . BASE_URL);
        } else {
            $this->view->mostrarInicio('Usuario incorrecto');
        }
    }

    function cerrarSesion(){
        $this->model->cerrarSesion();
        header('Location: ' . BASE_URL);
    }
}