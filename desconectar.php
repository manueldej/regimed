<?php
#############################################################################################################
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
@session_start();
	if (!file_exists('connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="installation/index.php";</script><?php
		return;
	}
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	include ('connections/miConex.php');
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
	$uss="";
	$clav="";
	if(($_POST["clav"])){ $clav = $_POST["clav"]; }
	if(($_POST["uss"])){ $uss = $_POST["uss"]; }
	if(($_POST["coneta"])){ $coneta = $_POST["coneta"]; }
	if (($uss) !="" AND ($clav) !="" ){
		$query = "select * from usuarios  where login='".$uss."' AND passwd = '" . base64_encode($clav) . "' AND tipo='root'";
		$result = mysqli_query($miConex, $query) or die(mysql_error());
		if (mysqli_num_rows($result) >0 )  {
			$resultadoses = mysqli_query($miConex, "delete from conectado where id='".$coneta."'") or die(mysql_error());
		}
	}
	?>
	<script type="text/javascript">document.location='index.php';</script>