<?php

namespace nagser\base\widgets\Menu;

use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Menu extends \yii\widgets\Menu
{

    public $parentLinkTemplate;
    public $parentLabelTemplate;

    /**
     * @inheritdoc
     * **/
    protected function renderItem($item)
    {
        //Есть ли дочерние элементы
        if(ArrayHelper::getValue($item, 'items')){
            $template = value($this->parentLinkTemplate, $this->linkTemplate);
        } else {
            $template = $this->linkTemplate;
        }
        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $template);
            return strtr($template, [
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
                '{icon}' => ArrayHelper::getValue($item, 'icon', null),
                '{active}' => ($this->isItemActive($item) or ArrayHelper::getValue($item, 'active', false)) ? $this->activeCssClass : null,
            ]);
        } else {
            $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);
            return strtr($template, [
                '{label}' => $item['label'],
            ]);
        }

    }

}