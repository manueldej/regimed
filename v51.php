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
$rsdocu = mysqli_query($docu);
$totall = mysqli_num_rows($rsdocu);
$nucam = mysqli_num_fields($rsdocu);
$cuet = 0;
for($qq=0;$qq<$nucam; $qq++){
$flagsm1 = @mysql_field_flags($rsdocu, $qq);
if((stristr ($flagsm1, 'auto_increment')) =="auto_increment" ){$cuet++;}
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
					$qPager2 = mysqli_query($ssql2);
					$u=0;
					while ($row_rs = @mysqli_fetch_array($qPager2))	{  
						$metam  = @mysql_fetch_field($qPager2, $jh);	?>
						<input type="hidden" name="idarea[]" value="<?php echo $row_rs['idarea'];?>"/><?php									
						for($m=0; $m<$nucam; $m++){ 
							$meta = mysql_fetch_field($qPager2, $m);
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
											$edat = mysqli_query("select * from datos_generales where id_datos='".$row_rs[$meta->name]."'", $miConex) or die(mysql_error());
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
			$QSelect = mysqli_query($Select, $miConex) or die(mysql_error());
			$rSelect = mysqli_fetch_array($QSelect);
			$nomba= $rSelect['nombre'];
			$q_v1  = "UPDATE `aft` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v1 = mysqli_query($q_v1,$miConex) or die(mysql_error());

			$q_v3  = "UPDATE `bajas_aft` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v3 = mysqli_query($q_v3,$miConex) or die(mysql_error());

			$q_v3  = "UPDATE `bajas_exp` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v3 = mysqli_query($q_v3,$miConex) or die(mysql_error());

			$q_v  = "UPDATE `exp` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v = mysqli_query($q_v,$miConex) or die(mysql_error());

			$q_v  = "UPDATE `plan_rep` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v = mysqli_query($q_v,$miConex) or die(mysql_error());

			$q_v  = "UPDATE `usuarios` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v = mysqli_query($q_v,$miConex) or die(mysql_error());

			$q_v2  = "UPDATE `areas` SET nombre = '".htmlentities($nombre[$tt])."' WHERE idarea='".$cmpoy."'";
			$r_q_v2 = mysqli_query($q_v2,$miConex) or die(mysql_error());
			$tt++;
		} ?>
		<script type="text/javascript">window.parent.location="registroareas.php"</script>;<?php
	} ?>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>