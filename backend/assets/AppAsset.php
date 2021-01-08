<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    // public $jsOptions = array(
    //     'position' => \yii\web\View::POS_HEAD
    // );

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css',
        'css/sb-admin-2.min.css',
        'css/site.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css',
        'https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i',
    ];
    public $js = [
        'js/sb-admin-2.min.js',
        'js/jquery.min.js',
        'js/bootstrap.bundle.min.js',
        'js/jquery.easing.min.js',
        'js/Chart.min.js',
        // 'js/chart-area-demo.js',
        'js/chart-pie-demo.js',
        '//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
