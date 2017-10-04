<?php
function leyendaActividades(){ ?>
	<div id="leyenda" class="row inset">
		<div id="leyenda" class="col-md-4 col-xs-4 nopadding">
			<span class="label label-success">&nbsp;</span> <small class="text-muted">Evento</small>
		</div>
		<div id="leyenda" class="col-md-4 col-xs-4 nopadding">
			<span class="label label-warning">&nbsp;</span> <small class="text-muted">Contenido</small>
		</div>
		<div id="leyenda" class="col-md-4 col-xs-4 nopadding">
			<span class="label label-danger">&nbsp;</span> <small class="text-muted">Curso</small>
		</div>
	</div>
<?php }

function modalActividad(){ ?>
<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-actividades">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title" id="act_titulo" ></h3>
				<span id="act_estado"><i></i></span>
			</div>
			<div class="modal-body">
			<div class= "row">
					<label  for="act_escuela"><strong>Escuela: </strong> </label>
					<span id="act_escuela"><i></i></span>
				</div>
				<div class= "row">
					<label  for="act_usuario"><strong>Usuario: </strong> </label>
					<span id="act_usuario"><i></i></span>
				</div>
				<div class= "row">
					<label  for="act_descripcion"><strong>Descripción: </strong> </label>
					<span id="act_descripcion"><i></i></span>
				</div>
				<div class= "row">
					<label  for="act_categoria"><strong>Categoría: </strong> </label>
					<span id="act_categoria"><i></i></span>
				</div>
				<div class= "row">
					<label  for="act_inicio"><strong>Fecha inicio: </strong></label>
					<span id="act_inicio"><i></i></span>
				</div>
				<div class= "row">
					<label  for="act_fin"><strong>Fecha fin: </strong> </label>
					<span id="act_fin"><i></i></span>
				</div>
				<div class= "row">
					<label  for="act_tipo"><strong>Tipo: </strong> </label>
					<span id="act_tipo"><i></i></span>
				</div>
				<div class= "row">
					<label  for="act_creditos"><strong>Presupuesto: </strong> </label>
					<span id="act_creditos"><i></i></span>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php } ?>