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
include('header.php');
include ('script.php');
$validus = "";
if(isset($_SESSION["autentificado"])){
	$validus = " AND idunidades='".$_SESSION["autentificado"]."'";
}elseif (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$validus = " AND idunidades='".$_COOKIE['unidades']."'";
}else{
	$validus = "";
}
$us1 = mysqli_query("select * from usuarios where login='".$_SESSION ["valid_user"]."'",$miConex) or die(mysql_error());
$rus1 = mysqli_fetch_array($us1);
if(($rus1['tipo']) !="root"){ ?>
	<script type="text/javascript">document.location="v1.php?marcado[0]=<?php echo $rus1['id'];?>&editar";</script><?php exit;
}
$i=0;
$palabra="";
if(isset($_GET['palabra'])){ $palabra = $_GET['palabra'];}

$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$cuantos = 5;
if(($rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
///////navegador
		$inicio = 0;
		$pagina = 1;
		$registros = $cuantos;
	if(isset($_GET["registros"])) {
		$registros = $_GET["registros"];
		$inicio = 0;
		$pagina = 1;
	}
	if(isset($_GET['pagina']))  {
		$pagina=$_GET['pagina'];
		$inicio = ($pagina - 1) * $registros;
	}
	if(isset($_GET["mostrar"])) {
		$registros = $_GET["mostrar"];
		if(($registros) ==0){ $registros=1;}
		$inicio = 0;
		$pagina = 1;
	}
///////////
	if(($palabra) =="") 	{
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$sql = "select * from usuarios WHERE idunidades = '".$_COOKIE['unidades']."'";
			$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
		}else{
			$sql = "select * from usuarios";
			$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);	
		}
	}else{
		$sql = "SELECT * FROM usuarios WHERE  login LIKE '%".$palabra."%' or nombre LIKE '%".$palabra."%' or idunidades = '".$palabra."'";
		$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
	}
	$result= mysqli_query($query_limit);
//NAVEGADOR inicio
	if(isset($_GET['total_registros'])){
		$total_registros=$_GET['total_registros'];
	} else {
		$all_rsDA = mysqli_query($sql);
		$total_registros = mysqli_num_rows($all_rsDA);
	}
	$total_paginas = ceil($total_registros / $registros);
//NAVEGADOR	FIN ?>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="js/main.js"></script>
  <script src="js/jquery.tools.min.js"></script>  
  <style>
	a:active {
		outline:none;
	}

	:focus {
		-moz-outline-style:none;
	}
    .modal {
    background-color:#fff;
    display:none;
    width:350px;
    padding:15px;
    text-align:left;
    border:2px solid #333;
    opacity:0.8;
  }

  </style>
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript">
	function hacer(valo){
		document.location="v1.php?marcado[]="+valo+"&modificar=Modificar";

	}
	function limpia(){
		document.getElementById('palabra1').value ="";
	}
</script>

<?php include('barra.php');?>
<link href="css/template.css" rel="stylesheet">
<div id="buscad">
<fieldset class="fieldset"><legend class="vistauserx"><?php echo $mostrar1.$de.$new6; ?></legend>
<h1 align="CENTER" class="vistauser1 Estilo3"><?php echo strtoupper($mostrar1.$de.$new6);?></h1>
<div class="modal" id="yesno">
		<div align="justify"><div><?php echo $seguro;?></div></div>
		<div align="left">
		    <button class="close"><?php echo $btcancelar?></button>
			<button class="close"> <?php echo $btaceptar?></button>
		</div>
</div>
<table width="60%" border="0" align="right" cellpadding="0" cellspacing="0">
	<tr>
		<td><input name="palabra2" type="text" id="palabra1" size="20" autocomplete="off" class="imput" align="middle" value="<?php echo $bttextobuscar;?>..." onKeyUp="mand(this.value);"  onClick="limpia();"/></td>
	</tr>
