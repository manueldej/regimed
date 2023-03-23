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
@session_start();
$e="n";
$s="n";

if (version_compare(PHP_VERSION, "5.3.0") < 0) {
   die("versi&oacute;n de PHP requerida >= 5.3.0");
}
define('DO_NOT_CHECK_HTTP_REFERER', 1);
define('REGIMED_ROOT', dirname(__FILE__));

if(isset($_SESSION['valid_user'])){ ?><script type="text/javascript">document.location="expedientes.php";</script><?php }
require_once("chequeo.php");
	
	if (!file_exists('connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="installation/index.php";</script><?php	
		 die();
	}
include ('connections/miConex.php');
$i="es";
?>
<script type="text/javascript">
	function _descon(){		
		<?php 				
		if(!isset($_COOKIE['username'])){
		 	mysqli_query($miConex, "TRUNCATE `conectado`") or die(mysql_error());
		?>
		document.location="index.php";
		<?php } ?>
	} 
</script> 
	
<?php
if(isset($_COOKIE['seulang'])){
	if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
}

if(($i) =="es"){include('esp.php');}else{include('eng.php');}
$pss = "";
$usuarioreg = "invitado";

//saber quien esta conectado			
$select = "SELECT * FROM conectado";
$query_select = mysqli_query($miConex, $select);

// saber el tipo de user que se conecto
$sqlroot = "SELECT * FROM usuarios WHERE login='".@$_SESSION['valid_user']."'";
$query_root = mysqli_query($miConex, $sqlroot);
$row_sqlroot = mysqli_fetch_array ($query_root);

$reup = mysqli_query($miConex, "select * from datos_generales") or die(mysql_error());
$rreup = mysqli_fetch_array($reup);
?>
<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
   <title>RegiMed -<?php echo $btversion;?>-</title>
    <link rel="shortcut icon" href="images/logo_10814142.png" />
  	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	
<script language="JavaScript">
function alerta(){
	showAlert(3000,'<div class="alert negro" style="display: none"><b>&iexcl;<?php echo $wellc;?>! </b> <br/> <?php echo $wellc1;?>.</div>');
	document.cookie="lgmi=1";
}

</script>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />   
<style type="text/css">
@import url("css/system-message.css");

*{padding: 0; margin: 0;}

/* ----- base default font size, type, and line height ----- */
html body{font: 12px;  Arial, Helvetica, sans-serif;color:#333333}


/* ----- add selectors here for font sizing ----- */
#JT_close_left, #JT_close_right{font-size: 1.1em;}
#JT_copy p, #JT_copy ul{font-size: 1.1em;}
p, label{font-size: 12px;}


p {line-height:1.4em;margin:10px 0;}
hr{margin:10px 0;color:#999999;}

ul{
	list-style: none;
}

ul li{
padding-top:3px;
}

#contentPad{
margin:20px;
}

.formInfo a, .formInfo a:active, formInfo a:visited{
	background-color: #FF0000;
	font-size: 1.0em;
	font-weight:bold;
	padding:1px 2px;
	margin-left:5px;
	color:#FFFFFF;
	text-decoration: none;
}

.formInfo a:hover{
	color:#660000;
	text-decoration: none;
}

#JT_arrow_left{
	background-image: url(images/arrow_left.gif);
	background-repeat: no-repeat;
	background-position: left top;
	position: absolute;
	z-index:101;
	left:-12px;
	height:23px;
	width:10px;
    top:-3px;
}

#JT_arrow_right{
	background-image: url(images/arrow_right.gif);
	background-repeat: no-repeat;
	background-position: left top;
	position: absolute;
	z-index:101;
	height:23px;
	width:10px;
    top:-3px;
}

#JT {
	position: absolute;
	z-index:100;
	border: 2px solid #CCCCCC;
	background-color: #fff;
}

#JT_copy{
	padding:10px 10px 10px 10px;
	color:#333333;
}

.JT_loader{
	background-image: url(../images/loader.gif);
	background-repeat: no-repeat;
	background-position: center center;
	width:100%;
	height:12px;
}

#JT_close_left{
	background-color: #CCCCCC;
	text-align: left;
	padding-left: 8px;
	padding-bottom: 5px;
	padding-top: 2px;
	font-weight:bold;
}

#JT_close_right{
	background-color: #CCCCCC;
	text-align: left;
	padding-left: 8px;
	padding-bottom: 5px;
	padding-top: 2px;
	font-weight:bold;
}

#JT_copy p{
margin:3px 0;
}

#JT_copy img{
	padding: 1px;
	border: 1px solid #CCCCCC;
}

.jTip{
cursor:help;
}

