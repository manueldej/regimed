<?php 
############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    24/03/2011 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)							         		            #
# Licencia: Freeware                                                				                        #
#                                                                       			                        #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                 #
# LICENCIA: Este archivo es parte de REGIMED. REGIMED es un software libre; Usted lo puede redistribuir y/o #
# lo puede modificar bajo los términos de la Licencia Pública General GNU publicada por la Fundación de     #
# Software Gratuito (the Free Software Foundation ); Ya sea la versión 2 de la Licencia, o (en su opción)   #
# cualquier posterior versión. REGIMED es distribuido con la esperanza de que será útil, pero SIN CUALQUIER #
# GARANTÍA; Sin aún la garantía implícita de COMERCIABILIDAD o ADAPTABILIDAD PARA UN PROPÓSITO PARTICULAR.  #
# Vea la Licencia Pública General del GNU para más detalles. Usted debería haber recibido una copia de la   #
# Licencia  Pública General de GNU junto con REGIMED. En Caso de que No, vea <http://www.gnu.org/licenses>. #
#############################################################################################################
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
		$resultadoses = mysqli_query($miConex, $consultases) or die(mysqli_error($miConex));
		$filases = mysqli_fetch_array($resultadoses);
		$consulta = "SELECT * FROM preferencias where usuario = '".@$_SESSION["valid_user"]."' AND idunidades='".@$filases['idunidades']."'";
		$resultado = mysqli_query($miConex,$consulta) or die(mysqli_error($miConex));
		$fila = mysqli_fetch_array($resultado);
	if((@$fila['salva']) =="s"){
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

	$upcoses = mysqli_query($miConex, "delete from conectado where conectado = '".@$_SESSION["valid_user"]."' AND idunidades='".@$filases['idunidades']."'") or die(mysqli_error($miConex));
	?>
	<script type="text/javascript" src="ajax.js"></script>
	<script type="text/javascript">
	//	Nuevos1();
	</script><?php
	unset($_SESSION['valid_user']);
	$consultases1 ="SELECT * FROM conectado";
	$resultadoses1 = mysqli_query($miConex, $consultases1) or die(mysqli_error($miConex));
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
?>
<script type="text/javascript">document.location='index.php';</script>

