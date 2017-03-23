<?php
class tpl{

	/**
	 * Set template
	 * @param  string 	$template_file 		Template file name
	 * @param  string 	$modulename    		Module name whre template is placed
	 */
	function tpl($template_file, $modulename){
		$this->tpl_file = dirname(__FILE__).'/../modules/'.$modulename.'/templates/mails/'.$template_file.'.tpl';
	}
	
	/**
	 * Set template vars
	 * @param array 	$vars 		Vars in template: var name and value
	 */
	function setVars($vars){
		global $ini_conf;
		$vars = array_merge($vars, $ini_conf);
		$this->vars = (empty($this->vars)) ? $vars : $this->vars.$vars;
	}
	
	/**
	 * Get template
	 * @return string HTML template
	 */
	function getTpl(){
		if (!($this->fd = @fopen($this->tpl_file, 'r'))) echo 'error al abrir la plantilla '.$this->tpl_file;
		else{
			$this->template_file = fread($this->fd, filesize($this->tpl_file));
			fclose($this->fd);
			$this->mihtml = $this->template_file;
			$this->mihtml = str_replace ("'", "\'", $this->mihtml);
			$this->mihtml = preg_replace('#\{([a-z0-9\-_]*?)\}#is', "' . $\\1 . '", $this->mihtml);
			reset ($this->vars);
			while (list($key, $val) = each($this->vars)){
				$$key = $val;
			}
			eval("\$this->mihtml = '$this->mihtml';");
			reset ($this->vars);
			while (list($key, $val) = each($this->vars)){
				unset($$key);
			}
			$this->mihtml = str_replace ("\'", "'", $this->mihtml);

			ob_start();
			include_once(dirname(__FILE__)."/../../css/mails.css");
			$estilos_mensaje = ob_get_contents();
			ob_end_clean();

			return "<style>".$estilos_mensaje."</style>".$this->mihtml;
		}
	}
}
?>