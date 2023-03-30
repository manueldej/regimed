<?php
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    01/06/2016                                             					                        #
# @autor  Ing. Manuel de Jesús Núñez Guerra   								     			                #
#          	Msc. Carlos Pollan Estrada											         		            #
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

$h = $_GET['h'];
$u = $_GET['u'];
$p = $_GET['p'];
$b = $_GET['b'];

// $i = "es";
 	 // if(isset($_COOKIE['seulang'])){
		// if(($_COOKIE['seulang']) =="es"){@$i="es"; }else{@$i="en";}
	// }
	// if((@$i) =="es"){include('../esp.php');} else { include('../eng.php');}
	// if((@$i) =="es"){include('../esp.php');} else { include('../eng.php');}

	function compruebaDB($h,$u,$p,$b) {	
	 $i = "es";
 	 if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){@$i="es"; }else{@$i="en";}
	}
	if((@$i) =="es"){include('../esp.php');} else { include('../eng.php');}
	if((@$i) =="es"){include('../esp.php');} else { include('../eng.php');}
		$mysqli = mysqli_init();
		$mysqli->real_connect($h,$u, $p,"");
		$resultx = mysqli_query($mysqli, "SHOW DATABASES");
		$b_names = Array();
		$existe='n';
		
			while ($row = mysqli_fetch_array($resultx)) { 
				$b_names = $row['Database'];					
				if($b_names == $b){
					$existe='s';
				}
			}
			
			if ($existe =='s') {
				echo "<font color='red'><em>".$scri_exp."<b>".$b."</b>, ".$yaExiste.".</em></font>";
				//return true;
			}
			
			if ($existe =='n') {
				echo "<em>".$nomajax."</em>";
				//return false;
			}
					    
				  
		$mysqli->close();	
	}
	
	compruebaDB($h,$u,$p,$b);
	
	

?> 		
