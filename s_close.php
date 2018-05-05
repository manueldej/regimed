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
setcookie('lgmi','0');	
$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
  @session_start();
  $k=0;
  $paso="";
  $export="";
  require_once("db_fns.php");
if (@$_SESSION["valid_user"]) {
	if (!file_exists('connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="installation/index.php";</script><?php	
		return;	
	}
include('connections/miConex.php');
		$consultases ="SELECT * FROM conectado where conectado = '".$_SESSION["valid_user"]."'";
		$resultadoses = mysqli_query($miConex, $consultases) or die(mysql_error());
		$filases = mysqli_fetch_array($resultadoses);
		$consulta ="SELECT * FROM preferencias where usuario = '".$_SESSION["valid_user"]."' AND idunidades='".$filases['idunidades']."'";
		$resultado = mysqli_query($miConex,$consulta) or die(mysql_error());
		$fila = mysqli_fetch_array($resultado);
	if(($fila['salva']) =="s"){
		include('salvar.php');
		$sql = "SHOW TABLES FROM ".$database_miConex; 
		$result = mysqli_query($miConex, $sql);
		$tbl=array();
		while ($row = mysqli_fetch_row($result)) {
			$tbl[]=$row[0];
		}
		salvar($i,$tbl,'esyda','si');
	}
	$old_user = $_SESSION["valid_user"];  // almacenado para comprobar si ellos estuvieron logged in
	$result = $_SESSION["valid_user"];

	$upcoses = mysqli_query($miConex, "delete from conectado where conectado = '".$_SESSION["valid_user"]."' AND idunidades='".$filases['idunidades']."'") or die(mysql_error());
	?>
	<script type="text/javascript" src="ajax.js"></script>
	<script type="text/javascript">
	//	Nuevos1();
	</script><?php
	unset($_SESSION['valid_user']);
	$consultases1 ="SELECT * FROM conectado";
	$resultadoses1 = mysqli_query($miConex, $consultases1) or die(mysql_error());
	$filases1 = mysqli_num_rows($resultadoses1);
	unset($_SESSION["autentificado"]); ?>
	<script type="text/javascript" src="ajax.js"></script>
	<script type="text/javascript">
		document.cookie = "username=1;expires=" + d.toGMTString() + ";" + ";";
		document.cookie = "manuni=1;expires=" + d.toGMTString() + ";" + ";";
		document.cookie = "unidades=1;expires=" + d.toGMTString() + ";" + ";";
	</script>
	<?php
	
	if (!empty($old_user)){    
		if ($result){
			//print "Ya existe una session iniciada...";
		} else{    
			if (isset($userid))   {
				echo "ha intentado hacer login y ha fallado";
			} else {
				print "no han intentado hacer login  y no han hecho logged out";
			}
		}
	}
}
//header('Location:index.php');
?>
<script type="text/javascript">document.location='index.php';</script>

