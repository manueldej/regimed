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
