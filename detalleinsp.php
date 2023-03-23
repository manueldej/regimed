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
include ('connections/miConex.php');
$kk=0;
$roo = $_SERVER['DOCUMENT_ROOT'];
$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
$ruta = $roo .$pht1."inspecciones/";

if(isset($_GET['l1'])){$kk=1;}
	if(($kk) !=1){
		if(isset($_GET['insp'])){
			$sql = "SELECT * FROM inspecciones WHERE id = '".$_GET['insp']."'";
			$result= mysqli_query($sql) or die(mysql_error());
		}elseif(isset($_GET['ini'])){
			$inicio=$_GET['ini']; $registros=$_GET['reg'];
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$sql = "select * from inspecciones where idunidades='".$_COOKIE['unidades']."'";
				$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
				$result= mysqli_query($sql,$miConex) or die(mysql_error());
			}else{
				$sql = "select * from inspecciones";
				$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
				$result= mysqli_query($sql,$miConex) or die(mysql_error());				
			}
		}
		
		$numro = mysqli_num_rows($result);

		$i="es";
		if(isset($_COOKIE['seulang'])){
			if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
		}
		if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
		?>
		<link href="template.css" rel="stylesheet" type="text/css" />
		<fieldset class='fieldset'><legend class="vistauserx"><?php echo strtoupper($otrosdet);?></legend>	
		<style type="text/css">
		<!--
		.Estilo2 {font-weight: bold}
		-->
		</style><?php
		if(($numro) ==1){ 
			$row=mysqli_fetch_array($result);
			$sedg=mysqli_query("select * from datos_generales where id_datos ='".$row["idunidades"]."'") or die(mysql_error());
			$qsedg = mysqli_fetch_array($sedg);?>
			<TABLE width="100%" BORDER='0' bordercolor='#AFCBCF' class='sgf1' align='center' >
				<tr>
					<td width="71"class="vistauser1"><b><?php echo $Fecha;?>:</b>&nbsp;<?php  echo $row["fecha"]." -> <b>".$btdatosentidad3."</b>: ".$qsedg['entidad'];?></td>
			    </tr>
				<tr>
					<td class="Estilo2"><?php 
						$handle=fopen($ruta.$row["observ"],'r');
						while(!feof($handle)){
							$buffer=fgets($handle,4096);
							echo htmlspecialchars($buffer);
						}
						fclose($handle);?>
					</td>
			</table><?php
		}else{ ?>
			<TABLE width="100%" BORDER='0' bordercolor='#AFCBCF' class='sgf1' aling='center' > <?php
					while($row=mysqli_fetch_array($result)) { $i++;
						$sedg=mysqli_query("select * from datos_generales where id_datos ='".$row["idunidades"]."'") or die(mysql_error());
						$qsedg = mysqli_fetch_array($sedg);	?>
						<tr>
							<td width="71"class="vistauser1"><b><?php echo $Fecha;?>:</b>&nbsp;<?php  echo $row["fecha"]." -> <b>".$btdatosentidad3."</b>: ".$qsedg['entidad'];?></td>
						</tr>
						<tr>
							<td class="Estilo2"><?php echo $ruta.$row["observ"];
								$handle=fopen($ruta.$row["observ"],'r');
								while(!feof($handle)){
									$buffer=fgets($handle,4096);
									echo htmlspecialchars($buffer);
								}
								fclose($handle);?>
							</td>
						</tr>
						<tr>
							<td><hr></td>
						</tr><?php
					}?>
			</table>
<?php

		}
	}	?>
</fieldset>
