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
include('header.php'); 
$query_creditos = "SELECT * FROM creditos";
$rscreditos = mysqli_query($miConex, $query_creditos) or die(mysql_error());
$row_creditos = mysqli_fetch_assoc($rscreditos);
$ver = $row_creditos['creditos'];
?>
<SCRIPT language='javascript'>
 function doSubmit() {		var emptyForm = true;
	with (document.cre)
	{      emptyForm = (lng.value == "");		
		if (!emptyForm)		{         submit();		}	} }

function confi(r){
	var modal;
	modal=window.showModalDialog(r);
	
}
function showModalz(pos,ima, txt){
	$('.dialogoInfo').html('<div id="myModal" class="modal hide fade"><div class="modal-header rojo">'+pos+'</div><div class="modal-body"><p align="center"><table align="center" cellpadding="3" cellspacing="3" border="0"><tr><td><img src="images/'+ima+'" border="2" align="left"></td><td valign="top">'+txt+'</td></tr></table></p></div><div class="modal-footer"><button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button></div></div>');
	$('#myModal').modal();
}
</script>
<?php include('barra.php');?>
<div id="buscad">
<fieldset class='fieldset'><legend class="vistauserx"><?php echo $btcreditos1;?></legend>
	<table align="center" border="0" cellpadding="0" cellspacing="0" style="height:440px; width:886px">
	    <tr>
			<td align="center" valign="top">
				<div align="center"><img src="images/logoaplicacion.png" width="189" height="127" align="middle" /><br><br></div>
				<div align="justify"><span style="color: red"><strong>Registro de Medios&nbsp;Inform&aacute;ticos</strong></span>, idea original, dise&ntilde;o y programaci&oacute;n: <a href="?m#modal2" class="tooltip"><font color="#000000"><b>Ing. Manuel de Jes&uacute;s N&uacute;&ntilde;ez Guerra</b></font><span onmouseover="this.style.cursor='pointer';"><?php echo $click1.strtolower($sho).$bddatosper;?></span></a>, Administrador superior "A" de redes inform&aacute;ticas de la F&aacute;brica &quot;Manuel Fajardo Rivero&quot;, programaci&oacute;n: <a class="tooltip" href="?p#modal2"><font color="#000000"><b>MSc. Carlos Poll&aacute;n Estrada</b></font><span onmouseover="this.style.cursor='pointer';"><?php echo $click1.strtolower($sho).$bddatosper;?></span></a>, Especialista en Ciencias Inform&aacute;ticas del &quot;Joven Club de Computaci&oacute;n de Guant&aacute;namo&quot;.&nbsp;</div>
			</td>
		</tr>
	    <tr>
			<td valign="top"><?php echo $ver;?></td>
		</tr>
	</table><?php
	if(isset($_GET['m'])){
		$post='Ing. Manuel de Jes&uacute;s N&uacute;&ntilde;ez Guerra';
		$ima='manuel.jpg';
		$textoam='Administrador superior "A" de redes inform&aacute;ticas de la Empresa de Servicios T&eacute;cnicos Industriales ZETI - UEB F&aacute;brica &quot;Manuel Fajardo Rivero.<br> email:<a href=mailto:manuel.jesus@zetifmf.azcuba.cu style=cursor:pointer>manuel.jesus@zetifmf.azcuba.cu</a><br>Telf: (+53) 59867533<br>M&oacute;vil: (+53) 53924528';
	}
	if(isset($_GET['p'])){
		$post='MSc. Carlos Poll&aacute;n Estrada';
		$ima='carlos4.jpg';
		$textoam='Especialista en Ciencias Inform&aacute;ticas del Archivo Hist&oacute;rico de Manzanillo<br><b>IN MEMORIAN</b>';
	}	?>
<div id="modal2" class="modalmask">
<div class="modalbox rotate">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -13px; width: 548px; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2 class="pos"><?php echo $post;?></h2></div>
		<p><p align="center"><table align="center" cellpadding="3" cellspacing="3" border="0"><tr><td><img src="images/<?php echo $ima;?>" border="2" align="left"></td><td valign="top"><?php echo $textoam;?></td></tr></table></p></p>
	</div>
</div>	
</fieldset><br>
<?php include ("version.php");?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>