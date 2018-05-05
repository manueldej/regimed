<?php
############################################################################################################
# Software: Regimed                                                                                        #
#(Registro de Medios Informáticos)     					                                		           #
# Version:  3.0.1                                                     				                       #
# Fecha:    01/06/2016 - 03/04/2018                                             					                       #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			           #
#          	Msc. Carlos Pollan Estrada											         		           #
# Licencia: Freeware                                                				                       #
#                                                                       			                       #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                #
############################################################################################################
	$conexion = new mysqli('localhost','root','adminred','seguridad',3306);
	$titulo = $_POST['titulo'];
	$consulta = "select * FROM resoluciones WHERE titulo LIKE '%$titulo%' OR descripcion LIKE '%$titulo%' ";

	$result = $conexion->query($consulta);
	
	$respuesta = new stdClass();
	if($result->num_rows > 0){
		$fila = $result->fetch_array();
		$respuesta->titulo = $fila['titulo'];
		$respuesta->descripcion = $fila['descripcion'];
		$respuesta->organo = $fila['organo'];		
	}
	echo json_encode($respuesta);

?>