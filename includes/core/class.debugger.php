<?php
/**
 * Class degugger
 * @version 1.0
 * @author David Noguera Gutierrez nogueradavid1@gmail.com
 */

ini_set('memory_limit', -1);
set_error_handler('debugger::errorHandler');
register_shutdown_function('debugger::shutdownHandler');

class debugger {
	
	static public $errors_log = array();
	static public $num_warnings = 0;
	static public $num_sql = 0;
	static public $num_sql_error = 0;
	static public $debugger_output = "screen"; //values: screen or file
	static public $debugger_file = "errors.log"; //file name for errors log

	public function errorHandler( $errno, $errstr, $errfile, $errline, $errcontext){
		if (!(error_reporting() & $errno)) {
			// Este código de error no está incluido en error_reporting
			return;
		}

		debugger::addError($errno, $errstr, $errfile, $errline, $errcontext, debug_backtrace(), 'php');

	    /* No ejecutar el gestor de errores interno de PHP */
	    return true;
	}

	public function shutdownHandler (){
		if (count(debugger::$errors_log)>0): 
			switch (debugger::$debugger_output){
				case "file":
					debugger::fileDebug();
					break;
				default:
					debugger::screenDebug();
			}
		endif;
	}

	public static function addError($errno, $errstr, $errfile, $errline, $errcontext, $errbacktrace,$errtype){
		$error = array( 'errfile' => $errfile,
						'errno' => $errno,
						'errline' => $errline,
						'errstr' => $errstr,
						'errcontext' => $errcontext,
						'errbacktrace' => $errbacktrace,
						'errtype' => $errtype );

		array_push(debugger::$errors_log, $error);
	}

	private function screenDebug(){
		debugger::stylesDebug();
		debugger::jsDebug();
	}	

	private function fileDebug(){
		foreach(debugger::$errors_log as $error_log):
			if ($error_log['errtype']!="sql"){
				debugger::addFileMessage($error_log['errstr'],$error_log['errtype']);
			}
		endforeach;
	}

	private function addFileMessage($message, $type){
		$fp = fopen(realpath(dirname(__FILE__))."/".debugger::$debugger_file, "a+"); 
		fwrite($fp, "[".date("Y-m-d H:i:s")."] [client ".$_SERVER['REMOTE_ADDR']."] [$type] ".$message."\n");
		fclose($fp);
	}

	public static function addScreenMessage($error_log){
		$error_log = debugger::prepareJsText($error_log);

		if ( $error_log['errtype']=='php'):
			debugger::$num_warnings ++; ?>
			var err_containner = document.createElement("div");
			err_containner.className = "debugger-container-warning";
			err_containner.innerHTML = '<ul class="errTrigger"><b><?php echo $error_log['errfile'];?></b> - Error(<?php echo $error_log['errno'];?>) in line: <?php echo $error_log['errline'];?> - <?php echo $error_log['errstr'];?> <li data-d="0"><div class="debugger-content-code"><b>Error Context</b><br /><pre><?php echo $error_log['errcontext'];?></pre></div><div class="debugger-content-code"><b>Error Backtrace</b><br /><pre><?php echo $error_log['errbacktrace'];?></pre></div></li></ul>';
			document.getElementById("contentPhp").appendChild(err_containner);
		<?php
		elseif ( $error_log['errtype']=='sql'):
			debugger::$num_sql ++; ?>
			var err_containner = document.createElement("div");
			err_containner.className = "debugger-container-success";
			err_containner.innerHTML = '<ul class="errTrigger"><b><?php echo $error_log['errfile'];?></b> - <?php echo $error_log['errstr'];?> </li></ul>';
			document.getElementById("contentSql").appendChild(err_containner);
		<?php			
		elseif ( $error_log['errtype']=='sql_error'):
			debugger::$num_sql_error ++;?>
			var err_containner = document.createElement("div");
			err_containner.className = "debugger-container-danger";
			err_containner.innerHTML = '<ul class="errTrigger"><b><?php echo $error_log['errfile'];?></b> - <?php echo $error_log['errstr'];?> </li></ul>';
			document.getElementById("contentSqlError").appendChild(err_containner);
		<?php			
		endif;
	}	

	private function prepareJsText($error_log){
		$error_log['errfile'] = str_replace(array("\r\n", "\r", "\n"), '\n', $error_log['errfile']);
		$error_log['errno'] = str_replace(array("\r\n", "\r", "\n"), '\n', $error_log['errno']);
		$error_log['errline'] = str_replace(array("\r\n", "\r", "\n"), '\n', $error_log['errline']);
		$error_log['errstr'] = str_replace(array("\r\n", "\r", "\n"), '\n', $error_log['errstr']);
		$error_log['errstr'] = str_replace("'", '`', $error_log['errstr']);
		$error_log['errcontext'] = print_r($error_log['errcontext'], true);
		$error_log['errcontext'] = str_replace(array("\r\n", "\r", "\n"), '\n', $error_log['errcontext']);
		$error_log['errbacktrace'] = print_r($error_log['errbacktrace'], true);
		$error_log['errbacktrace'] = str_replace(array("\r\n", "\r", "\n"), '\n', $error_log['errbacktrace']);

		return $error_log;
	}

