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
include('header.php');
include ('script.php');
require('mensaje.php');
?><fieldset class="fieldset"><?php

if(isset($_POST["eliminar"])){
	$marcado = $_POST['marcado'];
	foreach($marcado as $key){		
		$satf = "select * from areas where idarea='".$key."'";
		$qsatf = mysqli_query($miConex, $satf) or die(mysql_error());
		$rsatf = mysqli_fetch_array($qsatf);
		
		//$sqld1 = "DELETE FROM aft WHERE idarea='".$rsatf['nombre']."'";			
		//$result1 = mysqli_query($sqld1) or die(mysql_error());
		
		$sqld = "DELETE FROM areas WHERE idarea='".$key."'";			
		$result = mysqli_query($miConex, $sqld) or die(mysql_error());	
	}
	?>
	<script type="text/javascript">document.location="registroareas.php";</script>
<?php 	
}

if(isset($_REQUEST["editar"])){
 $marcado = $_REQUEST['marcado'];

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
.Estilo2 {
	color: #0099CC;
	font-weight: bold;
	font-family : "Trebuchet MS", Arial, Helvetica, sans-serif;
}
-->
</style>

<?php include('barra.php');?>
<div id="buscad"> 
<fieldset class='fieldset'><legend class="vistauserx"><?php echo $btAreas;?></legend>
<?php
				if(empty($marcado)){
					show_message("Mensaje de Error","Por favor seleccione al menos un elemento para Modificar.","cancel","registroareas.php"); 
				exit;
				}
?>
<form id="frmSearch" name="frmSearch" method="post" action="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
					<td width="17%" align="right" class='vistauser1'><b><?php echo $btCampo;?></b>&nbsp;&nbsp;</td>
					<td width="83%" class='vistauser1'>&nbsp;&nbsp;<b><?php echo $btValor;?></b></td>
					</tr>
				</table>
				<?php
				$jh=0;
				foreach( $marcado as $key){
					$ssql2 = "SELECT * FROM areas  WHERE idarea='".$key."'";
					$qPager2 = mysqli_query($miConex, $ssql2);
					$u=0;?>
					<?php
							while ($row_rs = @mysqli_fetch_array($qPager2))	{  
								//$metam  = @mysql_fetch_field($qPager2, $jh);	?>
										<input type="hidden" name="idarea[]" value="<?php echo $row_rs['idarea'];?>"/>			
										<?php									
									for($m=0; $m<$nucam; $m++){ 
										$meta = mysqli_fetch_field_direct($qPager2, $m);
									
										$size = strlen($row_rs[$meta->name]) + 1;
										$len = $meta->type;
										$size1 = $meta->max_length + 1;
										if(($meta->name) =="idunidades" OR ($meta->name) =="nombre"){
										 ?>
											<table width='100%' border='0' cellspacing='1' cellpadding='1'>
												<tr>
													<td width='17%' align="right"><?php 
														if(($meta->name) =="nombre"){
															echo "Nombre del Area";
														}elseif(($meta->name) =="idunidades"){
															echo "Nombre de la Entidad";
														}else{  echo $meta->name;} echo ":&nbsp;&nbsp;"; ?></td>
													<td width='83%'><?php 
													if(($meta->name) =="idunidades"){ 
													$edat = mysqli_query($miConex, "select * from datos_generales where id_datos='".$row_rs[$meta->name]."'") or die(mysql_error());
													$redat = mysqli_fetch_array($edat);
														echo $redat['entidad'];
													?>
														<input name='<?php echo $meta->name;?>[]' size ='50' type='hidden' readonly value='<?php echo $redat['id_datos'];?>'>
														<input name='nada' size ='50' type='hidden' readonly value='<?php echo $redat['codigo'];?>'><?php
													}if(($meta->name) =="nombre"){ ?>
														<input class="form-control" name='<?php echo $meta->name;?>[]' size ='50' type='text' value='<?php echo $row_rs[$meta->name];?>'><?php
													}
													?>
												  </td>  
												</tr>
											</table>	<?php
										}
									} ?>
								<hr>
								<?php 
							}$jh++; ?>
							<?php				
				}		 ?>
				<input type="hidden" name="nucam" value="<?php echo $nucam;?>"/>
				<input type="hidden" name="cantidad" value="<?php echo count($marcado);?>"/>
			</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="modificado" type="submit" class="btn" value="<?php echo $btaceptar;?>">&nbsp;
			<input name="cancelar" type="button" class="btn" value="<?php echo $btcancelar;?>" onclick="javascript:document.location='registroareas.php';"></td>
		</tr>
	</table>
</form>
</fieldset>
<?php

}
if(isset($_REQUEST["insertar"])){ ?>
	<script type="text/javascript">document.location="form-insertarareas.php"</script>;<?php
}
	if(isset($_REQUEST["modificado"])){
		if(isset($_REQUEST['nombre'])){$nombre= $_REQUEST['nombre'];}
		if(isset($_REQUEST['idarea'])){$idarea= $_REQUEST['idarea'];}
		$tt=0;
		foreach ($idarea as $cmpoy) {			
			$Select="select * from areas where idarea='".$cmpoy."'";
			$QSelect = mysqli_query($miConex, $Select) or die(mysql_error());
			$rSelect = mysqli_fetch_array($QSelect);
			$nomba= $rSelect['nombre'];
			$q_v1  = "UPDATE `aft` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v1 = mysqli_query($miConex, $q_v1) or die(mysql_error());

			$q_v3  = "UPDATE `bajas_aft` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v3 = mysqli_query($miConex, $q_v3) or die(mysql_error());

			$q_v3  = "UPDATE `bajas_exp` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v3 = mysqli_query($miConex, $q_v3) or die(mysql_error());

			$q_v  = "UPDATE `exp` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v = mysqli_query($miConex, $q_v) or die(mysql_error());

			$q_v  = "UPDATE `plan_rep` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v = mysqli_query($miConex, $q_v) or die(mysql_error());

			$q_v  = "UPDATE `usuarios` SET idarea = '".htmlentities($nombre[$tt])."' WHERE idarea='".$nomba."'";
			$r_q_v = mysqli_query($miConex, $q_v) or die(mysql_error());

			$q_v2  = "UPDATE `areas` SET nombre = '".htmlentities($nombre[$tt])."' WHERE idarea='".$cmpoy."'";
			$r_q_v2 = mysqli_query($miConex, $q_v2) or die(mysql_error());
			$tt++;
		} ?>
		<script type="text/javascript">document.location="registroareas.php"</script>;<?php
	} ?>
</fieldset><br>
<?php include ("version.php");?>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>