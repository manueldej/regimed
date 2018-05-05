<?php 
############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.0.1                                                     				                        #
# Fecha:    01/06/2016 - 03/04/2018                                             					                        #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada											         		            #
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
define('ruta_ficheros', dirname(__FILE__));
if (!defined("ruta_images")) {
   define("ruta_images", ruta_ficheros."/images/"); 
   define("ruta_medias", ruta_ficheros."/images/");
   # si no está definido en (MiComex.php)
}
echo "<!DOCTYPE html>"; 
echo "<html lang='es'>";
echo '<meta http-equiv="Content-Script-Type" content="text/javascript"/>'."\n";
$versphpvieja = str_ireplace('.','',phpversion());
$versphpnueva = 540;
if($versphpvieja < $versphpnueva ){?>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php 
}else{ ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php 
}?>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="css/bootstrap-responsive.css" rel="stylesheet">
<?php
		@session_start();
		include('chequeo.php');
class colores {
	public function ColorFila($i,$color1,$color2){
		if (($i % 2)== 0) {
			$this->ColorFondo = $color1;
		}else {
			$this->ColorFondo = $color2;
		}
		return $this->ColorFondo;
	}
}
$color1="#F1F2F3";
$color2="#E9EAEB";
$uCPanel = new colores();
		if (!check_auth_user()){
			?><script type="text/javascript">window.parent.location="index.php";</script><?php
			exit;
		}
	if (!file_exists('connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="installation/index.php";</script><?php
		return;
	}else{
	 require_once('connections/miConex.php');
	} 
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}

	if ($i=="es") {
	  include('esp.php');
	}else{
	  include('eng.php');
	}
	//$_SESSION["regimeddate_format"]=1;
	//echo convDate(date('Y:m:d'));
	
	$consulta_unidades ="SELECT * FROM datos_generales";
	$reado = mysqli_query($miConex, $consulta_unidades) or die(mysql_error());
	$total_filas = mysqli_num_rows($reado);
	
?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="shortcut icon" href="images/logo_10814142.png" />
    <title>RegiMed -<?php echo $btversion;?>-</title>
	<link href="css/template.css" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="ajax.js"></script> 
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/animatedcollapse.js"></script>
	<script type="text/javascript">
	animatedcollapse.addDiv('cat', 'fade=0,speed=400,group=pets')
	animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
		//$: Access to jQuery
		//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
		//state: "block" or "none", depending on state
	}
	animatedcollapse.init()

  	function cambiaunidad(va,url){
		if((va) !="-1"){
			document.cookie="unidades="+va;
			document.formU.submit();
		}else{
			var d = new Date();
			document.cookie = "unidades=1;expires=" + d.toGMTString() + ";" + ";";
			document.location=url;
		}
	}
  
    function handleEnter (field, event) { 
		var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode; 
		if (keyCode == 13) { 
			var i; 
			for (i = 0; i < field.form.elements.length; i++) 
				if (field == field.form.elements[i]) break; 
				i = (i + 1) % field.form.elements.length; 
				field.form.elements[i].focus(); 
			return false; 
		} else 
			return true; 
    } 

function guarda(i){
	document.cookie="seulang="+i;
	document.idioma.i.value =i;
	document.idioma.submit();
}  
function cambiaclass(who){
	document.getElementById('hom').className='opt';
	document.getElementById('medi').className='opt';
	document.getElementById('base').className='opt';
	document.getElementById('visi').className='opt';
	if (who=="admin") {
	  document.getElementById(who).className='opt active dropdown-toggle';
	  document.getElementById('ayuda').className='opt dropdown';
	  document.getElementById('user').className='opt dropdown';
	}else if (who=="ayuda"){
	  document.getElementById(who).className='opt active dropdown';
	  document.getElementById('admin').className='opt dropdown-toggle';
	  document.getElementById('user').className='opt dropdown';
	}else if (who=="user"){
	  document.getElementById(who).className='opt active dropdown';
	  document.getElementById('admin').className='opt dropdown-toggle';
	  document.getElementById('ayuda').className='opt dropdown';
	}
}
</script>  
<script src="js/jquery.min.js" type="text/javascript"></script>
    <style type="text/css">
        #demo input
        {
            width: 330px;
            height: 10px;
            margin-top: 80px;
            border: solid 1px #c9c9c9;
            padding: 10px;
            padding-top: 6px;
            font-family: Arial;
            font-size: 11px;
            font-weight: bold;
        }
		
		#hora {
		position: absolute;
		top: 2px;
		width: 200px;
		font-size: 11px;
		font-weight: bold;
		line-height: 32px;
		text-align: justify;
		color: #F9E6E6;
		}
		
		.gnu-linux {
			position: relative;
			margin-top: -37px;
			box-shadow: 1px #000;
			border-radius: 4px;
            			
		}
