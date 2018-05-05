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
include('header.php'); 
include('script.php');
$query_man = "SELECT * FROM manuales";
$RSD_man = mysqli_query($miConex, $query_man);
$row_man = mysqli_fetch_assoc($RSD_man);
include('barra.php');
$palabra='';
if(isset($_GET['palabra'])){$palabra = $_GET['palabra'];} ?>
<div id="buscad"> 
<fieldset class="fieldset"><legend class="vistauserx">Manual del Usuario</legend>
<div align="justify"><?php echo $row_man['manuales'];?></div>
</fieldset><br>
<?php include ("version.php");?>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>