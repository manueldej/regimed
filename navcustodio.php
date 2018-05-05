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
$quepagina=$bttotalreg;
switch (substr(strrchr($_SERVER['PHP_SELF'],'/'),1)) {
	case "expedientes.php":$quepagina=$btTAreas; //Expedientes
		break;
	case "registromedios1.php":$quepagina=$btregmedio0; //Expedientes
		break;
	case "res.php":$quepagina=$btResoluciones0; //Expedientes
		break;
	case "registroareas.php":$quepagina=$btAreas0; //Expedientes
		break;
	case "ej1.php":$quepagina=$new0; //Expedientes
		break;
	case "categ_medios.php":$quepagina=$btmostrarall0; //Expedientes
		break;
	case "reg_claves_sistema.php":$quepagina=$pass0; //Expedientes
		break;
	case "plan_mtto.php":$quepagina=$btpmtto0; //Expedientes
		break;
	case "r_traspasos.php":$quepagina=$bttotraspaso0; //Expedientes
		break;
	case "bajas.php":$quepagina=$btbajas0; //Expedientes
		break;
	case "insp.php":$quepagina=$btinsp0; //Expedientes
		break;
	case "defectuosos.php":$quepagina=$btListado0; //Expedientes
		break;
}
?>
<script type="text/javascript">
	function DoSubmit(){
		var emptyForm = true;
		with (document.navga){      
			emptyForm = (pagina.value == "");		
			if (!emptyForm)	{
				submit();	
			}	
		}
	}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td></td>
		<td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="middle"><div class="navegador"> 
					<form action="<?php echo @$PHP_SELF;?>" method="get" name="navga" id="navga">
					  <?php 
						if($registros >= $total_registros){ echo $quepagina;?>: <font color='red'><?php echo $total_registros;?></font>&nbsp;&nbsp;<?php
						}else{
							if($pagina == 1) {
								if(@$i !=1){ ?>
									<?php echo $totalrecord1;?> <font color='red'>1</font> <?php echo $totalrecord3;?> <font color='red'><?php echo $i;?></font> <?php echo $de;?> <font color='blue'><?php echo $total_registros;?></font>&nbsp;&nbsp;<?php
								}else{ ?>
									<?php echo $registr5;?> <font color='red'>1</font> <?php echo $de;?> <font color='blue'> <?php echo $total_registros;?></font>&nbsp;&nbsp;<?php
								}
							}else  {
								if(@$i !=1){ ?>
									<?php echo $totalrecord1;?><font color='red'><?php echo ($inicio+1);?></font> <?php echo $totalrecord3;?> <font color='red'><?php echo ($inicio + $i);?></font> <?php echo $de;?> <font color='blue'><?php echo $total_registros;?></font>&nbsp;&nbsp;<?php
								}else{ ?>
									<?php echo $registr5;?> <font color='red'><?php echo ($inicio + 1);?></font> <?php echo $de;?> <font color='blue'><?php echo $total_registros;?></font>&nbsp;&nbsp;<?php
								}
							}
						}
						if(($pagina - 1) > 0) { ?>
						   <a class="tooltip" href='<?php echo @$PHP_SELF;?>?registros=<?php echo @$registros;?>&total_paginas=<?php echo @$total_paginas;?>&pagina=1&palabra=<?php echo @$palabra;?>&gral=<?php echo @$gral;?>&nom_custo=<?php echo @base64_encode($nom_custo);?>&total_registros=<?php echo $total_registros;?>&asc=<?php echo @$asc;?>&chequeado=<?php echo $chequeado;?>&orderby=<?php echo @$orderby; if(isset($_GET['m'])){ ?>&m=m<?php } ?>'><img src='images/b_firstpage.png' width='16' align='absmiddle' height='16' border='0'><span onmouseover="this.style.cursor='pointer';" ><?php echo $registr1;?>...</span></a>&nbsp;
						   <a class="tooltip" href='<?php echo @$PHP_SELF;?>?registros=<?php echo @$registros;?>&total_paginas=<?php echo @$total_paginas;?>&pagina=<?php echo ($pagina-1);?>&palabra=<?php echo @$palabra;?>&gral=<?php echo @$gral;?>&nom_custo=<?php echo @base64_encode($nom_custo);?>&total_registros=<?php echo $total_registros;?>&chequeado=<?php echo $chequeado;?>&asc=<?php echo @$asc;?>&orderby=<?php echo @$orderby; if(isset($_GET['m'])){ ?>&m=m<?php } ?>'><img src='images/b_prevpage.png' width='16' align='absmiddle' height='16' border='0'><span onmouseover="this.style.cursor='pointer';" ><?php echo $registr3;?>...</span></a>&nbsp;<?php 
						}
						if(($pagina + 1)<=$total_paginas)  { ?>
							<a class="tooltip" href='<?php echo @$PHP_SELF;?>?registros=<?php echo @$registros;?>&total_paginas=<?php echo @$total_paginas;?>&pagina=<?php echo ($pagina+1);?>&palabra=<?php echo @$palabra;?>&gral=<?php echo @$gral;?>&nom_custo=<?php echo @base64_encode($nom_custo);?>&total_registros=<?php echo $total_registros;?>&chequeado=<?php echo $chequeado;?>&asc=<?php echo @$asc;?>&orderby=<?php echo @$orderby; if(isset($_GET['m'])){ ?>&m=m<?php } ?>'><img src='images/b_nextpage.png'  width='16' align='absmiddle' height='16' border='0'><span onmouseover="this.style.cursor='pointer';" ><?php echo $registr2;?>...</span></a>&nbsp;
							<a class="tooltip" href='<?php echo @$PHP_SELF;?>?registros=<?php echo @$registros;?>&total_paginas=<?php echo @$total_paginas;?>&pagina=<?php echo ($total_paginas);?>&chequeado=<?php echo $chequeado;?>&palabra=<?php echo @$palabra;?>&gral=<?php echo @$gral;?>&nom_custo=<?php echo @base64_encode($nom_custo)?>&total_registros=<?php echo $total_registros;?>&asc=<?php echo @$asc;?>&orderby=<?php echo @$orderby; if(isset($_GET['m'])){ ?>&m=m<?php } ?>'><img src='images/b_lastpage.png' width='16' align='absmiddle' height='16' border='0'><span onmouseover="this.style.cursor='pointer';" ><?php echo $registr4;?>...</span></a><?php
						}	
						if(($pagina - 1) > 0 OR ($pagina + 1)<=$total_paginas) { ?>
						    &nbsp;&nbsp;<?php echo $btpage;?>
						    <select name="pagina" id="pagina" onchange="DoSubmit();"><?php 
							for ($i=1; $i<=$total_paginas; $i++){ ?>
								<option value="<?php echo $i;?>" <?php if(($i) ==$pagina){ echo "selected";}?>><?php echo $i;?></option><?php
							} ?>
						</select>
						<input type="hidden" name="registros" value="<?php echo @$registros;?>">
						<input type="hidden" name="total_paginas" value="<?php echo $total_paginas;?>">
						<input type="hidden" name="palabra" value="<?php echo @$palabra;?>">
						<input type="hidden" name="total_registros"  value="<?php echo $total_registros;?>">
						<input type="hidden" name="nom_custo" value="<?php echo @base64_encode($nom_custo);?>" />
						<input name="chequeado" id="chequeado" type="hidden" value="<?php echo $chequeado;?>">
						<input type="hidden" name="gral" value="<?php echo @$gral;?>">
						<input type="hidden" name="orderby" value="<?php echo @$orderby;?>">
						<input type="hidden" name="asc" value="<?php echo @$asc;?>">
						<?php if(isset($_GET['m'])){ ?>
							<input type="hidden" name="m" value="m">
						<?php } 
						}
						?>
                  </form></div>
			  </td>
		    </tr>
		</table></td>
		<td></td>
	</tr>
</table>


