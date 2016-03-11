<?php 
function showBatallas($tipo, $total_reg){
	$batallas = new batallas();
	$users = new users();
	$filtro = "";
	$tipo_filtro = "";
	$p=0; //indica la pestaña que hay que mostar en el paginador

	$reg = 3;
	if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
	if (!isset($pag)) { $inicio = 0; $pag = 1;}
	else { $inicio = ($pag - 1) * $reg;}

	switch ($tipo) {
    case "ganadas":
        $filtro =  " AND finalizada=1 AND ganador='".$_SESSION['user_name']."' ";
        $tipo_filtro = $tipo;
        if (isset($_REQUEST['f']) and $_REQUEST['f'] != 1) {$inicio = 0; $pag = 1;}
        $p=1;
        break;
    case "perdidas":
        $filtro =  " AND finalizada=1 AND ganador<>'' AND ganador<>'".$_SESSION['user_name']."' AND (user_create='".$_SESSION['user_name']."' OR user_retado='".$_SESSION['user_name']."') ";
        $tipo_filtro = $tipo;
        if (isset($_REQUEST['f']) and $_REQUEST['f'] != 2) {$inicio = 0; $pag = 1;}
        $p=2;
        break;
    case "pendientes usuario":
        $filtro =  " AND finalizada=0 AND user_retado='".$_SESSION['user_name']."' AND id_batalla NOT IN ( SELECT id_batalla FROM batallas_luchas WHERE user_lucha='".$_SESSION['user_name']."' ) ";
        $tipo_filtro = "pendientes-usuario";
        if (isset($_REQUEST['f']) and $_REQUEST['f'] != 3) {$inicio = 0; $pag = 1;}
        $p=3;
        break; 
    case "pendientes contrincario":
        $filtro =  " AND finalizada=0 AND user_create='".$_SESSION['user_name']."' AND id_batalla NOT IN ( SELECT id_batalla FROM batallas_luchas WHERE user_lucha<>'".$_SESSION['user_name']."' )";
        $tipo_filtro = "pendientes-contrincario";
        if (isset($_REQUEST['f']) and $_REQUEST['f'] != 4) {$inicio = 0; $pag = 1;}
        $p=4;
        break;                        
	}

	$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal_batalla='".$_SESSION['user_canal']."' " : "");
	$elements = $batallas->getBatallas($filtro_canal.$filtro." ORDER BY date_batalla DESC  LIMIT ".$inicio.",".$reg);

	echo '<div class="row">';
	echo '<div class="col-md-12 nopadding">';

	if ($tipo=="pendientes contrincario"){$texto_tipo = 'Total de "sus" batallas pendientes';}
	elseif ($tipo=="pendientes usuario"){$texto_tipo = 'Total de "mis" batallas pendientes';}
	else{$texto_tipo = 'Total batallas '.$tipo;}

	$i=0;
	foreach($elements as $element):
  		//obtener contrincario
  		$contrincario_data ="";
  		if ($element['user_create']==$_SESSION['user_name']){$contrincario=$element['user_retado'];}
  		else {$contrincario = $element['user_create'];}
  		$contrincario_data = $users->getUsers("AND username='".$contrincario."' ");
  		$contrincario_data[0]['id_comentario'] = $tipo_filtro.$i;

  		//conocer si el usuario a jugado la batalla
  		$jugadas = connection::countReg("batallas_luchas"," AND id_batalla=".$element['id_batalla']." AND user_lucha='".$_SESSION['user_name']."' ");

  		//datos partida usuario
  		$mi_partida = $batallas->getBatallasLuchas(" AND id_batalla=".$element['id_batalla']." AND user_lucha='".$_SESSION['user_name']."' ");

  		//datos partida oponente
  		$su_partida = $batallas->getBatallasLuchas(" AND id_batalla=".$element['id_batalla']." AND user_lucha<>'".$_SESSION['user_name']."' ");

		echo '		<div class="row">
						<div class="col-md-12">
						<div class="panel panel-default">
						<div class="panel-heading">
							'.getDateFormat($element["date_batalla"], "DATE_TIME").'  - <span class="text-primary">Categoría:</span> '.$element['tipo_batalla'].' - <span class="text-primary">Puntos jugados:</span> '.$element['puntos'].'<br />
						</div>
						<div class="panel-body">	
							<div class="row">
								<div class="col-md-5 col-sm-5 nopadding">
									<div class="row">
										<div class="col-md-2 col-xs-3 nopadding">';
										userFicha($contrincario_data[0]);
									echo '</div>
										<div class="col-md-10 col-xs-9">
											<ul class="list-unstyled">
												<li><small><span class="text-primary">Jugador:</span> '.$contrincario_data[0]['nick'].' 
												('.$contrincario_data[0]['nombre_tienda'].')</small></li>';
												if ($tipo!='pendientes usuario'){

												echo '	<li><small><span class="text-primary">Sus aciertos:</span> '.(isset($su_partida[0]['aciertos_lucha']) ? $su_partida[0]['aciertos_lucha'] : "").' ('.(isset($su_partida[0]['tiempo_lucha']) ? $su_partida[0]['tiempo_lucha'] : "").' seg.)</small></li>';
												}
									echo '	</ul>
										</div>
									</div>
								</div>

								<div class="col-md-2 col-sm-2">
									<span class="text-primary text-center"><big>VS</big></span>';

									if ($jugadas==0 and ($tipo!='perdidas' or $tipo='ganadas')){
										echo '<input type="button" class="jugar-batalla btn btn-primary btn-block" value="jugar!!!" data-c="'.$element['tipo_batalla'].'" data-id="'.$element['id_batalla'].'" />';
									}
		echo '					</div>
								<div class="col-md-5 col-sm-5">
									<div class="row">
										<div class="col-md-2 col-xs-3 nopadding">
											<img class="comment-mini-img pull-right" src="'.$_SESSION['user_foto'].'" />
										</div>
										<div class="col-md-10 col-xs-9">
											<ul class="list-unstyled">
												<li><small><span class="text-primary">Mis aciertos:</span> '.$mi_partida[0]['aciertos_lucha'].'
											('.$mi_partida[0]['tiempo_lucha'].' seg.)</small></li>
										</div>
									</div>
								</div>';



		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '</div>';


  		$i++;
  	endforeach;

  	if (count($elements) == 0){
  		echo '<div class="col-md-12">No tienes batallas.</div>';
  	}

  	PaginatorTabs($pag,$reg,$total_reg,'batallas','batallas',$p);
	
	echo '</div>';
	echo '</div>';
}
?>