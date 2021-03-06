<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\Alert;
use backend\assets\AppAsset;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use backend\controllers\SiteController;
use common\models\Contact;
use common\models\Menus;
use common\models\Orders;
use common\models\Staff;
use SebastianBergmann\RecursionContext\Context;


function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


$userId = Yii::$app->user->identity->id;
$restaurantId = (Staff::find()->where(['userId' => $userId])->one())->restaurantId;
$menus = Menus::find()->where(['restaurantId' => $restaurantId])->all();
$menuId = -1;
foreach ($menus as $menu) {
    $menuId = $menu->menuId;
}
$sql = "SELECT orders.orderId, orders.date, orders.estado, profiles.fullname, profiles.alergias, dishes.type, dishes.name, dishes.description, order_items.quantity 
FROM orders
INNER JOIN profiles ON orders.userId = profiles.userId
INNER JOIN order_items ON orders.orderId = order_items.orderId
INNER JOIN dishes ON order_items.dishId = dishes.dishId
WHERE orders.estado = 0 AND dishes.menuId = $menuId";

$connection = Yii::$app->getDb();
$command = $connection->createCommand($sql);
$recs = $command->queryAll();

AppAsset::register($this);
rmrevin\yii\fontawesome\AssetBundle::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title>Foodly | <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body id="page-top">
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= Url::toRoute('/'); ?>">
                <div class="sidebar-brand-icon">
                    <!-- <i class="fas fa-laugh-wink"></i> -->
                    <?= Html::img(yii\helpers\Url::base() . '/img/LogoTransparente.png', ['style' => ['height' => '39px', 'width' => '39px']]); ?>
                </div>
                <div class="sidebar-brand-text mx-3">Food<sub>ly</sub></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <?php if (Yii::$app->request->url == '/') : ?>
                <li class="nav-item active">
                <?php else : ?>
                <li class="nav-item">
                <?php endif; ?>
                <a class="nav-link" href="<?= Url::toRoute('/'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Gestão
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <?php if (Yii::$app->request->url == '/staff' || Yii::$app->request->url == '/restaurant' || Yii::$app->request->url == '/menus' || Yii::$app->request->url == '/dishes' || Yii::$app->request->url == '/order') : ?>
                    <li class="nav-item active">
                    <?php else : ?>
                    <li class="nav-item">
                    <?php endif; ?>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Gestão</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Modelos:</h6>
                            <?php if (Yii::$app->request->url == '/staff') : ?>
                                <a class="collapse-item active" href="<?= Url::toRoute('staff/'); ?>">Staff</a>
                            <?php else : ?>
                                <a class="collapse-item" href="<?= Url::toRoute('staff/'); ?>">Staff</a>
                            <?php endif; ?>
                            <?php if (Yii::$app->request->url == '/restaurant') : ?>
                                <a class="collapse-item active" href="<?= Url::toRoute('restaurant/'); ?>">Restaurant</a>
                            <?php else : ?>
                                <a class="collapse-item" href="<?= Url::toRoute('restaurant/'); ?>">Restaurant</a>
                            <?php endif; ?>
                            <?php if (Yii::$app->request->url == '/menus') : ?>
                                <a class="collapse-item active" href="<?= Url::toRoute('menus/'); ?>">Menus</a>
                            <?php else : ?>
                                <a class="collapse-item" href="<?= Url::toRoute('menus/'); ?>">Menus</a>
                            <?php endif; ?>
                            <?php if (Yii::$app->request->url == '/dishes') : ?>
                                <a class="collapse-item active" href="<?= Url::toRoute('dishes/'); ?>">Dishes</a>
                            <?php else : ?>
                                <a class="collapse-item" href="<?= Url::toRoute('dishes/'); ?>">Dishes</a>
                            <?php endif; ?>
                            <?php if (Yii::$app->request->url == '/order') : ?>
                                <a class="collapse-item active" href="<?= Url::toRoute('order/'); ?>">Orders</a>
                            <?php else : ?>
                                <a class="collapse-item" href="<?= Url::toRoute('order/'); ?>">Orders</a>
                            <?php endif; ?>



                        </div>
                    </div>
                    </li>

                    <?php if (Yii::$app->request->url == '/kitchen') : ?>
                        <li class="nav-item active">
                        <?php else : ?>
                        <li class="nav-item">
                        <?php endif; ?>
                        <a class="nav-link" href="<?= Url::toRoute('kitchen/'); ?>">
                            <i class="fas fa-fw fa-utensils"></i>
                            <span>Cozinha</span>
                        </a>
                        </li>

                        <?php if (Yii::$app->request->url == '/messages') : ?>
                            <li class="nav-item active">
                            <?php else : ?>
                            <li class="nav-item">
                            <?php endif; ?>
                            <a class="nav-link" href="<?= Url::toRoute('messages/'); ?>">
                                <i class="fas fa-envelope fa-fw"></i>
                                <span>Mensagens</span>
                            </a>
                            </li>

                            <hr class="sidebar-divider d-none d-md-block">
                            <div class="text-center d-none d-md-inline">
                                <button class="rounded-circle border-0" id="sidebarToggle"></button>
                            </div>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" style="overflow: hidden;" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter"><?= sizeof($recs) ?></span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">Order Alert Center</h6>
                                <?php foreach ($recs as $order) : ?>
                                    <a class="dropdown-item d-flex align-items-center" href="/kitchen">
                                        <div class="mr-3">

                                            <?php if ($order["alergias"] != '') : ?>
                                                <div class="icon-circle bg-warning">
                                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                                </div>
                                            <?php else : ?>
                                                <div class="icon-circle bg-success">
                                                    <i class="fas fas fa-fw fa-utensils text-white"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500"><?= $order['type'] ?></div>
                                            <?= $order['name'] ?>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                                <a class="dropdown-item text-center small text-gray-500" href="/kitchen">Show All Orders</a>
                            </div>
                        </li>

                        <?php if (isset(Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id)['admin'])) : ?>
                            <!-- Nav Item - Messages -->
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-envelope fa-fw"></i>
                                    <!-- Counter - Messages -->
                                    <span class="badge badge-danger badge-counter"><?php echo Contact::find()->where(['isRead' => '0'])->count() ?></span>
                                </a>
                                <!-- Dropdown - Messages -->
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                                    <h6 class="dropdown-header">
                                        Message Center
                                    </h6>
                                    <?php foreach (Contact::find()->where(['isRead' => '0'])->limit(4)->orderBy(['(date)' => SORT_DESC])->all() as $contact) : ?>


                                        <?php if (!$contact->isRead) : ?>
                                            <a class="dropdown-item d-flex align-items-center" href="/messages/view?id=<?= $contact->contactId ?>">
                                                <div class="dropdown-list-image mr-3">
                                                    <?= Html::img(yii\helpers\Url::base() . 'https://avatars.dicebear.com/api/human/' . rand(1, 1000) . '.svg', ['class' => 'rounded-circle']); ?>
                                                    <div class="status-indicator bg-success"></div>
                                                </div>
                                                <div class="font-weight-bold">
                                                    <div class="text-truncate"><?= $contact->body ?></div>
                                                    <div class="small text-gray-500"><?= $contact->email ?> · <?= time_elapsed_string($contact->date . ""); ?></div>
                                                </div>
                                            </a>
                                        <?php else : ?>
                                        <?php endif; ?>


                                    <?php endforeach; ?>

                                    <a class="dropdown-item text-center small text-gray-500" href="/messages">Read More Messages</a>
                                </div>
                            </li>
                        <?php else : ?>
                        <?php endif; ?>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span name="Span[username]" class="mr-2 d-none d-lg-inline text-gray-600 small"><?= is_null(Yii::$app->user->identity) ? 'Guest' : Yii::$app->user->identity->username

                                                                                                                ?></span>
                                <?= Html::img(yii\helpers\Url::base() . 'img/undraw_profile.svg', ['class' => 'img-profile rounded-circle']); ?>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <?php $form = ActiveForm::begin(['id' => 'logout-form', 'class' => 'user', 'action' => '/site/logout']); ?>
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    <?= Html::submitButton('Logout', ['style' => 'display: inline;background: none;box-shadow: 0px 0px 0px transparent;border:  transparent;text-shadow: 0px 0px 0px transparent;', 'name' => 'logout-button']) ?>
                                    <?php ActiveForm::end(); ?>
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
            </div>

            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fa fa-angle-up"></i>
            </a>

            <div class="wrap" id='wrap' style="padding-left: 1.5rem;
    padding-right: 1.5rem;">
                <div>
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </div>

            <?php $this->endBody() ?>
        </div>
</body>

</html>
<?php $this->endPage() ?>

<script>
    $(document).ready(function() {
        if ($('table').length) {
            $('table').attr('id', 'myTable');
            $('#myTable').DataTable();
            $('.pagination').remove();
        }
        <?php
        $every_month = SiteController::sql_requests('every_month');

        $array = [];
        foreach ($every_month as $month) {
            array_push($array, $month['Earning']);
        }
        ?>

        function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        // Area Chart Example
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Earnings",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: <?php echo json_encode($array) ?>,
                    // data: [0, 2, 23, 10, 14, 2, 1, 1, 1, 11, 1, 1], 
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return '$' + number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });




    });
</script>