<?php

use yii\bootstrap\Tabs;

/**
 * @var $inputs;
 * */
foreach($inputs as $key => $input){
	$items[] = [
		'label' => $input['label'],
		'content' => $input['begin'] . $input['content'] . $input['end'],
		'active' => $key === \app\modules\languages\Languages::getDefaultLanguage() ? true : false,
	];
}

?>
<div class="tab-block mb25">
	<div class="nav-tabs-custom">
		<?=
		Tabs::widget([
			'items' => $items
		])?>
	</div>
</div>


