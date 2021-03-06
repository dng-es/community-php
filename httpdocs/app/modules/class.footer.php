<?php
class footer{
	/**
	* Print HTML footer. From <footer> until javascript
	*/	
	public static function PageFooterInfo(){
		global $page;
		$pages = new pages();
		$politica = $pages->getPages(" AND page_name='policy' ");
		$declaracion = $pages->getPages(" AND page_name='declaracion' ");
		$theme = ((isset($_REQUEST['theme']) && $page == 'home_new') ? sanitizeInput($_REQUEST['theme']) : $_SESSION['user_theme']);
		?>
		</div>
		<div class="row footer hidden-print">
			<div class="col-md-4 col1">
				<h4><?php e_strTranslate("Useful_links");?></h4>
				<ul class="list-unstyled">
					<li><a href="contact"><?php e_strTranslate("Contact");?></a></li>
					<li><a href="users-conn"><?php e_strTranslate("Users_connected");?></a></li>
				</ul>
			</div>
			<div class="col-md-4 col2">
				<h4><?php e_strTranslate("Legal_bases");?></h4>
				<ul class="list-unstyled">
					<li><a href="#" id="declaracion-trigger"><?php e_strTranslate("Rights_and_responsabilities");?></a></li>
					<li><a href="#" id="policy-trigger"><?php e_strTranslate("Private_policy");?></a></li>
				</ul>
			</div>
			<div class="col-md-4">
				<img src="themes/<?php echo $theme;?>/images/logo.png" class="img-responsive" />
				<p><small>powered by Grass Roots <?php echo date("Y");?></small></p>
				<?php get_hooks('footer');?>
			</div>
		</div>

		<!-- Modal Derechos y responsabilidades (declaración)-->
		<div class="modal modal-wide fade" id="declaracionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><?php e_strTranslate("Rights_and_responsabilities");?></h4>
					</div>
					<div class="modal-body">
					<?php echo $declaracion[0]['page_content'];?>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!-- Modal Politica de seguridad (policy)-->
		<div class="modal modal-wide fade" id="policyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><?php e_strTranslate("Private_policy");?></h4>
					</div>
					<div class="modal-body">
					<?php echo $politica[0]['page_content'];?>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div id="toTop"><i class="fa fa-arrow-up"></i></div>
	<?php
	}

	/**
	* Print HTML end file. From Javascript to </html>.
	* Includes Piwik block for statistics
	*/	
	public static function PageFooter(){
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