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
$paiss1 = array();	
$codig1 = array();
$ipp1 = array();
$handle1=@fopen("ip.txt",'r');
	while(!feof($handle1)){
		$buffer1=fgets($handle1,4096);
		$strre1 = str_ireplace('"','',$buffer1);
		$array1 = explode(',', $strre1);
		$paiss1[] = $array1[5];
		$codig1[] = $array1[4];
	}
fclose($handle1);
?>