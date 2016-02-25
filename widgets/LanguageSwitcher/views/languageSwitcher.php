<?php

use yii\helpers\Url;

/**
 * @var $items
 * */
?>
<? if(isset($items) and $items): ?>
	<li class="dropdown menu-merge">
		<div class="navbar-btn btn-group">
            <?= \yii\helpers\Html::button(\app\modules\languages\Languages::getLanguageNameByCode(Yii::$app->language), [
                'data-toggle' => 'dropdown',
                'class' => 'btn btn-sm dropdown-toggle'
            ])?>
			<ul class="dropdown-menu pv5" role="menu">
				<? foreach($items as $item): ?>
					<li>
                        <?= \yii\helpers\Html::a(\app\modules\languages\Languages::getLanguageNameByCode(\yii\helpers\ArrayHelper::getValue($item, 'code')), Url::to($item['url']))?>
					</li>
				<? endforeach ?>
			</ul>
		</div>
	</li>
<? endif ?>
