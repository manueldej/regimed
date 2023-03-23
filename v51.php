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
@session_start();
require_once('connections/miConex.php');
		include('chequeo.php');
 	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
?>
	<link href="css/template.css" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="ajax.js"></script> <?php
include ('script.php');
require('mensaje.php');
if(isset($_GET["editar"])){
 $marcado = @$_GET['marcado'];

$docu = "select * from areas";
$rsdocu = mysqli_query($miConex, $docu);
$totall = mysqli_num_rows($rsdocu);
$nucam = mysqli_num_fields($rsdocu);
$cuet = 0;
for($qq=0;$qq<$nucam; $qq++){
 $flagsm1 = mysqli_fetch_field_direct($rsdocu, $qq);
 if((stristr ($flagsm1->name, 'auto_increment')) =="auto_increment" ){$cuet++;}
}
?>
<style type="text/css">
<!--
.Estilo4 {
	color: #000000;
	font-weight: bold;
	font-family : "Trebuchet MS", Arial, Helvetica, sans-serif;
}
-->
</style>
<div id="buscad"> <?php
				if(empty($marcado)){
					show_message("Mensaje de Error","Por favor seleccione al menos un elemento para Modificar.","cancel","registroareas.php"); 
				exit;
				}
?>
<form id="frmSearch" name="frmSearch" method="post" action="">
	<table class="table" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="30%" align="right" class="vistauser1" ><b><span class="Estilo4"><?php echo strtoupper($btCampo);?></span></b>&nbsp;&nbsp;</td>
			<td width="70%" class="vistauser1" >&nbsp;&nbsp;<b><span class="Estilo4"><?php echo strtoupper($btValor);?></span></b></td>
		</tr><?php
				$jh=0;
				foreach( $marcado as $key){
					$ssql2 = "SELECT * FROM areas  WHERE idarea='".$key."'";
					$qPager2 = mysqli_query($miConex, $ssql2);
					$u=0;
					while ($row_rs = @mysqli_fetch_array($qPager2))	{  
						$metam  = mysqli_fetch_field_direct($qPager2, $jh);	?>
						<input type="hidden" name="idarea[]" value="<?php echo $row_rs['idarea'];?>"/><?php									
						for($m=0; $m<$nucam; $m++){ 
							$meta = mysqli_fetch_field_direct($qPager2, $m);
							$size = strlen($row_rs[$meta->name]) + 1;
							$len = $meta->type;
							$size1 = $meta->max_length + 1;
							if(($meta->name) =="idunidades" OR ($meta->name) =="nombre"){ ?>
								<tr>
									<td><div align='right'><?php 
										if(($meta->name) =="nombre"){
											echo "Nombre del &Aacute;rea";
										}elseif(($meta->name) =="idunidades"){
											echo "Nombre de la Entidad";
										}else{  echo $meta->name;} echo ":&nbsp;"; ?></div>
									</td>
									<td><?php 
										if(($meta->name) =="idunidades"){ 
											$edat = mysqli_query($miConex, "select * from datos_generales where id_datos='".$row_rs[$meta->name]."'") or die();
											$redat = mysqli_fetch_array($edat);
											echo "<b><font color='#000000'>".$redat['entidad']."</font></b>"; ?>
											<input name='<?php echo $meta->name;?>[]' size ='50' type='hidden' value='<?php echo $redat['id_datos'];?>'>
											<input name='nada' size ='50' type='hidden' value='<?php echo $redat['codigo'];?>'><?php
										}
										if(($meta->name) =="nombre"){ ?>
											<input class="boton" name='<?php echo $meta->name;?>[]' size ='50' type='text' value='<?php echo $row_rs[$meta->name];?>'><?php
										} ?>
									</td>  
								</tr><?php
							}
						}
					}
					$jh++; 			
				}		 ?>
				<input type="hidden" name="nucam" value="<?php echo $nucam;?>"/>
				<input type="hidden" name="cantidad" value="<?php echo count($marcado);?>"/>
		<tr>
			<td colspan="2"><hr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="modificado" type="submit" class="btn" value="<?php echo $btaceptar;?>">&nbsp;
			<input name="cancelar" type="button" class="btn" value="<?php echo $btcancelar;?>" onclick="window.parent.location='registroareas.php';"></td>
		</tr>
	</table>
</form><?php
}
	if(isset($_POST["modificado"])){
		if(isset($_POST['nombre'])){$nombre= $_POST['nombre'];}
		if(isset($_POST['idarea'])){$idarea= $_POST['idarea'];}
		$tt=0;
		foreach ($idarea as $cmpoy) {			
			$Select="select * from areas where idarea='".$cmpoy."'";
			$QSelect = mysqli_query($miConex, $Select) or die();
			$rSelect = mysqli_fetch_array($QSelect);
			$nomba= $rSelect['nombre'];
			$q_v1  = "UPDATE `aft` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v1 = mysqli_query($miConex, $q_v1) or die();

			$q_v3  = "UPDATE `bajas_aft` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v3 = mysqli_query($miConex, $q_v3) or die();

			$q_v3  = "UPDATE `bajas_exp` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v3 = mysqli_query($miConex, $q_v3) or die();

			$q_v  = "UPDATE `exp` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v = mysqli_query($miConex, $q_v) or die();

			$q_v  = "UPDATE `plan_rep` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v = mysqli_query($miConex, $q_v) or die();

			$q_v  = "UPDATE `usuarios` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v = mysqli_query($miConex, $q_v) or die();

			$q_v2  = "UPDATE `areas` SET nombre = '".htmlentities($nombre[$tt])."' WHERE idarea='".$cmpoy."'";
			$r_q_v2 = mysqli_query($miConex, $q_v2) or die();
			$tt++;
		} ?>
		<script type="text/javascript">window.parent.location="registroareas.php"</script>;<?php
	} ?>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>