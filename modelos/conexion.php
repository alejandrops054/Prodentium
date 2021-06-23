<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=lyerijca_control.prodentium","lyerijca_controlprodentium","W$)%+._-DKiJ");
		$link->exec("set names utf8");

		return $link;

	}

}