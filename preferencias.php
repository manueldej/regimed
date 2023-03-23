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
		include('chequeo.php');
		if (!check_auth_user()){
			?><script type="text/javascript">window.parent.location="index.php";</script><?php
			exit;
		}

include('script.php');
	if (!file_exists('connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="installation/index.php";</script><?php	
		return;	
	} 
	?>

<?php include('connections/miConex.php');?>
<?php $leyenda = array('Codificadores','Preferencias Avanzadas','Herramientas','Varias'); ?>
<link href="template_css.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<script LANGUAGE="JavaScript">
<!--
   function escondetodo()   {
		document.getElementById("Codificadores").style.display = "none";
		document.getElementById("Preferencias").style.display = "none";
		document.getElementById("Herramientas").style.display = "none";
		document.getElementById("varias").style.display = "none";	    
   }
//-->
</script>

<script type="text/javascript">
	function va1(){
		document.getElementById('Codificadores').style.display = "block";
		document.getElementById('Preferencias').style.display = "none";
		document.getElementById('Herramientas').style.display = "none";
		document.getElementById('varias').style.display = "none";
	}
	function va2(){
		document.getElementById('Codificadores').style.display = "none";
		document.getElementById('Preferencias').style.display = "block";
		document.getElementById('Herramientas').style.display = "none";
		document.getElementById('varias').style.display = "none";
	}
	function va3(){
		document.getElementById('Codificadores').style.display = "none";
		document.getElementById('Preferencias').style.display = "none";
		document.getElementById('Herramientas').style.display = "block";
		document.getElementById('varias').style.display = "none";
	}
	function va4(){
		document.getElementById('Codificadores').style.display = "none";
		document.getElementById('Preferencias').style.display = "none";
		document.getElementById('Herramientas').style.display = "none";
		document.getElementById('varias').style.display = "block";
	}
</script>
			
<style type="text/css">
<!--
.Estilo3 {
	font-size: 12px;
	color: #846131;
	font-weight: bold;
	font-style: italic;
}

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
/*- Menu Tabs 9--------------------------- */

    #tabs9 {
      float:none;
      width:100%;
      font-size:93%;
          border-bottom:1px solid #F45551;
      line-height:normal;
      }
    #tabs9 ul {
          margin:0;
          padding:10px 10px 0 50px;
          list-style:none;
      }
    #tabs9 li {
      display:inline;
      margin:0;
      padding:0;
      }
    #tabs9 a {
      float:left;
      background:url("images/tableft9.gif") no-repeat left top;
      margin:0;
      padding:0 0 0 4px;
      text-decoration:none;
      }
    #tabs9 a span {
      float:left;
      display:block;
      background:url("images/tabright9.gif") no-repeat right top;
      padding:5px 15px 4px 6px;
      color:#FFF;
      }
    /* Commented Backslash Hack hides rule from IE5-Mac \*/
    #tabs9 a span {float:none;}
    /* End IE5-Mac hack */
    #tabs9 a:hoVer span {
      color:#FFF;
      }
    #tabs9 a:hoVer {
      background-position:0% -42px;
      }
    #tabs9 a:hoVer span {
      background-position:100% -42px;
      }

      #tabs9 #current a {
              background-position:0% -42px;
      }
      #tabs9 #current a span {
              background-position:100% -42px;
      }
	  .boton { 
		font-family: Verdana, sans-serif; 
		font-size: 10px; 
		color: #333333; 
		border: 1px #666666 solid; 
		background-color: #f2f2f2; 
		font-weight: bold;
		}
		
.Estilo14 {
	color: #009239;
	font-size: 24px;
	font-family: Georgia, "Times New Roman", Times, serif;
}
.Estilo15 {font-size: 36px}
body {
	margin-left: 10px;
	margin-top: 1px;
	margin-right: 10px;
	margin-bottom: 1px;
	background-color: #FFFFFF;
}

img {
border: none;
}

