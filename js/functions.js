$(document).ready(function()
{
	/**
    *@desc- retrasa el evento keyup
    *@param fn - function
    *@param ms - milisegundos que queremos retrasar
    */
    $.fn.delayPasteKeyUp = function(fn, ms)
    {
        var timer = 0;
        $(this).on("keyup paste", function()
        {
            clearTimeout(timer);
            timer = setTimeout(fn, ms);
        });
    };
 
    $("input[name=autocomplete]").delayPasteKeyUp(function()
    {
        $.ajax({
        	type: "POST",
            url: "http://localhost/regimed/autocomplete.php",
            data: "autocomplete="+$("input[name=autocomplete]").val(),
            success: function(data)
            {
            	if(data)
            	{
            		var json = JSON.parse(data),
          				html='<table class="table" border="0">';
						html+='<tr>';
						
            		if(json.res == 'full')
            		{
            			for(datos in json.data)
            			{
            				html+='<td>';
							html+='<a href="res.php?palabra='+json.data[datos].titulo+'">'+json.data[datos].titulo+'</a>';
            				html+='</td>';
							html+='</tr>';
						}
						
            		}
            		else
            		{
            			html+='<b>';
        				html+='No se ha encontrado nada con '+$("input[name=autocomplete]").val();
        				html+='</b>';
            		}
            		html+='</table>';
            		$("#busqueda").html("").append(html);
            	}
            }
        });
    }, 500);

	$(document).on("click", "a", function()
	{
		$("a").removeClass("active");
		$(this).addClass("active");
	})
});