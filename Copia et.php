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
require("mensaje.php");
$palabra ="";
$dde="";
$varCPU = array('marca','cpuid','frecuencia','fabricante','socket','cpucores','cpulogicos');
$varMemorias = array('marca','modelo','no_serie','fabricante','capacidad','tasa','frecuencia');
$varDiscoDuro = array('marca','modelo','no_serie','fabricante','capacidad','tasa','cache','rpm');
$varTarjetaGrafica = array('marca','modelo','no_serie','fabricante','capacidad','frecuencia');
$varcomponente = array($varCPU,$varMemorias,$varDiscoDuro,$varTarjetaGrafica);
$compon="";
$nombcampo=array();

	if(isset($_POST['categ'])){$categ =$_POST['categ'];}
	if(isset($_POST['marcado'])){$marcado =$_POST['marcado'];}
	if(isset($_REQUEST['inv'])){$categ =$_REQUEST['inv'];}
    if(isset($_REQUEST['categ'])){$categ =$_REQUEST['categ'];}
	if(isset($_REQUEST['idunidades'])){$idunidadesc =$_REQUEST['idunidades'];}
	if(isset($_REQUEST['cut'])){$nom_custo =$_REQUEST['cut'];}
	if(isset($_REQUEST['marcado'])){$marcado =$_REQUEST['marcado'];}
	if(isset($_REQUEST['palabra'])){$palabra =$_REQUEST['palabra'];}
	if(isset($_REQUEST['dde'])){$dde =$_REQUEST['dde'];}
	if(isset($_REQUEST['compon'])){$compon =$_REQUEST['compon'];}
	if(isset($_REQUEST['compo'])){$compo =$_REQUEST['compo'];}
	
	if(isset($_REQUEST['compo'])){
	    $sql1 ="SELECT * FROM componentes WHERE nombre ='".$compo."' AND idexp='".$categ."'";
	}else{
	  $compo ="";
	  $sql1 ="SELECT * FROM componentes";
	 }

	$result1 = mysqli_query($miConex, $sql1) or die (mysqli_error());
	$rows1 = mysqli_fetch_array($result1); 
	$cantrows = mysqli_num_rows($result1);
	   
	
	$query_Recordset4 = "SELECT * FROM usuarios where login = '".$_SESSION['valid_user']."'";
	$Recordset4 = mysqli_query($miConex, $query_Recordset4) or die(mysql_error());
	$Rerow4 = mysqli_fetch_array($Recordset4);
	
	if (isset($_REQUEST['idunidades']) AND ($_REQUEST['idunidades']) !=""){ 
		$query="select * from aft where inv='".@$categ."' AND idunidades='".$idunidadesc."'";
	}else{
		$query="select * from aft where inv='".@$categ."'";
	}

	$result=mysqli_query($miConex, $query);
	$row = mysqli_fetch_array ($result);
	$idunddes= $row["idunidades"];

	
// SQL para la busqueda
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$sql1="SELECT * FROM `exp` where inv='".@$categ."' and idunidades='".$_COOKIE['unidades']."'"; 
}elseif (isset($_REQUEST['idunidades']) AND ($_REQUEST['idunidades']) !=""){
	$sql1="SELECT * FROM `exp` where inv='".@$categ."' and idunidades='".$_REQUEST['idunidades']."'"; 
}else{
	$sql1="SELECT * FROM `exp` where inv='".@$categ."'"; 
}

$result1=mysqli_query($miConex, $sql1) or die (mysql_error());
$result2=mysqli_query($miConex, $sql1) or die (mysql_error());
$num_resultados1 = mysqli_num_rows($result1);
$num_resultados2 = mysqli_num_rows($result2);
$ggg= base64_encode($sql1);
$seledtgn = mysqli_query($miConex, "select * from datos_generales where id_datos = '".$row["idunidades"]."'")  or die (mysql_error());
$qseledtgn = mysqli_fetch_array($seledtgn);

if (isset($_REQUEST['q'])){
 $q= $_REQUEST['q'];
}else{
 $q="";
}
$sql23="SELECT * FROM exp WHERE inv ='".$categ."'"; 
$result23=mysqli_query($miConex, $sql23);
$row23 = mysqli_fetch_array($result23);
				
$sqlcomp ="SELECT * FROM componentes WHERE nombre ='".$q."' AND idexp='".$categ."'";
$resultcomp = mysqli_query($miConex, $sqlcomp) or die (mysql_error());
$rowscomp = mysqli_fetch_array($resultcomp); 
							
