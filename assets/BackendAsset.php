<?php

namespace app\base\assets;

use yii\web\AssetBundle;


class BackendAsset extends AssetBundle
{
    public $sourcePath = '@app/base/assets/web';
    public $baseUrl = '@web';
    public $css = [
        'css/system.less',
        'css/backend.less',
    ];
    public $js = [
        'js/system.js',
        'js/backend.js',
    ];

    public function init()
    {
        parent::init();

        $this->depends = [
            'yii\web\YiiAsset',
//            'app\base\assets\vendors\MagnificPopupAsset',//Всплывающие окна.
            'app\base\assets\vendors\IoniconsAsset',//Иконки
            'app\base\assets\vendors\AwesomefontsAsset',//Иконки
            'app\base\assets\vendors\JqueryUIAsset', //jQuery UI
            'app\base\assets\vendors\MustacheAsset',//Шаблонизатор js.
            'app\base\assets\vendors\AnimateCssAsset',//Анимация.
            'app\base\assets\vendors\NprogressAsset',//Красивый индикатор загрузки.
            'app\base\assets\vendors\PNotifyAsset',//Всплывающие уведомления.
            'app\base\assets\vendors\AnimateHelperAsset',//Дополнительная анимация окон.
            'app\web\themes\\' . \Yii::getAlias('@currentTheme') . '\assets\ThemeAsset',
        ];
    }
}
