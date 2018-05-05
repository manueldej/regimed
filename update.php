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
require_once('connections/miConex.php');
$sql="DROP TABLE IF EXISTS `conectado`"; 
mysqli_query($miConex, $sql);
$sql1= "CREATE TABLE `conectado` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `conectado` varchar(100) DEFAULT NULL,
					  `fecha` date DEFAULT NULL,
					  `idunidades` int(11) NOT NULL,
					  PRIMARY KEY (`id`),
					  KEY `idunidades` (`idunidades`)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
				mysqli_query($sql1,$miConex);
?>