?>
<style type="text/css">
<!--
.Estilo6 {
	font-size: 36px;
	color: #000000;
}
.Estilo8 {
	font-size: 24px;
	margin: 0;
	margin-top: -15px;
	padding-top: 15px;
	padding-bottom: 5px;
	padding: 0;
}
.Estilo23 {font-size: 9; color: #000000; font-weight: bold; }
	.email{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -37px;
	}
	.pdf{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -117px;
	}
	.exel{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -97px;
	}
	.printer{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -17px;
	}
-->
</style>
<script language="JavaScript" >
 function seguro4(q,inv,idun,ini,donde,compon,compo,accion){
    document.wq.q.value = q;
	document.wq.action='#modal6';
	document.wq.inv.value = inv;
	document.wq.idunidades.value = idun;
	document.wq.palabra.value = ini;
	document.wq.dde.value = donde;
	document.wq.compon.value = compon;
	document.wq.compo.value = compo;
	document.wq.accion.value = accion;
	document.wq.submit();
 }
 
 function ocultacat(tipo){
	if (tipo=='hdd') {
        document.getElementById('rpm1').style.display ='block';
	    document.getElementById('rpm2').style.display ='block';
	    document.getElementById('tmem1').style.display ='none';
	    document.getElementById('tmem2').style.display ='none';
	}
	if (tipo=='memo') { 
		document.getElementById('rpm1').style.display ='none';
		document.getElementById('rpm2').style.display ='none';
		document.getElementById('tmem1').style.display ='block';
	    document.getElementById('tmem2').style.display ='block';
	}   
 }
 	function __ir(inv,idun,ini,donde){
	   var aceptaEntrar = window.confirm("\u00BFEs esta operaci\u00F3n correcta.?");
		if (aceptaEntrar) {
		  document.ir.inv.value = inv;
	      document.ir.idunidades.value = idun;
	      document.ir.palabra.value = ini;
	      document.ir.dde.value = donde;
	     document.ir.submit();
		}else{
		 return false;
		}  
	  
	}
	
	function __importa(inv,marcado,idunidades) {
	  document.creaExp.inv.value = inv;
	  document.creaExp.marcado.value = marcado;
	  document.creaExp.idunidades.value = idunidades;
	  document.creaExp.impor.value = 'kbpimpirt';
	  document.creaExp.submit();
	}
	
	function __creaExpt(inv,marcado,idunidades) {
	  document.creaExp.inv.value = inv;
	  document.creaExp.marcado.value = marcado;
	  document.creaExp.idunidades.value = idunidades;
	  document.creaExp.submit();
	}
	
	function __print(categ) {
	  document.imprime.categ.value = categ;
	  document.imprime.action="imprimir/index1.php";
	  document.imprime.target="_blank";
	  document.imprime.submit();
	}
	
</script>
<?php include('barra.php');?>
<form name="creaExp" action="form-insertarexp.php" method="post">
  <input name="inv" type="hidden">
  <input name="marcado" type="hidden">
  <input name="idunidades" type="hidden">
  <input name="impor" type="hidden">
</form>
<div id="modal6" class="modalmask" style="background: rgba(63, 57, 57, 0.7);">
	<div class="modalbox resize" style="width: 400px; <?php if($compon=="Disco Duro") { ?>height: 390px;<?php }elseif($compon=="Memorias"){ ?>height: 353px;<?php }elseif($compon=="Tarjeta Grafica"){ ?>height: 319px;<?php }elseif($compon=="Microprocesador"){ ?>height: 320px;<?php } ?>border: 1px solid rgb(194, 35, 16); border-radius: 5px 5px 5px 5px; left: 4%; top: 45px; background: rgb(244, 251, 251) none repeat scroll 0% 0%;">
		<div style="height: 15px; text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.25); background-color: rgb(196, 84, 60); background-image: linear-gradient(to bottom, rgb(#3C85C4), rgb(#3C85C4)); background-repeat: repeat-x; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25); color: rgb(251, 238, 238); padding: 1px 0px 16px 9px; margin-left: -19px; width: 429px; vertical-align: middle; border-radius: 4px 4px 0px 0px; margin-top: -3px;"><span class="close tip-s medium  barramenu" onclick="__ir('<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm');" style="text-decoration:none; cursor:pointer; color: #F8F3F3; float:right; width: 15px; top: 0px;">X</span>
			<div class="panel-title" style="margin-top: 5px;"><b>DETALLES DEL COMPONENTE: <?php if (strlen($q)>=15) { echo substr($q,0,15)."..."; } else { echo $q; }?></b></div>
		</div><br>
	<form action="" method="post" name="componente">
        <table width="47%" align="center" class="table"><?php 
		    if($compon == "Memorias") {
		        foreach ($varcomponente[1] as $clave => $valor) { 
				   $nombcampo[] = $valor; 
				}
			}elseif(($compon == "Microprocesador")) {
		        foreach ($varcomponente[0] as $clave => $valor) { 
				   $nombcampo[] = $valor; 
				}
		    }elseif(($compon == "Tarjeta Grafica")) {
		        foreach ($varcomponente[3] as $clave => $valor) { 
				   $nombcampo[] = $valor; 
				}
		    }elseif(($compon == "Disco Duro")) {
		        foreach ($varcomponente[2] as $clave => $valor) { 
				   $nombcampo[] = $valor; 
				}
		    }
		  
		for ($a=0; $a<count($nombcampo); $a++ ) { ?>
		
		<tr>
		  <td width="46%" align="center"><div align="center"><b><?php echo strtoupper($nombcampo[$a]); ?></b></div></td>
		  <td width="54%" align="center"><div align="center"><input name="<?php echo $nombcampo[$a]; ?>1" id="<?php echo $nombcampo[$a]; ?>1" type="text" onkeypress="return handleEnter(this, event)" required value="<?php if ($cantrows!=0) { echo $rows1[$nombcampo[$a]]; } ?>" class="form-control" onblur="componente.<?php echo $nombcampo[$a]; ?>.value=this.value; <?php if($_REQUEST['accion']=='editar') { ?>__editcompo('<?php echo $nombcampo[$a]; ?>','<?php echo $rows1['id']; ?>',this.value,'<?php echo $nombcampo[$a]; ?>'); <?php } ?>"></div></td>
		</tr><?php } ?>
		<tr><input name="interfaz" id="interfaz" type="hidden" value="<?php if ($cantrows!=0) { echo $rows1['interfaz']; } ?>"><?php if($compon!="Microprocesador" AND $compon!="Memorias" AND $compon!="Disco Duro" ) { ?>
		  <td width="46%" align="center"><div align="center"><b>INTERFAZ</b></div></td>
		  <td width="54%" align="center"><div align="center">
		    <select name="interf" id="interf" class="form-control" required onchange="componente.interfaz.value=this.value; __editcompo('interfaz','<?php echo $rows1['id']; ?>',this.value,'interfaz');">
			  <option value="AGP" <?php if ($cantrows!=0) {if($rows1['interfaz']=="AGP") { ?> selected <?php }} ?>>AGP</option>
			  <option value="IDE" <?php if ($cantrows!=0) {if($rows1['interfaz']=="IDE") { ?> selected <?php }} ?>>IDE</option>
			  <option value="PCI" <?php if ($cantrows!=0) {if($rows1['interfaz']=="PCI") { ?> selected <?php }} ?>>PCI</option>
			  <option value="PCI-X" <?php if ($cantrows!=0) {if($rows1['interfaz']=="PCI-X") { ?> selected <?php }} ?>>PCI-X</option>
			  <option value="PCIe" <?php if ($cantrows!=0) {if($rows1['interfaz']=="PCIe") { ?> selected <?php }} ?>>PCIe</option>
			  <option value="SATA" <?php if ($cantrows!=0) {if($rows1['interfaz']=="SATA") { ?> selected <?php }} ?>>SATA</option>
			  <option value="SCSI" <?php if ($cantrows!=0) {if($rows1['interfaz']=="SCSI") { ?> selected <?php }} ?>>SCSI</option>
			  <option value="SAS" <?php if ($cantrows!=0) {if($rows1['interfaz']=="SAS") { ?> selected <?php }} ?>>SAS</option>
			  <option value="USB" <?php if ($cantrows!=0) {if($rows1['interfaz']=="USB") { ?> selected <?php }} ?>>USB</option>
	        </select></div></td><?php } ?>
		<tr><input name="taip" id="taip" type="hidden" value="<?php if ($cantrows!=0) { echo $rows1['tipo']; } ?>"><?php if($compon=="Memorias") { ?>
		</tr>
		  <td width="46%" align="center"><div align="center" id="tmem1"><b>TIPO</b></div></td>
		  <td width="54%" align="center"><div align="center" id="tmem2" >
		    <select name="tai" id="tai" class="form-control" onchange="componente.taip.value=this.value; __editcompo('tipo','<?php echo $rows1['id']; ?>',this.value,'tipo');">
			  <option value="SDR SDRAM" <?php if ($cantrows!=0) { if($rows1['tipo']=="SDR SDRAM") {?> selected <?php }} ?>>SDR SDRAM</option>
			  <option value="RDRAM" <?php if ($cantrows!=0) { if($rows1['tipo']=="RDRAM") {?> selected <?php }} ?>>RDRAM</option>
			  <option value="DDR SDRAM" <?php if ($cantrows!=0) { if($rows1['tipo']=="DDR SDRAM") {?> selected <?php }} ?>>DDR SDRAM</option>
			  <option value="DDR2 SDRAM" <?php if ($cantrows!=0) { if($rows1['tipo']=="DDR2 SDRAM") {?> selected <?php }} ?>>DDR2 SDRAM</option>
			  <option value="DDR3 SDRAM" <?php if ($cantrows!=0) { if($rows1['tipo']=="DDR3 SDRAM") {?> selected <?php }} ?>>DDR3 SDRAM</option>
			  <option value="DDR4 SDRAM" <?php if ($cantrows!=0) { if($rows1['tipo']=="DDR4 SDRAM") {?> selected <?php }} ?>>DDR4 SDRAM</option>
	        </select></div></td><?php } ?>
		</tr><input name="taip" id="taip" type="hidden" value="<?php if ($cantrows!=0) { echo $rows1['tipo']; } ?>"><?php if($compon=="Disco Duro") { ?>
		</tr>
		  <td width="46%" align="center"><div align="center" id="tmem1"><b>TIPO</b></div></td>
		  <td width="54%" align="center"><div align="center" id="tmem2" >
		    <select name="tai" id="tai" class="form-control" onchange="componente.taip.value=this.value; __editcompo('tipo','<?php echo $rows1['id']; ?>',this.value,'tipo');">
			  <<option value="M2" <?php if ($cantrows!=0) {if($rows1['interfaz']=="M2") { ?> selected <?php }} ?>>M2</option>
			  <option value="SATA" <?php if ($cantrows!=0) {if($rows1['interfaz']=="SATA") { ?> selected <?php }} ?>>SATA</option>
			  <option value="SCSI" <?php if ($cantrows!=0) {if($rows1['interfaz']=="SCSI") { ?> selected <?php }} ?>>SCSI</option>
			  <option value="SAS" <?php if ($cantrows!=0) {if($rows1['interfaz']=="SAS") { ?> selected <?php }} ?>>SAS</option>
			  <option value="USB" <?php if ($cantrows!=0) {if($rows1['interfaz']=="USB") { ?> selected <?php }} ?>>USB</option>
	        </select></div></td><?php } ?>
		</tr>
		<tr>
		  <td colspan="2"><input name="acepta" onclick="<?php if($_REQUEST['accion']=='insertar') { ?> __insertcompo('<?php echo $compon; ?>','<?php echo $categ; ?>','<?php echo $q; ?>',document.getElementById('marca').value,document.getElementById('modelo').value,document.getElementById('no_serie').value,document.getElementById('fabricante').value,document.getElementById('capacidad').value,document.getElementById('tasa').value,document.getElementById('frecuencia').value,document.getElementById('cache').value,document.getElementById('rpm').value,document.getElementById('interfaz').value,document.getElementById('tipo').value,document.getElementById('cpuid').value,document.getElementById('cpucores').value,document.getElementById('cpulogicos').value,document.getElementById('socket').value); <?php } ?> __ir('<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm');" value="<?php echo $btaceptar;?>" class="btn" style="float: right;" type="button"></td>
		</tr>
		</table>
		<input name="marca" id="marca" type="hidden">
		<input name="modelo" id="modelo" type="hidden">
		<input name="no_serie" id="no_serie" type="hidden">
		<input name="fabricante" id="fabricante" type="hidden">
		<input name="capacidad" id="capacidad" type="hidden">
		<input name="tasa" id="tasa" type="hidden">
		<input name="frecuencia" id="frecuencia" type="hidden">
		<input name="cache" id="cache" type="hidden">
		<input name="rpm" id="rpm" type="hidden">
		<input name="interfaz" id="interfaz" type="hidden">
		<input name="tipo" id="tipo" type="hidden">
		<input name="cpuid" id="cpuid" type="hidden">
		<input name="cpucores" id="cpucores" type="hidden">
		<input name="cpulogicos" id="cpulogicos" type="hidden">
		<input name="socket" id="socket" type="hidden">
	</form>
	</div>
</div>
<form action="et.php" method="post" name="ir" id="ir">
	<input name="inv" value="" type="hidden">
	<input name="idunidades" type="hidden">
	<input name="idun" id="marcado" type="hidden">
	<input name="palabra" id="palabra" type="hidden">
	<input name="dde" id="dde" type="hidden">
</form>
<form method="post" name="imprime">
	<input name="categ" type="hidden">
</form>
<form action="" method="post" name="wq" id="wq">
	<input name="q" value="<?php echo $q;?>" type="hidden">
	<input name="inv" value="" type="hidden">
	<input name="idunidades" type="hidden">
	<input name="idun" id="marcado" type="hidden">
	<input name="palabra" id="palabra" type="hidden">
	<input name="dde" id="dde" type="hidden">
	<input name="compon" id="compon" type="hidden">
	<input name="compo" id="compo" type="hidden">
	<input name="accion" id="accion" type="hidden">
</form>
<div id="buscad">
<fieldset class="fieldset"><legend class="vistauserx"><?php echo $btEXPEDIENTE1;?></legend>
	<table width="100%" border="0" align="center" class="tablen"><?php
	if(($num_resultados1) !=0){ ?>
	    <tr>
		   <td colspan="2"><img src="images/cabeceraET.jpg" width="100%" height="75"></td>
		</tr>
		<tr>
			<td width="708"></td>
			<td width="80">
				<div id="imprime">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><?php 
						$result3=mysqli_query($miConex, $sql1) or die (mysql_error());
						$rowq=mysqli_fetch_array($result3);
						$custoq=$rowq["custodio"];
						$nomb_PCq = $rowq["n_PC"];
						$idunidasq = $rowq["idunidades"];
						$area_respq = $rowq["idarea"];
						$sello_s = $row["sello"];
						$serie_s = $row["no_serie"];
						
						$sqlcargo ="SELECT * FROM usuarios WHERE nombre='".$custoq."'";
						$resulcargo =mysqli_query($miConex, $sqlcargo) or die (mysql_error());
						$filacargo = mysqli_fetch_array($resulcargo); ?>
						
					  <td class="exel"><a href="expexp.php?query=<?php echo $ggg;?>&tb=exp&categ=<?php echo $categ; ?>" target="_blank" class="tooltip">&nbsp;&nbsp;&nbsp;<span onMouseOver="this.style.cursor='pointer';" ><?php echo strtoupper($cr_exel);?></span></a></td>
                      <td class="printer"><a style="cursor:pointer;" onclick="__print('<?php echo $categ; ?>');" target="_blank" class="tooltip">&nbsp;&nbsp;&nbsp;<span onMouseOver="this.style.cursor='pointer';" ><?php echo strtoupper($sav_print);?></span></a></td>
                    </tr>
                  </table>	
				</div>			
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<table width="630" border="0" cellspacing="0" cellpadding="0" style="border-color: rgb(204, 221, 240); border-style: solid;" class="table">
			  <tr>
				<td colspan="2"><span class="vistauser1"><b><?php echo $btEXPEDIENTE1;?></b></span><span class="vistauser1"><?php echo "<font color=red class=Estilo8><b>".@$categ."</b></font>"; ?></span></td>
				<td><span class="vistauser1"><b><?php echo $btdatosentidad3; ?></b></span></td>
				<td><?php echo $qseledtgn['entidad']; ?></td>
			  </tr>
			  <tr>
				<td width="113"><span class="vistauser1"><b><?php echo $apodo1.$dela3;?>PC</b>:</span></td>
				<td width="156"><?php echo $nomb_PCq; ?></td>
				<td width="44"><span class="vistauser1"><b><?php echo substr($btAreas,0,-1);?>:</b></span></td>
				<td width="307"><?php echo $rowq['idarea']; ?></td>
			  </tr>
			  <tr>
				<td><span class="vistauser1"><b><?php echo $btResponsable; ?>:</b></span></td>
				<td><?php echo $custoq; ?></td>
				<td><span class="vistauser1"><b><?php echo $btnCargo; ?>:</b></span></td>
				<td><?php echo $filacargo['cargo']; ?></td>
			  </tr>
			  <tr>
				<td><span class="vistauser1"><b><?php echo ucwords(strtolower($btSELLO));?>:</b></span></td>
				<td><?php echo $sello_s; ?></td>
				<td><span class="vistauser1"><b><?php echo $serie1; ?>:</b></span></td>
				<td><?php echo $serie_s; ?></td>
			  </tr>
			</table>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="2"><?php
				if(($num_resultados1) !=0){ 
					// Si hay resultados crea una tabla y los muestra		
					    $row2=mysqli_fetch_array($result2);
						$custo=$row2["custodio"];
						$nomb_PC = $row2["n_PC"];
						$idunidas = $row2["idunidades"];
						$area_resp = $row2["idarea"];?>
					    <font size="3"><b><?php echo $Comp;?></b></font>
						<table width="100%" border='1' cellpadding="0" style="border-color: rgb(204, 221, 240); border-style: solid;" cellspacing="0" class="table" >
							<tr>
								<td width="25%"><span class="vistauser1"><b><font color="black">CPU</font><b></span></td>
								<td width="15%"><span class="vistauser1"><b><font color="black">MOTHERBOARD</font><b></span></td>
								<td width="15%"><span class="vistauser1"><b><font color="black">CHIPSET</font><b></span></td>
								<td width="25%"><span class="vistauser1"><b><font color="black">HDD/CD/DVD</font><b></span></td>
								<td width="25%"><span class="vistauser1"><b><font color="black">HDD/CD/DVD</font><b></span></td>
							</tr><?php 
						while ($row=mysqli_fetch_array($result1)){ 
							$red3 = explode('*',$row["RED2"]);?>
							<tr>
								<td valign="top">
								 <?php 
									  $sqlcpt = "SELECT * FROM componentes WHERE componentes.idexp='".$categ."' AND componentes.nombre = '".$row["CPU"]."'";
									  $rescpt = mysqli_query($miConex, $sqlcpt) or die (mysql_error());
									  $filacomp = mysqli_fetch_array($rescpt);
									  $numre = mysqli_num_rows($rescpt);
								
									foreach ($varcomponente[0] as $clave => $valor) { 
										   $nombcampo[] = $valor; 
									}
									
								?>
								<span onmouseover="this.style.color='rgb(79, 105, 179)';" onmouseout="this.style.color='rgb(0, 0, 0)';">&nbsp;<?php echo $row['CPU']; ?><?php if ($numre!=0 and $_SESSION ["valid_user"]!='invitado') { ?><i id="editcpu" onclick="seguro4('<?php echo $row["CPU"]; ?>','<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Microprocesador','<?php echo $row['CPU']; ?>','editar');" manolo="Editar&nbsp;<?php echo $row['CPU']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 4px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><i id="deleCPU" onclick="__deletecompo('<?php echo $filacomp["id"]; ?>'); __ir('<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm');" manolo="Eliminar Compontes del:&nbsp;<?php echo $row['CPU']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 21px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i></span>
								<div id="<?php echo $row['CPU']; ?>">
								<form name="cpu" action="" method="post">
								<table width="30%" align="center" class="table">
									<?php if ($numre!=0 and @$rus["tipo"] =="root"){  
									 for ($a=0; $a<count($nombcampo); $a++) { ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><b><?php echo strtoupper($nombcampo[$a]); ?></b></div></td>
									  <td width="54%" align="center"><div align="center"><input name="<?php echo $nombcampo[$a]; ?>" id="<?php echo $nombcampo[$a]; ?>0" type="text" value="<?php echo $filacomp[$nombcampo[$a]]; ?>" class="vistauser1" onblur="__editcompo('<?php echo $nombcampo[$a]; ?>','<?php echo $filacomp['id']; ?>',this.value,'<?php echo $nombcampo[$a]; ?>');"></div></td>
									</tr><?php } } ?>
								</form>	
								</table>
								<?php } elseif (@$rus["tipo"] =="root") {  ?>
									<i id="insertcpu" onclick="seguro4('<?php echo $row["CPU"]; ?>','<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Microprocesador','<?php echo $row['CPU']; ?>','insertar');" manolo="Insertar Compontes del:&nbsp;<?php echo $row['CPU']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 5px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -250px;"></i>
								<?php } ?>	
								</div>
								</td>
								<td valign="top">&nbsp;<?php echo $row["PLACA"] ?></td>
								<td valign="top">&nbsp;<?php echo $row["CHIPSET"] ?></td>
								<td valign="top">
								 <?php 
								  $sqlcpt = "SELECT * FROM componentes WHERE componentes.idexp='".$categ."' AND componentes.nombre = '".$row["DRIVE1"]."'";
								  $rescpt = mysqli_query($miConex, $sqlcpt) or die (mysql_error());
								  $filacomp = mysqli_fetch_array($rescpt);
								  $numre = mysqli_num_rows($rescpt);
													  
								 	foreach ($varcomponente[2] as $clave => $valor) { 
										$nombcampo1[] = $valor; 
									}
								?>
								<span onmouseover="this.style.color='rgb(79, 105, 179)';" onmouseout="this.style.color='rgb(0, 0, 0)';">&nbsp;<?php echo $row["DRIVE1"] ?><?php if ($numre!=0) { ?><i id="editdrive1" onclick="seguro4('<?php echo $row["DRIVE1"]; ?>','<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Disco Duro','<?php echo $row['DRIVE1']; ?>','editar');" manolo="Editar&nbsp;<?php echo $row['DRIVE1']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 24px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><i id="deledrive1" onclick="__deletecompo('<?php echo $filacomp["id"]; ?>'); __ir('<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm');" manolo="Eliminar Compontes del:&nbsp;<?php echo $row['DRIVE1']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 41px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i></span>
								<form name="drive1" action="" method="post">
								<table width="30%" align="center" class="table"><?php if ($numre!=0 and $_SESSION ["valid_user"]!='invitado') { 
									 for ($a=0; $a<count($nombcampo1); $a++) { ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><b><?php echo strtoupper($nombcampo1[$a]); ?></b></div></td>
									  <td width="54%" align="center"><div align="center"><input name="<?php echo $nombcampo1[$a]; ?>" id="<?php echo $nombcampo1[$a]; ?>1" type="text" value="<?php echo $filacomp[$nombcampo1[$a]]; ?>" class="vistauser1" onblur="__editcompo('<?php echo $nombcampo1[$a]; ?>','<?php echo $filacomp['id']; ?>',this.value,'<?php echo $nombcampo1[$a]; ?>');"></div></td>
									</tr><?php } ?>
									<tr>
									<td width="46%" align="center"><div align="center"><b>INTERFAZ</b></div></td>
									<td width="54%" align="center"><div align="left">
									    <select name="inter" id="inter" class="vistauser1" onclick="__editcompo('interfaz','<?php echo $filacomp['id']; ?>',this.value,'interfaz');">
										  <option value="AGP" <?php if($filacomp['interfaz']=="AGP") { ?> selected <?php } ?>>AGP</option>
										  <option value="IDE" <?php if($filacomp['interfaz']=="IDE") { ?> selected <?php } ?>>IDE</option>
										  <option value="PCI" <?php if($filacomp['interfaz']=="PCI") { ?> selected <?php } ?>>PCI</option>
										  <option value="PCI-X" <?php if($filacomp['interfaz']=="PCI-X") { ?> selected <?php } ?>>PCI-X</option>
										  <option value="PCIe" <?php if($filacomp['interfaz']=="PCIe") { ?> selected <?php } ?>>PCIe</option>
										  <option value="SATA" <?php if($filacomp['interfaz']=="SATA") { ?> selected <?php } ?>>SATA</option>
										  <option value="SCSI" <?php if($filacomp['interfaz']=="SCSI") { ?> selected <?php } ?>>SCSI</option>
										  <option value="SAS" <?php if($filacomp['interfaz']=="SAS") { ?> selected <?php } ?>>SAS</option>
										  <option value="USB" <?php if($filacomp['interfaz']=="USB") { ?> selected <?php } ?>>USB</option>
										</select>
									  </div>
									</td>
									</tr><?php } ?>
								</form>
								</table><?php } elseif ($row["DRIVE1"]!="" and @$rus["tipo"] =="root") { ?>
									<i id="insertdrive2" onclick="seguro4('<?php echo $row["DRIVE1"]; ?>','<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Disco Duro','<?php echo $row['DRIVE1']; ?>','insertar');" manolo="Insertar Compontes del:&nbsp;<?php echo $row['DRIVE1']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 5px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -250px;"></i>
								<?php } ?>	
								</td>
								<td valign="top">
								  <?php 
								  $sqlcpt = "SELECT * FROM componentes WHERE componentes.idexp='".$categ."' AND componentes.nombre = '".$row["DRIVE2"]."'";
								  $rescpt = mysqli_query($miConex, $sqlcpt) or die (mysql_error());
								  $filacomp = mysqli_fetch_array($rescpt);
								  $numre = mysqli_num_rows($rescpt);
								foreach ($varcomponente[2] as $clave => $valor) { 
										$nombcampo2[] = $valor; 
									}
								?>
								<span onmouseover="this.style.color='rgb(79, 105, 179)';" onmouseout="this.style.color='rgb(0, 0, 0)';">&nbsp;<?php echo $row["DRIVE2"] ?><?php if ($numre!=0) {  ?><i id="editdrive2" onclick="seguro4('<?php echo $row["DRIVE2"]; ?>','<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Disco Duro','<?php echo $row['DRIVE2']; ?>','editar');" manolo="Editar&nbsp;<?php echo $row['DRIVE2']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 24px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i>&nbsp;<i id="deledrive2" onclick="__deletecompo('<?php echo $filacomp["id"]; ?>'); __ir('<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm');" manolo="Eliminar Compontes del:&nbsp;<?php echo $row['DRIVE2']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 37px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i></span>
								<form name="drive2" action="" method="post">
								<table width="30%" align="center" class="table"><?php 
									 for ($a=0; $a<count($nombcampo2); $a++) { ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><b><?php echo strtoupper($nombcampo2[$a]); ?></b></div></td>
									  <td width="54%" align="center"><div align="center"><input name="<?php echo $nombcampo2[$a]; ?>" id="<?php echo $nombcampo2[$a]; ?>3" type="text" value="<?php echo $filacomp[$nombcampo2[$a]]; ?>" class="vistauser1" onblur="__editcompo('<?php echo $nombcampo1[$a]; ?>','<?php echo $filacomp['id']; ?>',this.value,'<?php echo $nombcampo1[$a]; ?>');"></div></td>
									</tr><?php } ?>
									<tr>
									<td width="46%" align="center"><div align="center"><b>INTERFAZ</b></div></td>
									<td width="54%" align="center"><div align="left">
									    <select name="inter" id="inter" class="vistauser1" onclick="__editcompo('interfaz','<?php echo $filacomp['id']; ?>',this.value,'interfaz');">
										  <option value="AGP" <?php if($filacomp['interfaz']=="AGP") { ?> selected <?php } ?>>AGP</option>
										  <option value="IDE" <?php if($filacomp['interfaz']=="IDE") { ?> selected <?php } ?>>IDE</option>
										  <option value="PCI" <?php if($filacomp['interfaz']=="PCI") { ?> selected <?php } ?>>PCI</option>
										  <option value="PCI-X" <?php if($filacomp['interfaz']=="PCI-X") { ?> selected <?php } ?>>PCI-X</option>
										  <option value="PCIe" <?php if($filacomp['interfaz']=="PCIe") { ?> selected <?php } ?>>PCIe</option>
										  <option value="SATA" <?php if($filacomp['interfaz']=="SATA") { ?> selected <?php } ?>>SATA</option>
										  <option value="SCSI" <?php if($filacomp['interfaz']=="SCSI") { ?> selected <?php } ?>>SCSI</option>
										  <option value="SAS" <?php if($filacomp['interfaz']=="SAS") { ?> selected <?php } ?>>SAS</option>
										  <option value="USB" <?php if($filacomp['interfaz']=="USB") { ?> selected <?php } ?>>USB</option>
										</select>
									  </div>
									</td>
									</tr><?php } elseif ($row["DRIVE2"]!="" and @$rus["tipo"] =="root"){ ?>
									<i id="insertdrive2" onclick="seguro4('<?php echo $row["DRIVE2"]; ?>','<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Disco Duro','<?php echo $row['DRIVE2']; ?>','insertar');" manolo="Insertar Compontes del:&nbsp;<?php echo $row['DRIVE2']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 5px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -250px;"></i>
								<?php } ?>	
								</form>	
								</table>
								</td>
							</tr>
						</table>
						<?php } 
				}else { ?>
					<div align="center"><div class="message" align="center"><?php echo $btconformado;?>.</div></div>
					<input name="cance" type="button" value="<?php echo $btcancelar;?>" class="btn" onclick="document.location='registromedios1.php';"><?php if (@$rus["tipo"] =="root") { ?>
					<input name="crea" type="button" value="<?php echo $btCreate;?>" class="btn" onclick="__creaExpt('<?php echo $categ;?>','<?php echo @$marcado;?>','<?php echo $idunddes;?>');">
					<input name="importa" type="button" value="<?php echo $impo_exp8;?>" class="btn" onclick="__importa('<?php echo $categ;?>','<?php echo @$marcado;?>','<?php echo $idunddes;?>');">
					<?php }
				}
				$sql="SELECT * FROM exp WHERE custodio='".@$custo."' AND inv ='".@$categ."' and idunidades='".@$idunidas."'"; 
				$result=mysqli_query($miConex, $sql);
				$num_resultados = mysqli_num_rows($result);
           				
				$sqla="SELECT * FROM aft WHERE custodio='".@$custo."' AND inv !='".@$categ."' and idunidades='".@$idunidas."' and categ!='COMPUTADORAS'"; 
				$resulta=mysqli_query($miConex, $sqla);
				$num_resultadosa = mysqli_num_rows($resulta);
								
				$sqlact="SELECT * FROM aft WHERE custodio='".@$custo."' AND inv LIKE '".@$categ."%' and idunidades='".@$idunidas."' and categ!='COMPUTADORAS'"; 
				$resulaft=mysqli_query($miConex, $sqlact);
				$num_resultaft = mysqli_num_rows($resulaft);
				
				if ($num_resultados !=0){ ?>
				    <table width="100%" border='1' style="border-color: rgb(204, 221, 240); border-style: solid;" cellpadding="0" cellspacing="0" class="table" > 
						 <tr> 
							 <td width="246"><span class="vistauser1"><b><?php echo $Memorias1;?></b></span></td>
							 <td width="246"><span class="vistauser1"><b><?php echo $Memorias1;?></b></span></td>
							 <td width="246"><span class="vistauser1"><b><?php echo $Memorias1;?></b></span></td>
							 <td width="246"><span class="vistauser1"><b><?php echo $Memorias1;?></b></span></td>
						 </tr><?php 
				
						while ($row = mysqli_fetch_array($result)) { 			
							
                            if ($row["MEMORIA2"]!=""){
								$memoriasf = explode('*',$row["MEMORIA2"]);
							}else{
								$memoriasf =null;
							}
							
							$sqlcpt = "SELECT * FROM componentes WHERE componentes.idexp='".$categ."' AND componentes.nombre = '".$row["MEMORIA"]."'";
							$rescpt = mysqli_query($miConex, $sqlcpt) or die (mysql_error());
							$filacomp = mysqli_fetch_array($rescpt);
							$numre = mysqli_num_rows($rescpt);
								    foreach ($varcomponente[1] as $clave => $valor) { 
										$nombcampo3[] = $valor; 
									}
								?>
							<tr>
								<?php if ($row['MEMORIA']!="") { ?><td><span onmouseover="this.style.color='rgb(79, 105, 179)';" onmouseout="this.style.color='rgb(0, 0, 0)';"><?php echo $row["MEMORIA"] ?><?php if ($numre!=0) {?> <i id="editmemoria" onclick="seguro4('<?php echo $row["MEMORIA"]; ?>','<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Memorias','<?php echo $row['MEMORIA']; ?>','editar');" manolo="Editar&nbsp;<?php echo $row['MEMORIA']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 4px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><i id="deleMEMORIA" onclick="__deletecompo('<?php echo $filacomp["id"]; ?>'); __ir('<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm');" manolo="Eliminar Compontes del:&nbsp;<?php echo $row['MEMORIA']; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 21px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i></span>
								<form name="memoria" action="" method="post">
								<table width="30%" align="center" class="table"><?php if ($numre!=0 and $_SESSION ["valid_user"]!='invitado') { 
									 for ($a=0; $a<count($nombcampo3); $a++) { ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><b><?php echo strtoupper($nombcampo3[$a]); ?></b></div></td>
									  <td width="54%" align="center"><div align="center"><input name="<?php echo $nombcampo3[$a]; ?>" id="<?php echo $nombcampo3[$a]; ?>4" type="text" value="<?php echo $filacomp[$nombcampo3[$a]]; ?>" class="vistauser1" onblur="__editcompo('<?php echo $nombcampo3[$a]; ?>','<?php echo $filacomp['id']; ?>',this.value,'<?php echo $nombcampo3[$a]; ?>');"></div></td>
									</tr><?php } ?>
								    <tr>
									  <td width="46%" align="center"><div align="center"><b>TIPO</b></div></td>
									  <td width="54%" align="center"><div align="center">
									    <select name="tipo0" id="tipo0" class="vistauser1" onchange="__editcompo('tipo','<?php echo $filacomp['id']; ?>',this.value,'tipo');">
										  <option value="SDR SDRAM" <?php if($filacomp['tipo']=="SDR SDRAM") {?> selected <?php } ?>>SDR SDRAM</option>
										  <option value="RDRAM" <?php if($filacomp['tipo']=="RDRAM") {?> selected <?php } ?>>RDRAM</option>
										  <option value="DDR SDRAM" <?php if($filacomp['tipo']=="DDR SDRAM") {?> selected <?php } ?>>DDR SDRAM</option>
										  <option value="DDR2 SDRAM" <?php if($filacomp['tipo']=="DDR2 SDRAM") {?> selected <?php } ?>>DDR2 SDRAM</option>
										  <option value="DDR3 SDRAM" <?php if($filacomp['tipo']=="DDR3 SDRAM") {?> selected <?php } ?>>DDR3 SDRAM</option>
										  <option value="DDR4 SDRAM" <?php if($filacomp['tipo']=="DDR4 SDRAM") {?> selected <?php } ?>>DDR4 SDRAM</option>
										</select>
									  </div></td>
									</tr><?php } ?> 
								</form>	
								</table><?php }elseif ($row["MEMORIA"]!="" and $_SESSION ["valid_user"]!='invitado'){ ?>
									<i id="insertmemo0" onclick="seguro4('<?php echo $row["MEMORIA"]; ?>','<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Memorias','<?php echo $row["MEMORIA"]; ?>','insertar');" manolo="Insertar Compontes del:&nbsp;<?php echo $row["MEMORIA"]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 5px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -250px;"></i>
								<?php } ?>	
								</td><?php } ?> 
								<td><?php 
								$sqlcpt = "SELECT * FROM componentes WHERE componentes.idexp='".$categ."' AND componentes.nombre = '".$memoriasf[0]."'";
								$rescpt = mysqli_query($miConex, $sqlcpt) or die (mysql_error());
								$filacomp = mysqli_fetch_array($rescpt);
								$numre = mysqli_num_rows($rescpt);
										foreach ($varcomponente[1] as $clave => $valor) { 
											$nombcampo4[] = $valor; 
										} ?>
								<span onmouseover="this.style.color='rgb(79, 105, 179)';" onmouseout="this.style.color='rgb(0, 0, 0)';"><?php echo @$memoriasf[0];?><?php if ($numre!=0 and $_SESSION ["valid_user"]!='invitado') { ?><i id="editmemoria" onclick="seguro4('<?php $memoriasf[0]; ?>','<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Memorias','<?php echo $memoriasf[0]; ?>','editar');" manolo="Editar&nbsp;<?php echo $memoriasf[0]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 4px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><i id="deleMEMORIA2" onclick="__deletecompo('<?php echo $filacomp["id"]; ?>'); __ir('<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm');" manolo="Eliminar Compontes del:&nbsp;<?php echo $memoriasf[0]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 21px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i></span>
								<form name="memoria0" action="" method="post">
								<table width="30%" align="center" class="table"><?php if ($numre!=0 and $_SESSION ["valid_user"]!='invitado') {
									 for ($a=0; $a<count($nombcampo4); $a++) { ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><b><?php echo strtoupper($nombcampo4[$a]); ?></b></div></td>
									  <td width="54%" align="center"><div align="center"><input name="<?php echo $nombcampo4[$a]; ?>" id="<?php echo $nombcampo4[$a]; ?>5" type="text" value="<?php echo $filacomp[$nombcampo4[$a]]; ?>" class="vistauser1" onblur="__editcompo('<?php echo $nombcampo4[$a]; ?>','<?php echo $filacomp['id']; ?>',this.value,'<?php echo $nombcampo4[$a]; ?>');"></div></td>
									</tr><?php } ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><b>TIPO</b></div></td>
									  <td width="54%" align="center"><div align="center">
									  <select name="tipo1" id="tipo1" class="vistauser1" onchange="__editcompo('tipo','<?php echo $filacomp['id']; ?>',this.value,'tipo');">
										  <option value="SDR SDRAM" <?php if($filacomp['tipo']=="SDR SDRAM") {?> selected <?php } ?>>SDR SDRAM</option>
										  <option value="RDRAM" <?php if($filacomp['tipo']=="RDRAM") {?> selected <?php } ?>>RDRAM</option>
										  <option value="DDR SDRAM" <?php if($filacomp['tipo']=="DDR SDRAM") {?> selected <?php } ?>>DDR SDRAM</option>
										  <option value="DDR2 SDRAM" <?php if($filacomp['tipo']=="DDR2 SDRAM") {?> selected <?php } ?>>DDR2 SDRAM</option>
										  <option value="DDR3 SDRAM" <?php if($filacomp['tipo']=="DDR3 SDRAM") {?> selected <?php } ?>>DDR3 SDRAM</option>
										  <option value="DDR4 SDRAM" <?php if($filacomp['tipo']=="DDR4 SDRAM") {?> selected <?php } ?>>DDR4 SDRAM</option>
										</select>
									  </div></td>
									</tr><?php } ?> 
								</form>	
								</table><?php } elseif ($memoriasf[0]!="" and $_SESSION ["valid_user"]!='invitado'){ ?>
									<i id="insertmemo1" onclick="seguro4('<?php echo $memoriasf[0]; ?>','<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Memorias','<?php echo $memoriasf[0]; ?>','insertar');" manolo="Insertar Compontes del:&nbsp;<?php echo $memoriasf[0]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 5px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -250px;"></i>
								<?php } ?>	
								</td> 
								<td><?php 
								$sqlcpt = "SELECT * FROM componentes WHERE componentes.idexp='".$categ."' AND componentes.nombre = '".$memoriasf[1]."'";
								$rescpt = mysqli_query($miConex, $sqlcpt) or die (mysql_error());
								$filacomp = mysqli_fetch_array($rescpt);
								$numre = mysqli_num_rows($rescpt);
										foreach ($varcomponente[1] as $clave => $valor) { 
											$nombcampo5[] = $valor; 
										}?>
								<span style="cursor:pointer;" onmouseover="this.style.color='rgb(79, 105, 179)';" onmouseout="this.style.color='rgb(0, 0, 0)';"><?php echo @$memoriasf[1];?><?php if ($numre!=0) { ?><i id="editmemoria" onclick="seguro4('<?php $memoriasf[1]; ?>','<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Memorias','<?php echo $memoriasf[1]; ?>','editar');" manolo="Editar&nbsp;<?php echo $memoriasf[1]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 4px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><i id="deleMEMORIA3" onclick="__deletecompo('<?php echo $filacomp["id"]; ?>'); __ir('<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm');" manolo="Eliminar Compontes del:&nbsp;<?php echo $memoriasf[1]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 21px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i></span>
								<form name="memoria1" action="" method="post">
								<table width="30%" align="center" class="table"><?php if ($numre!=0 and $_SESSION ["valid_user"]!='invitado') { 
									 for ($a=0; $a<count($nombcampo5); $a++) { ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><b><?php echo strtoupper($nombcampo5[$a]); ?></b></div></td>
									  <td width="54%" align="center"><div align="center"><input name="<?php echo $nombcampo5[$a]; ?>" id="<?php echo $nombcampo5[$a]; ?>6" type="text" value="<?php echo $filacomp[$nombcampo5[$a]]; ?>" class="vistauser1" onblur="__editcompo('<?php echo $nombcampo5[$a]; ?>','<?php echo $filacomp['id']; ?>',this.value,'<?php echo $nombcampo5[$a]; ?>');"></div></td>
									</tr><?php } ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><b>TIPO</b></div></td>
									  <td width="54%" align="center"><div align="center">
									  <select name="tipo2" id="tipo2" class="vistauser1" onchange="__editcompo('tipo','<?php echo $filacomp['id']; ?>',this.value,'tipo');">
										  <option value="SDR SDRAM" <?php if($filacomp['tipo']=="SDR SDRAM") {?> selected <?php } ?>>SDR SDRAM</option>
										  <option value="RDRAM" <?php if($filacomp['tipo']=="RDRAM") {?> selected <?php } ?>>RDRAM</option>
										  <option value="DDR SDRAM" <?php if($filacomp['tipo']=="DDR SDRAM") {?> selected <?php } ?>>DDR SDRAM</option>
										  <option value="DDR2 SDRAM" <?php if($filacomp['tipo']=="DDR2 SDRAM") {?> selected <?php } ?>>DDR2 SDRAM</option>
										  <option value="DDR3 SDRAM" <?php if($filacomp['tipo']=="DDR3 SDRAM") {?> selected <?php } ?>>DDR3 SDRAM</option>
										  <option value="DDR4 SDRAM" <?php if($filacomp['tipo']=="DDR4 SDRAM") {?> selected <?php } ?>>DDR4 SDRAM</option>
										</select>
									  </div></td>
									</tr><?php } ?>
								</form>	
								</table><?php } elseif ($memoriasf[1]!="" and $_SESSION ["valid_user"]!='invitado'){ ?>
									<i id="insertmemo3" onclick="seguro4('<?php echo $memoriasf[1]; ?>','<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Memorias','<?php echo $memoriasf[1]; ?>','insertar');" manolo="Insertar Compontes del:&nbsp;<?php echo $memoriasf[1]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 5px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -250px;"></i>
								<?php } ?>	
								</td>
								<td><?php 
								$sqlcpt = "SELECT * FROM componentes WHERE componentes.idexp='".$categ."' AND componentes.nombre = '".$memoriasf[2]."'";
								$rescpt = mysqli_query($miConex, $sqlcpt) or die (mysql_error());
								$filacomp = mysqli_fetch_array($rescpt);
								$numre = mysqli_num_rows($rescpt);
										foreach ($varcomponente[1] as $clave => $valor) { 
											$nombcampo6[] = $valor; 
										}?>
								<span onmouseover="this.style.color='rgb(79, 105, 179)';" onmouseout="this.style.color='rgb(0, 0, 0)';"><?php echo @$memoriasf[2]; ?><?php if ($numre!=0 and $_SESSION ["valid_user"]!='invitado') { ?><i id="editmemoria" onclick="seguro4('<?php $memoriasf[2]; ?>','<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Memorias','<?php echo $memoriasf[2]; ?>','editar');" manolo="Editar&nbsp;<?php echo $memoriasf[2]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 4px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><i id="deleMEMORIA3" onclick="__deletecompo('<?php echo $filacomp["id"]; ?>'); __ir('<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm');" manolo="Eliminar Compontes del:&nbsp;<?php echo $memoriasf[2]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 21px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i></span>
								<form name="memoria2" action="" method="post">
								<table width="30%" align="center" class="table"><?php if ($numre!=0 and $_SESSION ["valid_user"]!='invitado') { 
									 for ($a=0; $a<count($nombcampo6); $a++) { ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><b><?php echo strtoupper($nombcampo6[$a]); ?></b></div></td>
									  <td width="54%" align="center"><div align="center"><input name="<?php echo $nombcampo6[$a]; ?>" id="<?php echo $nombcampo6[$a]; ?>7" type="text" value="<?php echo $filacomp[$nombcampo6[$a]]; ?>" class="vistauser1" onblur="__editcompo('<?php echo $nombcampo6[$a]; ?>','<?php echo $filacomp['id']; ?>',this.value,'<?php echo $nombcampo6[$a]; ?>');"></div></td>
									</tr><?php } ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><b>TIPO</b></div></td>
									  <td width="54%" align="center"><div align="center">
									  <select name="tipo3" id="tipo3" class="vistauser1" onchange="__editcompo('tipo','<?php echo $filacomp['id']; ?>',this.value,'tipo');">
										  <option value="SDR SDRAM" <?php if($filacomp['tipo']=="SDR SDRAM") {?> selected <?php } ?>>SDR SDRAM</option>
										  <option value="RDRAM" <?php if($filacomp['tipo']=="RDRAM") {?> selected <?php } ?>>RDRAM</option>
										  <option value="DDR SDRAM" <?php if($filacomp['tipo']=="DDR SDRAM") {?> selected <?php } ?>>DDR SDRAM</option>
										  <option value="DDR2 SDRAM" <?php if($filacomp['tipo']=="DDR2 SDRAM") {?> selected <?php } ?>>DDR2 SDRAM</option>
										  <option value="DDR3 SDRAM" <?php if($filacomp['tipo']=="DDR3 SDRAM") {?> selected <?php } ?>>DDR3 SDRAM</option>
										  <option value="DDR4 SDRAM" <?php if($filacomp['tipo']=="DDR4 SDRAM") {?> selected <?php } ?>>DDR4 SDRAM</option>
										</select>
									  </div></td>
									</tr><?php } ?>
								</form>	
								</table><?php } elseif ($memoriasf[2]!="" and $_SESSION ["valid_user"]!='invitado'){ ?>
									<i id="insertmemo4" onclick="seguro4('<?php echo $memoriasf[2]; ?>','<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Memorias','<?php echo $memoriasf[2]; ?>','insertar');" manolo="Insertar Compontes del:&nbsp;<?php echo $memoriasf[2]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 5px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -250px;"></i>
								<?php } ?>	
								</td>
							</tr>&nbsp;
			        </table><br>
					<table width="100%" border='1' cellpadding="0" style="border-color: rgb(204, 221, 240); border-style: solid;" cellspacing="0" class="table" >
							<tr>
								<td width="6%"><span class="vistauser1"><b><font color="black"><?php echo $btRED;?>-1</font></b></span></td>
								<td width="8%"><span class="vistauser1"><b><font color="black"><?php echo $btRED;?>-2</font></b></span></td>
								<td width="8%"><span class="vistauser1"><b><font color="black"><?php echo $btRED;?>-3</font></b></span></td>
							</tr>
							<tr>
								<td valign="top">&nbsp;<?php echo $row["RED"] ?></td>
								<td valign="top">&nbsp;<?php echo @$red3[0]; ?></td>
								<td valign="top">&nbsp;<?php echo @$red3[1]; ?></td>
							</tr>
					</table>
					<table width="100%" BORDER='1' style="border-color: rgb(204, 221, 240); border-style: solid;" cellpadding="0" cellspacing="0" class="table" > 
							 <tr> 
								 <td width="101"><span class="vistauser1"><b><?php echo $btSONIDO;?></b></span></td>
								 <td width="250"><span class="vistauser1"><b><?php echo $bttargeta;?></b></span></td>
								 <td width="151"><span class="vistauser1"><b><?php echo $btdevice;?>-3</b></span></td>
								 <td width="165"><span class="vistauser1"><b><?php echo $btdevice;?>-4</b></span></td>
								 <td width="101"><span class="vistauser1"><b><?php echo $btFUENTE;?></b></span></td>
								 <td width="175"><span class="vistauser1"><b>SO</b></span></td>
							 </tr>
								<tr>
									<td>&nbsp;<?php echo $row["SONIDO"] ?></td>
									<td><?php 
								$sqlcpt = "SELECT * FROM componentes WHERE componentes.idexp='".$categ."' AND componentes.nombre = '".$row["GRAFICS"]."'";
								$rescpt = mysqli_query($miConex, $sqlcpt) or die (mysql_error());
								$filacomp = mysqli_fetch_array($rescpt);
								$numre = mysqli_num_rows($rescpt);
										foreach ($varcomponente[3] as $clave => $valor) { 
											$nombcampo7[] = $valor; 
										}?>	
								<span onmouseover="this.style.color='rgb(79, 105, 179)';" onmouseout="this.style.color='rgb(0, 0, 0)';"><?php echo $row["GRAFICS"];?><?php if ($numre!=0 and $_SESSION ["valid_user"]!='invitado') { ?><i id="editmemoria" onclick="seguro4('<?php $row["GRAFICS"]; ?>','<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Tarjeta Grafica','<?php echo $row["GRAFICS"]; ?>','editar');" manolo="Editar&nbsp;<?php echo $row["GRAFICS"]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 4px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><i id="deleGrafics" onclick="__deletecompo('<?php echo $filacomp["id"]; ?>'); __ir('<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm');" manolo="Eliminar Compontes del:&nbsp;<?php echo $row["GRAFICS"]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 21px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -23px -250px;"></i></span>
								<form name="GRAFICS" action="" method="post">
								<table width="30%" align="center" class="table"><?php if ($numre!=0 and $_SESSION ["valid_user"]!='invitado') { 
									 for ($a=0; $a<count($nombcampo7); $a++) { ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><b><?php echo strtoupper($nombcampo7[$a]); ?></b></div></td>
									  <td width="54%" align="center"><div align="center"><input name="<?php echo $nombcampo7[$a]; ?>" id="<?php echo $nombcampo7[$a]; ?>8" type="text" value="<?php echo $filacomp[$nombcampo7[$a]]; ?>" class="vistauser1" onblur="__editcompo('<?php echo $nombcampo7[$a]; ?>','<?php echo $filacomp['id']; ?>',this.value,'<?php echo $nombcampo7[$a]; ?>');"></div></td>
									</tr><?php } ?>
									<tr>
									  <td width="46%" align="center"><div align="center"><b>INTERFAZ</b></div></td>
									  <td width="54%" align="center"><div align="left">
									    <select name="inter" id="inter" class="vistauser1" onclick="__editcompo('interfaz','<?php echo $filacomp['id']; ?>',this.value,'interfaz');">
										  <option value="AGP" <?php if($filacomp['interfaz']=="AGP") { ?> selected <?php } ?>>AGP</option>
										  <option value="IDE" <?php if($filacomp['interfaz']=="IDE") { ?> selected <?php } ?>>IDE</option>
										  <option value="PCI" <?php if($filacomp['interfaz']=="PCI") { ?> selected <?php } ?>>PCI</option>
										  <option value="PCI-X" <?php if($filacomp['interfaz']=="PCI-X") { ?> selected <?php } ?>>PCI-X</option>
										  <option value="PCIe" <?php if($filacomp['interfaz']=="PCIe") { ?> selected <?php } ?>>PCIe</option>
										  <option value="SATA" <?php if($filacomp['interfaz']=="SATA") { ?> selected <?php } ?>>SATA</option>
										  <option value="SCSI" <?php if($filacomp['interfaz']=="SCSI") { ?> selected <?php } ?>>SCSI</option>
										  <option value="SAS" <?php if($filacomp['interfaz']=="SAS") { ?> selected <?php } ?>>SAS</option>
										  <option value="USB" <?php if($filacomp['interfaz']=="USB") { ?> selected <?php } ?>>USB</option>
										</select>
									  </div></td>
									</tr><?php } ?>
								</form>	
								</table><?php }elseif ($row["GRAFICS"]!="" and $_SESSION ["valid_user"]!='invitado'){ ?>
									<i id="insertmemo4" onclick="seguro4('<?php echo $row["GRAFICS"]; ?>','<?php echo $categ;?>','<?php echo $idunidadesc;?>','<?php echo $palabra;?>','rm','Tarjeta Grafica','<?php echo $row["GRAFICS"]; ?>','insertar');" manolo="Insertar Compontes del:&nbsp;<?php echo $row["GRAFICS"]; ?>" style="cursor:pointer; height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 0px; margin-left: 5px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -250px;"></i>
								<?php } ?>	
									</td> 
									<td>&nbsp;<?php echo $row["DRIVE3"]; ?></td> 
									<td>&nbsp;<?php echo $row["DRIVE4"]; ?></td>
									<td>&nbsp;<?php echo $row["FUENTE"]; ?></td>
									<td>&nbsp;<?php echo $row["OS"] ?></td>
								</tr>&nbsp;<?php 
							} ?>
					</table><br>
				<?php if ($num_resultaft >= 1){ ?>
				<font size="3"><b><?php echo $btotros;?></b></font>
				<table width="100%" border='0' cellpadding="0" cellspacing="0" align="center" class="table" > 
						 <tr> 
							 <td><span class="vistauser1"><b>INV</b></span></td>
							 <td><span class="vistauser1"><b><?php echo $DESCRIPCION;?></b></span></td>
							 <td><span class="vistauser1"><b><?php echo $btSELLO;?></b></span></td>
							 <td><span class="vistauser1"><b><?php echo $btMARCA;?></b></span></td>
							 <td><span class="vistauser1"><b>NO. <?php echo $serie1;?></b></span></td>
							 <td><span class="vistauser1"><b><?php echo $btMODELO;?></b></span></td>
							 <td><span class="vistauser1"><b>CATEG.</b></span></td>
							 <td><span class="vistauser1"><b><?php echo strtoupper($bttipo);?></b></span></td>
						 </tr><?php 
					    while ($rowa = mysqli_fetch_array($resulaft)) { ?>
							<tr>
								<td>&nbsp;<?php echo $rowa["inv"]; ?></td>
								<td>&nbsp;<?php echo $rowa["descrip"];?></td> 
								<td>&nbsp;<?php echo $rowa["sello"]; ?></td>
								<td>&nbsp;<?php echo $rowa["marca"]; ?></td>
								<td>&nbsp;<?php echo $rowa["no_serie"]; ?></td>
								<td>&nbsp;<?php echo $rowa["modelo"] ;?></td>
								<td>&nbsp;<?php echo $rowa["categ"]; ?></td>
								<td>&nbsp;<?php echo $rowa["tipo"]; ?></td>
							</tr>&nbsp;<?php 
						} ?>
			  </table>
               		<div class="navegador" align="center" style="width:100%"><?php echo $bttmecateg2;?>: <font color=red><?php echo $num_resultadosa; ?></font></div></p><hr> <?php 
				} } //fin tabla ?> 
				<form name="etc" id="etc" method="post" action="modificarexp.php">
					<input name="inv" id="inv" type="hidden">
					<input name="idunidades" id="idunidades" type="hidden" value="<?php echo $qseledtgn['id_datos'];?>">
				</form>
				<script type="text/javascript">
					function qwex(){
						document.getElementById('inv').value='<?php echo $categ;?>';
						document.etc.submit();
					}
				</script><br>
				<form name="va" method="post" action="q.php"><?php 
					if(($num_resultados1) !=0){
						if($_SESSION ["valid_user"]!='invitado' and $Rerow4['tipo']=="root"){ ?>	
							<input name="edita" type="button" id="edita" value="<?php echo $bteditar;?>" class="btn" onclick="qwex()"><?php 
						}
						if(($palabra) !=""){ ?>
							<input name="expediente" type="button" id="expediente" value="<?php echo $btcancelar;?>" class="btn" onclick="document.location='registromedios1.php?palabra=<?php echo $palabra;?>';"><?php 
						}elseif((@$nom_custo)){ ?>
							<input name="expediente" type="button" id="expediente" value="<?php echo $btcancelar;?>" class="btn" onclick="document.location='registrocustodio.php?nom_custo=<?php echo $nom_custo;?>';"><?php 
						}elseif(($dde) =="rm"){ ?>
							<input name="expediente" type="button" id="expediente" value="<?php echo $btaceptar;?>" class="btn" onclick="document.location='registromedios1.php?otras=&palabra=';"><?php 
						}else{ ?>
							<input name="expediente" type="submit" id="expediente" value="<?php echo $btcancelar;?>" class="btn"> <?php 
						} ?>			
							<input name="marcado1" type="hidden" value="<?php echo @$marcado;?>"><?php
					} ?>
				</form>
			</td>
		</tr>
  </table>
</fieldset><br>
<?php include ("version.php");?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>