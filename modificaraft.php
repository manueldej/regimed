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
?>

<?php 
@session_start(); include('chequeo.php');
if (!check_auth_user()){
	header ("Location: index.php");
	exit;
}
require_once('connections/miConex.php'); 

$query_Recordset1 = "SELECT * FROM usuarios";
$Recordset1 = mysqli_query($miConex, $query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$query_Recordset2 = "SELECT * FROM tipos_medios";
$Recordset2 = mysqli_query($miConex, $query_Recordset2) or die(mysql_error());
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$query_Recordset3 = "SELECT * FROM areas";
$Recordset3 = mysqli_query($miConex, $query_Recordset3) or die(mysql_error());
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$query_Recordset4 = "SELECT * FROM tipos_aft";
$Recordset4 = mysqli_query($miConex, $query_Recordset4) or die(mysql_error());
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);

$query="select* from aft where inv='$_SESSION[id]'";
$result=mysqli_query($miConex, $query);
$row = mysqli_fetch_array ($result);

$query1="select* from areas where idarea='".$row['idarea']."'";
$result1=mysqli_query($miConex, $query1);
$row1 = mysqli_fetch_array ($result1);

$query2="select* from tipos_medios where nombre='".$row['categ']."'";
$result2=mysqli_query($miConex, $query2);
$row2 = mysqli_fetch_array ($result2);

$query3="select* from usuarios where nombre='".$row['custodio']."'";
$result3=mysqli_query($miConex, $query3);
$row3 = mysqli_fetch_array ($result3);
?>
<script language="JavaScript" >

