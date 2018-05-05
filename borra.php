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
include ('connections/miConex.php');
	$query = "SELECT * FROM ips";
	$lista = mysqli_query($query,$miConex);
	$nnum = mysqli_num_rows($lista);
	$resto1 = array();
				$handle=@opendir('./images/banderas'); 
				while ($file = readdir($handle)) { 
					$resto = substr ($file, 0, -4);    
						if ($file != "." && $file != "..") { 
							$resto1[]=$resto;
			
						} 
				}
				closedir($handle);	
				//print_r($resto1);
		if(($nnum) !=0){
			$p=0;
			while($row = mysqli_fetch_array($lista)){ 
				if (!in_array($row['country_name'], $resto1)) {
				$repla = str_ireplace("'","''",$row['country_name']);
					$sql= mysqli_query("delete from ips where country_name ='".$repla."'",$miConex) or die(mysql_error());
					$p++;
				}
			} 	
		}
?>