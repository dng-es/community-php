<?php
/**
* @Manage banners
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 0.5
*/	
class banners extends connection{

	  public function getBanners($filter = "")  
	  {
	    $Sql="SELECT * FROM banners WHERE 1=1 ".$filter;
	    return connection::getSQL($Sql);  
	  }   

      public function updateBanner($id,$imagen){
		$Sql="UPDATE banners SET
			 imagen='".$imagen."',
			 WHERE nombre='".$id."'";
		return connection::execute_query($Sql);
      }
}
?>