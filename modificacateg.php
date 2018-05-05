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
?>
<?php 
@session_start(); include('chequeo.php');
if (!check_auth_user()){
	header ("Location: index.php");
	exit;
}
require_once('connections/miConex.php'); 
;

$query="select* from tipos_medios where id='$_SESSION[id]'";
$result=mysqli_query($query);
$row = mysqli_fetch_array ($result);
?>
<html>
<script language="JavaScript" >

// chequear campos en blanco 
function submit_page(form){
 foundError = false;

 if(isFieldBlank(form.t1)) {
  alert("El campo 'NO' esta en blanco.");
  foundError = true;
 }
 else
 if(isFieldBlank(form.t2)) {
  alert("El campo 'NOMBRE' est� en blanco.");
  foundError = true;
 }
 else
 if(foundError == false )  document.form1.action="insertacateg.php";
 else
   document.form1.action="javascript:goHist(-1)";
}

function retornar(form){
 document.form1.action="categ_medios.php";
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

function ci(theField) {
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
<fieldset class="fieldset"><legend class="vistauserx"><?php echo "Modificar Categor�a:<font color=blue><strong> ".$row["id"]; ?></legend>
<table width="248" border="0" align='center' >
  <tr>
    <td ><table width="256" border="0" align="center">
         <form action="" method="post" name="form1" >
		<tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5"><div align="center"></div></td>
        </tr>
        <tr>
          <td width="157"><div align="right" class="contentheading">No</div></td>
          <td colspan="3"><input name="t1" type="text" value="<?php echo $row["id"]?>" size="16"></td>
          <td width="15">&nbsp;</td>
        </tr>
        <tr>
          <td><div align="right" class="contentheading">NOMBRE</div></td>
          <td colspan="3"><input name="t2" type="text" value="<?php echo $row["nombre"]?>" size="16" ></td>
          <td>&nbsp;</td>
        </tr>
      	  <td width="157" align="right"><input type="submit" name="editar" value="Guardar" onClick="submit_page(this.form)"></td>
		  <td width="52" align="left"><input type="submit" name="Submit2" value="VolVer" onClick="retornar(this.form)"></td>
		  <td width="4">&nbsp;</td>
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
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="js/main.js"></script>