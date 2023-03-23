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

		$vali=$_GET['val'];
		$tabla = $_GET['tb'];
		$campo = $_GET['campo'];
	
	if(!isset($_GET['accion'])){
		if (($tabla=='usuarios')) {
			$sva=mysqli_query($miConex, "select login from usuarios where login='".$vali."'") or die(mysql_error());
			$rva = mysqli_num_rows($sva);
			if(($rva) !=0){ 
				echo "<input name='s' size='50' class='textod' value='El Usuario -".$vali."- no est&aacute; disponible'>"; 
			}else{
				if((strlen($vali) < 4)){
					echo "<input name='s' size='50' class='textod' value='El m&iacute;nimo de caracteres para el Login es de 4.'>";
			}elseif((strlen($vali) > 25)){
				echo "<input name='s' size='50' class='textod' value='El m&aacute;ximo de caracteres para el Login es de 25.'>";
			}
			} 
		}else if (($tabla=='aft')){
			if ($campo =='inv') {
			 $sva=mysqli_query($miConex, "select inv from aft where inv='".$vali."'") or die(mysql_error());
			 $rva = mysqli_num_rows($sva);
			 $sva1=mysqli_query($miConex, "select inv from bajas_aft where inv='".$vali."'") or die(mysql_error());
			 $rva1 = mysqli_num_rows($sva1);
			 $sva2=mysqli_query($miConex, "select inv from historial_bajas where inv='".$vali."'") or die(mysql_error());
			 $rva2 = mysqli_num_rows($sva2);
			 
				if(($rva !=0) OR ($rva1 !=0) OR ($rva2 !=0)){ 
					echo "<input name='s' size='50' class='textod' value='El INV:".$vali.", no est&aacute; disponible'>"; 
				}else{
					if((strlen($vali) < 4)){
						echo "<input name='s' size='50' class='textod' value='No cumple los requisitos para un nro. de Inv.'>";
					}elseif((strlen($vali) > 15)){
						echo "<input name='s' size='50' class='textod' value='El m&aacute;ximo de caracteres para el Inv. es de 15.'>";
					}
				} 
			}else if ($campo =='descrip') {
			    if((strlen($vali) < 3) OR (strlen($vali) > 15)){
				  echo "<input name='s' size='50' class='textod' value='No cumple los requisitos para nombre de un AFT.'>";
				}
			}
		}
	}else{
      $accion = $_GET['accion'];
	  $valantes = $_GET['valantes'];
      $ff =  $_GET['idcomp'];
		if (($tabla=='aft')){
			if ($campo =='inv' AND ($valantes!=$vali) ) {
			 $sva1=mysqli_query($miConex, "select inv from bajas_aft where inv='".$vali."'") or die(mysql_error());
			 $rva1 = mysqli_num_rows($sva1);
			 $sva2=mysqli_query($miConex, "select inv from historial_bajas where inv='".$vali."'") or die(mysql_error());
			 $rva2 = mysqli_num_rows($sva2);
			 
				if((@$rva !=0) OR (@$rva1 !=0) OR (@$rva2 !=0)){ 
					echo "<input name='s[]' id='s".$ff."' size='50' class='textod' value='El Nro. de Inv. -".$vali."- no est&aacute; disponible'>"; 
				}else{
					if((strlen($vali) < 4)){
						echo "<input name='s[]' id='s".$ff."' size='50' class='textod' value='No cumple los requisitos para un nro. de Inv.'>";
					}elseif((strlen($vali) > 15)){
						echo "<input name='s[]' id='s".$ff."' size='50' class='textod' value='El m&aacute;ximo de caracteres para el Inv. es de 15.'>";
					}
				} 
			}else if ($campo =='descrip') {
			   if((strlen($vali) < 4) OR (strlen($vali) > 15)){
					echo "<input name='s[]' id='s".$ff."' size='50' class='textod' value='No cumple los requisitos para nombre de un AFT.'>";
				}
			}
		}
	}    
			
?>
			
			