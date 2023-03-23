<!DOCTYPE html>
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
  <body onload="parametro(<?php echo $captura; ?>)">
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript">
	// var miVariable = screen.width + " " + screen.height; 
	
	// function parametro(captura){
		// console.log(captura); 
		
		// if(captura=='No'){
			// window.location="prueba.php?variable=miVariable";
		// }    
	// }         
	
	function proceso(){
		var nombre = $('#variable').val();
        //document.envia.submit();
		
		$.post('prueba.php',{variable:nombre},function(data){
			if (data !=null){
				alert('Los datos se enviaron correctamente');
			}else{ 
			   alert('Error recibiendo datos');
			}
		});
	} 	
</script>
   <form name="envia" enctype="multipart/form-data" method="post" >
	   <select id="variable" name="variable" onchange="proceso();">
			<option value="-1">...</option>
			<option value="1" <?php if (@$mivar =='1'){ echo "selected"; }?>>1</option>
			<option value="2" <?php if (@$mivar =='2'){ echo "selected"; }?>>2</option>
			<option value="3" <?php if (@$mivar =='3'){ echo "selected"; }?>>3</option>
	   </select>
  </form>

<?php
    //$mivar ="<script>document.write(nombre);</script>";
	//echo $mivar;
	
	$variable = @$_POST["variable"];
    echo $variable;
?>
</body>
</html>


