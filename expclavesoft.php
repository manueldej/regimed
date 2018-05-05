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
 header("Content-Disposition: attachment; filename=Claves_Software.xls");
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
		$se = "select * from reg_claves_soft".$idunidad." ORDER BY id";
	}

$result1 = mysqli_query($miConex, $se);
$rows1   = mysqli_num_rows($result1);
$leg = "REGISTRO DE CLAVES DE SOFTWARE";
?><html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>expexcelusuarios</title><fieldset class='fieldset'><legend class="vistauserx"><?php echo $leg;?></legend>
	<table width="100%" border='0' class="sgf1" align="center">
			<tr>
			  <td width="29" bgcolor="#EBEBEB" align="center">NO</td>
			  <td width="70" bgcolor="#EBEBEB" align="center">EQUIPO</td>
			  <td width="90" bgcolor="#EBEBEB" align="center">SOFTWARE</td>
			  <td width="140" bgcolor="#EBEBEB" align="center">USUARIO</td>
			  <td width="80" bgcolor="#EBEBEB" align="center">LOGIN</td>
			  <td width="80" bgcolor="#EBEBEB" align="center">PASSWORD</td>
			</tr>
			<?php
			$id = 0; 
			while($row=mysqli_fetch_array($result1)) {
			$i++;
				if(($rows1) !=0){?>
					<tr>
					  <td class="Estilo2"><?php echo $i;?></td>
					  <td class="Estilo2"> <?php echo $row["equipo"];?></td>
					  <td class="Estilo2"><?php echo $row["software"];?></td>
					  <td class="Estilo2"> <?php echo $row["usuario"];?></td>
					  <td class="Estilo2"><?php echo $row["login"];?></td>
					  <td class="Estilo2"> <?php echo base64_decode($row["passwd"]);?></td>
					</tr><?php
				}

			}?>
	</table>
</fieldset>
</html>