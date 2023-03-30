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
?>
<style type="text/css">
<!--
.Estilo3 {
	font-size: 12px;
	color: #846131;
	font-weight: bold;
	font-style: italic;
}
body {
	margin-top: 5px;
}
-->
</style>
<SCRIPT language='javascript'>
	function cierrz(){
		document.location="expedientes.php";
	}
	function chequea(){
		var tt= document.form1;
		var re=/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/ 
		if((tt.de.value) ==""){
			tt.de.focus();
			showAlert(4000,'<div class="alert negro" style="display: none"><button class="closex" type="button" onclick="cierrz();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $plea2.$SU.$electron;?>.</b></div></div>');
			return false;
		}if (!re.exec(tt.de.value)){
			tt.de.focus();
			tt.de.value="";
			showAlert(4000,'<div class="alert negro" style="display: none"><button class="closex" type="button" onclick="cierrz();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $no_addres;?>.</b></div></div>');
			return false;
		}else if((tt.asunto.value) ==""){
			tt.asunto.focus();
			showAlert(4000,'<div class="alert negro" style="display: none"><button class="closex" type="button" onclick="cierrz();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $plea2.$plea4;?>.</b></div></div>');
			return false;	
		}else if((tt.cuerpo.value) ==""){
			tt.cuerpo.focus();
			showAlert(4000,'<div class="alert negro" style="display: none"><button class="closex" type="button" onclick="cierrz();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $plea2.$plea3;?>.</b></div></div>');
			return false;	
		}	
	}
	
</script>


<?php include('barra.php');?>
<div id="buscad">
<fieldset class='fieldset'><legend class="vistauserx"><?php echo $s_email;?></legend><?php
	if(isset($_POST['ok'])){
		$cuerpo = $_POST['cuerpo'];
		$asunto = $_POST['asunto'] ;
		$sCabeceras = 'From: '.$_SESSION ["valid_user"].' <'.$_POST['de'].'>' ;
		$destino = array('manuel.jesus@zetifmf.azcuba.cu') ;
		
		$cuta=0;
		for($r=0; $r<count($destino);$r++){
			if(mail($destino[$r], $asunto, $_POST['cuerpo'], $sCabeceras)){
				$cuta++;
			}
		}
		if(($cuta) ==0)	{ ?>
			<form name="ya" method="post" action="email.php">
				<input name="m" type="hidden" value="0">
			</form>
			<script language="javascript">
				document.ya.submit();
			</script>	<?php 					
		}else{ ?>
			<form name="ya1" method="post" action="email.php">
				<input name="m" type="hidden" value="1">
			</form>
			<script language="javascript">
				document.ya1.submit();
			</script>	<?php 	
		}	
	}
?>
	<form name="form1" method="post" action="" onsubmit="return chequea();">
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
		  <tr>
			  <td width="13%" align="right"><strong><?php echo $De;?>:</strong></td>
			<td width="87%"><input name="de" type="text" id="de" class="btn5"></td>
		  </tr>
			<tr>
				<td align="right"><strong><?php echo $Para;?>:</strong></td>
				<td><input name="para" type="text" class="btn5" id="para" size="60" readonly="" value="Ing. Manuel de Jes&uacute;s N&uacute;&ntilde;ez Guerra"></td>
			</tr>
			<tr>
				<td align="right"><strong><?php echo $Asunto;?>:</strong></td>
				<td><input name="asunto" type="text" id="asunto" class="btn5"></td>
			</tr>
			<tr>
				<td align="right" valign="top"><strong><?php echo $Cuerpo;?>:</strong></td>
				<td><textarea name="cuerpo" cols="60" rows="4" class="btn5" id="cuerpo"></textarea></td>
			</tr>
			<tr>
				<td colspan="2"><hr></td>
			</tr>
			<tr>
				<td colspan="2">
					<input name="ok" type="submit" id="ok" value="<?php echo $enviasenala ='Enviar';?>" class="btn">
					<input name="cancel" type="button" id="cancel" onclick="document.location='creditos.php'" value="<?php echo $btcancelar?>" class="btn">
				</td>
			</tr>
		</table>
	</form><?php
	if(isset($_POST['m'])){
$dd = "";
$txtms = "";
	if(($_POST['m']) =="1"){ 
		$dd= $strinforma;
		$txtms = $n_mail1;
	}else{ 
		$dd = $strerror;
		$txtms = $n_mail;
	} ?>
<div class="ContenedorAlert" id="cir"><div class="alert negro"><button class="close" type="button" onclick="cierrz();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $dd;?></b></font></div><div align="center"><b><?php echo $txtms;?>.</b></div></div></div>
<script language="javascript">
	$('.alert').fadeIn('slow');
	setTimeout(function(){$('.alert').fadeOut('slow');document.location="expedientes.php"; }, 2000);
</script>
<?php
}	?>
</fieldset><br>
<?php include ("version.php");?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
