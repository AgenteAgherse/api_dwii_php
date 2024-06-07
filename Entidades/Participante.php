<?php
require_once '../Database/Connection.php';
class Participante {

    public static function getAll() {
        $select = "SELECT * FROM participantes";
        $db = new Connection();
        $results = $db->query($select);
        $datos = [];
        if($results->num_rows) {
            while($row = $results->fetch_assoc()) {
                $datos[] = [
                    'idparticipante' => $row['idparticipante'],
                    'compromiso' => $row['compromiso'],
                    'participante' => $row['participante']
                ];
            }
        }
        return $datos;
    }

    public static function getWhere($compromiso) {
        $db = new Connection();

        $where = "SELECT identificacion, CONCAT(nombre, ' ', apellido) AS participante FROM personas WHERE identificacion IN (SELECT participante FROM participantes WHERE compromiso = $compromiso)";

        $resultado = $db->query($where);
        $datos = [];
        if($resultado->num_rows) {
            while($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'identificacion' => $row['identificacion'],
                    'participante' => $row['participante']
                ];
            }
        }
        return $datos;
    }

    public static function insert($compromiso, $participante) {
        $db = new Connection();
        $query = "INSERT INTO participantes (compromiso, participante) VALUES (".$compromiso.", ".$participante.")";
        $db->query($query);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

    public static function delete($id, $compromiso) {
        $db = new Connection();
        $query = "DELETE FROM participantes WHERE participante=$id AND compromiso=$compromiso";
        $db->query($query);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

}
?>