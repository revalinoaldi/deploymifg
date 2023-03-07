<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "vendors/css/vendors.min.css",
        "vendors/css/pickers/daterange/daterangepicker.css",
        "vendors/css/pickers/pickadate/pickadate.css",
        "vendors/css/sweetalert/sweetalert.css",
        "css/bootstrap.min.css",
        "css/bootstrap-extended.min.css",
        "css/colors.min.css",
        "css/components.min.css",
        "css/core/menu/menu-types/horizontal-menu.min.css",
        "css/core/colors/palette-gradient.min.css",
        "css/plugins/forms/wizard.min.css",
        "css/plugins/pickers/daterange/daterange.min.css",
        "https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css",
        "css/core/menu/menu-types/horizontal-menu.min.css",
        "css/core/colors/palette-gradient.min.css",
        "css/pages/gallery.min.css",
        "vendors/css/forms/icheck/icheck.css",
        "vendors/css/forms/icheck/custom.css",
        "css/plugins/forms/checkboxes-radios.min.css",
        "css/style.css",
        'css/site.css',
    ];
    public $js = [
        "vendors/js/ui/jquery.sticky.js",
        "vendors/js/charts/jquery.sparkline.min.js",
        "vendors/js/sweetalert/sweetalert.min.js",
        // "vendors/js/gallery/masonry/masonry.pkgd.min.js",
        // "vendors/js/gallery/photo-swipe/photoswipe.min.js",
        // "vendors/js/gallery/photo-swipe/photoswipe-ui-default.min.js",
        "vendors/js/vendors.min.js",
        "vendors/js/extensions/jquery.steps.min.js",
        "vendors/js/pickers/dateTime/moment-with-locales.min.js",
        "vendors/js/pickers/daterange/daterangepicker.js",
        "vendors/js/pickers/pickadate/picker.js",
        "vendors/js/pickers/pickadate/picker.date.js",
        "vendors/js/forms/icheck/icheck.min.js",
        "vendors/js/forms/validation/jquery.validate.min.js",
        "js/core/app-menu.min.js",
        "js/core/app.min.js",
        "js/scripts/customizer.js",
        "js/scripts/ui/breadcrumbs-with-stats.min.js",
        "js/scripts/forms/wizard-steps.min.js",
        "js/scripts/forms/checkbox-radio.min.js",
        "js/scripts/forms/custom-file-input.min.js",
        // "js/scripts/ui/breadcrumbs-with-stats.min.js",
        // "js/scripts/gallery/photo-swipe/photoswipe-script.min.js",
        "js/qrcodelib.js",
        "js/webcodecamjs.js",
    ];
    public $depends = [
		#'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
