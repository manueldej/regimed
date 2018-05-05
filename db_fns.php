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
 //
 
 if (@$_REQUEST["userid"] && @$_REQUEST["passwd"]){
  // Si el usuario ha intentado hacer login

  require_once('connections/miConex.php');
  
  $query = "select * from usuarios where login='".$userid."' and passwd='".$passwd."'";
  $result = mysqli_query($query, $miConex);

  if (mysqli_num_rows($result) >0 )  {
    // si est�n en la base de datos registra la id de usuario
   
   $valid_user = $_REQUEST ["userid"];
    session_register("valid_user");
  }
}

?>

