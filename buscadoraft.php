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
?>
<?php
@session_start(); include('chequeo.php');
if (!check_auth_user()){
	header ("Location: index.php");
	exit;
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="funciones.js"></script>
<fieldset class="fieldset">
<form name="frmbusqueda" action="" onsubmit="buscarDato(); return false">
  <div align="center">
    <p><span class="Estilo4"><img src="images/Eye.jpg" width="102" height="99" /></span></p>
    <p><span class="Estilo4"><a name="buscar" id="buscar"></a>Introduzca: (No. INV o tipo de equipo a buscar)</span>
      <input type="text" name="dato" /> 
      </p>
  </div>
</form>
<div>
<div id="resultado"></div>
  <br><hr width="70%" align="center">
<div class="contentpaneopen" align="center">
	<div class="Footer-text" align="center">
		<?php include ("version.php"); ?>
	</div>
</div>
</fieldset>