.alertx{
	left:150px;
	top:233px;
	padding:8px 10px 8px 10px;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
	width: 350px;
	height:50px;
	position:absolute;
	margin-bottom:20px;
	border:1px solid #fbeed5;
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	color: #fcf8e3;
	border-radius:10px 10px 10px 10px;
}


a.tooltip {
  position: relative;
  display: inline;
}
a.tooltip span {
  position: absolute;
  color:#FFFFFF;
  width:120px;
  border:1px solid #000000; 
  background: #000000;
  font-family: Arial;
  font-size: 12px;
  height:70x;
  text-align: center;
  text-shadow: 1px 1px 1px  #000000; 
  vertical-align:middle;
  visibility: hidden;
  border-radius:4px ;  
  box-shadow:2px 2px 2px  #000000; 
  z-index: 9999;
}
a.tooltip span:after {
  content: '';
  position: absolute;
  top: 102%;
  left: 50%;
  margin-left: -8px;
  width: 0; height: 0;
  border-top: 8px solid #000000; 
  border-right: 8px solid transparent;
  border-left: 8px solid transparent;
  opacity:0.8;
   z-index: 9999;

}
a:hover.tooltip span {
  visibility: visible;
  opacity: 1;
  bottom: 20px;
  left: 50%;
  margin-left: -59px;
  z-index: 999;

}
</style>
</head>
<body onload = "<?php if(!isset($_COOKIE['lgmi']) OR (@$_COOKIE['lgmi']) =='0'){ ?>alerta();<?php } ?>">
<div id="modal3" class="modalmask">
	<div class="modalbox rotate">
		<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
			text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
			background-color: #DA4F49;
			background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
			background-repeat: repeat-x;
			border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
			color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -13px; width: 548px; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
			<h2 class="pos"><?php echo $term;?></h2>
		</div>
		<p align="justify"><font size="2"><?php echo $textoam; ?></font></p>
	</div>
</div>
<div id="modal4" class="modalmask">
<div class="modalbox rotate" style="height: 189px;">
	<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
		text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
		background-color: #DA4F49;
		background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
		background-repeat: repeat-x;
		border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -13px; width: 548px; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
		<h2 class="pos"><?php echo $recuperacla;?></h2>
	</div>
<p><iframe src="recupeclave.php" name="b" scrolling="none" width="102%" height="200" frameborder="0" class="notice" border="0"></iframe></p>
</div>
</div>
<div class="PageBackgroundGlare"></div>
    <div class="Main">
<div class="Sheet">
<div class="Sheet-tl"></div>
    <div class="Sheet-tr"><div>
      </div></div>
    <div class="Sheet-bl"><div>
      </div></div>
    <div class="Sheet-br"><div>
      </div></div>
    <div class="Sheet-tc">
    <div></div></div>
    <div class="Sheet-bc">
    <div></div></div>
    <div class="Sheet-cl">
    <div></div></div>
    <div class="Sheet-cr">
    <div></div></div>
            <div class="Sheet-cc"></div>
    <div class="Sheet-body">
<div class="Header">
  <div <?php if (($i) =="es") {?>class="Headeresp-jpeg" <?php }else {?> class="Headereng-jpeg" <?php }?>></div>
                    <div class="logo"></div>
      </div>
	  <div>
<div align="center">
	<div >
