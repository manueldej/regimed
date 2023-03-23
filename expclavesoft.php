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