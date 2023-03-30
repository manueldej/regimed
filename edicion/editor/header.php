<!DOCTYPE html>
<html lang="es">
<?php
/********************************************************************************************
* Software: Seguridad                                                                       * 
*(Registro de Medios Informáticos)     					                         			*
* Version:  2.0                                                     				        *
* Fecha:    01/06/2013                                             					        *
* Autores:  Lic. Manuel de Jesús Núñez Guerra   											*
*          	Msc. Carlos Pollan Estrada														*
* Licencia: Freeware                                                				        *
*                                                                       				    *
* Usted puede usar y modificar este software si asi lo desee, pero debe mencionar la fuente *
*********************************************************************************************/
		@session_start();
		include('../../chequeo.php');
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
	if (!file_exists('../../connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="../../installation/index.php";</script><?php
		return;
	}
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('../../esp.php');}else{ include('../../eng.php');}
?><head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="shortcut icon" href="../../../../images/pantalla.ico" />
    <title>RegiMed -Control de Medios Inform&aacute;ticos-</title>
	<link href="css/template.css" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
<?php
require_once('../../connections/miConex.php');
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
$us = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."' AND idunidades='".$rdage['id_datos']."'") or die(mysql_error());
$rus = mysqli_fetch_array($us);
$nrus=mysqli_num_rows($us);

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
 
$user = $_SERVER['HTTP_USER_AGENT'];
$ff=explode("/", $user);
if(strpos($user, "Mozilla")) { $browser = "Mozilla"; $img = "mozzila.gif"; }
if(strpos($user, "Firebird")) { $browser = "Mozilla Firebird"; $img = "mozzila.gif"; }
if(strpos($user, "Firefox")) { $browser = "Mozilla Firefox"; $img = "mozzila.gif"; }
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


$os = "Onbekend"; $img2="unknow.gif";

if(strpos($user, "Linux"))  { $os = "Linux"; $img2="linux.gif";}
if(strpos($user, "Unix"))  { $os = "Unix"; $img2="unix.gif";}
if(strpos($user, "Mac"))  { $os = "MacOS"; $img2="mac.gif";}
if(strpos($user, "FreeBSD"))  { $os = "FreeBSD"; $img2="freebsd.gif";}
if(strpos($user, "BEOS"))  { $os = "BeOS"; $img2="beos.gif";}

if(strpos($user, "Windows")) { 
	$os = "Windows"; $img2="windows.gif";
	if(strpos($user, "95")) { $os = "Windows 95"; $img2="windows.gif";}
	if(strpos($user, "98")) { $os = "Windows 98"; $img2="windows.gif";}
	if(strpos($user, "SE")) { $os = "Windows 98SE"; $img2="windows.gif";}
}

if(strpos($user, "Windows NT 5.0"))  { $os = "Windows 2000"; $img2="windows.gif";}
if(strpos($user, "Windows NT 5.1"))  { $os = "Windows XP"; $img2="windows.gif";}
if(strpos($user, "Windows XP"))  { $os = "Windows XP"; $img2="winxp.gif";}
if(strpos($user, "Windows NT 5.2"))  { $os = "Windows Server 2003"; $img2="windows.gif";}

// Waarschijnlijke useragents:
if(strpos($user, "Windows NT 5.3"))  { $os = "Windows Longhorn"; $img2="longhorn.gif";}
if(strpos($user, "Windows NT 5.4"))  { $os = "Windows Blackcomb"; $img2="blackcomb.gif";}  ?>
<SCRIPT LANGUAGE="JavaScript">
function guarda(i){
	document.cookie="seulang="+i;
	document.location='expedientes.php';
}
	<?php if(($rus["tipo"]) =="root"){ ?>
	var categoriaApp = [ '<?php echo $btAreas;?>','<?php echo $btcontrol;?>','<?php echo $btcategmedios;?>','<?php echo $btClaves;?>' ];
	<?php }else{ ?>
	var categoriaApp = [ '<?php echo $btAreas;?>','<?php echo $btcontrol;?>','<?php echo $btcategmedios;?>' ];
	<?php } ?>
	var categoriaProd = [ '<?php echo $btprep;?>', '<?php echo $bttrasp;?>','R. <?php echo $btinsp;?>','<?php echo $btsalvas;?>','<?php echo $btrestaurar." ".$btdatabase;?>','<?php echo $btpmtto;?>', '<?php echo $btCustodios;?>-AFT','<?php echo $btManuales;?>','<?php echo $btImportar;?>','<?php echo $btExportar;?>', '<?php echo $Memorias;?>','<?php echo $btbtecnicas;?>','<?php echo $repara;?>','<?php echo $bteditaunid;?>' ];
	var categoriaReg = [ '<?php echo $btpmtto;?>','<?php echo $btprep;?>','<?php echo $bttrasp;?>','<?php echo $btbajas;?>','<?php echo $btinsp;?>' ];
	
