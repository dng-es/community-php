jQuery(document).ready(function(){
	getCalendar();

	$("#delete_evento").click(function(e){
		e.preventDefault();
		location.href = "?page=alerts-calendar&act=dela&id=" + $(this).data("evento");
	});

	var year_ini = $.getURLParam("y"),
		month_ini = $.getURLParam("m"),
		day_ini = $.getURLParam("d");
	if (year_ini > 0 && month_ini > 0 && day_ini > 0) $('#calendar').fullCalendar( 'gotoDate', year_ini + '/' + month_ini + '/' + day_ini )

function getCalendar(){
		// var nombre =$.getURLParam("nombre");
		// var tipo =$.getURLParam("tipo");
		// var categoria =$.getURLParam("categoria");
		// var estado =$.getURLParam("estado");
		// var fechaIni =$.getURLParam("fecha_ini");
		// var fechaFin =$.getURLParam("fecha_fin");

		$("#cargandoCalendar").css("display", "inline");
		var zone = "05:30";

		$('#calendar').fullCalendar({
			header: {
				left:'title' ,
				//right: 'prev,next today',
				//right: 'month,agendaWeek,agendaDay'
				right: 'today prev,next month,agendaWeek,agendaDay,listMonth'
			},
			selectable: true,
			selectHelper: true,
			prev: 'left-single-arrow trigger-prev',
			next: 'right-single-arrow',
			prevYear: 'left-double-arrow',
			nextYear: 'right-double-arrow',
			height: 500,
			navLinks: true, // can click day/week names to navigate views
			businessHours: true,
			gotoDate : '2017/05/01',
			//editable: true,

			// add event name to title attribute on mouseover
  		    events: function(start, end, timezone, callback) {
		        $.ajax({
		            url: 'app/modules/alerts/pages/alerts-calendar-ajax.php',
		            dataType: 'json',
		            cache: false,
		           success: function(data) {
		                $("#cargandoCalendar").css("display", "none");
		                 $("#calendar").css("font-size","12px");

		                callback(data);
		            }
		        });
		    },

		    eventClick: function(data) {
				$("#modal-calendar #calendar_titulo").html(data["title"]);
				$("#modal-calendar #calendar_icon").html("<i class='fa fa-" + data["imageurl"] + "'></i>");
				$("#modal-calendar #calendar_text").html(data["text_alert"]);
				$("#modal-calendar #calendar_tipo").html("<span class='text-muted'>Tipo:</span> " + data["tipo_alerta"]);
				$("#modal-calendar #calendar_inicio").html("<span class='text-muted'>Inicio:</span> " + data["date_ini"]);
				$("#modal-calendar #calendar_fin").html("<span class='text-muted'>Fin:</span> " + data["date_fin"]);
				$("#modal-calendar #delete_evento").data("evento", data["id"]);
				if (data["nombre_archivo"] != ""){
					$("#modal-calendar #nombre_archivo").html("<a target='_blank' href='docs/showfile.php?file=" + data["nombre_archivo"] + "'>Descargar documentación</a>");
				}

				if ($("#user_perfil").val() != 'admin' && $("#user_empresa").val() != data["tienda"]){
					$("#calendar-footer").addClass("hidden");
				}
				else{
					$("#calendar-footer").removeClass("hidden");
				}

				$("#modal-calendar").modal();
    		},
    		eventMouseover: function(data, jsEvent, view) {
		         $(jsEvent.target).attr('title', data["title"]);
    		},
    		eventRender: function(event, eventElement) {
				if (event.imageurl) {
					eventElement.find("div.fc-content").prepend("<i style='font-size:24px; margin:0 10px 10px 0' class='fa fa-" + event.imageurl +"' ></i>").css({"padding": "5px", "cursor": "pointer"});
				}
			},
			eventAfterAllRender: function(){
				$('#calendar').find("th.fc-widget-header").css({"padding-top": "10px", "padding-bottom": "10px", "color":"#fff"});
			}
		});

	}
})