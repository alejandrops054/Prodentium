<?php 

require_once "conexion.php";

class ModeloAjustes{

    //MOSTRAR AJUSTES
    static public function mdlMostrarAjustes($tabla, $item, $valor){

            if($item != null){
    
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
    
                $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
                $stmt -> execute();
    
                return $stmt -> fetch();
    
            }else{
    
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
                $stmt -> execute();
    
                return $stmt -> fetchAll();
    
            }
    
            $stmt -> close();
            $stmt = null;
    }

    //Editar ajustes
	static public function mdlEditarAjustes($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET empresa = :empresa, direccion = :direccion, colonia = :colonia, alcaldia = :alcaldia, cp = :cp, estado = :estado, correo = :correo, telefono = :telefono WHERE id = :id");

		$stmt -> bindParam(":empresa", $datos["empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt -> bindParam(":colonia", $datos["colonia"], PDO::PARAM_STR);
        $stmt -> bindParam(":alcaldia", $datos["alcaldia"], PDO::PARAM_STR);
        $stmt -> bindParam(":cp", $datos["cp"], PDO::PARAM_STR);
        $stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
		

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}
}