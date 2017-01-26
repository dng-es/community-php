<?php
addJavascripts(array(getAsset("users")."js/ranking-empresas.js"));

$rankings = new rankings();
$id = intval($_REQUEST['id']);
$puntos_empresa = $rankings->getRankingsData(" AND d.cod_tienda='".$_SESSION['user_empresa']."' AND d.id_ranking='".$id."' ");

$posiciones = 10;

$posicion_empresa_user=rankings::posicionRankingEmpresa($_SESSION['user_empresa'], $id);
if ($_SESSION['user_perfil']=='admin'){$posicion_empresa=0;}
$puntos = $rankings->getRankingsData(" AND id_ranking=".$id." ORDER BY value_ranking DESC,d.cod_tienda ASC LIMIT ".$posiciones);

$ranking_data = rankingsController::getItemAction($id, " AND activo=1 ");

if (count($ranking_data)>0):
?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Rankings"), "ItemUrl"=>"#"),
			array("ItemLabel"=>$ranking_data[0]['nombre_ranking'], "ItemClass"=>"active"),
		));
		?>
		<div class="row">
			<div class="col-md-12 container-fade">
				<p><?php echo $ranking_data[0]['descripcion_ranking'];?></p>
				<br />
				<h3><?php echo number_format($puntos_empresa[0]['value_ranking'], 2, ',', '.');?> <small><?php echo $puntos_empresa[0]['nombre_tienda'];?></small> la posición de tu centro <span class="badge badge-primary"><?php echo $posicion_empresa_user;?></span></h3>
				<table class="table table-striped">
					<?php 
					for ($i = 0; $i <= ($posiciones-1); $i++){
						if (isset($puntos[$i])): ?>
					<tr>
						<td class="table-number"><span class="badge badge-primary"><?php echo ($i+1);?></span></td>
						<td width="100%"><p><?php echo number_format($puntos[$i]['value_ranking'], 2, ',', '.');?> - <small><?php echo $puntos[$i]['nombre_tienda'];?></small></p></td>
					</tr>
						<?php endif;
					} ?>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior hidden-xs">
			<h3>rankings</h3>
			<p class="text-center"><i class="fa fa-trophy fa-big"></i></p>
		</div>
	</div>
</div>
<?php endif;?>