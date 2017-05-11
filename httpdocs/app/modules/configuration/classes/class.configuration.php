<?php
class configuration{
	function getConfigIni($filter = ""){
		$Sql = "SELECT * FROM config WHERE 1=1 ".$filter;
		$result = connection::execute_query($Sql);
		$array_data = array();
		$array_data = connection::get_result($result);
		return $array_data;
	}

	function getConfiguracion($filter = ""){
		$Sql = "SELECT * FROM config WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function updateConfiguracion($telefono, $telefono2, $fax, $direccion, $ContactEmail, $SiteName, $SiteTitle, $SiteDesc, $SiteSubject, $SiteKeywords, $SiteUrl, $MailingEmail){
		$Sql = "UPDATE config SET
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

	public function getPanels($filter = ""){
		$Sql = "SELECT * FROM config_panels WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function getPanelsRows($filter = ""){
		$Sql = "SELECT DISTINCT(panel_row) AS rows FROM config_panels WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertPanel($page_name, $panel_name, $panel_cols, $panel_pos, $panel_row){
		$Sql = "INSERT INTO config_panels (page_name, panel_name, panel_cols, panel_pos, panel_row) 
				VALUES('".$page_name."', '".$panel_name."', '".$panel_cols."', '".$panel_pos."', ".$panel_row.") ";
		return connection::execute_query($Sql);
	}

	public function updatePanel($page_name, $panel_name, $panel_cols, $panel_pos, $panel_row, $theme){
		$Sql = "INSERT INTO config_panels (panel_cols, panel_pos, panel_row, page_theme, panel_visible, panel_name, page_name) 
				VALUES (".$panel_cols.", ".$panel_pos.", ".$panel_row.",'".$theme."', 1, '".$panel_name."', '".$page_name."')";
		return connection::execute_query($Sql);
	}

	public function deletePanel($filter = ""){
		$Sql = "DELETE FROM config_panels WHERE 1=1 ". $filter;
		return connection::execute_query($Sql);
	}

	public function updatePanels($filter = ""){
		$Sql = "UPDATE config_panels SET visible=1 WHERE 1=1 ". $filter;
		return connection::execute_query($Sql);
	}
}
?>