<?php
function SearchUser($labelForm = "Buscar:", $labelButton = "ir", $clase_css = "" , $class_form = "") { ?>
<div class="<?php echo $clase_css;?>">
	<form action="" method="post" id="searchUserForm" name="searchUserForm" class="<?php echo $class_form;?>">
		<div class="input-group">
			<label class="sr-only" for="find_user"><?php echo $labelForm;?></label>
			<input type="text" class="form-control" id="find_user" name="find_user" placeholder="<?php echo $labelForm;?>" value="">
			<div class="input-group-btn">
				<button type="submit" class="btn btn-default" title="<?php echo $labelButton;?>"><i class="glyphicon glyphicon-search"></i></button>
			</div>
		</div>
	</form>
</div>
<?php } ?>