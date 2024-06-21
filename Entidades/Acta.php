<?php
require_once '../Database/Connection.php';
class Acta {
    public static function getAll() {
        $select = "SELECT * FROM acta";
        $db = new Connection();
        $results = $db->query($select);
        $datos = [];
        if($results->num_rows) {
            while($row = $results->fetch_assoc()) {
                $datos[] = [
                    'idacta' => $row['idacta'],
                    'pertenece' => $row['pertenece'],
                    'fecha' => $row['fecha'],
                    'hora' => $row['hora'],
                    'lugar_emision' => $row['lugar_emision'],
                    'descripcion' => $row['descripcion'],
                    'titulo' => $row['titulo'],
                ];
            }
        }
        return $datos;
    }

    public static function buscarActa($persona, $acta) {
        $db = new Connection();
        $sql = "SELECT acta.*, compromisos.titulo AS compromiso FROM acta  JOIN compromisos ON pertenece = idcompromiso WHERE organizador = $persona AND idacta = $acta";
        $resultado = $db->query($sql);
        $datos = [];
        if($resultado->num_rows) {
            while($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idacta' => $row['idacta'],
                    'pertenece' => $row['pertenece'],
                    'fecha' => $row['fecha'],
                    'hora' => $row['hora'],
                    'lugar_emision' => $row['lugar_emision'],
                    'descripcion' => $row['descripcion'],
                    'titulo' => $row['titulo'],
                    'compromiso' => $row['compromiso'],
                ];
            }
        }
        return $datos;
    }

    public static function obtenerActasHechas($persona) {
        $db = new Connection();
        $where = "SELECT acta.*, compromisos.titulo AS compromiso FROM acta 
                    JOIN compromisos ON compromisos.idcompromiso = pertenece
                    WHERE organizador = $persona";
        $resultado = $db->query($where);
        $datos = [];
        if($resultado->num_rows) {
            while($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idacta' => $row['idacta'],
                    'pertenece' => $row['pertenece'],
                    'fecha' => $row['fecha'],
                    'hora' => $row['hora'],
                    'lugar_emision' => $row['lugar_emision'],
                    'descripcion' => $row['descripcion'],
                    'titulo' => $row['titulo'],
                    'compromiso' => $row['compromiso'],
                ];
            }
        }
        return $datos;

    }

    public static function buscarPorTitulo($persona, $titulo) {
        $db = new Connection();
        $where = "SELECT acta.*, compromisos.titulo AS compromiso FROM acta 
                    JOIN compromisos ON pertenece = idcompromiso
                    WHERE organizador = $persona
                    AND acta.titulo LIKE '%$titulo%'";
        $resultado = $db->query($where);
        $datos = [];
        if($resultado->num_rows) {
            while($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idacta' => $row['idacta'],
                    'pertenece' => $row['pertenece'],
                    'fecha' => $row['fecha'],
                    'hora' => $row['hora'],
                    'lugar_emision' => $row['lugar_emision'],
                    'descripcion' => $row['descripcion'],
                    'titulo' => $row['titulo'],
                    'compromiso' => $row['compromiso'],
                ];
            }
        }
        return $datos;
    }

    public static function getById($id) {
        $db = new Connection();

        $where = "SELECT * FROM acta WHERE idacta = $id";

        $resultado = $db->query($where);
        $datos = [];
        if($resultado->num_rows) {
            while($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idacta' => $row['idacta'],
                    'pertenece' => $row['pertenece'],
                    'fecha' => $row['fecha'],
                    'hora' => $row['hora'],
                    'lugar_emision' => $row['lugar_emision'],
                    'descripcion' => $row['descripcion'],
                    'titulo' => $row['titulo'],
                ];
            }
        }
        return $datos;
    }

    public static function getWhere($pertenece) {
        $db = new Connection();

        $where = "SELECT * FROM acta WHERE pertenece = ".$pertenece."";

        $resultado = $db->query($where);
        $datos = [];
        if($resultado->num_rows) {
            while($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idacta' => $row['idacta'],
                    'pertenece' => $row['pertenece'],
                    'fecha' => $row['fecha'],
                    'hora' => $row['hora'],
                    'lugar_emision' => $row['lugar_emision'],
                    'descripcion' => $row['descripcion'],
                    'titulo' => $row['titulo'],
                ];
            }
        }
        return $datos;
    }

    public static function insert($pertenece, $titulo, $fecha, $hora, $lugar_emision, $descripcion) {
        $db = new Connection();
        $query = "INSERT INTO acta (pertenece, titulo, fecha, hora, lugar_emision, descripcion) VALUES ($pertenece, '$titulo', '$fecha', '$hora', '$lugar_emision','$descripcion')";

        $db->query($query);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

    public static function update($idacta, $pertenece, $fecha, $hora, $lugar_emision, $descripcion) {
        $db = new Connection();
        $update = "UPDATE acta 
        SET pertenece = ".$pertenece.", fecha ='".$fecha."', hora ='".$hora."', lugar_emision ='".$lugar_emision."', descripcion='".$descripcion."' WHERE idacta=".$idacta;

        $db->query($update);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

    public static function delete($id) {
        $db = new Connection();
        $query = "DELETE FROM acta WHERE idacta=".$id;
        $db->query($query);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

}
?>