<?php 
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Inform�ticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    24/03/2011 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jes�s N��ez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)							         		            #
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
?>
<?php
		@session_start(); 
		include('chequeo.php');
		if (!check_auth_user()){
			?><script type="text/javascript">window.parent.location="index.php";</script><?php
			exit;
		}

include('script.php');
	if (!file_exists('connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="installation/index.php";</script><?php	
		return;	
	} 
	?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><?php
include('connections/miConex.php');
    $query_Recordset4 = "SELECT usuarios.nombre FROM usuarios"; 
	$Recordset4 = mysqli_query($query_Recordset4, $miConex) or die(mysql_error());
	
?>
<link href="css/template.css" rel="stylesheet" type="text/css" />
<table width="952" height="46" border="0" align="center">
  <tr>
    <td height="42"><div align="center" class="mosimage_caption"><strong>MEMORIAS - FLAH</strong></div>
      <iframe src="registrousb.php" name="b" scrolling="Auto" width="950" height="600" frameborder="0" class="notice" border="0"> El explorador no admite los marcos flotantes o no est? configurado actualmente 
    para mostrarlos. </iframe></td>
  </tr>
</table>
