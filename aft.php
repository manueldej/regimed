<?php 
############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    24/03/2011 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)							         		            #
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
