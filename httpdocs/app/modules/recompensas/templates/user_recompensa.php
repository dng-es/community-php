<?php 
function userRecompensa($username){ 
	$elements = recompensasController::getListUserAction(" AND recompensa_user='".$username."' ");
	
	if ($elements['total_reg'] > 0): ?>
	<br /><p class="text-center">
	<?php foreach($elements['items'] as $element):?>
		<span style="width:100px;height: 150px;margin-right: 15px;display:inline-block;position:relative">
			<span width="60px" style="position: relative">
				<img width="60px" src="<?php echo PATH_REWARDS.$element['recompensa_image'];?>" />
				<span style="color:#fff; font-size: 26px; display: block;text-align: center;margin-top: -44px; font-weight: bolder; line-height: 40px;"><?php echo $element['total'];?></span>
			</span>
			<small class="text-muted"><?php echo $element['recompensa_name'];?></small>
			</td>
		</span>	
	<?php endforeach; ?>
	</p>
	<?php endif;?>
<?php }

function userRecompensaAdmin($username){ 
	$elements = recompensasController::getListUserListAction(9999999, " AND recompensa_user='".$username."' ");	?>
	<div class="row">
		<div class="col-md-5">
			<?php userRecompensaInsert($username);?>
		</div>
		<div class="col-md-7">
			<div class="table-responsive">
				<table class="table table-hover table-striped">
				<?php foreach($elements['items'] as $element):?>
					<tr>
						<td nowrap="nowrap" width="40px">					
							<span class="fa fa-ban icon-table" title="Eliminar"
								onClick="Confirma('¿Seguro que quieres eliminar la recompensa?', 'admin-user?id=<?php echo $username;?>&del_rew=<?php echo $element['id_recompensas_user'];?>')">
							</span>
						</td>			
						<td width="40px"><img width="30px" src="<?php echo PATH_REWARDS.$element['recompensa_image'];?>" /></td>
						<td>
							<b><?php echo $element['recompensa_name'];?></b> 
							<small><?php echo $element['recompensa_comment'];?><br />
							<em class="text-muted">Concedido por <a href="admin-user?id=<?php echo $element['recompensa_assign'];?>"><?php echo $element['recompensa_assign'];?></a> el <?php echo getDateFormat($element['recompensa_date'], 'LONG');?></em></small>
						</td>
					</tr>	
				<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
<?php }

function userRecompensaInsert($username){ ?>
	<form action="" name="reward-insert" id="reward-insert" method="post" role="form">
		<input type="hidden" name="recompensa_user" value="<?php echo $username;?>" />
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="id_recompensa"><?php e_strTranslate("New_reward");?>:</label>
					<?php comboRecompensas(0, "", "id_recompensa");?>
				</div>
				<div class="form-group">
					<label for="recompensa_comment"><?php e_strTranslate("Comment");?>:</label>
					<textarea name="recompensa_comment" id="recompensa_comment" class="form-control"></textarea>
				</div>
				<div class="form-group">
					<input type="submit" value="<?php e_strTranslate('Save');?>" class="btn btn-primary btn-block" />
				</div>
			</div>
		</div>
	</form>
<?php }

function userRecompensaTip($username){ 
	$elements = recompensasController::getListUserAction(" AND recompensa_user='".$username."' ");
	$output = "";
	foreach($elements['items'] as $element):
		$output .='<div style="width:20px; float:left; position:relative"><img style="width: 20px" src="'.PATH_REWARDS.$element['recompensa_image'].'" /><br />
		<strong style="position: absolute; top: 11px;text-align:center;color: #000;display:block;width:100%">'.$element['total'].'</strong></div>';
	endforeach; 
	return $output.'<div class="clearfix"></div>';
}

function comboRecompensas($id_recompensa = 0, $filtro="", $name_control="id_recompensa"){
	$elements = recompensasController::getListAction(9999, $filtro); ?>
	<select name="<?php echo $name_control;?>" id="<?php echo $name_control;?>" class="form-control">
		<option value="0"> ---- Selecciona una recompensa ---- </option>
		<?php foreach($elements['items'] as $element):?>
		<option value="<?php echo $element['id_recompensa'];?>" <?php if ($id_recompensa == $element['id_recompensa']) echo ' selected="selected" ';?>><?php echo $element['recompensa_name'];?></option>
		<?php endforeach; ?>
	</select>
<?php }
?>