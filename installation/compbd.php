<?php
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Inform�ticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    01/06/2016                                             					                        #
# @autor  Ing. Manuel de Jes�s N��ez Guerra   								     			                #
#          	Msc. Carlos Pollan Estrada											         		            #
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
