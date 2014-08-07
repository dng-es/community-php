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

	public static function addMessage($error_log){
		$msg_file = str_replace(array("\r\n", "\r", "\n"), '\n', $error_log['errfile']);
		$msg_number = str_replace(array("\r\n", "\r", "\n"), '\n', $error_log['errno']);
		$msg_line = str_replace(array("\r\n", "\r", "\n"), '\n', $error_log['errline']);
		$msg_text = str_replace(array("\r\n", "\r", "\n"), '\n', $error_log['errstr']);
		$msg_text = str_replace("'", '`', $msg_text);
		$msg_context = print_r($error_log['errcontext'], true);
		$msg_context = str_replace(array("\r\n", "\r", "\n"), '\n', $msg_context);
		$msg_backtrace = print_r($error_log['errbacktrace'], true);
		$msg_backtrace = str_replace(array("\r\n", "\r", "\n"), '\n', $msg_backtrace);

		if ( $error_log['errtype']=='php'){
			debugger::$num_warnings ++
		?>
		var err_containner = document.createElement("div");
		err_containner.className = "debugger-container";
		err_containner.innerHTML = '<ul class="errTrigger"><b><?php echo $msg_file;?></b> - Error(<?php echo $msg_number;?>) in line: <?php echo $msg_line;?> - <?php echo $msg_text;?> <li data-d="0"><div class="debugger-content2"><b>Error Context</b><br /><pre><?php echo $msg_context;?></pre></div><div class="debugger-content2"><b>Error Backtrace</b><br /><pre><?php echo $msg_backtrace;?></pre></div></li></ul>';
		destinoPhp.appendChild(err_containner);
		<?php
		}
		elseif ( $error_log['errtype']=='sql'){
			debugger::$num_sql ++
		?>
		var err_containner = document.createElement("div");
		err_containner.className = "debugger-container2";
		err_containner.innerHTML = '<ul class="errTrigger"><b><?php echo $msg_file;?></b> - <?php echo $msg_text;?> </li></ul>';
		destinoSql.appendChild(err_containner);
		<?php			
		}
		elseif ( $error_log['errtype']=='sql_error'){
			debugger::$num_sql_error ++
		?>
		var err_containner = document.createElement("div");
		err_containner.className = "debugger-container3";
		err_containner.innerHTML = '<ul class="errTrigger"><b><?php echo $msg_file;?></b> - <?php echo $msg_text;?> </li></ul>';
		destinoSqlError.appendChild(err_containner);
		<?php			
		}
	}


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
		$errors_log = debugger::$errors_log;
		if (count($errors_log)>0): 
			switch (debugger::$debugger_output){
				case "file":
					debugger::fileLogDebug();
					break;
				default:
					debugger::stylesDebug();
					debugger::jsDebug();
			}
		endif;
	}

	private function fileLogDebug(){
		if (file_exists('errorlog.log')){
			echo "existe fichero ";
		}
		else{
			echo "NO existe fichero ";
		}
		$fp = fopen('errorlog.log', 'x');
		fwrite($fp, '1');
		fwrite($fp, '23');
		fclose($fp);
	}

	private function jsDebug(){
		?>
		<script type="text/javascript">
			(function(){ 
			function elemListen (elem, event, fn) { 
				if (document.addEventListener){ 
					elem.addEventListener(event, fn, false);
				} else { 
					elem.attachEvent('on' + event, fn); 
				}
			}

			function listListen(list, event, fn) {
				for (var i = 0, len = list.length; i < len; i++) {
					elemListen (list[i], event, fn);
				}
			}

			function showErr(){
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

			function showMessages(){
				var item = document.getElementById("contentPhp");
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

			function showMessagesSql(){
				var item = document.getElementById("contentSql");
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

			function showMessagesSqlError(){
				var item = document.getElementById("contentSqlError");
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

			var debugger_container =  document.createElement("div");
			debugger_container.id = "debugger-content";
			document.body.appendChild(debugger_container);
			
			var destinoDebug = document.getElementById("debugger-content");
			destinoDebug.innerHTML = "<div id='debugger-main'><?php echo "PHP " . PHP_VERSION . " (" . PHP_OS . ") - <b>Sql queries:</b> <span id='num-sql'>0</span> <b>Warnings:</b> <span id='num-warnings'>0</span> <b>Sql errors:</b> <span id='num-sql-error'>0</span></div>";?>";		
			destinoDebug.style.display = "block";

			var destinoPhp =  document.createElement("div");
			destinoPhp.id = "contentPhp";
			destinoDebug.appendChild(destinoPhp);

			var destinoSql =  document.createElement("div");
			destinoSql.id = "contentSql";
			destinoDebug.appendChild(destinoSql);

			var destinoSqlError =  document.createElement("div");
			destinoSqlError.id = "contentSqlError";
			destinoDebug.appendChild(destinoSqlError);

			<?php
			foreach(debugger::$errors_log as $error_log):
				debugger::addMessage($error_log);
			endforeach;
			?>
			var num_warnings = document.getElementById("num-warnings");			
			num_warnings.innerHTML = "<?php echo debugger::$num_warnings>0 ? '<span>'.debugger::$num_warnings.'</span>' : debugger::$num_warnings;?>";
			num_warnings.setAttribute("data-d", 0);
			elemListen (num_warnings,"click", showMessages);

			var num_sql = document.getElementById("num-sql");
			num_sql.innerHTML = "<?php echo debugger::$num_sql>0 ? '<span>'.debugger::$num_sql.'</span>' : debugger::$num_sql;?>";
			num_sql.setAttribute("data-d", 0);
			elemListen (num_sql,"click", showMessagesSql);

			var num_sql_error = document.getElementById("num-sql-error");
			num_sql_error.innerHTML = "<?php echo debugger::$num_sql_error>0 ? '<span>'.debugger::$num_sql_error.'</span>' : debugger::$num_sql_error;?>";
			num_sql_error.setAttribute("data-d", 0);
			elemListen (num_sql_error,"click", showMessagesSqlError);

			var errTriggers = document.getElementsByClassName("errTrigger");
			listListen (errTriggers,"click", showErr);
			})();
		</script>
		<?php
	}

	private function stylesDebug(){
		?>
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
				#debugger-content h1{
					color:#fff;
					font-family:Arial;
					font-size:22px;
					margin: 15px 0 0 0;
				}
				#debugger-content h2{
					color:#000;
					font-family:Arial;
					font-size:20px;
					margin:0px !important;
				}
				#debugger-content h3{
					color:#000;
					font-family:Arial;
					font-size:16px;
				}
				#debugger-content pre{
					font-size: 11px;
				}
				.debugger-container{
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
				.debugger-container2{
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
				.debugger-container3{
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

				.errTrigger li{
					display:none;
				}	
				.debugger-content1{
					display:none;
					font-size: 12px;
				}
				.debugger-content2{	
					background-color: #fff;
					font-size: 12px;		
					margin: 5px 0 0 0;
					max-height: 100px;
					overflow:auto;
					padding: 5px;
				}

				#contentPhp{
					display: none;
				}

				#contentSql{
					display: none;
				}
				#contentSqlError{
					display: none;
				}		
				#num-warnings span{
					background-color: #f1da36;
					border-radius: 20px;
					color: #8a6d3b;
					cursor: pointer;
					font-weight: bolder;
					padding: 3px 6px;
				}

				#num-sql span{
					background-color: #3c763d;
					border-radius: 20px;
					color: #fcf8e3;
					cursor: pointer;
					font-weight: bolder;
					padding: 3px 6px;
				}

				#num-sql-error span{
					background-color: #a94442;
					border-radius: 20px;
					color: #f2dede;
					cursor: pointer;
					font-weight: bolder;
					padding: 3px 6px;
				}
			</style>
		<?php 
	}
}
?>