<?php

namespace nagser\base\assets\vendors;

use yii\web\AssetBundle;

class MagnificPopupAsset extends AssetBundle
{
//	public $sourcePath = '@app/vendor/bower/magnific-popup/dist';
//	public $css = [
//		'magnific-popup.css',
//	];
//	public $js = [
//		'jquery.magnific-popup.js',
//	];

    public $sourcePath = '@bower/bootstrap3-dialog/dist';
    public $js = [
        'js/bootstrap-dialog.min.js',
    ];
    public $css = [
        'css/bootstrap-dialog.min.css',
    ];

    public function init()
    {
        parent::init();

        $this->depends = [
            'app\web\themes\\' . \Yii::getAlias('@currentTheme') . '\assets\ThemeAsset',
        ];
    }
}