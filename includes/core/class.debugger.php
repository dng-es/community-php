<?php
//if($ini_conf['debug_app']==1){
	ini_set('memory_limit', -1);
	//$errors_log = array();
	set_error_handler('errorHandler');
	register_shutdown_function("shutdownHandler");
// }
// else{
// 	error_reporting(0);
// }

class debugger {
	
	static public $errors_log = array();

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
		?>
		var err_containner = document.createElement("div");
		err_containner.id = "contentPhp";
		err_containner.className = "debugger-container";
		err_containner.innerHTML = '<ul class="errTrigger"><b><?php echo $msg_file;?></b> - Error(<?php echo $msg_number;?>) in line: <?php echo $msg_line;?> - <?php echo $msg_text;?> <li data-d="0"><div class="debugger-content2"><b>Error Context</b><br /><pre><?php echo $msg_context;?></pre></div><div class="debugger-content2"><b>Error Backtrace</b><br /><pre><?php echo $msg_backtrace;?></pre></div></li></ul>';
		destino.appendChild(err_containner);
		<?php
		}
		elseif ( $error_log['errtype']=='sql'){
		?>
		var err_containner = document.createElement("div");
		err_containner.id = "contentSql";
		err_containner.className = "debugger-container2";
		err_containner.innerHTML = '<ul class="errTrigger"><b><?php echo $msg_file;?></b> - <?php echo $msg_text;?> </li></ul>';
		destino.appendChild(err_containner);
		<?php			
		}
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

//var_dump(debugger::$errors_log);

	$errors_log = debugger::$errors_log;
	if (count($errors_log)>0): ?>
		<style type="text/css">
		#debugger-content{
			display: none;
			font-family:Arial;
			font-size: 12px;
			width:100%;
			margin:0 0 0 0;
			background-color:#f2dede;
			text-align:left;
			color:#a94442;
			position: fixed;
			bottom:0;
			left: 0;
			z-index: 999999999;
		}
		#debugger-content p{
			margin: 5px;
		}
		#debugger-content h1{
			font-family:Arial;color:#fff;font-size:22px; margin: 15px 0 0 0;
		}
		#debugger-content h2{
			font-family:Arial;color:#000;font-size:20px;margin:0px !important
		}
		#debugger-content h3{
			font-family:Arial;color:#000;font-size:16px
		}
		#debugger-content pre{
			font-size: 11px;
		}
		.debugger-container{
			background-color: #fcf8e3;
			border-bottom: 1px solid #faebcc;
			color:#8a6d3b;
			font-size: 12px;
			padding: 5px;
		}
		.debugger-container2{
			background-color: #dff0d8;
			border-bottom: 1px solid #d6e9c6;
			color:#3c763d;
			font-size: 12px;
			padding: 5px;
		}
		.errTrigger{
			cursor:pointer;
			margin:0;
			padding: 0;
		}
		.errOk{

		}

		.errTrigger li{
			display:none;
		}	
		.debugger-content1{
			display:none;
			font-size: 14px;
		}
		.debugger-content2{
			font-size: 12px;
			background-color: #fff;
			padding: 5px;
			margin: 5px 0 0 0;
			max-height: 100px;
			overflow:auto;
		}

		#contentPhp{

		}

		</style>
		<script type="text/javascript">

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


			var debugger_container =  document.createElement("div");
			debugger_container.id = "debugger-content";
			document.body.appendChild(debugger_container);

			var debugger_container2 =  document.createElement("div");
			debugger_container2.id = "debugger-content2";
			document.body.appendChild(debugger_container2);
			
			var destino = document.getElementById("debugger-content");
			destino.innerHTML = "<p><?php echo "PHP " . PHP_VERSION . " (" . PHP_OS . ") - Num Alerts: <b>".count($errors_log)."</b>- Num Warnings: <span id='num-warnings'>0</span>- Num Sql queries: <span id='num-sql'>0</span></p>";?>";		
			destino.style.display = "block";
			<?php
			foreach($errors_log as $error_log):
				debugger::addMessage($error_log);
			endforeach;
			?>

			var errTriggers = document.getElementsByClassName("errTrigger");
			listListen (errTriggers,"click", showErr);
		</script>
		<?php
	endif;
}
?>