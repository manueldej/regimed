/*Datos*/ 
/*Aplicaciones*/
var dataApp = [
/*  [0]categoria   [1]nombre    [2]version        [3]paquete                 [4]descripCorta                     [5]Autor             [6]Correo          [7] Desciption larga*/
	[ 0, 'Alarife3', '26.04.2013', 'alarife3_26.04.2013.zip', 'Generador de sitios web y enciclopedias temáticas.', 'Manzinella Digital', 'delio@ahmzllo.granma.inf.cu', 'Alarife III es una aplicación cliente servidor y multiplataforma. De forma gráfica y sin poseer conocimientos de programación o diseño gráfico, Ud. puede construir un compendio informativo o enciclopedia temática. Para usar el programa descomprima el fichero y copie la carpeta resultante donde su servidor gestione los sitios web. Si trabaja en un servidor local teclee en su navegador http://localhost/alarife y siga las indicaciones del asistente de instalación.' ],
	[ 0, 'Alarife4', '10.05.2013', 'alarife4_10.05.2013_i386.deb', 'Constructor de sitios web y enciclopedias temáticas.', 'Manzinella Digital y Multisystem', 'soporte-alarife@ahmzllo.granma.inf.cu', 'Alarife 4 es una aplicación desktop que le permite crear y generar un sitio web o una enciclopedia temática en función de la cantidad, diversidad y profundidad de la indormación empleada. Ud. sin conocimientos de diseño gráfico o programación web puede hacer su compendio o enciclopedia; solo necesita registrar la información, las imágenes, los vídeos y el sonido y relacionarlos; Alarife se encargará del resto.' ],
	[ 0, 'Alfidi', '01.05.2013', 'alfidi_01.05.2013_i386.deb', 'Almacén de ficheros digitales.', 'Maikel Pernía Matos', 'corba@grannet.grm.sld.cu', 'Alfidi le permite gestionar ficheros digitales de cualquier tipo los cuales se dividen en dos grandes grupos: programas y productos. Con Alfidi Ud. puede crear un ftp portable, compartir sus ficheros con terceros y/o localizarlos fácilmente. Alfidi es un almacén, no un rastro.' ],
	[ 0, 'Catalogo', '08.05.2013', 'catalogo.zip', 'Catalogador para archivos y bibliotecas.', 'Carlos Pollán Estrada', 'cpollan@ahmzllo.granma.inf.cu', 'Esta es una herramienta cliente servidor y multiplataforma. Para usar el programa solo debe descomprimir el fichero y copiar la carpeta resultante en el directorio donde su servidor gestiona los sitios web. Si es un servidor local, deberá teclear en su navegador: http://localhost/catalogo y luego seguir las indicaciones del asistente de instalación.' ],
	[ 0, 'Cax', '0.2', 'cax_0.2-beta_i386.deb', 'Compresor de aplicaciones.', ' Maikel Pernía Matos', 'corba@grannet.grm.sld.cu', 'Interfaz gráfica para comprimir aplicaciones utilizando "strip" y "upx".' ],
	[ 0, 'Cyu-qt', '1.1', 'cyu-qt_1.1_i386.deb', 'Cortar y unir ficheros.', 'Maikel Pernía Matos', 'corba@grannet.grm.sld.cu', 'Interfaz gráfica para cortar y unir ficheros. Se ha probado con archivos de hasta 500 Mbytes.' ],
	[ 0, 'Dbsigex', '23.04.2013', 'dbsigex_23.04.2013.zip', 'Gestor de base de datos MySQL.', 'Carlos Pollán Estrada', 'cpollan@ahmzllo.granma.inf.cu', 'DBSiGEX, inspirado en PhpMyAdmin, es una herramienta cliente servidor para gestionar bases de datos diseñadas en MySQL. Para su uso sólo debe descomprimir el fichero y copiar la carpeta resultante en el directorio donde su servidor gestiona los sitios web. Para ejecutarlo, si está empleando un servidor local, debe teclear en la barra de su navegador http://localhost/dbsigex y seguir las instrucciones del asistente de instalación.' ],
	[ 0, 'Eidmat', '3', 'eidmat3.2009.zip', 'Frontend para octave desarrollado en python con Gtk.', 'Grupo EIDMAT', 'alexeis@uci.cu', 'Esta versión de EIDMAT está siendo editada para buscar su compatibilidad con los Ubuntu por encima del 10.04, pero a partir de este o uno superior ya no se puede correr más por la desaparición de bibliotecas que quedaron en desuso, tenga pues en cuenta este detalle a la hora de Ejecutarlo. Para usar el programa es preciso descompactarlo y leer el manual que está en formato .pdf' ],
	[ 0, 'iMEdia', '-', 'iMEdia.zip', 'Almacén de video.', 'Yoel Benítez Fonseca', 'mark@grm.uci.cu', 'iMedia es un almacen de video, permite también la reproducción via HTTP de los videos almacendos. De cada archivo almacenado se mantienen 2 copias 1 en el formato original y otra en formato OGV reproducible por la mayoría de los navegadores. Para usar el programa descompacte el fichero y lea el archivo README.TXT que está dentro de la carpeta iMEdia.' ],
	[ 0, 'Idesk-lanzador', '12.04.2013', 'idesk-lanzador_12.04.2013_i386.deb', 'Configurador de escritorio.', 'Maikel Pernía Matos', 'corba@grannet.grm.sld.cu', 'Con esta aplicación Ud. puede colocar íconos de acceso directo en el escritorio y fondos de pantalla. Facilita el uso de gestores de ventanas con apariencia austera como icewm, openbox, fluxbox, jwm, awesome, fvwm, etc.' ],
	[ 1, 'Intranet', '3.0', 'intranet.zip', 'Plataforma libre para la gestión de procesos.', 'Facultad Regional de la UCI en Granma', '-', 'Es una aplicación cliente servidor que gestiona distintos procesos dentro de la Facultad Regional de la UCI en Granma. Para el uso del programa, descompacte el fichero y siga las instrucciones del fichero README.TXT que se encuentra dentro de la carpeta «intranet».' ],
	[ 1, 'Isocrea', '1.0', 'isocrea.zip', 'Copia exacta de un sistema Debian para crear imágenes ISO booteables.', ' Haylem Candelario Bauzá', 'haylem@inor.sld.cu', 'Isocrea es una aplicación que permite realizar una copia exacta con configuraciones de su sistema operativo Linux Debian para generar una imagen ISO booteable. Luego podrá quemar esta en un CD-ROM para uso como disco live o instalar en una memoria flash mediante el programa unetbootin o manual. Para usar el programa descomprima el fichero y siga las instrucciones que se ofrecen en el archivo "manualISOCREA.pdf "' ],
	[ 0, 'Man-editor', '1.0.1', 'man-editor_1.0.1_i386.deb', 'Editar páginas del man.', 'Maikel Pernía Matos', 'corba@grannet.grm.sld.cu', 'Este es un editor hecho para facilitarle la creación y edición de las páginas del "man" de sus programas.' ],
	[ 1, 'Misox', '01.05.2013', 'misox_01.05.2013_i386.deb', 'Generador de distros empleando repo estable de Debian.', 'Equipo desarrollador de MiSOX', 'misox@ahmzllo.granma.inf.cu', 'MiSOX le permite, de manera totalmente gráfica, generar una distribución a la medida empleando un repo de Debian estable. Ud. puede escoger, como escritorio, Gnome, XFCE, LXDE, Enlightenment o cualquiera de los siguientes Gestores de Ventana: fluxbox, blackbox, openbox, icewm, jwm, fvwm, wmaker, pekwm y awesome. Los gestores de sesión a usar son GDM, GDM3 y SLIM.' ],
	[ 1, 'Piviewer', '2.1', 'piviewer2.1.zip', 'Visor de imágenes panorámicas.', 'Yenner Joaquín Díaz', 'yjdiaz@grm.uci.cu', 'El sistema permite ampliar, disminuir y descargar la panorámica correspondiente, desplazarse entre los espacios del lugar, realizar una visita guiada en forma de vídeo con voz en off. Muestra las panorámicas con que cuenta el local, en forma de fotos en miniaturas, a las cuales el usuario puede acceder. Realiza una visita guiada con el sonido de cada panorámica respectivamente, dando la sensación de un video por el sitio. Para usar el programa descompacte el fichero .zip y ábralo en la web.' ],
	[ 1, 'Regcel', '1.2', 'regcel_0.1.2_i386.deb', 'Controlar el consumo eléctrico en empresas y hogares.', 'Yunior Barceló Chávez', 'barcelo@ssp.co.cu', 'La herramienta permite llevar el control sobre el consumo de la energía eléctrica tanto en las empresas como en los hogares; con ella podremos guardar en una base de datos las lecturas que se tomen periódicamente del contador eléctrico, la aplicación nos devolverá automáticamente los Kw/h consumidos y también opcionalmente se podrá generar un importe a pagar según la tarifa seleccionada, luego podremos crear facturas con los registros almacenados.' ],
];

