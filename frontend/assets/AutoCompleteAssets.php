<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AutoCompleteAssets extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'autoComplete.css',
    ];
    public $js = [
        'js/autoComplete.min.js',
        'js/index.js'
    ];
}
