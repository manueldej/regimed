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

function check_auth_user(){    
	global $_SESSION;
    if (isset($_SESSION['valid_user']) && (session_id()!=="")) {
	  return true;
    } else {
		return false;   
	}  
}
    function convDate($time) {

      if (is_null($time) || ($time == 'NULL')) {
         return NULL;
      }

      if (!isset($_SESSION["regimeddate_format"])) {
         $_SESSION["regimeddate_format"] = 0;
      }

      switch ($_SESSION['regimeddate_format']) {
         case 1 : // DD-MM-YYYY
            $date  = substr($time, 8, 2)."/";  // day
            $date .= substr($time, 5, 2)."/"; // month
            $date .= substr($time, 0, 4);     // year
            return $date;

         case 2 : // MM-DD-YYYY
            $date  = substr($time, 5, 2)."/";  // month
            $date .= substr($time, 8, 2)."/"; // day
            $date .= substr($time, 0, 4);     // year
            return $date;

         default : // YYYY-MM-DD
            if (strlen($time)>10) {
               return substr($time, 0, 10);
            }
            return $time;
      }
    }
?>