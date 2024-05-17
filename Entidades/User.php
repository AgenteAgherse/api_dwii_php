<?php
require_once '../Database/Connection.php';
class User {

    public static function findUser($user) {
        $db = new Connection();
        $where = "SELECT user_name FROM usuarios WHERE user_name = '".$user."'";
        $resultado = $db->query($where);
        return ($resultado->num_rows > 0);
    }

    public static function getWhere($user, $password) {
        $db = new Connection();
        $where = "SELECT * FROM usuarios WHERE user_name = '".$user."' AND user_password = SHA('".$password."')";
        
        $resultado = $db->query($where);
        if($resultado->num_rows) {
            while($row = $resultado->fetch_assoc()) {
                return [
                    'user_name' => $row['user_name'],
                    'id' => $row['id'],
                    'user_password' => $row['user_password']
                ];
            }
        }
        return $datos;
    }

    public static function insert($identificacion, $nombre, $apellido, $tipo_identificacion, $profesion) {
        $db = new Connection();
        $query = "INSERT INTO personas (identificacion, nombre, apellido, tipo_identificacion, profesion) VALUES('".$identificacion."', '".$nombre."', '".$apellido."', '".$tipo_identificacion."', '".$profesion."')";
        $db->query($query);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

    public static function update($identificacion, $nombre, $apellido, $tipo_identificacion, $profesion) {
        $db = new Connection();
        $update = "UPDATE personas SET nombre = '".$nombre."', apellido ='".$apellido."', tipo_identificacion ='".$tipo_identificacion."', profesion ='".$profesion."' WHERE identificacion ='".$identificacion."'";

        $db->query($update);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

    public static function delete($id) {
        $db = new Connection();
        $query = "DELETE FROM personas WHERE identificacion='$id"."'";
        $db->query($query);
        if($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

}
?>