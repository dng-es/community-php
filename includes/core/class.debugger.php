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
	}


	function errorHandler( $errno, $errstr, $errfile, $errline, $errcontext){
		if (!(error_reporting() & $errno)) {
			// Este código de error no está incluido en error_reporting
			return;
		}

		debugger::addError($errno, $errstr, $errfile, $errline, $errcontext, debug_backtrace(), 'php');

	    /* No ejecutar el gestor de errores interno de PHP */
	    return true;
	}


	function shutdownHandler (){
		$errors_log = debugger::$errors_log;
		if (count($errors_log)>0): 
			debugger::stylesDebug();
			debugger::jsDebug();
		endif;
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

			var debugger_container =  document.createElement("div");
			debugger_container.id = "debugger-content";
			document.body.appendChild(debugger_container);
			
			var destinoDebug = document.getElementById("debugger-content");
			destinoDebug.innerHTML = "<div id='debugger-main'><?php echo "PHP " . PHP_VERSION . " (" . PHP_OS . ") - Num Alerts: <b>".count($errors_log)."</b> | Num Warnings: <span id='num-warnings'>0</span> | Num Sql queries: <span id='num-sql'>0</span></div>";?>";		
			destinoDebug.style.display = "block";

			var destinoPhp =  document.createElement("div");
			destinoPhp.id = "contentPhp";
			destinoDebug.appendChild(destinoPhp);

			var destinoSql =  document.createElement("div");
			destinoSql.id = "contentSql";
			destinoDebug.appendChild(destinoSql);

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
					border-top: 1px solid #EBCCD1;
					display: none;
					font-family:Arial;
					font-size: 14px;
					left: 0;		
					margin:0 0 0 0;
					max-height: 250px;
					overflow-y:auto;
					position: fixed;
					width:100%;
					z-index: 999999999;
				}
				#debugger-main{
					background-color:#f2dede;
					border-bottom: 1px solid #EBCCD1;
					color:#a94442;
					font-family:Arial;
					font-size: 14px;
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
					background-color: #fcf8e3;
					border-bottom: 1px solid #faebcc;
					color:#8a6d3b;
					font-size: 14px;
					padding: 5px;
				}
				.debugger-container2{
					background-color: #dff0d8;
					border-bottom: 1px solid #d6e9c6;
					color:#3c763d;
					font-size: 14px;
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
					font-size: 14px;
				}
				.debugger-content2{	
					background-color: #fff;
					font-size: 14px;		
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
				#num-warnings span{
					background-color: red;
					border-radius: 20px;
					color: #fff;
					cursor: pointer;
					font-weight: bolder;
					padding: 3px 6px;
				}

				#num-sql span{
					background-color: red;
					border-radius: 20px;
					color: #fff;
					cursor: pointer;
					font-weight: bolder;
					padding: 3px 6px;
				}
			</style>
		<?php 
	}
}
?>