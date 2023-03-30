<?php
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.0.1                                                     				                        #
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
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
?>
<script type="text/javascript">
	(function( $ ){
		var s;
		// Methods
		var m = {
			init: function(){},
			start: function(){},
			complete: function(){},
			error: function(){
				return 0;
			},
			traverse: function(files, input, area){
				if (typeof files !== "undefined") {
					for (var i=0, l=files.length; i<l; i++) {
						m.control(files[i], input, area);
					}
				} else {
					area.html(nosupport);
				}
			},
			control: function(file, input, area){
				
				var tld = file.name.toLowerCase().split(/\./);
				tld = tld[tld.length -1];       	
			  
					m.upload(file, input, area);
			},
			upload: function(file, input, area){
				
				area.find('div').empty();
				var progress = $('<div>',{
					'class':'progress'
				});
				area.append(progress);
				
				// Uploading - for Firefox, Google Chrome and Safari
				var xhr = new XMLHttpRequest();
				xhr.open("post", input.data('post'), true);
				xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
				// Update progress bar
				xhr.upload.addEventListener("progress", function (e) {
					if (e.lengthComputable) {
						var loaded = Math.ceil((e.loaded / e.total) * 100);
						progress.css({
							'height':loaded + "%",
							'line-height': (area.height() * loaded / 100) +'px'
						}).html(loaded + "%");
					}
				}, false);
				// File uploaded
				xhr.addEventListener("load", function (e) {
					var result = jQuery.parseJSON(e.target.responseText);
					
					// Calling complete function
					s.complete(result, file, input, area);
					progress.addClass('uploaded');
					progress.html(s.uploaded).fadeOut('slow');
					
					
				}, false);
			 
				// Create a new formdata
				var fd = new FormData();
				// Add optional form data
				for (var i in input.data())
					if (typeof input.data(i) !== "object")
						fd.append(i, input.data(i));
				// Add file data
				fd.append(input.attr('name'), file);
				// Send data
				xhr.send(fd);
			},
			dataURItoBlob: function(dataURI){
				// for check the original function: http://stackoverflow.com/questions/4998908/
				// convert base64 to raw binary data held in a string
				// doesn't handle URLEncoded DataURIs
				var byteString = atob(dataURI.split(',')[1]);
				// separate out the mime component
				var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]
				// write the bytes of the string to an ArrayBuffer
				var ab = new ArrayBuffer(byteString.length);
				var ia = new Uint8Array(ab);
				for (var i = 0; i < byteString.length; i++) {
					ia[i] = byteString.charCodeAt(i);
				}
				// write the ArrayBuffer to a blob, and you're done
				var bb = new (window.BlobBuilder || window.WebKitBlobBuilder || window.MozBlobBuilder)();
				bb.append(ab);
				return bb.getBlob(mimeString);
			}
		};
		$.fn.droparea = function(o) {
			// Settings
			s = {
				'init'        : m.init,
				'start'       : m.start,
				'complete'    : m.complete,
				'instructions': '<?php echo $arrastrar1;?>',
				'over'        :'<?php echo $arrastrar2;?>' ,
				'nosupport'   : '<?php echo $arrastrar3;?>',
				'noimage'     : '<?php echo $arrastrar4;?>',
				'uploaded'    : '<?php echo $arrastrar5;?>',
				'maxsize'     : '10' //Mb
			};
			if(o) $.extend(s, o);
			this.each(function(){
				var area = $('<div class="'+$(this).attr('class')+'">').insertAfter($(this));
				var instructions = $('<div>').appendTo(area);
				var input = $(this).appendTo(area);
				//var input = $('<input type="file" multiple>').appendTo($(this));
				
				s.init($(this));            
				if(input.data('value') && input.data('value').length)
					$('<img src="'+input.data('value')+'">').appendTo(area);
				else 
					instructions.addClass('instructions').html(s.instructions);

				// Drag events
				$(document).bind({
					dragleave: function (e) {
						e.preventDefault();
						if(input.data('value') || area.find('img').length)
							instructions.removeClass().empty();
						else
							instructions.removeClass('over').html(s.instructions);
					},
					drop: function (e) {
						e.preventDefault();
						if(input.data('value') || area.find('img').length)
							instructions.removeClass().empty();
						else
							instructions.removeClass('over').html(s.instructions);
					},
					dragenter: function (e) {
						e.preventDefault();
						instructions.addClass('instructions over').html(s.over);
					},
					dragover: function (e) {
						e.preventDefault();
						instructions.addClass('instructions over').html(s.over);
					}
				});
				
				// Drop file event
				this.addEventListener("drop", function (e) {
					e.preventDefault();
					s.start($(this));
					m.traverse(e.dataTransfer.files, input, area);
					instructions.removeClass().empty();
				},false);
				
				// Browse file event
				input.change(function(e){
					m.traverse(e.target.files, input, area);
				});
			   
			});
		};
	})( jQuery );
</script>
