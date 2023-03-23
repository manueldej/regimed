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
<script type="text/javascript">
	function DoSubmit(pagi){
		var emptyForm = true;
		with (document.navga){      
			emptyForm = (pagina.value == "");		
			if (!emptyForm)	{
				pagina.value=pagi;
				submit();	
			}	
		}
	}
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td></td>
		<td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="middle"><div class="navegador dataTables_paginate paging_full_numbers"> 
					<form action="buscador.php" method="get" name="navga" id="navga">
					  <?php 
						if($registros >= $total_registros){ echo $bttotalreg;?>: <font color='red'><?php echo $total_registros;?></font>&nbsp;&nbsp;<?php
						}else{
							if($pagina == 1) {
								if(@$p !=1){ ?>
									<?php echo $totalrecord1;?> <font color='red'>1</font> <?php echo $totalrecord3;?> <font color='red'><?php echo $p;?></font> <?php echo $de;?> <font color='blue'><?php echo $total_registros;?></font>&nbsp;&nbsp;<?php
								}else{ ?>
									<?php echo $registr5;?> <font color='red'>1</font> <?php echo $de;?> <font color='blue'> <?php echo $total_registros;?></font>&nbsp;&nbsp;<?php
								}
							}else  {
								if(@$p !=1){ ?>
									<?php echo $totalrecord1;?><font color='red'><?php echo ($inicio+1);?></font> <?php echo $totalrecord3;?> <font color='red'><?php echo ($inicio + $p);?></font> <?php echo $de;?> <font color='blue'><?php echo $total_registros;?></font>&nbsp;&nbsp;<?php
								}else{ ?>
									<?php echo $registr5;?> <font color='red'><?php echo ($inicio + 1);?></font> <?php echo $de;?> <font color='blue'><?php echo $total_registros;?></font>&nbsp;&nbsp;<?php
								}
							}
						}
						if(($pagina - 1) > 0) { ?>
						   <a href='buscador.php?registros=<?php echo @$registros;?>&total_paginas=<?php echo @$total_paginas;?>&pagina=1&palabra=<?php echo @$palabra;?>&gral=<?php echo @$gral;?>&nom_custo=<?php echo @$nom_custo;?>&total_registros=<?php echo $total_registros;?>&asc=<?php echo @$asc;?>&orderby=<?php echo @$orderby; if(isset($_GET['m'])){ ?>&m=m<?php } ?>'><span onmouseover="this.style.cursor='pointer';" class="last paginate_button" ><?php echo $registr1;?>...</span></a>&nbsp;
						   <a href='buscador.php?registros=<?php echo @$registros;?>&total_paginas=<?php echo @$total_paginas;?>&pagina=<?php echo ($pagina-1);?>&palabra=<?php echo @$palabra;?>&gral=<?php echo @$gral;?>&nom_custo=<?php echo @$nom_custo;?>&total_registros=<?php echo $total_registros;?>&asc=<?php echo @$asc;?>&orderby=<?php echo @$orderby; if(isset($_GET['m'])){ ?>&m=m<?php } ?>'><span onmouseover="this.style.cursor='pointer';" class="previous paginate_button"><?php echo $registr3;?>...</span></a>&nbsp;<?php 
						}
						if(($pagina + 1)<=$total_paginas)  { ?>
							<a href='buscador.php?registros=<?php echo @$registros;?>&total_paginas=<?php echo @$total_paginas;?>&pagina=<?php echo ($pagina+1);?>&palabra=<?php echo @$palabra;?>&gral=<?php echo @$gral;?>&nom_custo=<?php echo @$nom_custo;?>&total_registros=<?php echo $total_registros;?>&asc=<?php echo @$asc;?>&orderby=<?php echo @$orderby; if(isset($_GET['m'])){ ?>&m=m<?php } ?>'><span onmouseover="this.style.cursor='pointer';" class="next paginate_button"><?php echo $registr2;?>...</span></a>&nbsp;
							<a href='buscador.php?registros=<?php echo @$registros;?>&total_paginas=<?php echo @$total_paginas;?>&pagina=<?php echo ($total_paginas);?>&palabra=<?php echo @$palabra;?>&gral=<?php echo @$gral;?>&nom_custo=<?php echo @$_GET['nom_custo']?>&total_registros=<?php echo $total_registros;?>&asc=<?php echo @$asc;?>&orderby=<?php echo @$orderby; if(isset($_GET['m'])){ ?>&m=m<?php } ?>'><span onmouseover="this.style.cursor='pointer';" class="previous paginate_button"><?php echo $registr4;?>...</span></a><?php
						}	
						if(($pagina - 1) > 0 OR ($pagina + 1)<=$total_paginas) { ?>
						   <span>
							<?php for ($i=1; $i<=$total_paginas; $i++){ ?>
								<span onclick="DoSubmit('<?php echo $i; ?>');" <?php if($i==$pagina) { ?>class="paginate_active"<?php }else{ ?>class="paginate_button"<?php } ?>><?php if ($i==$pagina) { ?><b><?php } ?><?php echo $i; ?><?php if ($i==$pagina) { ?></b><?php } ?></span>
							<?php } ?>
						   </span>	
						<input type="hidden" name="pagina" id="pagina" value="<?php echo $i;?>">
						<input type="hidden" name="registros" value="<?php echo @$registros;?>">
						<input type="hidden" name="total_paginas" value="<?php echo $total_paginas;?>">
						<input type="hidden" name="palabra" value="<?php echo @$palabra;?>">
						<input type="hidden" name="total_registros"  value="<?php echo $total_registros;?>">
						<input type="hidden" name="nom_custo" value="<?php echo @$nom_custo;?>" />
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


