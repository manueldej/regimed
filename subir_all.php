<?php 
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Inform�ticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    24/03/2011 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jes�s N��ez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)							         		            #
# Licencia: Freeware                                                				                        #
#                                                                       			                        #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                 #
# LICENCIA: Este archivo es parte de REGIMED. REGIMED es un software libre; Usted lo puede redistribuir y/o #
# lo puede modificar bajo los t�rminos de la Licencia P�blica General GNU publicada por la Fundaci�n de     #
# Software Gratuito (the Free Software Foundation ); Ya sea la versi�n 2 de la Licencia, o (en su opci�n)   #
# cualquier posterior versi�n. REGIMED es distribuido con la esperanza de que ser� �til, pero SIN CUALQUIER #
# GARANT�A; Sin a�n la garant�a impl�cita de COMERCIABILIDAD o ADAPTABILIDAD PARA UN PROP�SITO PARTICULAR.  #
# Vea la Licencia P�blica General del GNU para m�s detalles. Usted deber�a haber recibido una copia de la   #
# Licencia  P�blica General de GNU junto con REGIMED. En Caso de que No, vea <http://www.gnu.org/licenses>. #
#############################################################################################################
?>
<?php
@session_start(); include('chequeo.php');
if (!check_auth_user()){
	header ("Location: index.php");
	exit;
}
include_once "Spreadsheet/Excel/reader.php";
require ('clases.php');
require ('funciones.php');
//require ("comun.php");
require ("db_mysql.php");
$db = new mysql ;

	
?>
<html>
<head>
	<title>Documento sin t&iacute;tulo</title>
	<meta http-equiv="" content="text/html; charset=UTF-8">
	<link href="styles/css/style.css" rel="stylesheet" type="text/css">
</head>

<body >
<?php
	$C_OVer = new Fila_OVer();
	$C_Fila = new Fila_Tabla();

if( (isset($_POST['leer_datos'])))
{
 $hoja=$_POST['hoja'];
 $tbl1=$_POST['tabla'];//nombre de la tabla
 $fila=$_POST['fila'];//fila  inicial
 $hoja--;//numero de la hoja excel (como  la primera es cero )
 //echo $hoja.'</br>';
 if(is_uploaded_file($_FILES['file']['tmp_name']))
	{
		//leer los datos de las celdas de la hoja
		function getdato($fila, $col, $consulta, $campo,  $data, $hoja)
		{
		    
			$dato=$data->sheets[$hoja]['cells'][$fila][$col];//lee el primer dato
			$fields  = mysqli_fetch_field_direct ($consulta, 1); 
			$type  = $fields->type; //tipo de campo
			
			if ($type =='string') {
			           $dato=str_replace(chr(47),"",$dato);//reemplazar los /
					   $dato=str_replace(chr(39),"",$dato);//reemplaza los '
					   $dato=chr(39).htmlentities($dato).chr(39);
					   }
					else if ($type =='int') $dato=round($dato);
						else if ($type =='real') $dato=round($dato,2); 
						  else if ($type =='date'){
						  $dato=$dato=chr(39).substr($dato,-4).'-'.substr($dato,3,2).'-'.substr($dato,0,2).$dato=chr(39);}
						  
			return $dato;
		}
		
		
		$trun=$db->consulta("truncate table `$tbl1`");//limpiar la tabla
		$result=$db->consulta("select * from ".$tbl1);//consulta a la tabla (para los nombres de los campos)
		$tot_fields = mysqli_num_fields($result);//total de campos
				
		//para leer las tablas
		
		copy($_FILES['file']['tmp_name'],"basurero/".$_FILES['file']['name']);
		$fichero = "basurero/".$_FILES['file']['name']; 
		$data = new Spreadsheet_Excel_Reader();
        $ruta_archivo = $fichero;
		$data->read($ruta_archivo);
		//$fila=3;//primera fila de datos
		$col=0;
		$columnas=array(3,4,5,6,7,8);//orden de las columnas de datos uno por cada campo de la tabla (sin el autonumerico) 
		//tantas columnas como datos
		//$dato1=getdato($fila, $columnas[$col], $result, 1,  $data, $hoja);
		$dato1=$data->sheets[$hoja]['cells'][$fila][$columnas[$col]];
		while (strlen($dato1)>0)
		{
			$datos=array();
			//el for es por el numero de columnas que lees
			for ($f=0;$f < sizeof($columnas); $f++)
			{
			  $datos[]=getdato($fila, $columnas[$col], $result, $f+1,  $data, $hoja);//$f+1 es porque tengo autonum�rico en el campo 0
			  $col++;
			}
			//guardaste los datos de todas las columnas
			//en datos viene el arreglo de los valores leidos
			$valores=implode(', ',$datos);
			$ins="INSERT INTO `".$tbl1."` VALUES (NULL, ".htmlentities($valores)." )";
		    $res=$db->consulta($ins);
			//echo $ins.'</br>';	
			$fila++;//para la pr�xima fila
			$col=0;
			$dato1=$data->sheets[$hoja]['cells'][$fila][$columnas[$col]];
			//$dato1=getdato($fila, $columnas[$col], $result, 1,  $data, $hoja);
		}
		
	}
	else
	{
	echo "seleccione el fichero";
	}
}

	?>
	<h3 > Subir Datos </h3>
	<form action="" method="post" enctype="multipart/form-data" name="form2">
	<table width ="100%">
	<tr><td> Selecciona la hoja de los datos : <input type="file" name="file"></td></tr>
	<tr><td colspan="10" align="left"> N&uacute;mero de la hoja&nbsp;<input name="hoja" type="text" id="hoja" value="1" size="2" maxlength="2"></td></tr>
	<tr><td colspan="10" align="left"> N&uacute;mero de la fila inicial&nbsp;<input name="fila" type="text" id="fila" value="1" size="2" maxlength="2"></td></tr>
	<tr><td colspan="10" align="left"> Nombre de la Tabla&nbsp;<input name="tabla" type="text" id="tabla" value="tbl_" size="40" maxlength="40"></td></tr>
	
	<tr><td colspan="2"><input class ="boton" name="leer_datos" type="submit" id="leer_datos" value="<?php echo $btaceptar;?>">
	<input name="canc" type="submit" id="canc" value="<?php echo $btcancelar;?>" class="boton2"> </td></tr> 
	
</body>
</html>



