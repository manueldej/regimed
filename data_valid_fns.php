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
function filled_out($form_vars)
{
  // comprueba que cada variable tiene un valor
  foreach ($form_vars as $key => $value)
  {
     if (!isset($key) || ($value == "")) {
        return false;
	}
  }
  return true;
}

function valid_email($emailqty)
{
  // comprueba que la dirección email sea posiblemente válida
  if (ereg("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$", $emailqty))
    return true;
  else
    return false;
}

?>