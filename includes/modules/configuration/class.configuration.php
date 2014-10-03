<?php
/**
* @Configuration app module
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.1.1
*/	
class configuration{

	function getConfigIni($filter = ""){
		$Sql="SELECT * FROM config WHERE 1=1 ".$filter;
		$result=connection::execute_query($Sql);
		$array_data = array();
		$array_data = connection::get_result($result);
		return $array_data;
	} 

	function getConfiguracion($filter = ""){
		$Sql="SELECT * FROM config WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	} 	    

	public function updateConfiguracion($telefono,$telefono2,$fax,$direccion,$ContactEmail,$SiteName,$SiteTitle,$SiteDesc,$SiteSubject,$SiteKeywords,$SiteUrl,$MailingEmail){	 
		$Sql="UPDATE config SET
			 telefono='".$telefono."',
			 telefono2='".$telefono2."',
			 fax='".$fax."',
			 direccion='".$direccion."',
			 ContactEmail='".$ContactEmail."',
			 SiteName='".$SiteName."',
			 SiteTitle='".$SiteTitle."',
			 SiteDesc='".$SiteDesc."',
			 SiteSubject='".$SiteSubject."',
			 SiteKeywords='".$SiteKeywords."', 
			 SiteUrl='".$SiteUrl."',
			 MailingEmail='".$MailingEmail."'";
		return connection::execute_query($Sql);
	}
}
?>