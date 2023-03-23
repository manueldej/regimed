<?php 
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					             	                    #
# Version:  3.1.1                                                    				            #
# Fecha:    24/03/2011 - 01/01/2023                                             			    #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   							    #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)						    #
# Licencia: Freeware                                                				            #
#                                                                       			            #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                 #
# LICENCIA: Este archivo es parte de REGIMED. REGIMED es un software libre; Usted lo puede redistribuir y/o #
# lo puede modificar bajo los términos de la Licencia Pública General GNU publicada por la Fundación de     #
# Software Gratuito (the Free Software Foundation ); Ya sea la versión 2 de la Licencia, o (en su opción)   #
# cualquier posterior versión. REGIMED es distribuido con la esperanza de que será útil, pero SIN CUALQUIER #
# GARANTÍA; Sin aún la garantía implícita de COMERCIABILIDAD o ADAPTABILIDAD PARA UN PROPÓSITO PARTICULAR.  #
# Vea la Licencia Pública General del GNU para más detalles. Usted debería haber recibido una copia de la   #
# Licencia  Pública General de GNU junto con REGIMED. En Caso de que No, vea <http://www.gnu.org/licenses>. #
#############################################################################################################
@session_start(); include('chequeo.php');
if (!check_auth_user()){
	header ("Location: index.php");
	exit;
}
require_once('connections/miConex.php');
?>
<script language="JavaScript" >
// chequear campos en blanco 
function submit_page(form){
 foundError = false;

 if(isFieldBlank(form.t1)) {
  alert("El campo 'login' esta en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.t2)) {
  alert("El campo 'clave' esta en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.t3)) {
  alert("El campo 'email' esta en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.t4)) {
  alert("El campo 'cargo' esta en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.t5)) {
  alert("El campo 'Nombre' esta en blanco.");
  foundError = true;
 } else
 
 if(foundError == false )
  document.form1.action="insertar.php";
 else
   document.form1.action="javascript:goHist(-1)";
}

function retornar(form){
 document.form1.action="ej1.php";
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

function ci(theField)  {
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
<link href="css/template.css" rel="stylesheet" type="text/css" />
<fieldset class="fieldset">
<div  class="message"><?php //echo "Modificando Usuario:<font color='blue'> ".$row["login"]."</font> "; ?></div>
<form name="form1" method="post" action="">
<table width="484"  border="0" align="center">
<?php 
$marcado = $_POST['marcado'];
foreach($marcado as $key=> $val){
 echo $key.">>".$val."<br>";
}
	for($i=0; $i< count($marcado); $i++){
		$query="select* from usuarios where id='".$marcado[$i]."'";
		$result=mysqli_query($query) or die(mysql_error());
		$row = mysqli_fetch_array ($result);
		?>
		<tr>
          <td width="187"><div align="right" class="Estilo4">Login:</div></td>
          <td colspan="4"><input name="t1" type="text" value="<?php echo $row["login"]?>" size="16"></td>
        </tr>
        <tr>
          <td><div align="right" class="Estilo4">Clave:</div></td>
          <td colspan="4"><input name="t2" type="text" value="<?php echo base64_decode($row["passwd"]);?>" size="16" ></td>
        </tr>
        <tr>
          <td><div align="right" class="Estilo4">E-Mail:</div></td>
          <td colspan="4"><p>
            <input name="t3" type="text" id="t3"  maxlength="16" value=<?php echo $row["email"]?>>
            <label></label>
            </p>          </td>
      </tr>
        <tr>
		  <td><div align="right" class="Estilo4">Cargo:</div></td>
          <td colspan="4"><p>
            <input name="t4" type="text" id="t4"  maxlength="40" value=<?php echo $row["cargo"]?>>
            <label></label>
            </p>          </td>
	  </tr>
        <tr>
		  <td><div align="right" class="Estilo4">Nombre:</div></td>
          <td colspan="3"><p>
            <input name="t5" type="text" id="t5"  maxlength="50" value=<?php echo $row["nombre"]?>>
            <label></label>
        </p>        </tr>
		<tr><td colspan="3"><hr></td></tr>		<?php 
	} ?>
       <tr>
          <td></td>
		  <td width="89" align="right"><input type="submit" name="editar" value="Guardar" onClick="submit_page(this.form)"></td>
		  <td width="194" align="left"><input type="submit" name="Submit2" value="VolVer" onClick="retornar(this.form)"></td>
      </tr>
    </table>
	</form>
<br><hr width="70%" align="center">
<div class="Footer-inner" align="center">
	<div class="Footer-text" align="center">
		<?php include ("version.php"); ?>
	</div>
</div>
</fieldset>

