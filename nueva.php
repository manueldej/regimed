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
include('script.php');
include('barra.php');
?>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="ajax.js"></script>
		<script type="text/javascript">
			var nav4 = window.Event ? true : false;
			function acceptNum(evt){	
				var key = nav4 ? evt.which : evt.keyCode;	
				return (key <= 13 || (key >= 48 && key <= 57));
			}
		</script>
<div id="buscad"><?php
include('jquery.php');
$msge="Ya existe";
$rooa = $_SERVER['DOCUMENT_ROOT'];
$posiciona = strripos($rooa, "/");
$rutaa= substr($rooa, 0, $posiciona)."/tmp/";
$leyenda = array($Codificadores,$Preferencias,$bthmtas,$Opciones,$Memorias); 
$validus = "";
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$validus = " AND idunidades='".$_COOKIE['unidades']."'";
}else{
	$validus = "";
}
$resprov = mysqli_query("select * from provincia ORDER BY nombre",$miConex) or die(mysql_error());

$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));

$reup = mysqli_query("select * from datos_generales",$miConex) or die(mysql_error());
$rreup = mysqli_fetch_array($reup);
$cod = $rreup['id_datos'];
$logo = $rreup['logo'];

$consulta ="SELECT * FROM preferencias";
$resultado = mysqli_query($consulta, $miConex) or die(mysql_error());
$cantconf=mysqli_num_rows($resultado);
////
	if (isset($_POST['modifica'])){
		$entidad = $_POST['entidad'];
		$sector = $_POST['sector'];
		$smtp = $_POST['smtp'];
		$web = $_POST['web'];
		$mailent = $_POST['mail'];
		$NombreAdmin = $_POST['NombreAdmin'];
		$LoginAdmin = $_POST['LoginAdmin'];
		$PassAdmin = $_POST['PassAdmin'];
		$sex = $_POST['sex'];
		$prov = $_POST['provincia'];
		$seen = mysqli_query("select * from datos_generales where id_datos='1'",$miConex) or die(mysql_error());
		$rowen = mysqli_fetch_array($seen);
		$reupn = $rowen['codigo'];
		$reup = $_POST['reup']; 
		$logo = "";
		if(($reupn) ==$reup){ echo "Ya existe ese Codogo REUP"; exit;}
		
		$upload_extensions = array(".png", ".jpg", ".gif", ".bmp", ".PNG", ".JPG", ".GIF", ".BMP");
		if(isset($_FILES['logo']['tmp_name'])){ 
			if(is_uploaded_file($_FILES['logo']['tmp_name'])) {
				$upload_ext = strrchr($_FILES['logo']['name'],".");
				if (in_array($upload_ext, $upload_extensions) AND ($upload_ext) !="") {		
					copy($_FILES['logo']['tmp_name'],$rutaa.$reup.$_FILES['logo']['name']);			
					rename($rutaa.$reup.$_FILES['logo']['name'],$rutaa."logo_".$reup.$upload_ext);				
					copy($rutaa."logo_".$reup.$upload_ext, $_SERVER['DOCUMENT_ROOT']."/".substr($pht1,1)."images/logo_".$reup.$upload_ext);				
					unlink($rutaa."logo_".$reup.$upload_ext);
					$logo = "logo_".$reup.$upload_ext;
				}else{	  
					?>
				<script type="text/javascript">
					alert("El fichero: <?php echo $_FILES['logo']['name'];?>, tiene una extesion no valida");
				</script> <?php
							} 
			}
		}
			$guarda = "insert into datos_generales (entidad,sector,smtp,codigo,web,mail,provincia,logo) values('".htmlentities($entidad)."', '".$sector."', '".$smtp."', '".$reup."', '".$web."', '".$mailent ."', '".htmlentities($prov)."', '".$logo."')";
			$result = mysqli_query ($guarda,$miConex) or die (mysql_error()); 
			$ultimoid = mysqli_insert_id($miConex);
			$sql="INSERT INTO `areas` (`idarea`, `nombre`, `teclado`, `switch`, `router`, `modem`, `computadoras`, `adaptadores`, `monitor`, `ploter`, `mouse`, `impresora`, `escanner`, `fotocopiadora`, `camara`, `memorias`, `ups`, `pinza`, `bocinas`, `idunidades`) VALUES (NULL,'Reparaciones', '0', '0', '0','0','0','0','0','0','0','0','0','0','0', '0','0','0','0','".$ultimoid."');";
			mysqli_query($sql,$miConex) or die(mysql_error());	
			$sql="INSERT INTO `areas` (`idarea`, `nombre`, `teclado`, `switch`, `router`, `modem`, `computadoras`, `adaptadores`, `monitor`, `ploter`, `mouse`, `impresora`, `escanner`, `fotocopiadora`, `camara`, `memorias`, `ups`, `pinza`, `bocinas`, `idunidades`) VALUES (NULL, 'Inform&aacute;tica', '0', '0', '0','0','0','0','0','0','0','0','0','0','0', '0','0','0','0','".$ultimoid."')";
			mysqli_query($sql,$miConex) or die (mysql_error());
			$ultimoidA = mysqli_insert_id($miConex);
			$sql1="INSERT INTO `usuarios` (`id`,`id_area`,  `nombre`, `login`, `passwd`, `email`, `cargo`, `tipo`, `idarea`, `sexo`, `idunidades`) VALUES (null,'".$ultimoidA."','".htmlentities($NombreAdmin)."', '".$LoginAdmin."', '".base64_encode($PassAdmin)."', '".$mailent."', '".'Inform&aacute;tico'."', 'usuario', '".'Inform&aacute;tica'."','".$sex."','".$ultimoid."')";
			mysqli_query($sql1,$miConex) or die (mysql_error());			?>
			  <script type="text/javascript">document.location="configura.php?p=d";</script>
			<?php   
	}
