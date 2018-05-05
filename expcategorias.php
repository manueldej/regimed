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

@session_start(); include('chequeo.php');
if (!check_auth_user()){
	?><script type="text/javascript">window.parent.location="index.php";</script><?php
	exit;
}

 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition: attachment; filename=Categorias.xls");
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
		$se = "select * from tipos_medios".$idunidad." ORDER BY id";
	}

$result1 = mysqli_query($miConex, $se);
$rows1   = mysqli_num_rows($result1);
$leg = "CATEGOR&Iacute;AS DE MEDIOS";
?><html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>expexcelusuarios</title><fieldset class='fieldset'><legend class="vistauserx"><?php echo $leg;?></legend>
	<table width="100%" border='0' class="sgf1" align="center">
			<tr>
			  <td width="29" bgcolor="#EBEBEB" align="center">NO</td>
			  <td width="173" bgcolor="#EBEBEB" align="center">NOMBRE</td>
			</tr>
			<?php
			$id = 0; 
			while($row=mysqli_fetch_array($result1)) {
			$i++;
				if(($rows1) !=0){?>
					<tr>
					  <td class="Estilo2"><?php echo $i;?></td>
					  <td class="Estilo2"> <?php echo $row["nombre"];?></td>
					</tr><?php
				}

			}?>
	</table>
</fieldset>
</html>