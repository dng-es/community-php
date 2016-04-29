<?php 

function menuPages(){
	$elements = pagesController::getListAction(999, " AND page_menu=1 "); ?>
	<h3 class="text-center"><big>Trofeos</big></h3>
	<ul class="lista-lateral">
		<?php foreach($elements['items'] as $element):?>
			<li><a href="pagename?id=<?php echo $element['page_name'];?>"><?php echo $element['page_title'];?></a></li>
		<?php endforeach;?>
	</ul>
<?php }

?>