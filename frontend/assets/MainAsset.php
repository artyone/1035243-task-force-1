<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MainAsset extends AssetBundle
{
    public $basePath = '@frontend';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css', 'css/style.css'
    ];
    public $js = [
        'js/main.js'
    ];

}
