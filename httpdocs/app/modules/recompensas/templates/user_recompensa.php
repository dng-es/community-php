<?php 
function userRecompensa($username){ 
	$elements = recompensasController::getListUserAction(" AND recompensa_user='".$username."' ");
	
	if ($elements['total_reg'] > 0): ?>
	<br /><p class="text-center">
	<?php foreach($elements['items'] as $element):?>
		<span style="width:100px;height: 150px;margin-right: 15px;display:inline-block;position:relative">
			<span width="60px" style="position: relative">
				<img width="60px" src="images/<?php echo $element['recompensa_image'];?>" />
				<span style="display: block;text-align: center;margin-top: -60px"><?php echo $element['total'];?></span>
			</span>
			<br /><br /><small class="text-muted"><?php echo $element['recompensa_name'];?></small>
			</td>
		</span>	
	<?php endforeach; ?>
	</p>
	<?php endif;?>
<?php }

function userRecompensaAdmin($username){ 
	$elements = recompensasController::getListUserListAction(9999999, " AND recompensa_user='".$username."' ");
	userRecompensaInsert($username);?>
	<div class="table-responsive">
		<table class="table table-hover table-striped">
		<?php foreach($elements['items'] as $element):?>
			<tr>
				<td nowrap="nowrap" width="40px">					
					<span class="fa fa-ban icon-table" title="Eliminar"
						onClick="Confirma('¿Seguro que quieres eliminar la recompensa?', 'admin-user?id=<?php echo $username;?>&del_rew=<?php echo $element['id_recompensas_user'];?>')">
					</span>
				</td>			
				<td width="40px"><img width="30px" src="images/<?php echo $element['recompensa_image'];?>" /></td>
				<td>
					<?php echo $element['recompensa_name'];?>
					<br /><small><em class="text-muted">Concedido por <a href="admin-user?id=<?php echo $element['recompensa_assign'];?>"><?php echo $element['recompensa_assign'];?></a> el <?php echo getDateFormat($element['recompensa_date'], 'LONG');?></em></small>
				</td>
			</tr>	
		<?php endforeach; ?>
		</table>
	</div>
<?php }

function userRecompensaInsert($username){ 
	$elements = recompensasController::getListAction(9999, ""); ?>
	<form action="" name="reward-insert" id="reward-insert" method="post" role="form">
		<input type="hidden" name="recompensa_user" value="<?php echo $username;?>" />
		<label for="id_recompensa"><?php e_strTranslate("New_reward");?></label>
		<div class="row">
			<div class="col-md-10 nopadding">
				<select name="id_recompensa" id="id_recompensa" class="form-control">
					<?php foreach($elements['items'] as $element):?>
					<option value="<?php echo $element['id_recompensa'];?>"><?php echo $element['recompensa_name'];?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-md-2 nopadding">
				<input type="submit" value="<?php e_strTranslate('Save');?>" class="btn btn-primary btn-block" />
			</div>
		</div>
	</form>
<?php }

function userRecompensaTip($username){ 
	$elements = recompensasController::getListUserAction(" AND recompensa_user='".$username."' ");
	$output = "";
	foreach($elements['items'] as $element):
		$output .='<div style="width:20px; float:left; position:relative"><img style="width: 20px" src="images/'.$element['recompensa_image'].'" /><br />
		<strong style="position: absolute; top: 3px;text-align:center;color: #000;display:block;width:100%">'.$element['total'].'</strong></div>';
	endforeach; 
	return $output.'<div class="clearfix"></div>';
}
?>