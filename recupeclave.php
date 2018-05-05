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

	if (!file_exists('connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="installation/index.php";</script><?php
		return;
	}
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="shortcut icon" href="images/pantalla.ico" />
    <title><?php echo $bttitulo;?></title>
<?php
require_once('connections/miConex.php');

 $os ="";
 $option_block ="";
 $usuario ="";
?>
<script type="text/javascript" src="js/script.js"></script>
	<!--<link rel="stylesheet" href="css/bubble.css" type="text/css" media="screen" /> -->
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->

<style type="text/css">
<!--
@import url("css/system-message.css");


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

.PostFooterIcons, .PostFooterIcons a, .PostFooterIcons a:link, .PostFooterIcons a:visited, .PostFooterIcons a:hover
{
  font-family: Verdana, Geneva, Arial, Helvetica, Sans-Serif;
  font-size: 11px;
  text-decoration: none;
  color: #767232;
}

.PostFooterIcons a, .PostFooterIcons a:link, .PostFooterIcons a:visited, .PostFooterIcons a:hover
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

.PostFooterIcons a:hover, .PostFooterIcons a.hover
{
  font-family: Verdana, Geneva, Arial, Helvetica, Sans-Serif;
  text-decoration: none;
  color: #4D5D66;
}

-->
</style>
<link href="css/template.css" rel="stylesheet" type="text/css" />
</head>
<body>
<style type="text/css">
<!--
.Estilo2 {
	color: #58919C;
	font-weight: bold;
}
-->

<!--
#Layer1 {
	position:absolute;
	left:12px;
	top:3px;
	width:360px;
	height:19px;
	z-index:1;
}

div.message {
	font-family : "trebuchet MS", Arial, Helvetica, sans-serif;
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
 <SCRIPT LANGUAGE="JavaScript">
	function cierrz(){
		document.getElementById('cir').innerHTML="";
	}
	function chequea(){
		var tt= document.form1;
		var re=/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/ 
		if((tt.nomb.value) ==""){
			tt.nomb.focus();
			showAlert(4000,'<div class="alert negro" style="display: none"><button class="closex" type="button" onclick="cierrz();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $plea2.$apodo;?>.</b></div></div>');
			return false;
		}else if((tt.email.value) ==""){
			tt.email.focus();
			showAlert(4000,'<div class="alert negro" style="display: none"><button class="closex" type="button" onclick="cierrz();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $plea2.$SU.$electron;?>.</b></div></div>');
			return false;
		}else if (!re.exec(tt.email.value)){
			tt.email.focus();
			tt.email.value="";
			showAlert(4000,'<div class="alert negro" style="display: none"><button class="closex" type="button" onclick="cierrz();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $no_addres;?>.</b></div></div>');
			return false;
		}	
	}
  </SCRIPT>
    <table width="357" border="0" class="table">
    <form action="recupeclaveuser.php" name="form1" method="post"  onSubmit="return chequea()">
		<tr bgColor='#66CCFF'>
            <td width='63' bgcolor="#FFFFFF">&nbsp;</td>
            <td width='300' bgcolor="#FFFFFF"></td>
        </tr>
        <tr>
            <td><div align="right"><strong><?php echo $btNombre;?>: </strong></div></td>
            <td align='left'><input type="text" class="form-control" required name='nomb' id="nomb" size='45' maxLength='50'></td>
        </tr>
        <tr>
            <td><div align="right" ><strong><?php echo $electron2;?>:</strong></div></td>
            <td align='left'><input class="form-control" required name='email' id="email" type="email" size='45' maxLength='50'></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align='left'><input name="submit" class="btn" type='submit' value="<?php echo strtoupper($btaceptar); ?>"></td>
        </tr>
    </table>
</form>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
</body>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</html>