</table>
<div id="vistausua">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><form action="" method="get" name="form1">
					<input name="pagina" type="hidden"  value="<?php echo $pagina;?>">
					<span ><?php echo $cantidadmost;?>:</span>
					<input name="mostrar" type="text" size="1" value="<?php if(isset($_GET["mostrar"])){ echo $_GET["mostrar"];}elseif(isset($_GET["registros"])){ echo $_GET["registros"];}elseif(!isset($_GET["registros"]) AND !isset($_GET['mostrar'])){ echo $rsel['visitas'];}elseif(($rsel['visitas']) ==""){ echo "5";}?>" onKeyPress="return acceptNum(event);" class="mostrar">
					<input name="mo"  type="submit" value="<?php echo $btver;?>" class="btn4">
					<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
					<input name="palabra" type="hidden"  value="<?php echo $palabra;?>">
					<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">
				</form>			</td>
          </tr>
        </table><br>
		<form name="frm1" method="post" action="v1.php">
			<TABLE width="100%" BORDER='0' class='table' cellpadding="0" cellspacing="0">
				<tr>
					<td width="20"><b></b></td>
				  <td width="69" align='center' class="vistauser1"><div align="left">Login</div></td>
				  <td width="164" align='center' class="vistauser1"><div align="left"><b><?php echo $btNombre;?></b></div></td>
				  <td width="95" align='center' class="vistauser1"><div align="left"><b><?php echo $btnCargo;?></b></div></td>
				  <td width="165" align='center' class="vistauser1"><div align="left"><b>E-mail</b></div></td>
				  <td width="150" align='center' class="vistauser1"><div align="left"><b><?php echo ucwords($btAreas1);?></b></div></td>
				  <td width="92" align='center' class="vistauser1"><div align="center"><b><?php echo $Sexo;?></b></div></td>
				  <td width="186" align='center' class="vistauser1"><div align="center"><b><?php echo $btdatosentidad3;?></b></div></td>
				</tr>  
				<?php   	
				$id = 0;
				$p=0;
					//$arreg = array();
				while($row=mysqli_fetch_array($result))    {  $i++;
					$selent=mysqli_query("select * from datos_generales where id_datos='".$row['idunidades']."'",$miConex) or die(mysql_error()); 
					$rselun=mysqli_fetch_array($selent); ?>
					<tr bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" id="cur_tr_<?php echo $p;?>" onDblClick="hacer('<?php echo $row["id"]?>');" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#DBE2D0');"  onclick="marca1(<?php echo $p;?>,'#ffffff')">
						<td><input name="marcado[]" type="checkbox" class="boton" id="marcado[<?php echo $p;?>]" onClick="marca1(<?php echo $p;?>,'#ffffff')" value="<?php echo $row["id"]?>" /></td>
						<td><?php echo $row["login"];?></td>
						<td><?php echo $row["nombre"];?></td>
						<td><?php echo $row["cargo"];?></td>
						<td><?php echo $row["email"];?></td>
						<td><?php echo $row["idarea"];?></td>
						<td align="center"><?php if(($row["sexo"]) =="m"){ echo "Femenino";} elseif(($row["sexo"]) =="h"){ echo "Masculino";}else{ echo "-";}?> </td>						
				        <td><?php echo $rselun['entidad'];?></td>
			          <?php  	$p++;	 
				} ?>
					<tr>
					  <td colspan="8"><hr /></td>
					</tr>
					<tr>
					  <td colspan="8"><img src="images/check_all.png" name="marcart" width="17" height="17" border="0" usemap="#marcart" id="marcart" title="<?php echo $sel_all;?>" onClick='marcar_todo();' onMouseOVer="this.style.cursor='pointer';">&nbsp;<img src="images/uncheck_all.png" name="desmarcart" width="17" height="17" id="desmarcart" title="<?php echo $des_all;?>" onClick='desmarcar_todo();' onMouseOVer="this.style.cursor='pointer';"></td>
					</tr>
			  <tr>
					  <td colspan="8">
					  <button class="btn" rel="#yesno"><?php echo $bteliminar;?></button>
						<input type="hidden" name="crash">&nbsp;&nbsp;
			<input name="editar" type="submit" class="btn" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');" value="<?php echo $bteditar;?>" />
			&nbsp;&nbsp;
			<input name="insertar" type="button" class="btn"  value="<?php echo $btinsertar;?>" onclick="document.location='registro2.php';" /></td>
			</tr>
		</table>
			<?php include('navegador.php');?>
		</form>
	</div>
</div>
<br>
<div id="footer" class="degradado" align="center">
	<div class="container">
		<p class="credit"><?php include ("version.php");?></p>
	</div>
</div>
</fieldset>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script>
$(document).ready(function() {
    var triggers = $(".btn").overlay({

      // some mask tweaks suitable for modal dialogs
      mask: {
        color: '#ebecff',
        loadSpeed: 200,
        opacity: 0.9
      },

      closeOnClick: true
  });
  
    var buttons = $("#yesno button").click(function(e) {

      // get user input
      var yes = buttons.index(this) === 0;
      // do something with the answer
     // triggers.eq(0).html("You clicked " + (yes ? "yes" : "no"));
  });
  
    $("#prompt form").submit(function(e) {

      // close the overlay
      triggers.eq(1).overlay().close();

      // get user input
      var input = $("input", this).val();

      // do something with the answer
      triggers.eq(1).html(input);

      // do not submit the form
      return e.preventDefault();
  });
  });
</script>