/*- Menu Tabs 4--------------------------- */

    #tabs4 {
      float:left;
      width:100%;
      font-size:9px;
      line-height:normal;
      border-bottom:1px solid #6B78A9;
	  font-weight: bold;
    }
    #tabs4 ul {
          margin:0;
          padding:10px 10px 0 50px;
          list-style:none;
      }
    #tabs4 li {
      display:inline;
      margin:0;
      padding:0;
      }
    #tabs4 a {
      float:left;
      background:url("images/tableft4.gif") no-repeat left top;
      margin:0;
      padding:0 0 0 7px;
      text-decoration:none;
      }
    #tabs4 a span {
      float:left;
      display:block;
      background:url("images/tabright4.gif") no-repeat right top;
      padding:5px 15px 4px 6px;
      color:#6B78A9;
      }
    /* Commented Backslash Hack hides rule from IE5-Mac \*/
    #tabs4 a span {float:none;}
    /* End IE5-Mac hack */
    #tabs4 a:hoVer span {
      color:#6B78A9;
      }
    #tabs4 a:hoVer {
      background-position:0% -42px;
      }
    #tabs4 a:hoVer span {
      background-position:100% -42px;
      }

      #tabs4 #current a {
              background-position:0% -42px;
      }
      #tabs4 #current a span {
              background-position:100% -42px;
      }
-->
</style>

<table width="100%" border="0">
  <tr>
    <td><div id='tabs4'>
	<ul>
		<li onclick="va1();"><a href="#"><span><?php echo $leyenda[0];?></span></a></li>
		<li onclick="va2();"><a href="#"><span><?php echo $leyenda[1];?></span></a></li>
		<li onclick="va3();"><a href="#"><span><?php echo $leyenda[2];?></span></a></li>
		<li onclick="va4();"><a href="#"><span><?php echo $leyenda[3];?></span></a></li>	
	</ul>
  	</form>

</div></td>
  </tr>
</table>
<div id= "Codificadores">
<fieldset class='fieldset'>
<legend><?php echo $leyenda[0];?></legend>
<div align="center" class="mosimage_caption"><strong><?php echo strtoupper($leyenda[0]);?></strong> --><?php echo $btdatabase;?>:</strong> <font color="red"><?php echo $database_miConex;?></font></div>
<table width="551" height="349" border="0" align="center">
  </tr>
  <tr> 
    <td width="187" height="40" align="left" valign="middle"><div align="center" class="vistauser2"><a href="rep.php"><img src="images/dmfull (17) copia.jpg" width="32" height="32" border="0" /></a></div></td>
    <td width="157"><div align="center" class="vistauser1"><a href="ej1.php"><img src="images/candado.jpg" width="32" height="32" border="0" /></a></div></td>
    <td width="212"><div align="center" class="vistauser2"><a href="form-insertarinsp.php"><img src="images/laptop.jpg" width="32" height="32" border="0" /></a></div></td>
  </tr>
  <tr> 
    <td><div align="center"><span class="Estilo3"><a href="rep.php" target="_self" class="vistauser1"><?php echo $btprep;?></a></span></div></td>
    <td><div align="center"><span class="Estilo3"><a href="ej1.php" class="vistauser2"><?php echo $btcontrol;?></a> </span></div></td>
    <td><div align="center" class="vistauser2"><span class="Estilo3"><a href="form-insertarinsp.php"><?php echo $btinsp;?></a> </span></div></td>
  </tr>
  <tr> 
    <td align="center" valign="middle"><p align="center" class="vistauser2"><a href="registromedios1.php"></a><a href="registromedios1.php"><img src="images/registro.jpg" width="32" height="32" border="0" /></a></p></td>
    <td><div align="center" class="vistauser1"><span class="vistauser2"><a href="registroareas.php"><img src="images/Areas.jpg" alt="Registro" width="32" height="32" border="0" longdesc="Registro de Medios" /></a></span></div></td>
    <td><div align="center" class="vistauser2"><a href="categ_medios.php"><img src="images/tipos.jpg" width="32" height="32" border="0" class="vistauser2" /></a></div></td>
  </tr>
  <tr> 
    <td><div align="center" class="vistauser1"><a href="registromedios1.php" class="Estilo3"><?php echo $btregmedio;?></a></div></td>
    <td class="Estilo3"><div align="center" class="vistauser2"><a href="registroareas.php"><?php echo $btAreas;?></a> 
      </div></td>
    <td><div align="center" class="vistauser2"><a href="categ_medios.php" class="vistauser1"><em><?php echo $btcategmedios;?></em></a> </div></td>
  </tr>
  <tr> 
    <td height="46"><div align="center" class="vistauser1"><a href="reg_claves_sistema.php"><img src="images/claves.jpg" width="32" height="32" border="0" class="vistauser2" /></a></div></td>
    <td class="vistauser1" ><div align="center"><a href="traspasos.php"><img src="images/traspaso.jpg" width="32" height="32" border="0" /></a></div></td>
    <td class="vistauser1"><div align="center"><a href="plan_mtto.php"><img src="images/254.jpg" width="32" height="32" border="0" /></a></div></td>
  </tr>
  <tr> 
    <td height="32"><div align="center" class="vistauser1"><em><strong><a href="reg_claves_sistema.php"><?php echo $btClaves;?></a></strong></em></div></td>
    <td ><div align="center" class="vistauser1"><a href="traspasos.php"><em><?php echo $bttrasp;?></em></a></div></td>
    <td><div align="center" class="vistauser2"><a href="plan_mtto.php"><em><?php echo $btpmtto;?></em></a> </div></td>
  </tr>
  <tr> 
    <td height="32"><div class="vistauser1" align="center"><a href="salva.php"><img src="images/exp.png" width="32" height="32" border="0" /></a></div></td>
    <td ><div class="vistauser1" align="center"><a href="restaura.php"><img src="images/imp.png" width="32" height="32" border="0" /></a></div></td>
    <td><div class="vistauser1" align="center"><a href="edicion/edit_creditos.php"><img src="images/invest.png" width="32" height="32" border="0" /></a></div></td>
  </tr>
  <tr> 
    <td height="32"><div align="center" class="vistauser1"><em><strong><a href="salva.php"><?php echo $btsalvas;?></a></strong></em></div></td>
    <td ><div align="center" class="vistauser1"><a href="restaura.php"><em><?php echo $btrestaurar." ".$btsalvas;?></em></a></div></td>
    <td><div align="center" class="vistauser1"><em><strong><a href="edicion/edit_creditos.php"><?php echo $btManuales;?></a></strong></em></div></td>
  </tr>
  <tr> 
    <td height="32"><div class="vistauser1" align="center"><a href="registrocustodio.php"><img src="images/addusers.png" width="32" height="32" border="0" /></a></div></td>
    <td ><div class="vistauser1" align="center"><a href="res.php?e=s"><img src="images/glosario.png" width="32" height="32" border="0" /></a></div></td>
    <td><div class="vistauser1" align="center"><a href="usb.php"><img src="images/usb.jpg" width="32" height="32" border="0" /></a></div></td>
  </tr>
  <tr> 
    <td height="32"><div align="center" class="vistauser1"><a href="registrocustodio.php"><?php echo $btCustodios;?>-AFT</a></div></td>
    <td ><div align="center" class="vistauser1"><a href="res.php?e=s"><em><?php echo $bteditar." ".$btResoluciones;?></em></a></div></td>
    <td><div align="center" class="vistauser1"><a href="usb.php"><em><?php echo $Memorias;?></em></a></div></td>
  </tr>
