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

		@session_start();
		include('chequeo.php');
		if (!check_auth_user()){
			?><script type="text/javascript">window.parent.location="index.php";</script><?php
			exit;
		}
	if (!file_exists('connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="installation/index.php";</script><?php
		return;
	}

require_once("chequeo.php");
@session_start();
require_once('connections/miConex.php');

$query_Recordset1 = "SELECT * FROM tipos_medios";
$Recordset1 = mysqli_query($miConex, $query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$us = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rus = mysqli_fetch_array($us);

$vis = mysqli_query($miConex, "SELECT COUNT(user) as total FROM visitas WHERE user ='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$resu = mysqli_fetch_assoc($vis);

$us1 = mysqli_query($miConex, "select * from preferencias where usuario='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rus1 = mysqli_fetch_array($us1);

$query_Recordset2 = "SELECT * FROM tipos_medios ORDER BY id";
$Recordset2 = mysqli_query($query_Recordset2) or die(mysql_error());
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
?>
<?php
 $os ="";
 $option_block ="";
 $usuario ="";
?>
<form name="mm" method="post" action="index1.php" id="mm">
	<input name="m" type="hidden" value="m">
</form>
<form name="mmi" method="post" action="index1.php" id="mmi">
	<input name="insp" type="hidden" value="insp">
</form>
<SCRIPT LANGUAGE="JavaScript">
function loadImages() {
	  if (document.getElementById) {  // DOM3 = IE5, NS6
		 document.getElementById('hidepage').style.visibility = 'hidden';
		}else {
		if (document.layers) {  // Netscape 4
		  document.hidepage.visibility = 'hidden';
		 }else {  // IE 4 o superior
          document.all.hidepage.style.visibility = 'hidden';
          }
      }
  }
function md() {
	document.mm.submit();
}
function mi() {
	document.mmi.submit();
}
</script>
<script type="text/javascript" src="js/script.js"></script>
	<!--<link rel="stylesheet" href="css/bubble.css" type="text/css" media="screen" /> -->
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->

<script type="text/javascript">
	function busca_tipos(valor){
		var emptyForm = true;

  switch (valor) {
		case 0:
			with (document.form1){
				emptyForm = (palabra.value == "");
				if (!emptyForm)	{
					submit();
				}
			}
			break;
		case 1:
			with (document.form2){
				emptyForm = (palabra.value == "");
				if (!emptyForm)	{
					submit();
				}
			}
			break;
		case 2:
		   with (document.form3){
				emptyForm = (palabra.value == "");
				if (!emptyForm)	{
					submit();
				}
			}
			break;
		 case 3:
		   with (document.form4){
				emptyForm = (palabra.value == "");
				if (!emptyForm)	{
					submit();
				}
			}
			break;


		 case 4:
		   with (document.form5){
				emptyForm = (palabra.value == "");
				if (!emptyForm)	{
					submit();
				}
			}
		  break;
   }

}
</script>

<style type="text/css">
<!--
.message {
	BORDER-RIGHT: #aabf76 1px dotted; PADDING-RIGHT: 7px; BORDER-TOP: #aabf76 1px dotted; MARGIN-TOP: 10px; PADDING-LEFT: 7px; FONT-WEIGHT: bold; FONT-SIZE: 12px; BACKGROUND: #f9fdf0; PADDING-BOTTOM: 7px; BORDER-LEFT: #aabf76 1px dotted; WIDTH: 400px; COLOR: #777971; PADDING-TOP: 7px; BORDER-BOTTOM: #aabf76 1px dotted
}

.cuadro {
	clear: left;
	float: left;
	height: auto;
	width: 50%;
}
.blockquote p
{
  color:#1E1800;
  font-family: Verdana, Geneva, Arial, Helvetica, Sans-Serif;
  font-style: italic;
  font-weight: normal;
  text-align: left;
}

.blockquote
{
  border-color:#CDC989;
  border-width: 1px;
  border-style: solid;
  margin:10px 10px 10px 50px;
  padding:5px 5px 5px 41px;
  background-color:#E5E3C2;
  background-position:left top;
  background-repeat:no-repeat;
}

.PostFooterIcons, .PostFooterIcons a, .PostFooterIcons a:link, .PostFooterIcons a:visited, .PostFooterIcons a:hoVer
{
  font-family: Verdana, Geneva, Arial, Helvetica, Sans-Serif;
  font-size: 11px;
  text-decoration: none;
  color: #767232;
}

.PostFooterIcons a, .PostFooterIcons a:link, .PostFooterIcons a:visited, .PostFooterIcons a:hoVer
{
  margin:0;
}

.PostFooterIcons a:link
{
  font-family: Verdana, Geneva, Arial, Helvetica, Sans-Serif;
  text-decoration: underline;
  color: #7D7936;
}

.PostFooterIcons a:visited, .PostFooterIcons a.visited
{
  font-family: Verdana, Geneva, Arial, Helvetica, Sans-Serif;
  text-decoration: underline;
  color: #7D7936;
}

.PostFooterIcons a:hoVer, .PostFooterIcons a.hoVer
{
  font-family: Verdana, Geneva, Arial, Helvetica, Sans-Serif;
  text-decoration: none;
  color: #4D5D66;
}

-->
</style>
<link href="css/template.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/mctabs.js"></script>
<table width="952" border="0">
		<tr>
    		<td align="center" valign="top"><div align="center">
      			<table width="952" border="0" align="center">
					<tr>
						<td width="87" valign="top"  >&nbsp;</td>
						<td width="680" align="center" valign="middle"><img src="images/Header.jpg" width="680" height="91" /></td>
					  <td width="171" valign="middle" class="Estilo13"><?php
 						if ($_SESSION ["valid_user"]) {
					   	  if ($resu['total']==1){
							     $visitas="visita";
							 }else $visitas="visitas";

						  if ($rus['sexo']=="h"){
	                         $imge ="images/male.png";
						  }elseif ($rus['sexo']=="m"){
                            $imge ="images/female.png";
						  }
						 ?>
<div align="right" style="padding-right:0px; padding-top:5px;">
<TABLE WIDTH="215" height="57" BORDER=0 CELLPADDING=0 CELLSPACING=0>
	<TR>
		<TD background="images/01_01.gif" width="29" heigth="53">
		</TD>
		<TD background="images/01_02.gif" width="184" heigth="53" align="center" valign="middle">
		<a href="ej1.php?palabra="<?php $rus['nombre'];?> target="c"><img class="metadata-icon" src="<?php echo $imge;?>" style="cursor:pointer" width="14" height="14" title="<?php echo $rus['nombre']." ha realizado ".$resu['total']." ".$visitas." a este Sitio";?>" /></a><strong><font color="red"><?php echo strtoupper($rus["login"]);?></font></strong>
      <div align="center"><a href="s_close.php" title="Salir de la Aplicacin"><strong>Salir</Strong></a></div>
		</TD>
		<TD background="images/01_03.gif" width="26" heigth="53">
		</TD>
	</TR>
</TABLE>
</div><?php
						}

					 ?>
					 </td>
        			</tr>
       	 			<tr>
          				<td colspan="3" valign="top">
							<div class="PostMetadataHeader">
                            	<div class="PostHeaderIcons metadata-icons">
                                	<div align="center">
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
											document.write("<small><font color='000066' face='Verdana' size='1'><b>"+ dayarray[day] + "</b>, " +daym + " " + montharray[month] + " del " + year + "</font></small>");

										</script>
                                  	</div>
                           		</div>
						    </div>
						</td>
        			</tr>
      			</table></div>
			</td>
  		</tr>
		<tr>
  			<td> <?php
  			require_once("chequeo.php");?>
				<div class="tabs">
					<ul>
						<?php if(isset($_POST['gral']) OR isset($_POST['palabra']) OR isset($_POST['otras']) OR isset($_POST['m']) OR isset($_POST['insp'])){ ?>
						<li id="Exp"><span class="botonx" onClick="javascript:mcTabs.displayTab('Exp','Expe');" onMouseOVer="this.style.cursor='pointer';"><?php echo $bthome;?></span></li>
						<?php }else{ ?>
						<li id="Exp" class="current"><span class="botonx" onClick="javascript:mcTabs.displayTab('Exp','Expe');" onMouseOVer="this.style.cursor='pointer';"><?php echo $bthome;?></span></li>
						<?php } ?>
						<li id="Mtto"><span class="botonx" onClick="javascript:mcTabs.displayTab('Mtto','PMtto');" onMouseOVer="this.style.cursor='pointer';"><?php echo $btpmtto;?>.</span></li>
						<li id="Rep"><span class="botonx" onClick="javascript:mcTabs.displayTab('Rep','PRep'); " onMouseOVer="this.style.cursor='pointer';"><?php echo $btprep;?>.</span></li>
						<li id="Traspasos"><span class="botonx" onClick="javascript:mcTabs.displayTab('Traspasos','Rtraspasos');" onMouseOVer="this.style.cursor='pointer';"><?php echo $bttrasp;?></span></li>
						<li id="configura"><span class="botonx" onClick="javascript:mcTabs.displayTab('configura','Herramientas');" onMouseOVer="this.style.cursor='pointer';"><?php echo $bthmtas;?></span></li>
						<?php if(isset($_POST['gral']) OR isset($_POST['palabra']) OR isset($_POST['otras']) OR isset($_POST['m']) AND !isset($_POST['insp'])){ ?>
						<li id="Registro" class="current"><span class="botonx" onClick="javascript:mcTabs.displayTab('Registro','RegistroMedios1'); md();" onMouseOVer="this.style.cursor='pointer';"><?php echo $btrecords;?></span></li>
						<?php }else{ ?>
						<li id="Registro"><span class="botonx" onClick="javascript:mcTabs.displayTab('Registro','RegistroMedios1'); md();" onMouseOVer="this.style.cursor='pointer';"><?php echo $btrecords;?></span></li>
						<?php } ?>
						<li id="busca"><span class="botonx" onClick="javascript:mcTabs.displayTab('busca','buscador');" onMouseOVer="this.style.cursor='pointer';"><?php echo $btsearch;?></span></li>
						<?php  if(isset($_POST['insp'])){ ?>
						<li id="Inspe" class="current"><span class="botonx" onClick="javascript:mcTabs.displayTab('Inspe','Insp'); mi();" onMouseOVer="this.style.cursor='pointer';"><?php echo $btinsp;?></span></li>
						<?php }else{ ?>
						<li id="Inspe"><span class="botonx" onClick="javascript:mcTabs.displayTab('Inspe','Insp'); mi();" onMouseOVer="this.style.cursor='pointer';"><?php echo $btinsp;?></span></li>
						<?php } ?>
						<li id="Res"><span class="botonx" onClick="javascript:mcTabs.displayTab('Res','Reso');" onMouseOVer="this.style.cursor='pointer';"><?php echo $btlegal;?></span></li>
						<li id="visit"><span class="botonx" onClick="javascript:mcTabs.displayTab('visit','visitas');" onMouseOVer="this.style.cursor='pointer';"><?php echo $btvisita;?></span></li>
						<li id="manual"><span class="botonx" onClick="javascript:mcTabs.displayTab('manual','manuales');" onMouseOVer="this.style.cursor='pointer';"><?php echo $btayuda;?></span></li>
						<li id="credit"><span class="botonx" onClick="javascript:mcTabs.displayTab('credit','creditos');" onMouseOVer="this.style.cursor='pointer';"><?php echo $btacerca;?>...</span></li>
					</ul>
				</div>
		  </td>
	  </tr>
</table>
<fieldset>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="19%" align="center" valign="top"><span class="Estilo5"><form name="comp" method="post" action="index1.php"><input type="hidden" name="gral" value="COMPUTADORAS"><img onMouseOVer="this.style.cursor='pointer';" onClick="javascript:document.comp.submit();" src="images/pc.jpg" alt="Computadoras" width="45" height="40" border="0" title="Mostrar todas las Computadoras..." /></form></span></td>
					<td width="19%" align="center" valign="top"><span class="Estilo5"><form name="imp" method="post" action="index1.php"><input type="hidden" name="gral" value="IMPRESORA"><img onMouseOVer="this.style.cursor='pointer';" onClick="javascript:document.imp.submit();" src="images/imp.jpg" alt="Impresoras" width="45" height="40" border="0" title="Mostrar todas las Impresoras..." /></form></span></td>
					<td width="19%" align="center" valign="top"><div class="Estilo5"><form name="esc" method="post" action="index1.php"><input type="hidden" name="gral" value="ESCANNER"><img onMouseOVer="this.style.cursor='pointer';" onClick="javascript:document.esc.submit();" src="images/scan.jpg" alt="Escanner y/o Fotocopiadoras" width="45" height="40" border="0" title="Mostrar todas las Fotocopiadoras y/o Escanner..."/></form></span></td>
					<td width="19%" align="center" valign="top"><span class="Estilo5"><form name="moni" method="post" action="index1.php"><input type="hidden" name="gral" value="MONITOR"><img onMouseOVer="this.style.cursor='pointer';" onClick="javascript:document.moni.submit();" src="images/Mi Pc.jpg" alt="Monitores" width="45" height="40" border="0" title="Mostrar todos los Monitores..."/></form></span></td>
					<td width="24%" align="center" valign="top"><span class="Estilo5"><form name="vari" method="post" action="index1.php"><input type="hidden" name="otras" value="VARIAS"><img onMouseOVer="this.style.cursor='pointer';" onClick="javascript:document.vari.submit();" src="images/opciones.jpg" alt="Ver Todos" width="45" height="40" border="0" title="Todas las Categora de Medios..."/></form></span></td>
				</tr>
				<tr>
					<td bordercolor="#485860" bgcolor="#FFFFFF">
						<form action="index1.php" method="post" name="form1" id="form1" onChange="busca_tipos(0);">
						  <div align="center">
						    <select name="palabra" size="1" id="palabra" class="combo_box">
						      <option value="-1">Tipos...</option>
							  <option value="Escritorio">PC Escritorio</option>
						      <option value="Portatil">Port&aacute;tiles</option>
						      <option value="Cliente Ligero">Clientes Ligeros</option>
						      <option value="Servidor">Servidores</option>
					        </select>
						   	<input name="in" type="hidden" value="i"/>

				          </div>
						</form>					</td>
					<td bordercolor="#485860" bgcolor="#FFFFFF">
						<form action="index1.php" method="post" name="form2" id="form2" onChange="busca_tipos(1);">
							<div align="center">
							  <select name="palabra" size="1" id="palabra" class="combo_box">
							    <option value="-1">Tipos...</option>
								<option value="FX-2190">FX-2190</option>
							    <option value="FX-890">FX-890</option>
							    <option value="LX-300+">LX-300+</option>
							    <option value="HP-1006">HP-1006</option>
							    <option value="Magic Color">Magic Color</option>
							    <option value="FX-1170">FX-1170</option>
							    <option value="FX-1180">FX-1180</option>
						      </select>

					      </div>
						</form>					</td>
					<td bordercolor="#485860" bgcolor="#FFFFFF">
						<form action="index1.php" method="post" name="form3" id="form3" onChange="busca_tipos(2);">
							<div align="center">
							  <select name="palabra" size="1" id="palabra" class="combo_box">
							    <option value="-1">Tipos...</option>
								<option value="ESCANNER">Escanner</option>
							    <option value="Fotocopiadora">Fotocopiadoras</option>
							    <option value="Ploter">Ploter</option>
						      </select>

					      </div>
						</form>					</td>
					<td bordercolor="#485860" bgcolor="#FFFFFF">
						<form action="index1.php" method="post" name="form4" id="form4" onChange="busca_tipos(3);">
							<div align="center">
							  <select name="palabra" size="1" id="palabra" class="combo_box">
    						     <option value="-1">Tipos...</option>
								<option value="LCD">LCD</option>
							    <option value="Tubo">Tubo Cat&oacute;dico</option>
						      </select>
						   </div>
						</form>					</td>
					<td bordercolor="#485860" bgcolor="#FFFFFF">
						<form action="index1.php" method="post" name="form5" id="form5" onChange="busca_tipos(4);">
							<div align="center">
							  <select name="palabra" size="1" id="palabra" class="combo_box">
							     <option value="-1">Tipos...</option>
								<?php
							do { ?>
							    <option value="<?php echo $row_Recordset2['nombre']?>"><?php echo $row_Recordset2['nombre']?></option>
							    <?php
							} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
							$rows = mysqli_num_rows($Recordset2);
							if($rows > 0) {
								mysqli_data_seek($Recordset2, 0);
								$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
							}	?>
						      </select>
							  <input name="in" type="hidden" value="i"/>
					      </div>
						</form>					</td>
				</tr>
</table>
</fieldset>

