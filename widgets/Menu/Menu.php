<?php

namespace app\base\widgets\Menu;

use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Menu extends \yii\widgets\Menu {

    /**
     * @inheritdoc
     * **/
    protected function renderItem($item)
    {
        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);

            return strtr($template, [
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
                '{icon}' => $item['icon'],
                '{active}' => $this->isItemActive($item) ? $this->activeCssClass : null
            ]);
        } else {
            $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

            return strtr($template, [
                '{label}' => $item['label'],
            ]);
        }
    }

}