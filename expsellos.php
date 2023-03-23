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
@session_start(); include('chequeo.php');
if (!check_auth_user()){
	?><script type="text/javascript">window.parent.location="index.php";</script><?php
	exit;
}
 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition: attachment; filename=Registro_sellos.xls");
 header("Pragma: no-cache");
 header("Expires: 0");
$i=0;
$palabra="";
include ('connections/miConex.php');
		$idunidad="";
		if(isset($_GET['area']) AND ($_GET['area']) !=""){
			$idunidad=" where id =".$_GET['area'];
		}
	if(isset($_GET['query'])){
		$kk= base64_decode($_GET['query']);
		if(stristr($kk,'kk') !=""){
			$se = str_ireplace('kk',$idunidad,$kk);
		}else{
			$se =$kk;
		}
	}else{
		$se = "select * from sellos";
	}

$result = mysqli_query($miConex, $se);
$row   = mysqli_num_rows($result);
$leg = "REGISTRO DE MEDIOS";
?><html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>expsellos</title><fieldset class='fieldset'><legend class="vistauserx"><?php echo $leg;?></legend>	
	<table width="<?php if ($row["estado"]!='Disponible') { echo "100%"; }else { echo "50%"; } ?>" border='0' align="center" cellpadding="3" cellspacing="3"> 
	 	 	<tr><?php if ($row["estado"]!= 'Disponible') { ?> 				
			    <td width="109"><span><b>INV</b></span></td>
	            <td width="209"><span><b>ACTIVO</b></span></td><?php } ?>
				<td width="109"><span><b>SELLO</b></span></td>
				<td width="127"><span><b>ESTADO</b></span></td><?php if ($row["estado"]!= 'Disponible') { ?>
				<td width="144"><span><b>OBSERV</b></span></td><?php } ?>
	  		</tr><?php
			while($row=mysqli_fetch_array($result)){ ?>
				<tr><?php if ($row["estado"]!='Disponible') { ?>
					<td><?php echo $row["inv"]; ?></td>
					<td><?php echo $row["descrip"]; ?></td><?php } ?>
					<td><?php echo $row["numero"];?></td>
					<td><?php echo $row["estado"];?></td><?php if ($row["estado"]!='Disponible') { ?>
					<td><?php echo $row["observ"];?></td><?php } ?>
				</tr><?php 			
			} ?>		
		</TABLE>
</fieldset>
</html>