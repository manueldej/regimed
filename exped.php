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

@session_start(); include('chequeo.php');
if (!check_auth_user()){
	header ("Location: index.php");
	exit;
}
 require_once('connections/miConex.php'); 
 echo "EXPEDIENTE DEL MEDIO";  
 echo $_POST ['idarea']; 
 echo $_POST ['inv']; 
 
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO exp (idarea, inv, CPU, PLACA, CHIPSET, MEMORIA, MEMORIA2, GRAFICS, DRIVE1, DRIVE2, DRIVE3, DRIVE4, SONIDO, RED, RED2, OS) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idarea'], "int"),
                       GetSQLValueString($_POST['inv'], "text"),
                       GetSQLValueString($_POST['CPU'], "text"),
                       GetSQLValueString($_POST['PLACA'], "text"),
                       GetSQLValueString($_POST['CHIPSET'], "text"),
                       GetSQLValueString($_POST['MEMORIA'], "text"),
                       GetSQLValueString($_POST['MEMORIA2'], "text"),
                       GetSQLValueString($_POST['GRAFICS'], "text"),
                       GetSQLValueString($_POST['DRIVE1'], "text"),
                       GetSQLValueString($_POST['DRIVE2'], "text"),
                       GetSQLValueString($_POST['DRIVE3'], "text"),
                       GetSQLValueString($_POST['DRIVE4'], "text"),
                       GetSQLValueString($_POST['SONIDO'], "text"),
                       GetSQLValueString($_POST['RED'], "text"),
                       GetSQLValueString($_POST['RED2'], "text"),
                       GetSQLValueString($_POST['OS'], "text"));

  
  $Result1 = mysqli_query($insertSQL, $miConex) or die(mysql_error());

  $insertGoTo = "registromedios1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<fieldset class="fieldset"><legend class="vistauserx">Expediente</legend>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Area:</td>
      <td><input name="idarea" type="text" value="<?php echo $_GET ['idarea']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">No. Inv:</td>
      <td><input type="text" name="inv" value="<?php echo $_GET ['inv']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">CPU:</td>
      <td><input type="text" name="CPU" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">PLACA:</td>
      <td><input type="text" name="PLACA" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">CHIPSET:</td>
      <td><input type="text" name="CHIPSET" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">MEMORIA1:</td>
      <td><input type="text" name="MEMORIA" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">MEMORIA2:</td>
      <td><input type="text" name="MEMORIA2" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">GRAFICS:</td>
      <td><input type="text" name="GRAFICS" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">DRIVE1:</td>
      <td><input type="text" name="DRIVE1" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">DRIVE2:</td>
      <td><input type="text" name="DRIVE2" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">DRIVE3:</td>
      <td><input type="text" name="DRIVE3" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">DRIVE4:</td>
      <td><input type="text" name="DRIVE4" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">SONIDO:</td>
      <td><input type="text" name="SONIDO" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">RED:</td>
      <td><input type="text" name="RED" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">RED2:</td>
      <td><input type="text" name="RED2" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">OS:</td>
      <td><input type="text" name="OS" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<br><hr width="70%" align="center">
<div class="Footer-inner" align="center">
	<div class="Footer-text" align="center">
		<?php include ("version.php"); ?>
	</div>
</div>
</fieldset>
