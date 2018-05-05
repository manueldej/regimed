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
	?><script type="text/javascript">window.parent.location="index.php";</script><?php
	exit;
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/template.css" rel="stylesheet" type="text/css" />
<fieldset class="fieldset">
<table width="849" border="0" align="center">
  <tr>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF" align="center">
      <form action="registromedios1.php" method="post" name="header" target="b" id="header" >
	  <strong class="componentheading">Buscar Medios: </strong>
	  <input name="palabra" type="text" class="sgf1" size="20" maxlength="20" align="middle" />
	  <input name="Buscar" type="SUBMIT" class="sgf1" value="Buscar" />
      </form>
    </td>
  </tr>
</table>
<table width="896" height="406" border="0" align="center" cellpadding="0" cellspacing="0" class="notice" repeat:none>
  <tr align="right" valign="top">
    <td height="25"><iframe src="registromedios1.php" name="b" scrolling="Auto" width="950" height="600" frameborder="0" class="notice" border="0"> El explorador no admite los marcos flotantes o no est? configurado actualmente 
    para mostrarlos. </iframe></td>
  </tr>
</table>
    <br><hr width="70%" align="center">
<div class="contentpaneopen" align="center">
	<div class="Footer-text" align="center">
		<?php include ("version.php"); ?>
	</div>
</div>
</fieldset>
