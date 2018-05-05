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
<link href="css/template.css" rel="stylesheet" type="text/css" />
<p align="center">&nbsp;</p>
<table width="849" border="0" align="center">
  <tr>
    <td width="237"><div align="left"><strong class="componentheading">Introduce cualquier  Descripci&oacute;n por la que desee buscar: </strong></div></td>
    <td width="605" bordercolor="#FFFFFF" bgcolor="#FFFFFF"><form action="buscaaft.php" method="post" name="header" target="b" id="header" >
      <p align="center">
        <input name="palabra" type="text" class="sgf1" size="20" maxlength="20" align="middle" />
        <input name="Buscar" type="SUBMIT" class="sgf1" value="Buscar" />
      </p>
    </form></td>
  </tr>
</table>
<table width="100%" height="406" border="0" align="center" cellpadding="0" cellspacing="0" class="notice" repeat:none>
  <tr align="right" valign="top">
    <td width="450" height="2" bgcolor="#FFFFFF"><hr align="right" width="100%" color="#0099CC" /></td>
  </tr>
  <tr align="right" valign="top">
    <td height="25"><iframe src="buscaaft.php" name="b" width="100%" height="600" frameborder="0" class="notice" border="0"> El explorador no admite los marcos flotantes o no está configurado actualmente 
    para mostrarlos. </iframe></td>
  </tr>
</table>
<div align="right"></div>
