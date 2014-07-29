<?php
if($ini_conf['debug_app']==1){
	$errors_log = array();
	set_error_handler('errorHandler');
	register_shutdown_function("shutdownHandler");
}
else{
	error_reporting(0);
}

function errorHandler( $errno, $errstr, $errfile, $errline, $errcontext){
	if (!(error_reporting() & $errno)) {
		// Este código de error no está incluido en error_reporting
		return;
	}

	addError($errno, $errstr, $errfile, $errline, $errcontext, debug_backtrace());

    /* No ejecutar el gestor de errores interno de PHP */
    return true;
}

function addError($errno, $errstr, $errfile, $errline, $errcontext, $errbacktrace){
	global $errors_log;
	$error = array( 'errfile' => $errfile,
					'errno' => $errno,
					'errline' => $errline,
					'errstr' => $errstr,
					'errcontext' => $errcontext,
					'errbacktrace' => $errbacktrace );

	array_push($errors_log, $error);
}

function shutdownHandler (){
	global $errors_log;
	if (count($errors_log)>0):?>
		?>
		<style type="text/css">
		#debugger-content{
			display: none;
			font-family:Arial;
			width:100%;
			margin:0 0 0 0;
			background-color:#000;
			text-align:left;
			color:#fff;
			padding: 20px 5%;
			position: absolute;
			top:0;
			left: 0;
			z-index: 999999999;
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
			background-color: #ccc;
			color:#666;
			margin: 5px 0 30px;
			padding: 10px;
		}		
		.debugger-content1{
			font-size: 14px;
		}
		.debugger-content2{
			font-size: 11px;
		}
		</style>
		<script type="text/javascript">
			var debugger_container =  document.createElement("div");
			debugger_container.id = "debugger-content";
			document.body.appendChild(debugger_container);
			
			var destino = document.getElementById("debugger-content");
			destino.innerHTML = "<h1><?php echo "PHP " . PHP_VERSION . " (" . PHP_OS . ")</h1><p>Num Errors: <b>".count($errors_log)."</b></p>";?>";		
			destino.style.display = "block";
			<?php
			foreach($errors_log as $error_log):
				$msg_file = str_replace(array("\r\n", "\r", "\n"), '\n', $error_log['errfile']);
				$msg_number = str_replace(array("\r\n", "\r", "\n"), '\n', $error_log['errno']);
				$msg_line = str_replace(array("\r\n", "\r", "\n"), '\n', $error_log['errline']);
				$msg_text = str_replace(array("\r\n", "\r", "\n"), '\n', $error_log['errstr']);
				$msg_context = print_r($error_log['errcontext'], true);
				$msg_context = str_replace(array("\r\n", "\r", "\n"), '\n', $msg_context);
				$msg_backtrace = print_r($error_log['errbacktrace'], true);
				$msg_backtrace = str_replace(array("\r\n", "\r", "\n"), '\n', $msg_backtrace);
				?>
				//add main div error
				var err_containner = document.createElement("div");
				err_containner.className = "debugger-container";
				
				//add div with general info
				var err_info = document.createElement("div");
				err_info.className = "debugger-content1";  
				err_info.innerHTML = "<h3><?php echo $msg_file;?></h3><h2>Error(<?php echo $msg_number;?>) in line: <?php echo $msg_line;?></h2><em><?php echo $msg_text;?></em>";
				err_containner.appendChild(err_info);

				//add div with message context
				var err_context = document.createElement("div");
				err_context.className="debugger-content2";  
				err_context.innerHTML = '<h3>Error Context</h3><pre><?php echo $msg_context;?></pre>';
				err_containner.appendChild(err_context);

				//add div with message backtrace
				var err_backtrace = document.createElement("div");
				err_backtrace.className="debugger-content2";  
				err_backtrace.innerHTML = '<h3>Error Backtrace</h3><pre><?php echo $msg_backtrace;?></pre>';
				err_containner.appendChild(err_backtrace);

				destino.appendChild(err_containner);
				<?php
			endforeach;
			?>
		</script>
		<?php
	endif;
}
?>