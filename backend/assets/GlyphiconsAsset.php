<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class GlyphiconsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap3-glyphicons.min.css'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
