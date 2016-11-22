<?php
addJavascripts(array(getAsset("muro")."js/muro-comentarios-todos-ajax.js"));

templateload("reply","muro");
templateload("cmbCanales","users");
templateload("addcomment","muro");

//OBTENCION DE LOS COMENTARIOS DEL MURO
$muro = new muro();
if (isset($_REQUEST['id'])) $nombre_muro = $_REQUEST['id'];
if (isset($_POST['tipo_responder'])) $nombre_muro = $_POST['tipo_responder'];
if (isset($_POST['tipo_muro'])) $nombre_muro = $_POST['tipo_muro'];
if ($nombre_muro == "") $nombre_muro = "principal";

if (isset($_REQUEST['pag'])) $pagina = $_REQUEST['pag'];
else $pagina = 1;
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Wall"), "ItemClass"=>"active"),
		));
		?>
		<span id="tipo_muro" data-val="<?php echo $nombre_muro;?>"></span>
		<span id="pagina" data-val="<?php echo $pagina;?>"></span>
		<div id="destino">
			<div id="cargando" style="display:none"><i class="fa fa-spinner fa-spin ajax-load"></i></div>
		</div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php  addComment('principal', true, $title_label = "New_comment_on_wall");?>
			<br /><div id="result-muro"></div>
		</div>
	</div>
</div>
<?php replyMuro();?>