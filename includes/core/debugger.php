<?php
if($ini_conf['debug_app']==1){
	iniErrorHandler();
	set_error_handler('errorHandler');
}
else{
	error_reporting(0);
}


function iniErrorHandler(){
	?>
	<style type="text/css">
		#debugger-content{
			display: none;
			font-family:Arial;
			width:100%;
			margin:0 0 0 0;
			background-color:#000;
			text-align:left;
			color:#666;
			padding: 20px 0 0 0;
			position: absolute;
			top:0;
			left: 0;
			z-index: 999999999;
		}
		#debugger-content h3{
			font-family:Arial;color:#000;font-size:16px
		}
		#debugger-content h2{
			font-family:Arial;color:#000;font-size:20px;margin:0px !important
		}
		#debugger-content pre{
			font-size: 11px;
		}
		.debugger-container{
			background-color: #ccc;
			margin: 5px 5% 30px;
			padding: 10px;
		}
		.debugger-content1{
			font-size: 14px;
		}
		.debugger-content2{
			font-size: 11px;
		}
	</style>
	<div id="debugger-content"></div><?php
}

function errorHandler( $errno, $errstr, $errfile, $errline, $errcontext){
	if (!(error_reporting() & $errno)) {
        // Este código de error no está incluido en error_reporting
        return;
    }

    switch ($errno) {
    case E_USER_ERROR:
    	echo '<div style="width:80%;margin:20px 10% 0 10%;background-color:#f0f0f0;padding: 40px 20px;text-align:left;color:#000">';
        echo "<b>ERROR</b> [$errno] $errstr<br />\n";
        echo "  Error fatal en la línea $errline en el archivo $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Abortando...<br />\n";
        echo '</div>';
        exit(1);
        break;

    case E_USER_WARNING:
        echo '<div style="width:80%;margin:20px 10% 0 10%;background-color:#f0f0f0;padding: 40px 20px;text-align:left;color:#000">';
        echo "<b>WARNING</b> [$errno] $errstr<br />\n";
        echo '</div>';
        break;

    case E_USER_NOTICE:
    	echo '<div style="width:80%;margin:20px 10% 0 10%;background-color:#f0f0f0;padding: 40px 20px;text-align:left;color:#000">';
        echo "<b>NOTICE</b> [$errno] $errstr<br />\n";
        echo '</div>';
        break;

    default:

    	$msg_file = str_replace(array("\r\n", "\r", "\n"), '\n', $errfile);
    	$msg_number = str_replace(array("\r\n", "\r", "\n"), '\n', $errno);
    	$msg_line = str_replace(array("\r\n", "\r", "\n"), '\n', $errline);
    	$msg_text = str_replace(array("\r\n", "\r", "\n"), '\n', $errstr);

    	$msg_context = print_r($errcontext, true);
    	$msg_context = str_replace(array("\r\n", "\r", "\n"), '\n', $msg_context);

    	$msg_backtrace = print_r(debug_backtrace(), true);
    	$msg_backtrace = str_replace(array("\r\n", "\r", "\n"), '\n', $msg_backtrace);
		?>
			<script type="text/javascript">
			var mensaje, mensaje2, mensaje3, mensaje4;
			var destino = document.getElementById("debugger-content");
			var err_containner = document.createElement("div");
			err_containner.className = "debugger-container";
			destino.style.display = "block";


			var err_info = document.createElement("div");
			err_info.className = "debugger-content1";  
			mensaje = '<?php echo $msg_file;?>';
			mensaje2 = '<?php echo $msg_number;?>';
			mensaje3 = '<?php echo $msg_line;?>';
			mensaje4 = '<?php echo $msg_text;?>';
			err_info.innerHTML = '<h3>' + mensaje + "</h3><h2>Error(" + mensaje2 + ") in line: " + mensaje3 + "</h2><em>" + mensaje4 + "</em>";
			err_containner.appendChild(err_info);

			var err_context = document.createElement("div");
			err_context.className="debugger-content2";  
			mensaje = '<?php echo $msg_context;?>';
			err_context.innerHTML = '<h3>Error context</h3><pre>' + mensaje + '</pre>';
			err_containner.appendChild(err_context);

			var err_backtrace = document.createElement("div");
			err_backtrace.className="debugger-content2";  
			mensaje = '<?php echo $msg_backtrace;?>';
			err_backtrace.innerHTML = '<h3>Backtrace of errorHandler()</h3><pre>' + mensaje + '</pre>';
			err_containner.appendChild(err_backtrace);

			destino.appendChild(err_containner);
			</script>
		<?php
        break;
    }

    /* No ejecutar el gestor de errores interno de PHP */
    return true;
}
?>