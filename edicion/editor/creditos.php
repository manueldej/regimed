<!DOCTYPE html>
<?php 
#############################################################################################################
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
require('header.php'); 
?>
	<script src="../ckeditor.js"></script>
	<link rel="stylesheet" href="../../css/template.css">
<?php	 
$query_creditos = "SELECT * FROM creditos";
$rscreditos = mysqli_query($miConex, $query_creditos) or die(mysql_error());
$row_creditos = mysqli_fetch_assoc($rscreditos);
$ver = $row_creditos['creditos'];
if(($ver) ==""){
$in ="INSERT INTO creditos (creditos) VALUE ('&nbsp;&nbsp;')";
$qin = mysqli_query($miConex, $in);
}
include('barra.php');
echo "<table bordercolor='black' bgcolor='#ffffff' border='0' align='right' name='Table' class='' width='100%' cellspacing='0' cellpadding='0'><tr><td>";
echo "<form action='' method='post'>";
if(isset($_GET['c'])){ ?><div align="right"><span class="Footer_text"><a href="../../configura.php?c=c">Regresar&nbsp;&nbsp;&nbsp;&nbsp;</a></span></div><?php } ?>
<fieldset class='fieldset'><legend class='vistauserx'><font face='Verdana, Arial, Helvetica, sans-serif' size ='1'><?php echo strtoupper($bteditar).$btcreditos;?></font></legend><?php
	if (isset($_POST['creditos'])) {		  
		   $SQL_Creditos ="UPDATE creditos SET creditos = '".$_POST['creditos']."'";
		   $SQL_Creditos1 = "DELETE FROM creditos WHERE creditos ='' ";
		   $result = mysqli_query($miConex, $SQL_Creditos);
		   $result = mysqli_query($miConex, $SQL_Creditos1);
	} ?>
		<form action="edit_creditos.php" method="post">
			<textarea class="ckeditor" cols="80" id="creditos" name="creditos" rows="10"><?php echo $ver;?></textarea>
	</form>
			<br>
			<div id="footer" class="degradado" align="center">
				<div class="container">
					<p class="credit"><?php include ("version.php");?></p>
				</div>
			</div>
	</fieldset>
	<?php
	if (!empty($result)) {
		?>
		<script language="javascript">
			document.location = '../../creditos.php';
		</script>
	   <?php
	 }
?>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="../../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../js/main.js"></script>