<div>
<script language="JavaScript" >
function guarda(i){
	document.cookie="seulang="+i;
	document.cookie="lgmi=0";
	document.location='index.php';
}
function unidq(vas){
	var d = new Date();
	if((vas) !="-1"){
		if((vas) !="invitado"){
			document.cookie="manuni="+vas;
			document.location='index.php';
		}else{
     		document.cookie = "manuni=1;expires=" + d.toGMTString() + ";" + ";";
			document.location="index.php?v";
		}
	}else{
		document.cookie = "manuni=1;expires=" + d.toGMTString() + ";" + ";";
		document.location='index.php';	
	}
}
</script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script src="js/jtip.js" type="text/javascript"></script>
<?php if (isset($_GET['e']) AND ($_GET['e']) =="s") { ?>
	<div id="err" class="message inner red"><span><b><?php echo $strError; ?></b>: <?php echo $strnousuario ;?></span></div>			
<?php }
$sqluser = "SELECT * FROM usuarios INNER JOIN (preferencias) ON (preferencias.usuario = usuarios.login) WHERE preferencias.acceso='s'" ;
$query_user = mysqli_query($miConex, $sqluser) or die(mysql_error()); 
 ?>
     <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td width="22%">&nbsp;</td>
            <td valign="top">
				<table width="100%" height="291" border="0" align="center" cellpadding="1" cellspacing="1">
					<tr>
						<td height="24" colspan="2" align="center" valign="top"><b><?php echo $accesositio;?></b></td>
					</tr>
					<tr>
						<td height="97" colspan="2" align="center" valign="top" class="inputlabel"><div align="center"><img src="images/lock.png" alt="<?php echo $btSeguridad;?>" width="84" height="86" align="top" /></div></td>
					</tr>
						<form id="loginForm" method="post" name="formulario" action="control.php" onKeyUp="highlight(event)" onClick="highlight(event)">
								<tr>
									<td width="25" align="right"><div style="margin-top: -17px;"><b style="font-size: 12px;">&nbsp;&nbsp;&nbsp;<?php echo $btusuario1;?>:&nbsp;</b></div></td>
									<td width="125" height="24" valign="middle">
										<script type="text/javascript">
											function mandacookie(v){
												if((v) =="invitado"){
													document.getElementById('contrasenas').style.display='none';
												}else{
													document.getElementById('contrasenas').style.display='block';
												}
											}
										</script>								
										<span id="usuarioX" style="display:none;">
											<select name="usuario" class="login-register-input user" style="width: 160px;" onChange="mandacookie(this.value);">
												<option onClick="document.getElementById('usuarioX').style.display='none';document.getElementById('usuario').style.display='block';document.getElementById('contrasenas').style.display='none';" value="invitado"><?php echo $Invitado;?></option><?php
												while($row_sqluserc = mysqli_fetch_array ($query_user)){?>
													<option onClick="document.getElementById('usuarioX').style.display='block';document.getElementById('usuario').style.display='none';" value="<?php echo $row_sqluserc['login'];?>"> <?php echo $row_sqluserc['login'];?></option><?php
												}?>
											</select><span class="formInfo"><a href="ajax2.php?width=300" class="jTip" id="one" name="<?php echo $Ucumpleregla;?>:">?</a></span>
										</span>
										<span id="usuario">
											<select name="usuarioz" class="login-register-input user" style="width: 147px;" onChange="document.getElementById('usuarioX').style.display='block';mandacookie(this.value);document.getElementById('usuario').style.display='none'; ">
												<option value="invitado" onClick="document.getElementById('contrasenas').style.display='none';"><?php echo $Invitado;?></option>
												<option onClick=" document.getElementById('usuarioX').style.display='block'; document.getElementById('usuario').style.display='none'; " value="invitado"><?php echo $new6;?></option>
											</select><span class="formInfo"><a href="ajax2.php?width=300" class="jTip" id="tre" name="<?php echo $Ucumpleregla;?>:">?</a></span>
										</span>	
									</td>
								</tr> 
								<tr valign="bottom">
									<td valign="middle" colspan="2">
										<div id="contrasenas" style="display:none;">
										<b style="font-size: 12px;">&nbsp;&nbsp;&nbsp;<?php echo $btpassw;?>:</b>
										<input id="contrasena" class="login-register-input password"  placeholder="<?php echo $btpassw; ?>" size="15" style="width: 160px;" type="password" name="contrasena"/><span class="formInfo"><a href="ajax.php?width=450" class="jTip" id="two" name="<?php echo $Pcumpleregla;?>:">?</a></span>
										</div>
									</td>
								</tr>
								<tr valign="middle">
									<td height="38" colspan="2" align="center"><input type="hidden" value="<?php echo $i;?>" name="lang"><input class="btn" value="<?php echo strtoupper($btaceptar);?>" type="submit" name="submit"/></td>
								</tr>
							<tr>
								<td colspan="2" align="center"><a href="#modal4" target="_self"><font size="2"><?php echo $olvidapassw;?></font></a></td>
							</tr>
						</form>	
				</table>
			</td>
            <td width="13%" valign="top"><a href="#" class="tooltip"><img <?php if(($i) =="es"){ echo 'style="opacity: .5;"';} ?> src="images/es.png" width="20" height="14" border="0" align="absmiddle" onMouseOver="this.style.cursor='pointer';" onClick="guarda('es');" /><span onMouseOver="this.style.cursor='pointer';"><?php echo $btidiomes;?></span></a>&nbsp;&nbsp;<a href="#" class="tooltip"><img <?php if(($i) =="en"){ echo 'style="opacity: .5;"';} ?> src="images/en.png" width="20" height="14" border="0" align="absmiddle" onMouseOver="this.style.cursor='pointer';" onClick="guarda('en');" /><span onMouseOver="this.style.cursor='pointer';"><?php echo $btidiomen;?></span></a></td>
        </tr>
    </table>
</div>
<br></div>
</div>
</div>
<br>
<div id="footer" style="background-color: rgb(215, 205, 166); border-radius: 0px 0px 5px 5px; top: 3px; position:relative" align="center">
	<div class="container">
		<p class="credit"><?php include ("version1.php");?></p>
	</div>
</div>
    </div>
      </div>
    </div> 
</body>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</html>