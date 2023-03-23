<?php
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Inform�ticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    24/03/2011 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jes�s N��ez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)							         		            #
# Licencia: Freeware                                                				                        #
#                                                                       			                        #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                 #
# LICENCIA: Este archivo es parte de REGIMED. REGIMED es un software libre; Usted lo puede redistribuir y/o #
# lo puede modificar bajo los t�rminos de la Licencia P�blica General GNU publicada por la Fundaci�n de     #
# Software Gratuito (the Free Software Foundation ); Ya sea la versi�n 2 de la Licencia, o (en su opci�n)   #
# cualquier posterior versi�n. REGIMED es distribuido con la esperanza de que ser� �til, pero SIN CUALQUIER #
# GARANT�A; Sin a�n la garant�a impl�cita de COMERCIABILIDAD o ADAPTABILIDAD PARA UN PROP�SITO PARTICULAR.  #
# Vea la Licencia P�blica General del GNU para m�s detalles. Usted deber�a haber recibido una copia de la   #
# Licencia  P�blica General de GNU junto con REGIMED. En Caso de que No, vea <http://www.gnu.org/licenses>. #
#############################################################################################################

header('Content-Type: image/svg+xml');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');

function get_color($get_name, $default)
{
    // get color from GET args, only alphanumeric chcracters
    $opts = array('options' => array('regexp' => '/^[a-z0-9]+$/i'));
    $color = filter_input(INPUT_GET, $get_name, FILTER_VALIDATE_REGEXP, $opts);
    if (preg_match('/^[a-f0-9]{6}$/', $color)) {
        return '#' . $color;
    }
    return $color ? $color : $default;
}
?>
<?php echo '<?xml Version="1.0" ?>' ?>
<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" Version="1.0" width="100%" height="100%">
    <defs>
        <linearGradient id="linear-gradient" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" stop-color="<?php echo get_color('from', 'white') ?>" stop-opacity="1" />
            <stop offset="100%" stop-color="<?php echo get_color('to', 'black') ?>" stop-opacity="1" />
        </linearGradient>
    </defs>
    <rect width="100%" height="100%" style="fill:url(#linear-gradient);" />
</svg>
