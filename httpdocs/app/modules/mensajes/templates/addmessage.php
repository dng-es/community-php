<?php
function addMensaje(){ ?>

<!-- Modal -->
<div class="modal modal-wide fade" id="new_mensaje" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><?php echo strTranslate("New_message");?></h4>
			</div>
			<div class="modal-body">		
				<form id="message-form" name="message-form" action="" method="post">
					<input type="hidden" name="remitente-comentario" id="remitente-comentario" value="<?php echo $_SESSION['user_name'];?>" />
				 	<div class="form-group">
					 	<label for="nick-comentario"><?php echo strTranslate("Mailing_recipient");?> / <?php echo strTranslate("Nick");?>:</label>
						<input maxlength="100" name="nick-comentario" id="nick-comentario" type="text" class="form-control" value="" />
					</div>
					<div class="form-group">
						<label><?php echo strTranslate("Message_subject");?>:</label>
						<input maxlength="250" name="asunto-comentario" id="asunto-comentario" type="text" class="form-control" value="" />
					</div>
					<div class="form-group">
						<label><?php echo strTranslate("Mailing_message");?>:</label>
						<textarea class="form-control" rows="10" id="texto-comentario" name="texto-comentario"></textarea>
					</div>
				  	<button type="submit" class="btn btn-primary" id="coment-submit" name="coment-submit"><?php echo strTranslate("Send");?></button>
				</form>		
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php }?>