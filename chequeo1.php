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
  $qus = mysqli_query("select login,tipo from usuarios where login ='".$_SESSION ["valid_user"]."'") or die(mysql_error());
  $rus = mysqli_fetch_array($qus);
  if ($rus['tipo'] !="root") { ?>
     <script type="text/javascript">document.location="expedientes.php";</script>
 <?php  } ?>