	private function jsDebug(){ ?>
		<script type="text/javascript">
			(function(global,undefined){ 

				daDebugger = function(){

					init = function(){
						createContainers();
						<?php
						foreach(debugger::$errors_log as $error_log):
							debugger::addScreenMessage($error_log);
						endforeach;
						?>
						var lblSqlError = "<?php echo debugger::$num_sql_error>0 ? '<span>'.debugger::$num_sql_error.'</span>' : debugger::$num_sql_error;?>",			
							lblPhp = "<?php echo debugger::$num_warnings>0 ? '<span>'.debugger::$num_warnings.'</span>' : debugger::$num_warnings;?>",	
							lblSql = "<?php echo debugger::$num_sql>0 ? '<span>'.debugger::$num_sql.'</span>' : debugger::$num_sql;?>";
						
						createLabels (lblSqlError, lblPhp, lblSql)
					}

					elemListen = function (elem, event, fn) { 
						if (document.addEventListener){ 
							elem.addEventListener(event, fn, false);
						} else { 
							elem.attachEvent('on' + event, fn); 
						}
					}

					listListen = function (list, event, fn) {
						for (var i = 0, len = list.length; i < len; i++) {
							elemListen (list[i], event, fn);
						}
					}

					showErr = function (){
						var errDivs = this.firstChild,
							items = this.getElementsByTagName("li");

						for (var i = 0, len = items.length; i < len; ++i) {
							if (items[i].getAttribute("data-d")=="0"){
								items[i].style.display = "block";
								items[i].setAttribute("data-d", 1);
							}
							else{
								items[i].style.display = "none";
								items[i].setAttribute("data-d", 0);
							}			
						}
						return false;
					}

					showMessages = function (){
						var item = document.getElementById(this.getAttribute("data-dest"));
						if (this.getAttribute("data-d")=="0"){
							item.style.display = "block";
							this.setAttribute("data-d", 1);
						}
						else{
							item.style.display = "none";
							this.setAttribute("data-d", 0);
						}
						return false;
					}

					createContainers = function(){
						var debugger_container =  document.createElement("div");
						debugger_container.id = "debugger-content";
						document.body.appendChild(debugger_container);
						
						var destinoDebug = document.getElementById("debugger-content");
						destinoDebug.innerHTML = "<div id='debugger-main'><?php echo "PHP " . PHP_VERSION . " (" . PHP_OS . ") - <b>Sql queries:</b> <span id='num-sql' class='debugger-label'>0</span> <b>Warnings:</b> <span id='num-warnings' class='debugger-label'>0</span> <b>Sql errors:</b> <span id='num-sql-error' class='debugger-label'>0</span></div>";?>";		
						destinoDebug.style.display = "block";

						var destinoSqlError =  document.createElement("div");
						destinoSqlError.id = "contentSqlError";
						destinoDebug.appendChild(destinoSqlError);

						var destinoPhp =  document.createElement("div");
						destinoPhp.id = "contentPhp";
						destinoDebug.appendChild(destinoPhp);

						var destinoSql =  document.createElement("div");
						destinoSql.id = "contentSql";
						destinoDebug.appendChild(destinoSql);
					}

					createLabels = function(lblSqlError, lblPhp, lblSql){
						createLabel ("num-sql-error", lblSqlError, "contentSqlError");
						createLabel ("num-warnings", lblPhp, "contentPhp");
						createLabel ("num-sql", lblSql, "contentSql");

						var errTriggers = document.getElementsByClassName("errTrigger");
						listListen (errTriggers,"click", showErr);				
					}

					createLabel = function(elem, lblMessage, destination){
						var counter = document.getElementById(elem);
						counter.innerHTML = lblMessage;
						counter.setAttribute("data-d", 0);
						counter.setAttribute("data-dest", destination);
						elemListen (counter,"click", showMessages);					
					}

					init();
				}

				global.daDebugger();
			})(this);
		</script>
		<?php
	}

