<?php
$filtro = " AND username_order='".$_SESSION['user_name']."' ";

if (isset($_POST['find_reg'])) $filtro .= " AND d.id_order LIKE '%".$_POST['find_reg']."%' ";
if (isset($_REQUEST['f'])) $filtro .= " AND d.id_order LIKE '%".$_REQUEST['f']."%' ";
$filtro .= " ORDER BY d.id_order DESC";

$elements = shopOrdersController::getListDetailAction(15, $filtro);
?>
<div class="row row-top">
    <div class="app-main">
        <?php
        menu::breadcrumb(array(
            array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
            array("ItemLabel"=>strTranslate("APP_Shop"), "ItemUrl"=>"shopproducts"),
            array("ItemLabel"=> strTranslate("Shop_my_orders"), "ItemClass"=>"active"),
        ));
        ?>
        <ul class="nav nav-pills navbar-default">
            <li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
            <div class="pull-right">
                <?php echo SearchForm($elements['reg'], "shoporders", "searchForm", strTranslate("Search"), strTranslate("Search"), "", "navbar-form navbar-left");?>
            </div>
        </ul>
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th width="40px">&nbsp;</th>
                    <th>ID</th>
                    <th>Artículo</th>
                    <th><?php e_strTranslate("Date");?></th>
                </tr>
                <?php foreach($elements['items'] as $element): ?>
                        <tr>
                            <td nowrap="nowrap">
                                <span class="fa fa-edit icon-table" title="ver pedido"
                                    onClick="location.href='shopproductorderdetail?id=<?php echo $element['id_order'];?>'">
                                </span>
                            </td>
                            <td><?php echo $element['id_order'];?></td>
                            <td><?php echo $element['name_product'];?></td>
                            <td><?php echo getDateFormat($element['date_order'], 'SHORT');?></td>
                        </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], 'shoporders','Pedidos', $elements['find_reg']);?>
    </div>
    <div class="app-sidebar">
        <div class="panel-interior">
            <h2>Premios</h2>
            <p>Puedes canjear tus <?php e_strTranslate("APP_Credits");?> por fantasticos <?php strtolower(e_strTranslate("Shop_products"));?>!</p>
            <p class="text-center"><i class="fa fa-shopping-cart fa-big"></i></p>
        </div>
    </div>
</div>