?>
	<script type="text/javascript">
		 function alertacon(err,men,tipo,num)  { 
			var counx=0;
			document.getElementById('cir').innerHTML="";
			for (i=0;i<num;i++)   {
			 if ((document.getElementById("marcado["+i+"]").type=="checkbox")&&(document.getElementById("marcado["+i+"]").checked==true))	 {
					counx = counx +1;
				}
			} 

			if((counx) >0){
				if((tipo) =="d"){
						document.location="#openModal";
				}else{
					document.frm1.submit();
				}		
			}else{
				showAlert(5000,'<div class="alert negro" style="display: none"><button class="closex" type="button" onclick="cierr();">X</button><div align="center"><font color="#FFDCA8" size="3"><b>'+err+'</b></font></div><div><b>'+men+'.</b></div></div>');
				return false;
			}	
		}
		
	</script>
<fieldset class='fieldset'>
		<legend class="vistauserx"><?php echo $n_entidad."--> ".$btdatabase.":&nbsp;<font color=red>".$database_miConex."</font>";?></legend>
		<table width="100%" border="0" align="center">
		  <form id="frm_entidad" name="frm_entidad" method="post" action="" enctype="multipart/form-data" >
		  <tr>
			<td>&nbsp;</td>
			<td><b><?php echo $btdatosentidad;?></b></td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="116" height="26" align="right"><?php echo $btNombre;?>:</td>
			<td width="440">
			  <input name="entidad" type="text" id="entidad" class="imput" placeholder="<?php echo $btdatosentidad5;?>" size="50"/>      </td>
			<td width="230" rowspan="3">&nbsp;</td>
		  </tr>
		  <tr>
			<td height="26" align="right">Sector:</td>
			<td><input name="sector" type="text" class="imput" id="sector" placeholder="<?php echo $perteneciente1;?>" size="20"/></td>
			</tr>
		  <tr>
			<td height="24" align="right">REUP:</td>
			<td><input name="reup" type="text" class="imput" id="reup" placeholder="<?php echo $btCodigo1;?>" size="20" onblur="reupx(this.value);"/><span id="reux"></span></td>
			</tr>
		  <tr>
			<td height="26" align="right"><?php echo $nombreapel2;?></td>
			<td colspan="2"><input name="NombreAdmin" type="text" placeholder="<?php echo $name_admin;?>" id="NombreAdmin" class="imput" size="40"/></td>
		  </tr>
		  <tr>
			<td height="26" align="right"><?php echo $nick;?>:</td>
			<td colspan="2"><input name="LoginAdmin" placeholder="<?php echo $nick1;?>" type="text" id="LoginAdmin" class="imput" size="40" onblur="usuars(this.value);" /><span id="usux"></span></td>
		  </tr>
		  <tr>
			<td height="26" align="right"><?php echo $btpassw;?>:</td>
			<td colspan="2"><input name="PassAdmin" placeholder="<?php echo $btpassw2;?>" type="text" id="PassAdmin" class="imput" size="40"/></td>
		  </tr>
		  <tr>
			<td height="26" align="right"><?php echo $Sexo;?>:</td>
			<td colspan="2"><select name="sex" class="inputbox" id="sex"/>
				<option value="h"><?php echo $Hombre;?></option>
				<option value="m"><?php echo $Mujer;?></option>
				</select></td>
		  </tr>
		  <tr>
			<td height="26" align="right"><?php echo $electron;?>:</td>
			<td colspan="2"><input name="mail" type="email" id="mail" class="imput" size="40"/></td>
		  </tr>
		  <tr>
			<td height="26" align="right"><?php echo $SITIO;?>:</td>
			<td><input name="web" type="text" id="web" class="imput" size="40"/></td>
			<td><input name="logo" type="file" class="imput" id="logo"/></td>
		  </tr>
		  <tr>
			<td align="right"><?php echo $provincia;?>:</td>
			<td><select name="provincia" class="selectuno"><?php		
				while($rowa=mysqli_fetch_array($resprov)){ ?>
				<option value="<?php echo $rowa['nombre'];?>" <?php if(($rowa['nombre']) ==$vale['provincia']){ echo "selected"; }?>><?php echo $rowa['nombre'];?></option><?php
				} ?>
			</select></td>
			<td>&nbsp;</td>
		  </tr>  
		  <tr>
			<td align="right">SMTP:</td>
			<td><input name="smtp" type="text" class="imput" id="smtp" size="30"/></td>
			<td align="right">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="3">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input name="modifica" type="submit" class="btn" id="modifica" onMouseOVer="this.style.cursor='pointer';" value="<?php echo $btaceptar;?>" />				
			</td>
		  </tr></form>
		</table>
<br>
<div id="footer" class="degradado" align="center">
	<div class="container">
		<p class="credit"><?php include ("version.php");?></p>
	</div>
</div>
</fieldset>
<div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
		
		<script type="text/javascript" src="js/main.js"></script>
