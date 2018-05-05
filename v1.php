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
include ('script.php');
require("mensaje.php"); 
include('barra.php'); ?>
<div id="buscad"> <?php
	if(($_SESSION ["valid_user"]) =="invitado"){ ?>
		<fieldset class="fieldset"><legend class="vistauserx"><?php echo $musuario1;?></legend>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
				<td height="250">&nbsp;</td>
			  </tr>
			</table>
			<br>
			<div id="footer" class="degradado" align="center">
				<div class="container">
					<p class="credit"><?php include ("version.php");?></p>
				</div>
			</div>
		</fieldset>
		<div class="dialogoInfo"></div>
		<div class="ContenedorAlert" id="cir"> </div>
				<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
				<script type="text/javascript" src="js/bootstrap.min.js"></script>
				
				<script type="text/javascript" src="js/main.js"></script>
			<script type="text/javascript">
				function cierrasd(){
					document.location='expedientes.php';
				}
				showAlertx('<div class="alert negro"><button class="close" type="button" onclick="cierrasd();">x</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $privile1;?>.</b></div></div>');

			</script><?php 
			exit;
	}?>
<style type="text/css">
<!--

div.message {
	font-family : "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size : 14px;
	color : #c30;
	text-align: center;
	width: auto;
	background-color: #f9f9f9;
	border: solid 1px #d5d5d5;
	margin: 3px 0px 10px;
	padding: 3px 20px;
}
-->
</style>
<script type="text/javascript">
function decodifica(estado,codif,decodif,id,idcodif){
    if (estado==true){
	  document.getElementById(id).value=decodif;
	}else{
	 document.getElementById(id).value=document.getElementById(idcodif).value;
	}
 }
