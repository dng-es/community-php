<?php
class footer{
	
	/**
	* Print HTML footer. From <footer> until javascript
	*
	*/	
	public static function PageFooterInfo(){
		$pages = new pages();
		$politica= $pages->getPages(" AND page_name='policy' ");
		$declaracion= $pages->getPages(" AND page_name='declaracion' ");
		?>
		</div>
		<div class="footer">
			<p><a href="?page=contact"><?php echo strTranslate("Contact");?></a> - 
			<a href="#" id="declaracion-trigger"><?php echo strTranslate("Rights_and_responsabilities");?>.</a> - 
			<a href="#" id="policy-trigger"><?php echo strTranslate("Private_policy");?>.</a><br />
			make with <i class="fa fa-heart heart-pulp"></i> by DNG <?php echo date("Y");?></p>
		</div>

		<!-- Modal -->
		<div class="modal modal-wide fade" id="declaracionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><?php echo strTranslate("Rights_and_responsabilities");?></h4>
					</div>
					<div class="modal-body">
					<?php echo $declaracion[0]['page_content'];?>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="modal modal-wide fade" id="policyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><?php echo strTranslate("Private_policy");?></h4>
					</div>
					<div class="modal-body">
					<?php echo $politica[0]['page_content'];?>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	<?php
	}

	/**
	* Print HTML end file. From Javascript to </html>.
	* Includes Piwik block for statistics
	*
	*/	
	public static function PageFooter()
	{
	  	global $ini_conf, $paginas_free,$page;
	  	if (!in_array($page, $paginas_free)){
			
			self::PageFooterInfo();
			echo '</div>';
		}
		?>
		</body>
	</html>
	<?php }		
}
?>