<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=lvc_pos",
			            "root",
			            "1234");

		$link->exec("set names utf8");

		return $link;

	}

}