	private function stylesDebug(){ ?>
			<style type="text/css">
				#debugger-content{
					bottom:0;
					border-top: 1px solid #BCE8F1;
					display: none;
					font-family:Arial;
					font-size: 12px;
					left: 0;		
					margin:0 0 0 0;
					max-height: 250px;
					overflow-y:auto;
					position: fixed;
					width:100%;
					z-index: 999999999;
				}
				#debugger-main{
					background: #eeeeee; /* Old browsers */
/* IE9 SVG, needs conditional override of 'filter' to 'none' */
background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2VlZWVlZSIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNjY2NjY2MiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
background: -moz-linear-gradient(top,  #eeeeee 0%, #cccccc 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#eeeeee), color-stop(100%,#cccccc)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #eeeeee 0%,#cccccc 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #eeeeee 0%,#cccccc 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #eeeeee 0%,#cccccc 100%); /* IE10+ */
background: linear-gradient(to bottom,  #eeeeee 0%,#cccccc 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eeeeee', endColorstr='#cccccc',GradientType=0 ); /* IE6-8 */

					border-bottom: 1px solid #BCE8F1;
					color:#31708F;
					font-family:Arial;
					font-size: 12px;
					left: 0;
					padding: 5px;
					text-align:left;		
					top:0;
					width:100%;		
				}
				#debugger-content pre{
					font-size: 11px;
				}
				.debugger-container-warning{
					background: #fcf4ae; /* Old browsers */
					/* IE9 SVG, needs conditional override of 'filter' to 'none' */
					background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZjZjRhZSIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNmMWRhMzYiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
					background: -moz-linear-gradient(top,  #fcf4ae 0%, #f1da36 100%); /* FF3.6+ */
					background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fcf4ae), color-stop(100%,#f1da36)); /* Chrome,Safari4+ */
					background: -webkit-linear-gradient(top,  #fcf4ae 0%,#f1da36 100%); /* Chrome10+,Safari5.1+ */
					background: -o-linear-gradient(top,  #fcf4ae 0%,#f1da36 100%); /* Opera 11.10+ */
					background: -ms-linear-gradient(top,  #fcf4ae 0%,#f1da36 100%); /* IE10+ */
					background: linear-gradient(to bottom,  #fcf4ae 0%,#f1da36 100%); /* W3C */
					filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcf4ae', endColorstr='#f1da36',GradientType=0 ); /* IE6-8 */
					border-bottom: 1px solid #faebcc;
					color:#8a6d3b;
					font-size: 12px;
					padding: 5px;
				}
				.debugger-container-success{
					background: #a9db80; /* Old browsers */
					/* IE9 SVG, needs conditional override of 'filter' to 'none' */
					background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2E5ZGI4MCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiM5NmM1NmYiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
					background: -moz-linear-gradient(top,  #a9db80 0%, #96c56f 100%); /* FF3.6+ */
					background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#a9db80), color-stop(100%,#96c56f)); /* Chrome,Safari4+ */
					background: -webkit-linear-gradient(top,  #a9db80 0%,#96c56f 100%); /* Chrome10+,Safari5.1+ */
					background: -o-linear-gradient(top,  #a9db80 0%,#96c56f 100%); /* Opera 11.10+ */
					background: -ms-linear-gradient(top,  #a9db80 0%,#96c56f 100%); /* IE10+ */
					background: linear-gradient(to bottom,  #a9db80 0%,#96c56f 100%); /* W3C */
					filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a9db80', endColorstr='#96c56f',GradientType=0 ); /* IE6-8 */
					border-bottom: 1px solid #d6e9c6;
					color:#3c763d;
					font-size: 12px;
					padding: 5px;
				}
				.debugger-container-danger{
					background: #febbbb; /* Old browsers */
					/* IE9 SVG, needs conditional override of 'filter' to 'none' */
					background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZlYmJiYiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjQ1JSIgc3RvcC1jb2xvcj0iI2ZlOTA5MCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNmZjVjNWMiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
					background: -moz-linear-gradient(top,  #febbbb 0%, #fe9090 45%, #ff5c5c 100%); /* FF3.6+ */
					background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#febbbb), color-stop(45%,#fe9090), color-stop(100%,#ff5c5c)); /* Chrome,Safari4+ */
					background: -webkit-linear-gradient(top,  #febbbb 0%,#fe9090 45%,#ff5c5c 100%); /* Chrome10+,Safari5.1+ */
					background: -o-linear-gradient(top,  #febbbb 0%,#fe9090 45%,#ff5c5c 100%); /* Opera 11.10+ */
					background: -ms-linear-gradient(top,  #febbbb 0%,#fe9090 45%,#ff5c5c 100%); /* IE10+ */
					background: linear-gradient(to bottom,  #febbbb 0%,#fe9090 45%,#ff5c5c 100%); /* W3C */
					filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#febbbb', endColorstr='#ff5c5c',GradientType=0 ); /* IE6-8 */
					border-bottom: 1px solid #EBCCD1;
					color:#a94442;
					font-size: 12px;
					padding: 5px;
				}
				.errTrigger{
					cursor:pointer;
					margin:0;
					padding: 0;
				}

				.debugger-content-code{	
					background-color: #fff;
					font-size: 12px;		
					margin: 5px 0 0 0;
					max-height: 100px;
					overflow:auto;
					padding: 5px;
				}

				#contentPhp, #contentSql, #contentSqlError, .errTrigger li{
					display: none;
				}

				.debugger-label span{
					border-radius: 20px;
					cursor: pointer;
					font-weight: bolder;
					padding: 3px 6px;
				}
		
				#num-warnings span{
					background-color: #f1da36;
					color: #8a6d3b;
				}

				#num-sql span{
					background-color: #3c763d;
					color: #fcf8e3;
				}

				#num-sql-error span{
					background-color: #a94442;
					color: #f2dede;
				}
			</style>
		<?php 
	}
}
?>