function showEtiquetas(){
	app ='';
	prod ='';
	reg ='';

	reg+='<li><a href="../../plan_mtto.php">'+categoriaReg[0]+'</a></li>';
	reg+='<li><a href="../../rep.php">'+categoriaReg[1]+'</a></li>';
	reg+='<li><a href="../../r_traspasos.php">'+categoriaReg[2]+'</a></li>';
	reg+='<li><a href="../../bajas.php">'+categoriaReg[3]+'</a></li>';
	reg+='<li><a href="../../insp.php">'+categoriaReg[4]+'</a></li>';

	app+='<li><a href="../../registroareas.php">'+categoriaApp[0]+'</a></li>';
	app+='<li><a href="../../ej1.php">'+categoriaApp[1]+'</a></li>';
	app+='<li><a href="../../categ_medios.php">'+categoriaApp[2]+'</a></li>';
	<?php if(($rus["tipo"]) =="root"){ ?>
	app+='<li><a href="../../reg_claves_sistema.php">'+categoriaApp[3]+'</a></li>';
	<?php }else{ ?>
	app+='';
	<?php } ?>
	
	prod+='<li><a href="../../rep.php?con=c">'+categoriaProd[0]+'</a></li>';
	prod+='<li><a href="../../traspasos.php">'+categoriaProd[1]+'</a></li>';
	prod+='<li><a href="../../form-insertarinsp.php">'+categoriaProd[2]+'</a></li>';
	prod+='<li><a href="../../salva.php">'+categoriaProd[3]+'</a></li>';
	prod+='<li><a href="../../restaura.php?carpeta=salvas">'+categoriaProd[4]+'</a></li>';
	prod+='<li><a href="../../plan_mtto.php?con=m">'+categoriaProd[5]+'</a></li>';
	prod+='<li><a href="../../registrocustodio.php">'+categoriaProd[6]+'</a></li>';
	prod+='<li><a href="edit_creditos.php">'+categoriaProd[7]+'</a></li>';
	prod+='<li><a href="../../importa.php">'+categoriaProd[8]+'</a></li>';
	prod+='<li><a href="../../exportador.php">'+categoriaProd[9]+'</a></li>';
	prod+='<li><a href="../../registrousb.php">'+categoriaProd[10]+'</a></li>';
	prod+='<li><a href="../../destinobajas.php">'+categoriaProd[11]+'</a></li>';
	prod+='<li><a href="../../optimizar.php">'+categoriaProd[12]+'</a></li>';
	prod+='<li><a href="../../editaunidad.php">'+categoriaProd[13]+'</a></li>';

	$('.subProd').html(prod);
	$('.subApp').html(app);
	$('.subReg').html(reg);
}	
	
</script>
<script type="text/javascript" src="js/script.js"></script>
</head>