// chequear campos en blanco 
function submit_page(form){
 foundError = false;
 
 if(isFieldBlank(form.t1)) {
  alert("El campo 'Inv' est� en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.t2)) {
  alert("El campo 'Descripci�n' est� en blanco.");
  foundError = true;
 }else
  if(isFieldBlank(form.t5)) {
  alert("El campo 'Sello' est� en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.t6)) {
  alert("El campo 'Marca' est� en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.t7)) {
  alert("El campo 'No. de Serie' est� en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.t8)) {
  alert("El campo 'Modelo' est� en blanco.");
  foundError = true;
 }else
 
  if(isFieldBlank(form.t10)) {
  alert("El campo 'Tipo' est� en blanco.");
  foundError = true;
 }else
 
 if(foundError == false )  document.form1.action="insertaraft.php";
 else
   document.form1.action="javascript:goHist(-1)";
}

function retornar(form){
 document.form1.action="registromedios1.php";
}
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
   if(ch < "0" || "9"< ch)
     return true;
  }
}

function ci(theField){
 val = theField.value;
 Len = val.length;

  for(var i=0; i<Len; i++)
    var chh = val.substring(i,i+1)

  if(i < "11")
    return true;
}
</script>
<style type="text/css">
<!--
.Estilo2 {
	color: #0099CC;
	font-weight: bold;
}
.Estilo3 {color: #009999}
.Estilo4 {color: #336666; font-weight: bold; }

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
<link href="css/template.css" rel="stylesheet" type="text/css">
<div id="buscad">
<fieldset class="fieldset"><legend class="vistauserx"><?php echo "Modificando AFT:<font color=blue><strong> ".$row["inv"]; ?></legend>
<form action="" method="post" name="form1" class="contentheading">
<table width="200" border="0" align="center" >
  <tr>
    <td ><table width="256" border="0" align="center">
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5"><div align="center"></div></td>
        </tr>
        <tr>
          <td width="89"><div align="right" class="contentheading">Inv</div></td>
          <td colspan="3"><input name="t1" type="text" value="<?php echo $row["inv"]?>" size="11" maxlength="11"></td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr>
          <td><div align="right" class="contentheading">Descripci&oacute;n</div></td>
          <td colspan="3"><input name="t2" type="text" value="<?php echo $row["descrip"]?>" size="40" maxlength="300" ></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="right" class="contentheading">Estado</div></td>
          <td colspan="3"><p>
            <label>
            <select name="t3" size="1" id="t3">
              <option value="A">Activo</option>
              <option value="R">Roto</option>
              <option value="T">Taller</option>
            </select>
            </label>
            <label></label>
            </p>          </td>
          <td>&nbsp;</td>
	  </tr>
        <tr>
		  <td><div align="right" class="contentheading">Area</div></td>
          <td colspan="3"><p>
            <label>
            <select name="t4" size="1" id="t4">
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset3['idarea']?>" <?php if(($row1['idarea']) ==$row_Recordset3['idarea']){ echo "selected";}?>><?php echo $row_Recordset3['nombre']?></option>
              <?php
} while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
  $rows = mysqli_num_rows($Recordset3);
  if($rows > 0) {
      mysqli_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
  }

?>
            </select>
            </label>
            <label></label>
            </p>          </td>
		  <td>&nbsp;</td>
	  </tr>
        <tr>
		  <td><div align="right" class="contentheading">Sello</div></td>
          <td colspan="3"><p>
            <input name="t5" type="text" id="t34" value=<?php echo $row["sello"]?> size="40"  maxlength="50">
            <label></label>
        </p>        </tr>
		<tr>
		  <td><div align="right" class="contentheading">Marca</div></td>
          <td colspan="3"><p>
            <input name="t6" type="text" id="t34" value=<?php echo $row["marca"]?> size="40"  maxlength="50">
            <label></label>
        </p>        </tr>
		<tr>
		  <td><div align="right" class="contentheading">Serie</div></td>
          <td colspan="3"><p>
            <input name="t7" type="text" id="t34" value=<?php echo $row["no_serie"]?> size="40"  maxlength="50">
            <label></label>
        </p>        </tr>
		<tr>
		  <td><div align="right" class="contentheading">Modelo</div></td>
          <td colspan="3"><p>
            <input name="t8" type="text" id="t34" value=<?php echo $row["modelo"]?> size="40"  maxlength="50">
            <label></label>
        </p>        </tr>
		<tr>
		  <td><div align="right" class="contentheading">Categoria</div></td>
          <td colspan="3"><p>
            <label>
            <select name="t9" size="1" id="t9">
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset2['nombre']?>"<?php if(($row2['nombre']) ==$row_Recordset2['nombre']){ echo "selected";}?>><?php echo $row_Recordset2['nombre']?></option>
              <?php
} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
  $rows = mysqli_num_rows($Recordset2);
   if($rows > 0) {
      mysqli_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
 
	 
  }
?>
            </select>
            </label>
            <label></label>
        </p>        </tr>
		<tr>
		  <td><div align="right" class="contentheading">Tipo</div></td>
          <td colspan="3"><p>
            <label>
            <input name="t10" type="text" id="t10" value="<?php echo $row["tipo"]?>">
            </label>
            <label></label>
        </p>        </tr>
       <tr>
	   <td><div align="right" class="contentheading">Custodio</div></td>
          <td colspan="3"><p>
            <label>
            <select name="t11" size="1" id="t11">
              <?php
do {  
?><option value="<?php echo $row_Recordset1['nombre']?>"<?php if(($row3['nombre']) ==$row_Recordset1['nombre']){ echo "selected";}?> ><?php echo $row_Recordset1['nombre']?></option>
              <?php
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
  $rows = mysqli_num_rows($Recordset1);
  if($rows > 0) {
      mysqli_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
  }
?>
            </select>
            </label>
            <label></label>
        </p>        </tr>
       <tr>
	    <tr>
	   <td><div align="right" class="contentheading">Tipo AFT </div></td>
          <td colspan="3"><p>
            <label>
            <select name="t12" size="1" id="t12">
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset4['categoria']?>"><?php echo $row_Recordset4['categoria']?></option>
              <?php
} while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
  $rows = mysqli_num_rows($Recordset4);
  if($rows > 0) {
      mysqli_data_seek($Recordset4, 0);
	  $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
  }
?>
            </select>
            </label>
            <label></label>
        </p>        </tr>
       <tr>
	    <td></td>
		  <td width="59" align="right"><input type="submit" name="editar" value="Guardar" onClick="submit_page(this.form)"></td>
		  <td width="75" align="left"><input type="submit" name="Submit2" value="VolVer" onClick="retornar(this.form)"></td>
		  <td>&nbsp;</td>
      </tr>	 
</form>	
    </table></td>
  </tr>
<br><hr width="70%" align="center">
<div class="Footer-inner" align="center">
	<div class="Footer-text" align="center">
		<?php include ("version.php"); ?>
	</div>
</div>
</fieldset>
</div>
<?php
mysqli_free_result($Recordset1);
mysqli_free_result($Recordset2);
mysqli_free_result($Recordset3);
mysqli_free_result($Recordset4);
?>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="js/main.js"></script>
