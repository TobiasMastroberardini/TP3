<?php
require_once './app/model/model.php';
require_once 'config.php';

class subscripcionesModel extends model
{
    function __construct()
    {
        $this->db = new PDO("mysql:host=".MYSQL_HOST.";dbname=".MYSQL_DB.";charset=utf8",MYSQL_USER, MYSQL_PASS);
    }


    public function getSubs()
    {
        $query = $this->db->prepare('SELECT * FROM subscripciones');
        $query->execute();
        $subscripciones = $query->fetchAll(PDO::FETCH_OBJ);

        return $subscripciones;
    }

    public function getSub($ID)
    {
        $query = $this->db->prepare('SELECT * FROM subscripciones WHERE ID_subscripcion = ?');
        $query->execute([$ID]);
        $subscripciones = $query->fetch(PDO::FETCH_OBJ);

        return $subscripciones;
    }

    public function getSubsFiltro($sector,$precioMin,$precioMax,$duracionMin,$duracionMax)
    {
        $query = $this->db->prepare('SELECT * FROM subscripciones WHERE precio > ? AND precio < ? AND caracteristicas = ? AND duracion > ? AND duracion < ?');
        $query->execute([$precioMin,$precioMax,$sector,$duracionMin, $duracionMax]);
        $subscripciones = $query->fetchAll(PDO::FETCH_OBJ);

        return $subscripciones;
    }

    public function verificar(){
        session_start();
        if (!isset($_SESSION['USER_ID'])) {
            header('Location: ' . BASE_URL . 'inicioSesion');
            die();
        }
    }

    public function esAdmin(){
        $query = $this->db->prepare('SELECT rol FROM socios WHERE ID = ?');
        $query->execute([$_SESSION['USER_ID']]);
        $rol = $query->fetch(PDO::FETCH_OBJ);
        if($rol->rol == 1){
            return true;
        }
        return false;
    }

    function agregarSub($nombre,$sector,$precio,$duracion){
        $querry = $this->db->prepare('INSERT INTO subscripciones (tipo, caracteristicas, precio, duracion) VALUES (? ,?, ?, ?)');
        $querry->execute([$nombre,$sector,$precio,$duracion]);
    }

    function borrarSub($id){
        $querry = $this->db->prepare('DELETE FROM subscripciones WHERE ID_subscripcion = ?');
        $querry->execute([$id]);
    }
}