<!--
.Estilo2 {color: #000000}
.Estilo4 {color: #000000; font-weight: bold; }
a:link {
	color: #000000;
}
a:visited {
	color: #000000;
}
a:hover {
	color: #788DA7;
}
-->
</style>
<?php
 if ($_SESSION['valid_user']!="invitado") { 
	   $sql_pref="SELECT * FROM preferencias WHERE usuario='".$_SESSION['valid_user']."'";
	   $rsul = mysqli_query($miConex, $sql_pref) or die (mysql_error());
	   $rowsp = mysqli_fetch_array($rsul);
	   
	   $query = "SELECT * FROM usuarios WHERE login='".$_SESSION['valid_user']."'";
       $result = mysqli_query($miConex, $query) or die(mysql_error());
	   $rws = mysqli_fetch_array($result);

    }else{
	   $sql_pref="SELECT * FROM preferencias WHERE usuario='webmaster'";
	   $rsul = mysqli_query($miConex, $sql_pref) or die (mysql_error());
	   $rowsp = mysqli_fetch_array($rsul);
    } 

$cant_notif =0;
$sql_uactivaa = "select * from datos_generales";
$result_uactivaa= mysqli_query($miConex, $sql_uactivaa) or die(mysql_error());
$ractivaa = mysqli_num_rows($result_uactivaa);

$sql_notificamtto = "select * from mtto where estado='Pendiente'";
$result_notificamtto= mysqli_query($miConex, $sql_notificamtto) or die(mysql_error());
$notificamtto = mysqli_num_rows($result_notificamtto);

$sql_notificabajas = "select * from bajas_aft where titulo='sin Dictamen'";
$result_notificabajas= mysqli_query($miConex, $sql_notificabajas) or die(mysql_error());
$notificabajas = mysqli_num_rows($result_notificabajas);

$sql_notificares = "select * from resoluciones where link=''";
$result_notificares= mysqli_query($miConex, $sql_notificares) or die(mysql_error());
$notificares = mysqli_num_rows($result_notificares);

$cant_notif=$notificamtto+$notificabajas+$notificares ;

$query_Recordset1 = "SELECT * FROM tipos_medios";
$Recordset1 = mysqli_query($miConex, $query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
if(isset($_SESSION["autentificado"])){
	$dage="select * from datos_generales where id_datos='".$_SESSION["autentificado"]."'";
}elseif (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$dage="select * from datos_generales where id_datos='".$_COOKIE['unidades']."'";
}else{
	$dage="select * from datos_generales";
}
$qdage=mysqli_query($miConex, $dage) or die(mysql_error());
$rdage=mysqli_fetch_array($qdage);
$us = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rus = mysqli_fetch_array($us);
$nrus=mysqli_num_rows($us);

$usx = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$russx = mysqli_fetch_array($usx);
$nrusx=mysqli_num_rows($usx);

$vis = mysqli_query($miConex, "SELECT COUNT(user) as total FROM visitas WHERE user ='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$resu = mysqli_fetch_assoc($vis);

$us1 = mysqli_query($miConex, "select * from preferencias where usuario='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rus1 = mysqli_fetch_array($us1);

$query_Recordset2 = "SELECT * FROM tipos_medios ORDER BY id";
$Recordset2 = mysqli_query($miConex, $query_Recordset2) or die(mysql_error());
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$option_block ="";
$usuario ="";
$recuerda="";
$user = $_SERVER['HTTP_USER_AGENT'];
$ff=explode("/", $user);
if(strpos($user, "Mozilla")) { $browser = "Mozilla"; $img = "mozilla.png"; }
if(strpos($user, "Firebird")) { $browser = "Mozilla Firebird"; $img = "mozilla.png"; }
if(strpos($user, "Firefox")) { $browser = "Mozilla Firefox"; $img = "mozilla.png"; }
if(strpos($user, "Netscape")) { $browser = "Netscape"; $img = "ns.gif"; }
if(strpos($user, "Netscape6/")) { $browser = "Netscape 6"; $img = "ns.gif"; }
if(strpos($user, "Netscape/7.1")) { $browser = "Netscape 7.1"; $img = "ns.gif"; }
if(strpos($user, "Mozilla/4")) { $browser = "Netscape 4.0"; $img = "ns.gif";}
if(strpos($user, "MSIE"))  { $browser = "Microsoft Internet Explorer"; $img = "ie.gif"; }
if(strpos($user, "MSIE 6.0")) { $browser = "Microsoft Internet Explorer 6"; $img = "ie.gif";}
if(strpos($user, "MSIE 7.0")) { $browser = "Microsoft Internet Explorer 7"; $img = "ie.gif";}
if(($ff[0]) =="Opera") { $browser = "Opera"; $img = "opera.png"; }

// Volgende strings zijn niet getest:
if(strpos($user, "MSIE 5.0")) { $browser = "Microsoft Internet Explorer 5"; $img = "ie.gif";}
if(strpos($user, "MSIE 5.5")) { $browser = "Microsoft Internet Explorer 5.5"; $img = "ie.gif";}
if(strpos($user, "MSIE 4.0")) { $browser = "Microsoft Internet Explorer 4.0"; $img = "ie4.gif";}
if(strpos($user, "Konqueror")) { $browser = "Konqueror"; $img = "konqueror.gif";}
if(strpos($user, "SAGEM")) { $browser = "Sagem WAP"; $img = "gsm.gif";}

if(strpos($user, "Nautilus")) { $browser = "Nautilus"; $img = "nautilus.gif";}
if(strpos($user, "Lynx")) { $browser = "Lynx"; $img = "lynx.gif";}
if(strpos($user, "Galeon")) { $browser = "Galeon"; $img = "galeon.gif";}
if(strpos($user, "Safari")) { $browser = "Safari"; $img = "safari.gif";}
if(strpos($user, "Chrome")) { $browser = "Chrome"; $img = "crome.gif";}
if(strpos($user, "Iceweasel")) { $browser = "Iceweasel"; $img = "ice.gif";}
if(strpos($user, "Kameleon")) { $browser = "Kameleon"; $img = "kameleon.gif";}
if(strpos($user, "QupZilla")) { $browser = "QupZilla"; $img = "qupzilla.png"; }
if(strpos($user, "icecat")) { $browser = "IceCat"; $img = "icecat.png"; }
if(strpos($user, "Epiphany")) { $browser = "Epiphany"; $img = "epiphany.png"; }


$os = "Onbekend"; $img2="unknow.gif";

if(strpos($user, "Linux"))  { $os = "Linux"; $img2="linux.png";}
if(strpos($user, "Unix"))  { $os = "Unix"; $img2="unix.gif";}
if(strpos($user, "Mac"))  { $os = "MacOS"; $img2="mac.gif";}
if(strpos($user, "FreeBSD"))  { $os = "FreeBSD"; $img2="freebsd.gif";}
if(strpos($user, "BEOS"))  { $os = "BeOS"; $img2="beos.gif";}

if(strpos($user, "Windows")) { 
	$os = "Windows"; $img2="windows.png";
	if(strpos($user, "95")) { $os = "Windows 95"; $img2="windows.png";}
	if(strpos($user, "98")) { $os = "Windows 98"; $img2="windows.png";}
	if(strpos($user, "SE")) { $os = "Windows 98SE"; $img2="windows.png";}
}

if(strpos($user, "Windows NT 5.0"))  { $os = "Windows 2000"; $img2="windows.png";}
if(strpos($user, "Windows NT 5.1"))  { $os = "Windows XP"; $img2="windows.png";}
if(strpos($user, "Windows XP"))  { $os = "Windows XP"; $img2="windows.png";}
if(strpos($user, "Windows NT 5.2"))  { $os = "Windows Server 2003"; $img2="windows.png";}

// Waarschijnlijke useragents:
if(strpos($user, "Windows NT 5.3"))  { $os = "Windows Longhorn"; $img2="longhorn.gif";}
if(strpos($user, "Windows NT 5.4"))  { $os = "Windows Blackcomb"; $img2="blackcomb.gif";} 

	$unidadactiva = ""; 
	if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$ureactiva = "SELECT * FROM datos_generales WHERE id_datos='".$_COOKIE['unidades']."'";
		$qselactiva = mysqli_query($miConex, $ureactiva) or die(mysql_error());
		$rselactiva = mysqli_fetch_array($qselactiva);	
		$unidadactiva = $rselactiva['entidad'];
	}else{
		$unidadactiva = ""; 
	}

$lin = substr(strrchr ($_SERVER['PHP_SELF'],"/"),1);
$arreglopg=array("expedientes.php","registromedios1.php","res.php","visitas.php"); ?>
<script type="text/javascript">
    <?php if(($rus["tipo"]) =="root"){ ?>
	var categoriaApp = [ '<?php echo $btAreas;?>','<?php echo $btcontrol;?>','<?php echo $btcategmedios;?>','<?php echo $btgensello;?>'];
	<?php }else{ ?>
	var categoriaApp = [ '<?php echo $btAreas;?>','<?php echo $btcontrol;?>','<?php echo $btcategmedios;?>' ];
	<?php } ?>
	var categoriaProd = [ '<?php echo $bttrasp;?>','<?php echo $btinsp;?>','<?php echo $btsalvas;?>','<?php echo $btrestaurar." ".$btdatabase;?>','<?php echo $btpmtto;?>', '<?php echo $btCustodios;?>-AFT','<?php echo $btImportar;?>','<?php echo $btExportar;?>', '<?php echo $Memorias;?>','<?php echo $btbajas;?>','<?php echo $repara;?>','<?php echo $pass4;?>','<?php echo $pass5;?>'];
	var categoriaReg = [ '<?php echo $btpmtto;?>','<?php echo $btprep;?>','<?php echo $bttrasp;?>','<?php echo $btbtecnicas;?>','<?php echo $btinsp;?>','<?php echo $btListado1;?>' ,'<?php echo $bteditaunid0;?>' ];

	function showEtiquetas(){
		app ="";
		prod ="";
		reg ="";

		reg+='<li><a href="plan_mtto.php"><img src="gfx/icons/small/calendar.png">&nbsp;'+categoriaReg[0]+'</a></li>';
		reg+='<li><a href="rep.php"><img src="gfx/icons/small/calendar.png">&nbsp;'+categoriaReg[1]+'</a></li>';
		reg+='<li><a href="r_traspasos.php"><img src="gfx/icons/small/export.png">&nbsp;'+categoriaReg[2]+'</a></li>';
		reg+='<li><a href="destinobajas.php"><img src="gfx/icons/small/document.png">&nbsp;'+categoriaReg[3]+'</a></li>';
		
		reg+='<li><a href="insp.php"><img src="gfx/icons/small/document.png">&nbsp;'+categoriaReg[4]+'</a></li>';
		reg+='<li><a href="defectuosos.php"><img src="gfx/icons/small/trash.png">&nbsp;'+categoriaReg[5]+'</a></li>';
		reg+='<li><a href="incidencias.php"><img src="gfx/icons/small/support.png">&nbsp;'+categoriaReg[6]+'</a></li>';
		
		app+='<li><a href="registroareas.php"><img src="gfx/icons/small/dashboard.png">&nbsp;'+categoriaApp[0]+'</a></li>';
		app+='<li><a href="ej1.php"><img src="gfx/icons/small/users.png">&nbsp;'+categoriaApp[1]+'</a></li>';
		<?php if(($russx["tipo"]) =="root"){ ?>
		app+='<li><a href="categ_medios.php"><img src="gfx/icons/small/sitemap.png">&nbsp;'+categoriaApp[2]+'</a></li>';
		app+='<li><a href="sellos.php"><img src="gfx/icons/small/check.png">&nbsp;'+categoriaApp[3]+'</a></li>';
		<?php }else{ ?>
		app+='';
		<?php } ?>
		prod+='<li><a href="traspasos.php"><img src="gfx/icons/small/export.png">&nbsp;'+categoriaProd[0]+'</a></li>';
		prod+='<li><a href="form-insertarinsp.php"><img src="gfx/icons/small/file-edit.png">&nbsp;'+categoriaProd[1]+'</a></li>';
		prod+='<li><a href="salva.php"><img src="gfx/icons/small/database.png">&nbsp;'+categoriaProd[2]+'</a></li>';
		prod+='<li><a href="restaura.php?carpeta=salvas"><img src="gfx/icons/small/archive.png">&nbsp;'+categoriaProd[3]+'</a></li>';
		prod+='<li><a href="plan_mtto.php?con=m"><img src="gfx/icons/small/calendar.png">&nbsp;'+categoriaProd[4]+'</a></li>';
		prod+='<li><a href="registrocustodio.php"><img src="gfx/icons/small/users-aft.png">&nbsp;'+categoriaProd[5]+'</a></li>';
		prod+='<li><a href="importa.php"><img src="gfx/icons/small/database-importar.png">&nbsp;'+categoriaProd[6]+'</a></li>';
		prod+='<li><a href="exportador.php"><img src="gfx/icons/small/export.png">&nbsp;'+categoriaProd[7]+'</a></li>';
		prod+='<li><a href="registrousb.php"><img src="gfx/icons/small/register.png">&nbsp;'+categoriaProd[8]+'</a></li>';
		prod+='<li><a href="bajas.php"><img src="gfx/icons/small/file-remove.png">&nbsp;'+categoriaProd[9]+'</a></li>';
		
		prod+='<li><a href="optimizar.php"><img src="gfx/icons/small/database.png">&nbsp;'+categoriaProd[10]+'</a></li>';
		prod+='<li><a href="reg_claves_sistema.php"><img src="gfx/icons/small/user.png">&nbsp;'+categoriaProd[11]+'</a></li>';
		prod+='<li><a href="reg_claves_soft.php"><img src="gfx/icons/small/door.png">&nbsp;'+categoriaProd[12]+'</a></li>';
		$('.subProd').html(prod);
		$('.subApp').html(app);
		$('.subReg').html(reg);
	}	
	function borra(){
		document.getElementById('textox').value ="";
	}

function notifica(num){
	document.location='plan_mtto.php?noti='+num;
}
function notibaja(num){
	document.location='bajas.php?noti='+num;
}
function notires(num){
	document.location='res.php?noti='+num;
}

    function editaperfil(que){
	    if (que =="perfil") { 
		  document.ediper.editar.value="editar";
		  document.ediper.opera.value="opera";
		  document.ediper.submit();
		}else if (que =="preferencias"){
		  document.edipref.p.value="p";
		  document.edipref.t.value="t";
		  document.edipref.submit();
		}
		
	}
    function mueve(id,nro,cantidad,modo){
		 var num =0;
		 if (modo =='descendente') {
		   var num = parseInt(nro) + 1;
		 }else if (modo =='ascendente') {
		  var num = parseInt(nro) - 1;
		 }  

		if (num <= cantidad && num >0 ) {
		   document.getElementById(id).value =num;
		}else if (num > cantidad && num >0 ) {
		   document.getElementById(id).value =num-1;
		}	 		
	}
</script>
<script language="JavaScript">
		function pende(){
			showAlert(9000,'<div style="display: none; opacity: 1; margin-left:265px; left:265px; width: 180px; top:25px; font-size: 10px;"><h1>&iexcl;<?php echo $tareas; ?>! </h1> <br/> <?php if ($notificamtto !=0){  echo '<a href="#" onclick="notifica('.$notificamtto.');" >'.$btpmtto.'</a> - <span style="border-radius: 50px; background-color: #E00000; text-shadow: #999999c; color: #FFFFFF; text-align: center; width: 20px; height: 17px;"> '.$notificamtto.'</span>';  } ?><br><?php if ($notificabajas !=0){ echo '<a href="#" onclick="notibaja('.$notificabajas.');" >'.$bajassd.'</a> - <span style="border-radius: 50px; background-color: #E00000; text-shadow: #999999c; color: #FFFFFF; text-align: center; width: 20px; height: 17px;">  '.$notificabajas; } ?><a href="#close" original-title="Cerrar" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a></div>');
			document.cookie="lgmi=1";
		}
</script>
<script language="javascript">
//http://javascript.tunait.com/
//tunait@yahoo.com
function hora(){
	var dia = new Date();
	var hora = dia.getHours();
	var mi = dia.getMinutes();
	var sec = dia.getSeconds();
	var as = "AM";
	if(hora > 12){
		hora = hora-12;	
		as = "PM";
	}
	if(hora < 10){
		hora="0" + hora;		
	}
	if(mi < 10){
		mi="0" + mi;		
	}
	if(sec < 10){
		sec = "0" + sec;	
	}
	var place = document.getElementById("hora");
	place.innerHTML = hora + ":" + mi + ":" + sec + " " + as;
}
	function inicio(){
		document.write('<span id="hora" class="hora">')
		document.write ('000000</span>')
		hora();
		setInterval("hora()",1000);
	}
	
</script>
<script type="text/javascript" src="js/script.js"></script>
<div id="modal20" class="modalmask">
    <div class="modalbox rotate">
	<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
			text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
			background-color: #DA4F49;
			background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
			background-repeat: repeat-x;
			border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
			color: #ffe3e3; padding: 0px 0px 9px 4px; width: 106%; margin-top:-4px; margin-left:-18px; border-radius: 5px; vertical-align:middle;"><a href="#close "  onclick="nomuestra(muestranoti.muestra.value);"  original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3; top:-1px;">X</a>
		<h2 class="pos"><?php echo strtoupper($tareas); ?></h2>
	</div>
		<table width="100%" border="0" class="table" cellpadding="0" cellspacing="0">
			<tr>
				<td width="888">
				  <?php  if ($notificamtto !=0){ ?><a href="#" onClick="notifica('.$notificamtto.');" ><?php echo $btpmtto; ?></a>
				</td>
				<td width="77">
				 <?php echo  $notificamtto;  } ?>
				</td>
			</tr>
			<tr>
				<td>
				  <?php if ($notificabajas !=0){ ?><a href="#" onClick="notibaja('<?php echo $notificabajas; ?>');" ><?php echo $bajassd; ?></a>
				</td>
				<td>
				  <?php echo $notificabajas; } ?>
				</td>
			</tr>
			<tr>
				<td>
				  <div align="left"><?php if ($notificares !=0){ ?> <a href="#" onClick="notires('<?php echo $notificares; ?>');" ><?php echo $ressin; ?></a>
				</td>
				<td>
				 <?php echo $notificares; } ?>
				</td>
			</tr>
			<tr>
				<td><h2><b>TOTAL</b></h2></td>
				<td><h2><b><?php echo $cant_notif; ?></b></h2></td>
			</tr>
		</table>
    </div>
</div>	
<body onclick="$('#divMenu').css('display','none'); "><div class="fondo">
<form method="post" name="ediper" id="ediper" action="v1.php">
	<input name="editar" type="hidden" id="editar">
	<input name="opera" type="hidden" id="opera">
</form>
<form method="get" name="edipref" id="edipref" action="configura.php">
	<input name="p" type="hidden" id="p">
	<input name="t" type="hidden" id="t">
</form>
<table width="100%" border="0">
		<tr>
    		<td align="center" valign="top"><div align="center">
      			<table width="977" border="0" align="center">
					<tr>
						<td width="112" valign="top">&nbsp;</td>
						<td width="655" valign="middle">
						 <img <?php if(($i) =="es") { ?>src="images/headeresp.png" <?php }else { ?>src="images/headereng.png" <?php }?>/>
						</td>
					    <td width="226" valign="middle"><?php
 						if ($_SESSION ["valid_user"]) {
					   	  if ($resu['total']==1){
							     $visitas="visita";
							 }else $visitas="visitas";

						  if ($rus['sexo']=="h"){
	                         $imge ="images/admin.png";
						  }elseif ($rus['sexo']=="m"){
                            $imge ="images/female.png";
						  }else{
							$imge ="images/invitado.gif";
						  }
						  if(($rus['tipo']) =="root"){						 
						  	$imge ="images/male.png";
						  }  ?>
						  
<div id="procesa2" class="procesa2" style="margin-left: 39px;">
<?php if ($rus['tipo']=="root" ){ 
 if (($nrus) !=0 and $cant_notif !=0) { ?>
 <div class="notif" style="margin-left: 4px;"><a href="#modal20" class="tooltip"><i style="background: url(images/glyphicons-halflings-white.png) scroll -1478px -316px transparent; height: 16px; width: 20px; float: left; margin-top: 2px; position: relative; margin-left: -2px; left: 13px; z-index:9999;"></i><b style="color:#FFFFFF;"><?php echo $cant_notif; ?></b><span><?php echo $daleclik; ?></span></a></div>
 <?php }else { ?><span manolo="<?php echo $nohay; ?>"><div class="notif"><i style="background: url(images/glyphicons-halflings-white.png) scroll -1478px -316px transparent; height: 16px; width: 20px; float: left; margin-top: 2px; position: relative; margin-left: -2px; left: 13px; z-index:9999;"></i></div></span> <?php } }else{?>
 <span manolo="<?php echo $nohay; ?>"><div class="notif"><i style="background: url(images/glyphicons-halflings-white.png) scroll -1478px -316px transparent; height: 16px; width: 20px; float: left; margin-top: 2px; position: relative; margin-left: -2px; left: 13px; z-index:9999;"></i></div></span>
 <?php } ?>
<div style="padding:4px; width:87px; margin-left: 55px;">
	<a href="#" onclick="document.getElementById('idm').style.display='block';" tabindex="-1" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php if ($i=="es" ) { ?>images/es.png <?php }else{ ?>images/en.png <?php } ?>" align="absmiddle" style="cursor:pointer; text-decoration:none; margin-top: -10px;" width="20" height="16"></a>
	 <a href="#" class="tooltip"><img width="20"height="16" src="images/<?php echo $img2; ?>"><span><?php echo $os; ?></span></a><a href='#' class='tooltip'><img width='20' height='16' src='images/<?php echo $img; ?>'><span onMouseOver="this.style.cursor='pointer';"><?php echo $browser; ?></span></a><a class="tooltip" href="javascript:animatedcollapse.toggle('cat')" style="cursor:pointer;"><img src="images/registro.png" height="16" width="20" ><span>Datos del Servidor</span></a> 
<?php } ?>
<div id="idm" style="margin-top: -6px; margin-left: -12px; display: none; width: 28px; position: absolute; z-index: 90000; list-style: outside none none;">
	<ul class="dropdown-submenu" style="list-style: outside none">
		<li class="dropdown-submenu" style="width: 36px; margin-top: -21px; margin-left: -9px;">
			<span>&nbsp;<img id="<?php echo $i; ?>" width="20"height="16" class="<?php echo $i; ?>" style="opacity: .5;" title="<?php if($i=="en") { echo $btidiomen; }else{ echo $btidiomes; } ?>" src="images/<?php echo $i; ?>.png" width="20" height="14" border="0" align="absmiddle">&nbsp;</span>
		</li>
		<li class="dropdown-submenu" style="width: 36px; margin-top: -21px; margin-left: -19px;">
			<span manolo="<?php if($i=="es"){ echo $btidiomen; }else{ echo $btidiomes; } ?>">&nbsp;<img id="<?php if($i=="es"){ echo "en"; }else {echo "es";} ?>" width="20"height="16" class="<?php if ($i=="es") { echo "en"; }else {echo "es";} ?>" onClick="guarda('<?php if ($i=="es") { echo "en"; }else {echo "es";} ?>');" style="cursor: pointer;" src="images/<?php if ($i=="es") { echo "en"; }else {echo "es";} ?>.png" width="20" height="14" border="0" align="absmiddle">&nbsp;</span>
		</li>
	</ul>
</div>
</div>		
</div>

<div class="gnu-linux" id="gnu-linux">
<table width="200" border="0" cellpadding="4" cellspacing="4" align="center">
  <tr>
    <td><span manolo="ArchiLinux" style="cursor:pointer;"><img src="images/archlinux.png" width="24" height="24"></span></td>
    <td><span manolo="Debian" style="cursor:pointer;"><img src="images/debian.png" width="24" height="24"></span></td>
    <td><span manolo="Linux Mint" style="cursor:pointer;"><img src="images/linux-mint.png" width="24" height="24"></span></td>
    <td><span manolo="Fedora" style="cursor:pointer;"><img src="images/fedora.png" width="24" height="24"></span></td>
    <td><span manolo="Gentoo" style="cursor:pointer;"><img src="images/gentoo.png" width="24" height="24"></span></td>
	<td><span manolo="Opensuse" style="cursor:pointer;"><img src="images/opensuse.png" width="24" height="24"></span></td>
	<td><span manolo="Ubuntu" style="cursor:pointer;"><img src="images/ubuntu.png" width="24" height="24"></span></td>
  </tr>
</table>
</div>
<div style="position:absolute; position: absolute; top: 71px; margin-left: -402px;"><script language="JavaScript" type="text/javascript">
											var mydate=new Date();
											var year=mydate.getYear();
											if (year < 1000)
												year+=1900;
											var day=mydate.getDay();
											var month=mydate.getMonth();
											var daym=mydate.getDate();
											if (daym<10)
												daym="0"+daym;

											var dayarray=new Array("<?php  echo $dom;?>","<?php  echo $lunes;?>","<?php  echo $mart;?>","<?php  echo $mierc;?>","<?php  echo $juev;?>","<?php  echo $vier;?>","<?php  echo $sab;?>")
                                            var montharray=new Array("01","02","03","04","05","06","07","08","09","10","11","12")
											document.write("<div  class=btn45><font color='#F9E6E6' ><b>"+ dayarray[day] + "</b>, " +daym + "/" + montharray[month] + "/" + year + "</font></div>");
										</script>&nbsp;&nbsp;&nbsp;
<script>inicio();</script></div>
					 </td>
        			</tr>
   			  </table></div>
			</td>
  		</tr>
		<tr>
  			<td>			
		  </td>
	  </tr>
</table></div>
<form name="idioma" method="post" action="">
  <input name="i" type="hidden" value="<?php echo $i; ?>">
</form>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">			
					<ul class="nav">
							<li class="opt <?php if(($lin) =="expedientes.php"){ echo "active";}?>" id="hom"><a href="expedientes.php"><i style="background: url(images/glyphicons-halflings-white.png) scroll -0px -21px transparent; height:26px; width:16px; float: left;"></i><?php echo $bthome;?></a></li>
							<li class="opt <?php if(($lin) =="registromedios1.php"){ echo "active";}?>"id="medi"><a href="registromedios1.php"><i style="background: url(images/glyphicons-halflings-white.png) scroll -433px -21px transparent; height:26px; width:16px; float: left;"></i><?php echo $btregmedio1;?>s</a></li>
							<li class="dropdown" <?php if(!in_array($lin,$arreglopg)){ echo "active";}?> onClick="cambiaclass('admin');" id="admin" >
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" >
								  <i style="background: url(images/glyphicons-halflings-white.png) scroll -361px -139px transparent; height:20px; width:16px; float: left;"></i>&nbsp;<?php echo "<b>".$btopcion."</b>"; ?>&nbsp;<b class="caret"></b></a>							
							<?php 
									if(($russx['tipo']) =="root"){ ?>
										<ul class="dropdown-menu" style="left:160px;">
											<li class="dropdown-submenu"><a tabindex="-1" href="javascript:showCategorias(dataApp, 'Aplicaciones')"><img border="0" align="absmiddle" class="metadata-icon" src="gfx/icons/small/copy.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $Codificadores;?></a><ul class="dropdown-menu subApp">...</ul></li>		
											<li class="dropdown-submenu"><a tabindex="-1" href="javascript:showCategorias(dataReg, 'Registros')"><img border="0" align="absmiddle" class="metadata-icon" src="gfx/icons/small/document.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $btrecords;?></a><ul class="dropdown-menu subReg">...</ul></li>
											<li class="dropdown-submenu"><a tabindex="-1" href="javascript:showCategorias(dataProd, 'Otros')"><img border="0" align="absmiddle" class="metadata-icon" src="gfx/icons/small/settings.png" style="cursor:pointer" width="20" height="20">&nbsp;&nbsp;<?php echo $bthmtas;?></a><ul class="dropdown-menu subProd">...</ul></li>
											<li class="dropdown"><a tabindex="-1" href="configura.php?p=p"><img border="0" align="absmiddle" class="metadata-icon" src="gfx/icons/small/preferences.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $Preferencias;?></a></li>
											<li class="dropdown"><a tabindex="-1" href="configura.php?p=d"><img border="0" align="absmiddle" class="metadata-icon" src="gfx/icons/small/dashboard.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $Opciones;?></a></li>
										</ul><?php
									}elseif(($_SESSION ["valid_user"]) =="invitado"){  ?>
										<ul class="dropdown-menu">
											<li class="dropdown-submenu"><a tabindex="-1" href="javascript:showCategorias(dataReg, 'Registros')"><img border="0" align="absmiddle" class="metadata-icon" src="images/txt.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $btrecords;?></a><ul class="dropdown-menu subReg">...</ul></li>
										</ul><?php
									}else{ ?>
										<ul class="dropdown-menu">
                                            <li class="dropdown-submenu"><a tabindex="-1" href="javascript:showCategorias(dataApp, 'Aplicaciones')"><img border="0" align="absmiddle" class="metadata-icon" src="images/registro.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $Codificadores;?></a><ul class="dropdown-menu subApp">...</ul></li>
										    <li class="dropdown-submenu"><a tabindex="-1" href="javascript:showCategorias(dataReg, 'Registros')"><img border="0" align="absmiddle" class="metadata-icon" src="images/txt.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $btrecords;?></a><ul class="dropdown-menu subReg">...</ul></li>
										</ul><?php
									} ?>
							</li>							
							<li class="opt <?php if(($lin) =="res.php"){ echo "active";}?>" id="base"><a href="res.php"><i style="background: url(images/glyphicons-halflings-white.png) scroll -986px -202px transparent; height:26px; width:16px; float: left;"></i><?php echo $btlegal;?></a></li>
							<li class="opt <?php if(($lin) =="visitas.php"){ echo "active";}?>" id="visi"><a href="visitas.php"><i style="background: url(images/glyphicons-halflings-white.png) scroll -829px -202px transparent; height:26px; width:16px; float: left;"></i><?php echo $btvisita;?></a></li>
							<li class="dropdown" onClick="cambiaclass('ayuda');" id="ayuda">
							   <a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i style="background: url(images/glyphicons-halflings-white.png) scroll -565px -250px transparent; height:26px; width:16px; float: left;"></i>&nbsp;<?php echo "<b>".$btayuda."</b>"; ?>&nbsp;<b class="caret"></b></a>
								<ul class="dropdown-menu" style="left:-10px;">
								  <li class="opt" id="manual"><a href="manuales.php"><img src="gfx/icons/small/export.png" >&nbsp;<?php echo $btmanual;?>&nbsp;&nbsp;&nbsp;</a></li>							
                                  <li class="opt" id="cred"><a href="creditos.php"><img src="gfx/icons/small/help.png" >&nbsp;<?php echo $btacerca;?>&nbsp;&nbsp;&nbsp;</a></li>	
								</ul>
							</li>							
							<li class="dropdown" onClick="cambiaclass('user');" id="user">
							   <a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?php echo $imge; ?>" height="14" width="12" style="margin-top: 2px;">&nbsp;<?php echo "<b>".ucwords($_SESSION['valid_user'])."</b>"; ?>&nbsp;<b class="caret"></b></a>
								 <ul class="dropdown-menu" style="left:-13px;"><?php  if ($_SESSION['valid_user']!="invitado") { ?>
								  <li><a onClick="editaperfil('perfil');" style="cursor:pointer;"><img src="gfx/icons/small/register.png" alt="Register">&nbsp;Modificar Perfil</a></li>
								  <li><a onClick="editaperfil('preferencias');" style="cursor:pointer;"><img src="gfx/icons/small/preferences.png" alt="Register">&nbsp;Preferencias</a></li>
								  <li class="divider"></li>
								  <?php } ?>	
								  <li><a href="s_close.php"><img src="gfx/icons/small/logout.png">&nbsp;<?php echo $logout;?></a></li>
								 </ul>
						   </li>													   
					</ul>
					<form action="buscador.php" class="form-search navbar-search pull-left" method="post">
						<div class="input-append" style="margin-left: 110px;">
							<input name="palabra" id="textox" type="text" class="search-query" placeholder="<?php echo $bttextobuscar;?>..." autocomplete="off" onClick="borra();" onKeyUp="busc(this.value);"  onKeyPress="return acceptNumx(event,this.value);" />
							<input type="button" value="" name="busqueda" class="art-search-button" />
						</div>
				    </form>	 	
			</div>	
        </div>
<div id="cat" role="navigation" class="procesa1" >
		 <div class="panel panel-default" >
            <div class="panel-heading">
              <h4 class="panel-title" ><b>DATOS DEL SERVIDOR</b></h4>
			  <span class="hide"></span><a  href="javascript:animatedcollapse.hide('cat')" title="Cerrar" class="btn btn-default" style="text-decoration:none; margin-top: -36px; margin-left: -247px; float:right;">X</a>
            </div><span class="hide"></span>
            <div class="panel-body">
			<?php
			//alias
			$aliasDir = '../alias/';
			// lista a ignorar
			$projectsListIgnore = array('.', '..');
			$apache_version = @apache_get_version(); 
			$version_ap = @explode ('PHP',$apache_version); 
			// recuperacion de Proyectos
			$handle = opendir(".");
			while ($file = readdir($handle)) {
				if (is_dir($file) && !in_array($file, $projectsListIgnore)) {
					@$projectContents .= '<li><a href="' . $file . '">' . $file . '</a></li>';
				}
			}
			closedir($handle);
			if (!isset($projectContents))
				$projectContents = $langues[$langue]['txtNoProjet'];


			// recuperacion de extensiones PHP
			$loaded_extensions = get_loaded_extensions();
			foreach ($loaded_extensions as $extension)
			@$phpExtContents .= "<li>${extension}</li>";
            $sis_op="";
			$sis_op=php_uname("s");
			if ($_SESSION['valid_user']!="invitado") {
			 // $sql2= "UPDATE preferencias SET plataforma='".$sis_op."'";
			 // $result2 = mysqli_query($sql2) or die (mysql_error());
			} 
	
			echo "&nbsp;&nbsp;&nbsp;Plataforma: <b>" .php_uname("s")."</b><br>\n";
			echo "&nbsp;&nbsp;&nbsp;Versi&oacute;n Apache:&nbsp;<b>".$version_ap[0]."</b><br>\n";
			echo "&nbsp;&nbsp;&nbsp;Versi&oacute;n php: <b>".phpversion().", ".php_uname("s")."</b><a style='cursor:pointer;' onclick='document.getElementById('procesa').style.heigth=45px;'; >&nbsp;&nbsp;Cr&eacute;ditos</a><br>\n";
			echo "&nbsp;&nbsp;&nbsp;Cliente MySQL: <b>".substr(mysqli_get_client_info(),0,30)."</b><br>\n";
			echo "&nbsp;&nbsp;&nbsp;Servidor MySQL: <b>".mysql_get_host_info()."</b><br>\n";
			echo "&nbsp;&nbsp;&nbsp;Protocolo MySQL: <b>".mysql_get_proto_info()."</b><br>\n";
			echo "&nbsp;&nbsp;&nbsp;versi&oacute;n del Motor Zend: <b>".zend_version()."</b><br>\n";
			echo "&nbsp;&nbsp;&nbsp;Usuario MySQL: <b>root</b><br>\n";
            $sapi_type = php_sapi_name();
			
			if (substr($sapi_type, 0, 3) == 'cgi') {
				echo "<font color=red>Ud. est&aacute; usando CGI PHP\n</font>";
			} else {
				echo "&nbsp;&nbsp;&nbsp;Ud. no est&aacute; usando CGI PHP\n";
			}
$pageContents = <<< EOPAGE
	<link rel="shortcut icon" href="index1.php?img=favicon" type="image/ico" />
EOPAGE;
     echo $pageContents;
?>
</div>
</div>
</div>