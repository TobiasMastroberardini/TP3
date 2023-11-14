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

    function createSub($tipo,$caracteristicas,$precio,$duracion){
        $querry = $this->db->prepare('INSERT INTO subscripciones (tipo, caracteristicas, precio, duracion) VALUES (? ,?, ?, ?)');
        $querry->execute([$tipo,$caracteristicas,$precio,$duracion]);
    }

    function deleteSub($id){
        $querry = $this->db->prepare('DELETE FROM subscripciones WHERE ID_subscripcion = ?');
        $querry->execute([$id]);
    }

    function updateSub($tipo,$caracteristicas,$precio,$duracion,$id){
        $querry = $this->db->prepare('UPDATE subscripciones SET tipo = ?, caracteristicas = ?, precio = ?, duracion = ? WHERE ID_subscripcion = ?');
        $querry->execute([$tipo,$caracteristicas,$precio,$duracion,$id]);
    }


    public function verificar(){
        session_start();
        if (!isset($_SESSION['USER_ID'])) {
            die();
        }
    }

    public function getSubsFiltro($sector,$precioMin,$precioMax,$duracionMin,$duracionMax)
    {
        $query = $this->db->prepare('SELECT * FROM subscripciones WHERE precio > ? AND precio < ? AND caracteristicas = ? AND duracion > ? AND duracion < ?');
        $query->execute([$precioMin,$precioMax,$sector,$duracionMin, $duracionMax]);
        $subscripciones = $query->fetchAll(PDO::FETCH_OBJ);

        return $subscripciones;
    }

      public function getSubscripcionesOrdenadas($order, $sort)
    {
        $query = $this->db->prepare("SELECT * FROM subscripciones ORDER BY $sort $order");
        $query->execute();
        $subscripciones = $query->fetchAll(PDO::FETCH_OBJ);
        return $subscripciones;
    }
}