</script> 
<fieldset class="fieldset"><legend class="vistauserx"><?php echo $musuario1;?></legend>
<?php
	if(isset($_POST["crash"]) AND ($_POST["crash"]) !=""){
		$query_Recordset1 = "SELECT * FROM datos_generales";
		$Recordset1 = mysqli_query($query_Recordset1) or die(mysql_error());
		$row_Recordset1 = mysqli_fetch_array($Recordset1);
		$m_Priority = 3; // 1 Urgente, 3 Normal
		$m_r_Greeting = "Estimado(a): ";
		$m_Thanks = "Con toda consideracion, ";
		$mailserVer = $row_Recordset1['smtp'];//"172.26.11.1"
		$m_From_Adress =$row_Recordset1['mail'];
		$m_Signature = $row_Recordset1['entidad']."\nURL: http://".$row_Recordset1['web'];

			$marcado = @$_POST["marcado"];
			$cant = @$_POST['cant'];
				ini_set("SMTP",$mailserVer);
				ini_set("sendmail_from",$m_From_Adress);	

			if(empty($marcado)){
				show_message($strerror,$plea8.$useract.".","cancel","ej1.php"); 
				exit;
			}

			for($k=0; $k<count($marcado); $k++){
				if (!empty($marcado[$k]))  {  
					$query="select* from usuarios where id='".$marcado[$k]."'";
					$result=mysqli_query($query) or die(mysql_error());
					$row = mysqli_fetch_array ($result);
					if(($row["tipo"]) =="root"){ 
						show_message($strerror,$noborrar,"cancel","ej1.php"); ?>
						<br>
						<div id="footer" class="degradado" align="center">
							<div class="container">
								<p class="credit"><?php include ("version.php");?></p>
							</div>
						</div>
						<div class="dialogoInfo"></div>
						<div class="ContenedorAlert" id="cir"> </div>
								<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
								<script type="text/javascript" src="js/bootstrap.min.js"></script>
								
								<script type="text/javascript" src="js/main.js"></script>					<?php
						exit;
					}
				//Send confirmation mail.... 				
					$m_Priority = 3; // 1 Urgente, 3 Normal
					$cuerpo1 = $m_r_Greeting.$row["nombre"]."\n\nEste correo es para informarle que Usted ha sido eliminado como Usuario de este Sitio Web\n Cualquier duda, por favor contacte con el Administrador del Sitio.\n\n\n".$m_Thanks."\n\n".$m_Signature;
						$a = str_replace('&aacute;', 'á', $cuerpo1);
						$e = str_replace('&eacute;', 'é', $a);
						$i = str_replace('&iacute;', 'í', $e);
						$o = str_replace('&oacute;', 'ó', $i);
						$u = str_replace('&uacute;', 'ú', $o);
						$n = str_replace('&ntilde;', 'ñ', $u);
						$A = str_replace('&Aacute;', 'Á', $n);
						$E = str_replace('&Eacute;', 'É', $A);
						$I = str_replace('&Iacute;', 'Í', $E);
						$O = str_replace('&Oacute;', 'Ó', $I);
						$U = str_replace('&Uacute;', 'Ú', $O);
						$finall = str_replace('&Ntilde;', 'Ñ', $U);		
					
						$destino = array($row["email"]) ;
						$asunto = $btregisusuario ;
						$encabezados = 'From: Equipo Desarrollador <'.$m_From_Adress.'>' ;
							$cuta=0;
							for($r=0; $r<count($destino);$r++){
								if(mail($destino[$r], $asunto, $finall, $encabezados)){
									$cuta++;
								}
							}
						if(($cuta) ==0)	{			
							$Meng = $n_mail;
						}else{
							$Meng = $sol_registr1;
						}
						$sql = "DELETE FROM usuarios WHERE id='".$marcado[$k]."'";
						$result = mysqli_query($miConex, $sql) or die(mysql_error());
				}
			}
			echo '<br><div align="center"><div class="message" align="center">'.$Meng.'</div></div>';	?>
			<script language="javascript">
				document.location='ej1.php';
			</script><?php
	}
	if(isset($_REQUEST["editar"])){
		if(isset($_REQUEST["marcado"])){ $marcado = $_REQUEST["marcado"]; }
		
		if(empty($marcado)){
		    if (isset($_REQUEST['opera'])) {
			  $sqlyo = "SELECT * FROM usuarios WHERE login='".$_SESSION['valid_user']."'";
			  $resultyo = mysqli_query($miConex, $sqlyo) or die (mysql_error());
			  $filayo = mysqli_fetch_array($resultyo);  
			  $marcado[] = $filayo['id'];   
			}else{
			  show_message($strerror,$plea8.$useract.".","cancel","ej1.php"); 
			  exit;
			}
		} ?>
		<form name="form1" method="post" action="insertar.php">
			<table width="90%" border="0" align="center" cellspacing="2" cellpadding="2" class="tablen">
			<?php 
			$o=0;
			$validus = "";
				if(isset($_SESSION["autentificado"])){
					$validus = " AND idunidades='".$_SESSION["autentificado"]."'";
				}elseif (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
					$validus = " AND idunidades='".$_COOKIE['unidades']."'";
				}else{
					$validus = "";
				}
				$resultq = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
				$rowq = mysqli_fetch_array ($resultq);
				foreach($marcado as $key){
					$query="select* from usuarios where id='".$key."'";
					$result=mysqli_query($miConex, $query) or die(mysql_error());
					$row = mysqli_fetch_array ($result);
					$nrow = mysqli_num_rows ($result);
					
					$query_area = "SELECT * FROM areas where idunidades='".$row['idunidades']."'";
					$Recarea = mysqli_query($miConex, $query_area) or die(mysql_error());
					
					$query_areaz = "SELECT * FROM areas where idunidades='".$row['idunidades']."'";
					$Recareaz = mysqli_query($miConex, $query_areaz) or die(mysql_error());
					$row_areaz = mysqli_fetch_array($Recareaz);
					$selex = "select * from reg_claves where usuario='".$row['nombre']."'";
					$qselex = mysqli_query($miConex, $selex) or die(mysql_error());
					$numero = mysqli_num_rows($qselex);
					$rselex = mysqli_fetch_array($qselex);
					
					?>
					<tr><td colspan="2"><hr align="center" width="100%" class="Estilo4"></td></tr>
					<tr>
					  <td width="187"><div align="right"><strong>Login</strong>:&nbsp;</div></td>
					  <td colspan="4">
						<input name="t1[]" <?php if(($rowq['tipo']) !="root"){ echo "readonly"; } ?> class="form-control" type="text" value="<?php echo $row["login"];?>" size="<?php echo strlen($row["login"]);?>">
						<input name="loginviejo[]" type="hidden" value="<?php echo $row["login"];?>">
					  </td>
					</tr>
					<tr>
					  <td><div align="right"><b><?php echo $clave;?>:&nbsp;</b></div></td>
					  <td colspan="4">
						<input name="t2[]" id="clavevieja1<?php echo $o;?>" class="form-control" size="<?php echo strlen(base64_decode($row["passwd"]));?>" type="text" value="<?php echo $row['passwd'];?>" onclick="muestraclave('<?php echo 'sistema'.$o; ?>','<?php echo 'clavevieja1'.$o; ?>'); document.getElementById('muestram1<?php echo $o;?>').style.display='none';">
						<input name="decodifa[]" id="decodifa<?php echo $o;?>" type="hidden" value="<?php echo base64_decode($row['passwd']);?>">
						<input name="codifa[]" id="codifa<?php echo $o;?>" type="hidden" value="<?php echo $row['passwd'];?>">
						<div id="muestram1<?php echo $o;?>" style="display:block;"><input name="muestra1[]" type="checkbox" id="muestra1<?php echo $o;?>" style="cursor:pointer; display:none;" onClick="decodifica(getElementById('muestra1<?php echo $o;?>').checked,getElementById('codifa<?php echo $o;?>').value,getElementById('decodifa<?php echo $o;?>').value, 'clavevieja1<?php echo $o;?>','codifa<?php echo $o;?>');" value="muestra1" />
						<span manolo='Mostrar/Ocultar Contrase&ntilde;a' id="oji<?php echo $o;?>" style="background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -113px 202px; height: 26px; width: 30px; float: right; cursor: pointer; position: absolute; margin-left: 768px; margin-top: -25px;" onmouseover="this.style.cursor='pointer';" onclick="if (getElementById('muestra1<?php echo $o;?>').checked==false) {getElementById('muestra1<?php echo $o;?>').checked=true; }else{getElementById('muestra1<?php echo $o;?>').checked=false;} decodifica(getElementById('muestra1<?php echo $o;?>').checked,getElementById('codifa<?php echo $o;?>').value,getElementById('decodifa<?php echo $o;?>').value, 'clavevieja1<?php echo $o;?>','codifa<?php echo $o;?>'); if(getElementById('muestra1<?php echo $o;?>').checked) { getElementById('oji<?php echo $o;?>').style='background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -559px 202px; height: 26px; width: 30px; float: right; cursor:pointer; position: absolute; margin-left: 768px; margin-top: -25px;'}else{ getElementById('oji<?php echo $o;?>').style='background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -113px 202px; height: 26px; width: 30px; float: right; cursor:pointer; position: absolute; margin-left: 768px; margin-top: -25px;'} "></span></div>
					  </td>
					</tr>
					<tr>
					  <td><div align="right" ><b>E-Mail:&nbsp;</b></div></td>
					  <td colspan="4"><p>
						<input name="t3[]" type="email" required="" class="form-control"  size="<?php echo strlen($row["email"]);?>" value="<?php echo $row["email"];?>">
						<label></label>
						</p>          </td>
					</tr>
					<tr>
					  <td><div align="right"><b><?php echo $btnCargo;?>:&nbsp;</b></div></td>
					  <td colspan="4"><p>
						<input name="t4[]" type="text" class="form-control"  size="<?php echo strlen($row["cargo"]);?>" value="<?php echo $row["cargo"];?>">
						<label></label>
						</p>          </td>
					</tr>
					<tr>
					  <td><div align="right"><b><?php echo $btNombre;?>:&nbsp;</b></div></td>
					  <td colspan="3">
						<input name="t5[]" type="text" class="form-control" size="<?php echo strlen($row["nombre"]);?>" value="<?php echo $row["nombre"]?>" />
						<input name="viej[]" type="hidden"  value="<?php echo $row["nombre"]?>" />
						<input name="Uviejo[]" type="hidden"  value="<?php echo $rselex['usuario']?>" /></td>
					</tr><?php 
					if(($rowq["tipo"]) =="root"){ ?>
						<tr>
							<td><div align="right"><b><?php echo $btAreas;?>:&nbsp;</b></div></td>
							<td colspan="3">
								<input name="aviej[]" type="hidden"  value="<?php echo $row["idarea"];?>" />
								<select class="form-control" name="t6[]" size="1" id="t6[]"> <?php
								while ($row_area = mysqli_fetch_array($Recarea)){
									if(($row_area['nombre']) !="Reparaciones"){?>
										<option value="<?php echo $row_area['nombre']?>" <?php if($row_area['nombre']==$row["idarea"]){ echo "selected";} ?>><?php echo $row_area['nombre'];?></option> <?php
									}
								} ?>
							  </select>			
							</td>
						</tr><?php 
					}else{ ?><input name="t6[]" type="hidden"  value="<?php echo $row_areaz['nombre'];?>" />
						<input name="aviej[]" type="hidden"  value="<?php echo $row_areaz['idarea'];?>" /><?php 
					}
					if(($rowq["tipo"]) !="usuario" AND  ($row["tipo"]) !="root"){ ?>
					<tr>
						<td><div align="right"><b><?php echo $t_usuario;?>:&nbsp;</b></div></td>
						<td colspan="3">
							<select name="tipo[]" class="form-control">
								<option value="-1"><?php echo $seleccione.$El.$t_usuario;?></option>
								<option value="usuario" <?php if(($row["tipo"]) =="usuario"){ echo "selected";}?>><?php echo $btusuario;?></option>
								<option value="admin" <?php if(($row["tipo"]) =="admin"){ echo "selected";}?>><?php echo $admini;?></option>
						  </select>			</td>
					</tr>
					<?php }
					if(($rowq["tipo"]) == $row["tipo"] OR ($rowq["tipo"]) =="root"){ ?>
					<tr>
					  <td><div align="right"><b><?php echo $Sexo;?>:&nbsp;</b></div></td>
					  <td colspan="3"><select name="sexo[]" class="form-control">
						<option value="h" <?php if(($row["sexo"]) =="h"){ echo "selected";}?>><?php echo $Hombre;?></option>
						<option value="m" <?php if(($row["sexo"]) =="m"){ echo "selected";}?>><?php echo $Mujer;?></option>
						</select>
					  </td>
					</tr><?php 
					}
					if(($rowq["tipo"]) =="usuario"){ ?>
						<input name="tipo[]" type="hidden"  value="<?php echo $row["tipo"];?>" /><?php 
					}		
					if(($rowq["tipo"]) =="root"){ ?>
						<input name="tipo[]" type="hidden"  value="root" /><?php 
					}?>		
					<tr>
						<td colspan="3"><input name="id[]" type="hidden" value="<?php echo $row["id"];?>"><input name="tipo1[]" type="hidden" value="<?php echo $row["tipo"];?>"></td>
					</tr><?php  $o++;
				} ?>
				   <tr>
					  <td colspan="3" align="center"><hr>
						<input name="o" type="hidden" value="<?php echo $o;?>">
						<input type="submit" class="btn" name="editar" value="<?php echo $btaceptar;?>">&nbsp;
						<input type="button" class="btn" name="Submit2" value="<?php echo $btcancelar;?>" onClick="javascript:document.location='ej1.php';"></td>
				  </tr>
			  </table>
		</form><?php
	}
if(isset($_POST["insertar"])){
$t= @$_POST['palabra'];
	?><script type="text/javascript">document.location='registro2.php<?php if(($t) !=""){ ?>?t=<?php echo $t; }?>';</script><?php
} ?>
</fieldset><br>
<?php include ("version.php");?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>