/*Productos*/
var dataProd = [
/*  [0]categoria   [1]nombre    [2]version        [3]paquete                 [4]descripCorta                     [5]Autor             [6]Correo          [7] Desciption larga*/
	[ 0, 'Prod 1', '**26.04.2013', 'alarife3_26.04.2013.zip', 'Generador de sitios web y enciclopedias temáticas.', 'Manzinella Digital', 'delio@ahmzllo.granma.inf.cu', 'Alarife III es una aplicación cliente servidor y multiplataforma. De forma gráfica y sin poseer conocimientos de programación o diseño gráfico, Ud. puede construir un compendio informativo o enciclopedia temática. Para usar el programa descomprima el fichero y copie la carpeta resultante donde su servidor gestione los sitios web. Si trabaja en un servidor local teclee en su navegador http://localhost/alarife y siga las indicaciones del asistente de instalación.' ],
	[ 1, 'Prod 2', '**10.05.2013', 'alarife4_10.05.2013_i386.deb', 'Constructor de sitios web y enciclopedias temáticas.', 'Manzinella Digital y Multisystem', 'soporte-alarife@ahmzllo.granma.inf.cu', 'Alarife 4 es una aplicación desktop que le permite crear y generar un sitio web o una enciclopedia temática en función de la cantidad, diversidad y profundidad de la indormación empleada. Ud. sin conocimientos de diseño gráfico o programación web puede hacer su compendio o enciclopedia; solo necesita registrar la información, las imágenes, los vídeos y el sonido y relacionarlos; Alarife se encargará del resto.' ],
	[ 2, 'Prod 3', '**01.05.2013', 'alfidi_01.05.2013_i386.deb', 'Almacén de ficheros digitales.', 'Maikel Pernía Matos', 'corba@grannet.grm.sld.cu', 'Alfidi le permite gestionar ficheros digitales de cualquier tipo los cuales se dividen en dos grandes grupos: programas y productos. Con Alfidi Ud. puede crear un ftp portable, compartir sus ficheros con terceros y/o localizarlos fácilmente. Alfidi es un almacén, no un rastro.' ],
	[ 3, 'Prod 4', '**08.05.2013', 'catalogo.zip', 'Catalogador para archivos y bibliotecas.', 'Carlos Pollán Estrada', 'cpollan@ahmzllo.granma.inf.cu', 'Esta es una herramienta cliente servidor y multiplataforma. Para usar el programa solo debe descomprimir el fichero y copiar la carpeta resultante en el directorio donde su servidor gestiona los sitios web. Si es un servidor local, deberá teclear en su navegador: http://localhost/catalogo y luego seguir las indicaciones del asistente de instalación.' ],
	[ 4, 'Prod 5', '**0.2', 'cax_0.2-beta_i386.deb', 'Compresor de aplicaciones.', ' Maikel Pernía Matos', 'corba@grannet.grm.sld.cu', 'Interfaz gráfica para comprimir aplicaciones utilizando "strip" y "upx".' ],
	[ 5, 'Prod 6', '**1.1', 'cyu-qt_1.1_i386.deb', 'Cortar y unir ficheros.', 'Maikel Pernía Matos', 'corba@grannet.grm.sld.cu', 'Interfaz gráfica para cortar y unir ficheros. Se ha probado con archivos de hasta 500 Mbytes.' ],
	[ 6, 'Prod 7', '**23.04.2013', 'dbsigex_23.04.2013.zip', 'Gestor de base de datos MySQL.', 'Carlos Pollán Estrada', 'cpollan@ahmzllo.granma.inf.cu', 'DBSiGEX, inspirado en PhpMyAdmin, es una herramienta cliente servidor para gestionar bases de datos diseñadas en MySQL. Para su uso sólo debe descomprimir el fichero y copiar la carpeta resultante en el directorio donde su servidor gestiona los sitios web. Para ejecutarlo, si está empleando un servidor local, debe teclear en la barra de su navegador http://localhost/dbsigex y seguir las instrucciones del asistente de instalación.' ],
	[ 0, 'Prod 8', '**3', 'eidmat3.2009.zip', 'Frontend para octave desarrollado en python con Gtk.', 'Grupo EIDMAT', 'alexeis@uci.cu', 'Esta versión de EIDMAT está siendo editada para buscar su compatibilidad con los Ubuntu por encima del 10.04, pero a partir de este o uno superior ya no se puede correr más por la desaparición de bibliotecas que quedaron en desuso, tenga pues en cuenta este detalle a la hora de Ejecutarlo. Para usar el programa es preciso descompactarlo y leer el manual que está en formato .pdf' ],
	[ 1, 'Prod 9', '**-', 'iMEdia.zip', 'Almacén de video.', 'Yoel Benítez Fonseca', 'mark@grm.uci.cu', 'iMedia es un almacen de video, permite también la reproducción via HTTP de los videos almacendos. De cada archivo almacenado se mantienen 2 copias 1 en el formato original y otra en formato OGV reproducible por la mayoría de los navegadores. Para usar el programa descompacte el fichero y lea el archivo README.TXT que está dentro de la carpeta iMEdia.' ],
	[ 2, 'Prod 10', '**12.04.2013', 'idesk-lanzador_12.04.2013_i386.deb', 'Configurador de escritorio.', 'Maikel Pernía Matos', 'corba@grannet.grm.sld.cu', 'Con esta aplicación Ud. puede colocar íconos de acceso directo en el escritorio y fondos de pantalla. Facilita el uso de gestores de ventanas con apariencia austera como icewm, openbox, fluxbox, jwm, awesome, fvwm, etc.' ],
	[ 3, 'Prod 11', '**3.0', 'intranet.zip', 'Plataforma libre para la gestión de procesos.', 'Facultad Regional de la UCI en Granma', '-', 'Es una aplicación cliente servidor que gestiona distintos procesos dentro de la Facultad Regional de la UCI en Granma. Para el uso del programa, descompacte el fichero y siga las instrucciones del fichero README.TXT que se encuentra dentro de la carpeta «intranet».' ],
	[ 4, 'Prod 12', '**1.0', 'isocrea.zip', 'Copia exacta de un sistema Debian para crear imágenes ISO booteables.', ' Haylem Candelario Bauzá', 'haylem@inor.sld.cu', 'Isocrea es una aplicación que permite realizar una copia exacta con configuraciones de su sistema operativo Linux Debian para generar una imagen ISO booteable. Luego podrá quemar esta en un CD-ROM para uso como disco live o instalar en una memoria flash mediante el programa unetbootin o manual. Para usar el programa descomprima el fichero y siga las instrucciones que se ofrecen en el archivo "manualISOCREA.pdf "' ],
	[ 5, 'Prod 13', '**1.0.1', 'man-editor_1.0.1_i386.deb', 'Editar páginas del man.', 'Maikel Pernía Matos', 'corba@grannet.grm.sld.cu', 'Este es un editor hecho para facilitarle la creación y edición de las páginas del "man" de sus programas.' ],
	[ 6, 'Prod 14', '**01.05.2013', 'misox_01.05.2013_i386.deb', 'Generador de distros empleando repo estable de Debian.', 'Equipo desarrollador de MiSOX', 'misox@ahmzllo.granma.inf.cu', 'MiSOX le permite, de manera totalmente gráfica, generar una distribución a la medida empleando un repo de Debian estable. Ud. puede escoger, como escritorio, Gnome, XFCE, LXDE, Enlightenment o cualquiera de los siguientes Gestores de Ventana: fluxbox, blackbox, openbox, icewm, jwm, fvwm, wmaker, pekwm y awesome. Los gestores de sesión a usar son GDM, GDM3 y SLIM.' ],
	[ 0, 'Prod 15', '**2.1', 'piviewer2.1.zip', 'Visor de imágenes panorámicas.', 'Yenner Joaquín Díaz', 'yjdiaz@grm.uci.cu', 'El sistema permite ampliar, disminuir y descargar la panorámica correspondiente, desplazarse entre los espacios del lugar, realizar una visita guiada en forma de vídeo con voz en off. Muestra las panorámicas con que cuenta el local, en forma de fotos en miniaturas, a las cuales el usuario puede acceder. Realiza una visita guiada con el sonido de cada panorámica respectivamente, dando la sensación de un video por el sitio. Para usar el programa descompacte el fichero .zip y ábralo en la web.' ],
	[ 1, 'Prod 16', '**1.2', 'regcel_0.1.2_i386.deb', 'Controlar el consumo eléctrico en empresas y hogares.', 'Yunior Barceló Chávez', 'barcelo@ssp.co.cu', 'La herramienta permite llevar el control sobre el consumo de la energía eléctrica tanto en las empresas como en los hogares; con ella podremos guardar en una base de datos las lecturas que se tomen periódicamente del contador eléctrico, la aplicación nos devolverá automáticamente los Kw/h consumidos y también opcionalmente se podrá generar un importe a pagar según la tarifa seleccionada, luego podremos crear facturas con los registros almacenados.' ],
];

var nombreApp = ['Alarife3', 'Alarife4', 'Alfidi', 'Catalogo', 'Cax', 'Cyu-qt', 'Dbsigex', 'Eidmat', 'iMEdia', 'Idesk-lanzador', 'Intranet', 'Isocrea', 'Man-editor', 'Misox', 'Piviewer', 'Regcel'];

var nombreProd = ['Prod 1', 'Prod 2', 'Prod 3', 'Prod 4', 'Prod 5', 'Prod 6', 'Prod 7', 'Prod 8', 'Prod 9', 'Prod 10', 'Prod 11', 'Prod 12', 'Prod 13', 'Prod 14', 'Prod 15', 'Prod 16'];