<body><div class="fondo">
<table width="100%" border="0">
		<tr>
    		<td align="center" valign="top"><div align="center">
      			<table width="977" border="0" align="center">
					<tr>
						<td width="82" valign="top"  >&nbsp;</td>
						<td width="655" valign="middle"><img <?php if(($i) =="es") { ?>src="../../images/headeresp.png" <?php }else { ?>src="../../images/headereng.png" <?php }?>/></td>
					    <td width="226" valign="middle" class="Estilo13"><?php
 						if ($_SESSION ["valid_user"]) {
					   	  if ($resu['total']==1){
							     $visitas="visita";
							 }else $visitas="visitas";

						  if ($rus['sexo']=="h"){
	                         $imge ="../../images/admin.png";
						  }elseif ($rus['sexo']=="m"){
                            $imge ="../../images/female.png";
						  }else{
							$imge ="../../images/invitado.gif";
						  }
						  if(($rus['tipo']) =="root"){						 
						  	$imge ="../../images/male.png";
						  }						  
						 ?>
<div align="right" class="login">
<TABLE WIDTH="226" height="57" BORDER=0 CELLPADDING=0 CELLSPACING=0>
	<TR>
		<TD  width="23" heigth="53">		</TD>
		<TD  width="97" heigth="53"valign="middle"><div><?php 
		if(($nrus) ==0){?>
			<a href="../../ej1.php?palabra=<?php echo $rus['login'];?>" target="c"><img class="metadata-icon" src="<?php echo $imge;?>" style="cursor:pointer" width="16" height="16" title="<?php echo $Invitado;?>" /></a><strong><font color="#ffffff"><?php echo strtoupper($Invitado);?></font></strong><?php 
		}else{ ?>
			<a href="../../ej1.php?palabra=<?php echo $rus['login'];?>" target="c" class="tooltip1"><img class="metadata-icon" src="<?php echo $imge;?>" style="cursor:pointer" width="16" height="16"/><span onmouseover="this.style.cursor='pointer';"><?php echo $rus['nombre'].$btRealizado1.$resu['total'].'&nbsp;'; if(($resu['total']) >1){ echo $btvisitas; }else{ echo $btvisita; } echo $btestesitio;?></span></a><strong><font color="#ffffff" size="1"><?php echo strtoupper($rus["login"]);?></font></strong><?php 
		} ?></div>
			<div>&nbsp;&nbsp;&nbsp;&nbsp;<a class="tooltip" href="../../s_close.php"><button class="btn-inverse1"><b><?php echo $logout;?></b></button><span onmouseover="this.style.cursor='pointer';"><?php echo $logout1;?></span></a>
			</div>		</TD>
		<TD width="90" align="right" height="53"><div align="center"><a href="#" class="tooltip"><img <?php if(($i) =="es"){ echo 'style="opacity: .5;"';} ?> src="../../images/es.png" width="33" height="18" border="0" align="absmiddle" onMouseOver="this.style.cursor='pointer';" onClick="guarda('es');" /><span onMouseOver="this.style.cursor='pointer';"><?php echo $btidiomes;?></span></a>&nbsp;&nbsp;<a href="#" class="tooltip"><img <?php if(($i) =="en"){ echo 'style="opacity: .5;"';} ?> src="../../images/en.png" width="33" height="16" border="0" align="absmiddle" onMouseOver="this.style.cursor='pointer';" onClick="guarda('en');" /><span onMouseOver="this.style.cursor='pointer';"><?php echo $btidiomen;?></span></a></div>
		<div align="center"><?php  echo "<a href='#' class='tooltip'><img width='25' height='14' src='../../images/".$img2."'><span onmouseover=\"this.style.cursor='pointer';\">".$os."</span></a>&nbsp;&nbsp;";  echo "<a href='#' class='tooltip3'><img width='25' height='18' src='../../images/".$img."'><span onmouseover=\"this.style.cursor='pointer';\">".$browser."</span></a>";?></div> </TD>
		<TD width="16" height="53">&nbsp;</TD>
	</TR>
</TABLE>
</div><?php
						}

					 ?>
					 </td>
        			</tr>
   			  </table></div>
			</td>
  		</tr>
		<tr>
  			<td>			
		  </td>
	  </tr>
</table></div><?php
$lin = substr(strrchr ($_SERVER['PHP_SELF'],"/"),1);
?>
		<div class="navbar navbar-inverse">
			<div class="navbar-inner">				
					<ul class="nav">
							<li  class="opt <?php if(($lin) =="expedientes.php"){ echo "active";}?>" onClick="document.location='../../expedientes.php'"><a href="#"><?php echo $bthome;?></a></li>
							<li  class="opt <?php if(($lin) =="registromedios1.php"){ echo "active";}?>" onClick="document.location='../../registromedios1.php'"><a href="#"><?php echo $btregmedio1;?>s</a></li>
							<li  class="opt <?php if(($lin) =="res.php"){ echo "active";}?>" onClick="document.location='../../res.php'"><a href="#"><?php echo $btlegal;?></a></li>
							<li  class="opt <?php if(($lin) =="visitas.php"){ echo "active";}?>" onClick="document.location='../../visitas.php'"><a href="#"><?php echo $btvisita;?></a></li>
							<li  class="opt <?php if(($lin) =="manuales.php"){ echo "active";}?>" onClick="document.location='../../manuales.php'"><a href="#"><?php echo $btayuda;?></a></li>							
                            <li  class="opt <?php if(($lin) =="creditos.php"){ echo "active";}?>" onClick="document.location='../../creditos.php'"><a href="#"><?php echo $btacerca;?></a></li>															
					</ul>		
						<form action="buscador.php" class="form-search navbar-search pull-left" method="get">
						<div class="input-append">
							<input name="palabra" id="textox" type="text" class="search-query" value="<?php echo $bttextobuscar;?>..." autocomplete="off" onClick="borra();" onKeyUp="busc(this.value);"  onKeyPress="return acceptNumx(event,this.value);" />
							
						</div>
				  </form><div align="center"></div><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    	<script language="JavaScript" type="text/javascript">
											var mydate=new Date();
											var year=mydate.getYear();
											if (year < 1000)
												year+=1900;
											var day=mydate.getDay();
											var month=mydate.getMonth();
											var daym=mydate.getDate();
											if (daym<10)
												daym="0"+daym;

											var dayarray=new Array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","S&aacute;bado");
											var montharray=new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
											document.write("<font size='2' color='#FFFFFF' face='verdana' size='1'><b>"+ dayarray[day] + "</b>, " +daym + " " + montharray[month] + " del " + year + "</font>");

										</script>
                                  	</div>
					
				
			</div>	
        </div> 

