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
require('mensaje.php');
include('barra.php');
include('script.php');?>
<div id="buscad"> 
<fieldset class="fieldset"><legend class="vistauserx"><?php echo $btcategmedios;?></legend>
		<script language="JavaScript" >
	// Check for a blank field
		function cierrz(){
		document.getElementById('cir').innerHTML="";
	}
			function submit_page() {
				// form validation check
				var formValid=false;
				var f = document.form1;
				if ( f.t2.value == '' ) {
					showAlert(4000,'<div class="alert negro" style="display: none"><button class="closex" type="button" onclick="cierrz();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $plea2.$nomnewcat;?>.</b></div></div>');
					f.t2.focus();
					formValid=false;
				} else{	formValid=true;  }
				return formValid;
			}
			//------------------------- funciones -------------------------------------------//
			function isFieldBlank(theField){
				innStr = theField.value;
				innLen = innStr.length;
				
				if(theField.value == "" && innLen==0)
					return true;
				else
					return false;
			}

			function ctype_digit(theField){
				val = theField.value;
				Len = val.length;
			 
				for(var i=0; i<Len; i++)  {
					var ch = val.substring(i,i+1)
					if(ch < "0" || "16"< ch)
						return true;
				}
			}
			//esta funcion comprobará que el No de carnet no tenga menos de 11 caracteres
			function ci(theField)  {
				val = theField.value;
				Len = val.length;
				for(var i=0; i<Len; i++)
					var chh = val.substring(i,i+1)
				if(i < "16")
					return true;
			}
			//-----------------------  formulario  ----------------------------------//
				var nav4 = window.Event ? true : false;
				function acceptNumx(evt){	
					var key = nav4 ? evt.which : evt.keyCode;	
					return (key <= 27 || (key >= 65 && key <= 90) || (key >= 97 && key <= 121));
				}
		</script><?php
	if(isset($_POST["insertar"])){	?>
		<table width="478" border=0 align="center" bgcolor='#FFFFFF'>
		<tr>
		  <td ><table width="100%" border="0" align="left" >
			<form name="form1" method="post" action="insertacateg.php" onsubmit="return submit_page();">          
			  <tr>
				
			  <td colspan="4"></td>
			  </tr>
			  <tr>
				<td><div align="right" class="contentheading"><?php echo strtoupper($btNombre);?></div></td>
				<td colspan="2"><input name="t2" type="text" id="t2" autocomplete="off" size="35" class="form-control" maxlength="100" onKeyPress="return acceptNumx(event);"></td>
			  </tr>
			  <td width="74" align="right"><input type="submit" class="btn" name="insertar" value="<?php echo $btaceptar;?>"></td>
				<td width="389" align="left"><input type="button" class="btn" name="Submit2" value="<?php echo $btcancelar;?>" onClick="javascript:document.location='categ_medios.php';"></td>
			  </tr>	 
			</form>	
		  </table></td>
		</tr>
	</table>	<?php
	}
	if(isset($_POST['crash']) AND ($_POST['crash']) !=""){
		@$marcado = @$_POST['marcado'];
			if(($marcado) ==""){
				show_message($strerror,$plea8.$btbajas.".","cancel","bajas.php"); ?>
				  <br><hr width="70%" align="center">
					<?php include ("version.php"); 
				exit;
			}	
			foreach($marcado as $rest){
				$sel = "select * from tipos_medios where id='".$rest."'";
				$qsel = mysqli_query($miConex, $sel) or die (mysql_error());
				$nsel = mysqli_fetch_array($qsel);
				
				$sql4v = "DELETE FROM tipos_medios WHERE  id='".$rest."'";
				$resultado4v = mysqli_query($miConex, $sql4v) or die(mysql_error());	
				
				$sql ="ALTER TABLE `areas` DROP `".strtolower($nsel['nombre'])."`";
				$result = mysqli_query($miConex, $sql) or die(mysql_error());
			} ?>
			<script type="text/javascript">document.location="categ_medios.php";</script><?php
	}
	if(isset($_POST['editar'])){ 
		@$marcado = @$_POST['marcado'];
		$ctos = count($marcado);
		if(($marcado) ==""){
			show_message($strerror,$plea8.$btbajas.".","cancel","bajas.php"); ?>
			  <br><hr width="70%" align="center">
			<div class="Footer">
				  <div class="Footer-inner">
					 <div class="Footer-text"><p><?php include ("version.php");?></p></div>
			  </div>
			</div><?php
			exit;
		} ?>
		<table width="478" border=0 align="center" bgcolor='#FFFFFF'>
			<tr>
				<td >
					<table width="473" border="0" align="left">
						<form name="form1" method="post" action="insertacateg.php" onSubmit="return submit_page();">          
							<tr>			
								<td colspan="3"></td>
							</tr>
							<tr>
							  <td colspan="2"><div align="center" class="contentheading"><?php if(($ctos) ==1){ echo $catmod; }else{  echo $catmod1; } ?></div></td>
						    </tr><?php
								foreach($marcado as $rest){
										$resultado4v = mysqli_query($miConex, "select * FROM tipos_medios WHERE  id='".$rest."'") or die(mysql_error());
										$resulta = mysqli_fetch_array($resultado4v);?>
									<tr>
										<td colspan="2">
											<input name="nombre[]" type="text" id="nombre[]" size="35" class="form-control" maxlength="100" onKeyPress="return acceptNumx(event);" value="<?php echo $resulta['nombre'];?>">
											<input type="hidden" name="marca[]" value="<?php echo $resulta['id'];?>">
											<input name="viejo[]" type="hidden"  value="<?php echo $resulta['nombre'];?>" />
										</td>
									</tr> <?php 
								} ?>							
							<tr>
								<td>
									<input type="submit" class="btn" name="modificar" value="<?php echo $btaceptar;?>">
									<input type="button" class="btn" name="Submit2" value="<?php echo $btcancelar;?>" onClick="javascript:document.location='categ_medios.php';">
								</td>
							</tr>	 
						</form>	
					</table>
				</td>
			</tr>
		</table><?php
	} ?>
</fieldset><br>
	<?php include ("version.php");?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="js/main.js"></script>