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
