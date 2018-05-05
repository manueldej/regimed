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
$h = $_GET['ent'];
require_once('connections/miConex.php');
$i = "es";
 	 if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){@$i="es"; }else{@$i="en";}
	}
	if((@$i) =="es"){include('esp.php');} else { include('eng.php');}
	
$miConex1 = mysqli_query("select * from datos_generales where id_datos='".$h."'",$miConex) or die(mysql_error()); ?>
<div class="messagex">
<table width="100%" border="0" class="table" align="center" cellspacing="0" cellpadding="0"><?php
	while($vale = mysqli_fetch_array ($miConex1)){ 
		$resprov = mysqli_query("select * from provincia where id='".$vale['provincia']."'",$miConex) or die(mysql_error());
		$rowa=mysqli_fetch_array($resprov);
		$resu = mysqli_query("select * from usuarios where idunidades='".$vale['id_datos']."'",$miConex) or die(mysql_error());
		$rowu=mysqli_fetch_array($resu);		?>
		<tr>
			<td width="173"><div align="right"><b><?php echo $perteneciente1;?>:&nbsp;</b></div></td>
			<td colspan="2" ><font color="#00000"><?php echo $vale['sector'];?></div></font></td>
		</tr>
		  <tr>
			<td><div align="right"><b><?php echo $btCodigo1?>:&nbsp;</b></div></td>
			<td colspan="2"><font color="#00000"><?php echo $vale['codigo'];?></font></td>
		  </tr>
		  <tr>
			<td><div align="right"><b><?php echo $name_admin;?>:&nbsp;</b></div></td>
			<td colspan="2"><font color="#00000"><?php echo $rowu['nombre'];?></font></td>
	      </tr>
		  <tr>
			<td><div align="right"><b><?php echo $electron;?>:&nbsp;</b></div></td>
			<td width="738"><a href="mailto:<?php echo $rowu['email'];?>" target="_blank"><?php echo $rowu['email'];?></a></td>
		  </tr><?php if(($vale['web']) !=""){ ?>
		  <tr>
			<td><div align="right"><b><?php echo $SITIO1;?>:&nbsp;</b></div></td>
			<td><a href="<?php echo $vale['web'];?>" target="_blank"><?php echo $vale['web'];?></a></td>
		  </tr><?php } ?>
		  <tr>
			<td><div align="right"><b><?php echo $provincia;?>:&nbsp;</b></div></td>
			<td><font color="#00000"><?php echo $rowa['nombre'];?></font></td>
			</tr>  
		  <tr>
			<td><div align="right"><b>SMTP:&nbsp;</b></div></td>
			<td><font color="#00000"><?php echo $vale['smtp'];?></font></td>
		  </tr><?php
		 }
?>
</table>
</div>
