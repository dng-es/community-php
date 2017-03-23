<?php
/**
 * Show Last Photo panel. Used in home page
 * @return 	String       			HTML panel
 */
function panelFotos(){
	$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal_album LIKE '%".$_SESSION['user_canal']."%' " : "");
	$last_photo = fotosController::getListAction(1, $filtro_canal." AND estado=1 ORDER BY id_file DESC ");
	?>
	<div class="col-md-12 section panel">
		<h3><?php e_strTranslate("Last_photos");?></h3>
		<?php if (isset($last_photo['items'][0])):?>
		<div class="media-preview-container">
			<a href="fotos"><img class="media-preview" src="<?php echo PATH_FOTOS.$last_photo['items'][0]['name_file'];?>" alt="<?php echo prepareString($last_photo['items'][0]['titulo']);?>" /></a>
			<div>
				<a href="fotos"><?php echo $last_photo['items'][0]['titulo'];?></a><br />
				<?php echo $last_photo['items'][0]['nick'];?><br />
				<span><small><?php echo ucfirst(getDateFormat($last_photo['items'][0]['date_foto'], "LONG"));?></small></span>
			</div>
		</div>
		<?php else: ?>
			<div class="text-muted">Todavía no se han subido fotos</div>
		<?php endif; ?>
	</div>
<?php }

/**
 * Show Last Photo and Video panel
 * @return 	String       			HTML panel
 */
function panelFotosVideos(){
	$last_photo = fotosController::getListAction(5, " AND estado=1 ORDER BY id_file DESC ");
	$last_video = videosController::getListAction(5, " AND estado=1 ");
	$i=0;
	$elements = array();
	$k = 0;
	foreach($last_photo['items'] as $foto):
		$elements[$k]['id'] = $foto['id_file'];
		$elements[$k]['titulo'] = $foto['titulo'];
		$elements[$k]['name_file'] = $foto['name_file'];
		$elements[$k]['tipo'] = 'foto';
		$k++;
	endforeach;

	foreach($last_video['items'] as $video):
		$elements[$k]['id'] = $video['id_file'];
		$elements[$k]['titulo'] = $video['titulo'];
		$elements[$k]['name_file'] = $video['name_file'];
		$elements[$k]['tipo'] = 'video';
		$k++;
	endforeach;
	shuffle($elements);
	?>

	<div class="container-fluid" style="margin-bottom: 25px">
		<div class="row-fluid"  id="carrusel-media-container">
			<div style="width:150px;float:left;height: 150px">
				<img src="images/carrusel.jpg" style="height: 150px" />
			</div>
			<div style="width:50px;float:left;height: 150px; background-color: #E60000; color: #fff">
				<a data-href="#thumbCarousel" data-target="#thumbCarousel" data-toggle="carousel" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" style="color: #fff; margin-top: 70px; font-size: 22px;left: 10px; cursor: pointer"></span>
				</a>
			</div>
			<div id="carrusel-centro" style="width:86%;float:left;height: 150px; background-color: #222">
				<div id="thumbCarousel" class="carousel slide">
					<!-- Carousel items -->
					<div class="carousel-inner thumb-inner" style="height: 150px;">
						<?php foreach($elements as $element): $i++;?>
						<div class="<?php echo ($i==1 ? 'active' : '');?> item">
							<div style="float:left">
								<?php if($element['tipo'] == 'foto'):?>
								<a href="fotos">
									<img src="<?php echo PATH_FOTOS.$element['name_file'];?>" style="height: 150px;" alt="<?php echo $element['titulo'];?>">
								</a>
								<?php endif;?>
								<?php if($element['tipo'] == 'video'):?>
								<a href="videos?id=<?php echo $element['id'];?>" style="position: relative">
									<p class="play-video">
										<span class="fa-stack fa-2x">
											<i class="fa fa-circle fa-stack-2x"></i>
											<i class="fa fa-play fa-stack-1x fa-inverse"></i>
										</span>
									</p>
									<img src="<?php echo PATH_VIDEOS.$element['name_file'];?>.jpg" style="height: 150px;" alt="<?php echo $element['titulo'];?>">
								</a>
								<?php endif;?>
							</div>
						</div>
						<?php endforeach;?>
					</div><!--/carousel-inner-->
				</div><!--/myCarousel-->
			</div><!--/col-md-12-->
			<div style="width:50px;float:left;height: 150px; background-color: #E60000; color: #fff">
				<a data-href="#thumbCarousel" data-target="#thumbCarousel" data-toggle="carousel" data-slide="next" >
					<span class="glyphicon glyphicon-chevron-right" style="color: #fff; margin-top: 70px; font-size: 22px;left: 10px; cursor: pointer"></span>
				</a>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$('#thumbCarousel .item').each(function(){
			var next = $(this).next();
			if(!next.length){
				next = $(this).siblings(':first');
			}
			
			next.children(':first-child').clone().appendTo($(this));

			for(var i=0;i<10;i++){
				next=next.next();
				if (!next.length){
					next = $(this).siblings(':first');
				}

				next.children(':first-child').clone().appendTo($(this));
			}
		});
	</script>
<?php } ?>