<?php
include_once("conexion.php");

header("Content-Type: application/json; charset=UTF-8");
$metodo= $_SERVER['REQUEST_METHOD'];

$path=isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : "/";
$buscar_id = explode("/",$path);
$id = ($path !== "/") ? end($buscar_id) : null;
    
switch($metodo){
    // Consulta Select
    case "GET":
        echo "Consulta GET ";
        getDatos($conn,$id);
        break;
    // Consulta Insert
    case "POST":
        echo "Consulta POST ";
        postDatos($conn);
        break;
    // Consulta Update
    case "PUT":
        echo "Consulta PUT ";
        putDatos($conn,$id);
        break;
    // Consulta Delete 
    case "DELETE":
        echo "Consulta DELETE ";
        deleteDatos($conn,$id);
        break;
        
    default:
        echo "No se ha definido el método";
        break;    
}

function getDatos($conn,$id){
    $sql = ($id===null) ? "SELECT * FROM usuarios" : "SELECT * FROM usuarios WHERE id=$id";
    $resultado = mysqli_query($conn, $sql);
    if(mysqli_num_rows($resultado) > 0){
        $datos = [];
        foreach($resultado as $row){
            array_push($datos,$row);
        }
        echo json_encode($datos);
    }
   
}

function postDatos($conn){
    $dato= json_decode(file_get_contents("php://input"),true);
    $nombre= $dato['nombre'];
    $sql = "INSERT INTO usuarios (nombre) VALUES ('$nombre')";
    $resultado = mysqli_query($conn, $sql);
    if($resultado){
        $dato["id"] = mysqli_insert_id($conn);
        echo json_encode($dato);
    
    }else{
        echo json_encode(array("mensaje"=>"Error al insertar"));
    }
    
}

function deleteDatos($conn,$id){
    
    $sql = "DELETE FROM usuarios WHERE id=$id";
    $resultado = mysqli_query($conn, $sql);
    if($resultado){
        echo json_encode(array("mensaje"=>"Registro eliminado"));
    
    }else{
        echo json_encode(array("mensaje"=>"Error al eliminar"));
    }
    
}
function putDatos($conn,$id){
    $dato= json_decode(file_get_contents("php://input"),true);
    $nombre= $dato['nombre'];
    $sql = "UPDATE usuarios SET nombre='$nombre' WHERE id=$id";
    $resultado = mysqli_query($conn, $sql);
    if($resultado){
        echo json_encode(array("mensaje"=>"Registro actualizado"));
    
    }else{
        echo json_encode(array("mensaje"=>"Error al actualizar"));
    }
    
}
?>