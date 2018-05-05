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
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript" >
// Check for a blank field
function submit_page(form){
 foundError = false;
 
 if(isFieldBlank(form.t1)) {
  alert("El campo 'Login' está en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.t2)) {
  alert("El campo 'password' está en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.t3)) {
  alert("El campo 'email' está en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.t4)) {
  alert("El campo 'cargo' está en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.t5)) {
  alert("El campo 'Nombre' está en blanco.");
  foundError = true;
 }else
 
 if(foundError == false )
  document.form1.action="insertar.php";
 else
   document.form1.action="javascript:goHist(-1)";
}

function retornar(form)
{
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
 
  for(var i=0; i<Len; i++)
  {
   var ch = val.substring(i,i+1)
   if(ch < "0" || "16"< ch)
     return true;
  }
}

function ci(theField)  {
 val = theField.value;
 Len = val.length;

  for(var i=0; i<Len; i++)
    var chh = val.substring(i,i+1)
    
  if(i < "16")
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
<fieldset class="fieldset">
<table width="200" border=0 align=left bgcolor='#FFFFFF' table >
    <tr>
      <td ><table width="228" border="0" align="left" background="index.php_files/libreria_17.gif" bgcolor="#FFFFFF">
        <form name="form1" method="post" action="" >     
          <tr>
            <td colspan="4"></td>
          </tr>
          <tr>
            <td width="68"><div align="right" class="Estilo4">login</div></td>
            <td colspan="2"><input name="t1" type="text" id="t12"></td>
            <td width="8">&nbsp;</td>
          </tr>
          <tr>
            <td><div align="right" class="Estilo4">passwd</div></td>
            <td colspan="2"><input name="t2" type="text" id="t22" size="16" maxlength="16"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div align="right" class="Estilo4">email</div></td>
            <td colspan="2"><input name="t3" type="text" id="t32" maxlength="50"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div align="right" class="Estilo4">cargo</div></td>
            <td colspan="2"><input name="t4" type="text" id="t33" size="40" maxlength="40"></td>
            <td>&nbsp;</td>
	      </tr>
          <tr>
            <td><div align="right" class="Estilo4">nombre</div></td>
            <td colspan="2"><input name="t5" type="text" id="t35" maxlength="50"></td>
            <td>&nbsp;</td>
		    <td width="59" align="right"><input type="submit" name="insertar" value="Guardar" onClick="submit_page(this.form)"></td>
		    <td width="75" align="left"><input type="submit" name="Submit2" value="VolVer" onClick="retornar(this.form)"></td>
		    <td>&nbsp;</td>
          </tr>	 
        </form>	
      </table></td>
    </tr>
</table>
<br><hr width="70%" align="center">
<div class="Footer-inner" align="center">
	<div class="Footer-text" align="center">
		<?php include ("version.php"); ?>
	</div>
</div>
</fieldset>
