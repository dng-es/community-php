<?php
class fotosAlbumController{
	public static function getItemAction($id){
		$fotos = new fotos();
		return $fotos->getFotosAlbumes(" AND id_album=".$id." ");
	}

	public static function getListAction($filter=""){
		$fotos = new fotos();
		return $fotos->getFotosAlbumes($filter);
	}
}
?>