<?php

namespace nagser\base\assets\vendors;

use yii\web\AssetBundle;

class UrlAsset extends AssetBundle {

    public $sourcePath = '@bower/urijs/src';
    public $js = [
        'URI.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}