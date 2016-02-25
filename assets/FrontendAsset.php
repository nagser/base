<?php

namespace nagser\base\assets;

use yii\web\AssetBundle;


class FrontendAsset extends AssetBundle
{
    public $sourcePath = '@nagser/base/assets/web';
    public $baseUrl = '@web';
    public $css = [
        'css/system.less',
        'css/frontend.less',
    ];
    public $js = [
        'js/system.js',
        'js/frontend.js',
    ];

    public function init()
    {
        parent::init();

        $this->depends = [
            'yii\web\YiiAsset',
            'app\web\themes\\' . \Yii::getAlias('@currentTheme') . '\assets\ThemeAsset',
            'nagser\base\assets\vendors\IoniconsAsset',//Иконки
            'nagser\base\assets\vendors\AwesomefontsAsset',//Иконки
            'nagser\base\assets\vendors\JqueryUIAsset', //jQuery UI
            'nagser\base\assets\vendors\MustacheAsset',//Шаблонизатор js.
            'nagser\base\assets\vendors\MagnificPopupAsset',//Всплывающие окна.
            'nagser\base\assets\vendors\AnimateCssAsset',//Анимация.
            'nagser\base\assets\vendors\NprogressAsset',//Красивый индикатор загрузки.
            'nagser\base\assets\vendors\PNotifyAsset',//Всплывающие уведомления.
            'nagser\base\assets\vendors\AnimateHelperAsset',//Дополнительная анимация окон.
        ];
    }
}