</table>
</fieldset>
</div>
<div id= "Preferencias">
<fieldset class='fieldset'>
<legend><?php echo $leyenda[1];?></legend> 
<div align="center" class="mosimage_caption"><strong><?php echo strtoupper($leyenda[1]);?></strong> --><?php echo $btdatabase;?>:</strong> <font color="red"><?php echo $database_miConex;?></font></div>
<form action="procesa.phtml" name="formulario" id="formulario" method="GET">
<input type="checkbox" name="check1" checked><?php echo $btcreasalva;?>.<br>
<input type="checkbox" name="check2"> <?php echo $btrecur;?><br>
<input type="checkbox" name="check3" checked> <?php echo $Opcion;?> 3</form>
</fieldset>
</div>
<div id= "Herramientas">
<fieldset class='fieldset'>
<legend><?php echo $leyenda[2];?></legend> 
<div align="center" class="mosimage_caption"><strong><?php echo strtoupper($leyenda[2]);?></strong> --><?php echo $btdatabase;?>:</strong> <font color="red"><?php echo $database_miConex;?></font></div>
</fieldset>
</div>
<div id= "varias">
<fieldset class='fieldset'>
<legend><?php echo $leyenda[3];?></legend> 
<div align="center" class="mosimage_caption"><strong><?php echo strtoupper($leyenda[3]);?></strong> --><?php echo $btdatabase;?>:</strong> <font color="red"><?php echo $database_miConex;?></font></div>
</fieldset>
</div>
<hr>
<div class="Footer-inner" align="center">
	<div class="Footer-text" align="center">
		<?php include ("version.php"); ?>
	</div>
</div>
<script>escondetodo(); </script>
