<?php 

function mainSearch($destination = "search-results", $search_text = "", $mod = ""){?>
<form role="form" action="<?php echo $destination;?>" method="get" id="searchForm" name="searchForm">
	<input type="hidden" name="mod" value="<?php echo $mod;?>" />
	<div class="input-group">
		<label class="sr-only" for="search"><?php e_strTranslate("Search");?></label>
		<input class="form-control" id="search" name="search" placeholder="<?php echo strtolower(strTranslate("Search"));?>" value="<?php echo $search_text;?>">
		<div class="input-group-btn">
			<button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
		</div>
	</div>
</form>
<?php } ?>