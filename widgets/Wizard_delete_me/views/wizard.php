<?
use yii\helpers\ArrayHelper;

/**
 * @var $id
 * @var $options
 * @var $source
 * */
?>
<div class="admin-form">
	<div class="wizard steps-bg steps-left clearfix" id="<?= $id ?>">
		<div class="steps">
			<ul>
				<?
				$count = 0;
				foreach ($source as $key => $item):
					$count++;
					?>
					<li class="<?= $count === 1 ? 'first current' : 'disabled' ?>">
						<a href="#tab-<?= $key ?>"
						   data-toggle="tab"><?= ArrayHelper::getValue($item, 'label', 'Tab Label') ?></a>
					</li>
				<? endforeach ?>
			</ul>
		</div>
		<div class="content tab-content clearfix">
			<? foreach ($source as $key => $item): ?>
				<div class="tab-pane" id="tab-<?= $key ?>">
					<section class="wizard-section body">
						<?= ArrayHelper::getValue($item, 'content', 'Tab Content') ?>
					</section>
				</div>
			<? endforeach ?>
			<div class="actions clearfix">
				<ul role="menu" aria-label="Pagination">
					<li class="disabled" aria-disabled="true"><a href="#previous" role="menuitem"><?= Yii::t('system', 'previous') ?></a></li>
					<li aria-hidden="false" aria-disabled="false"><a href="#next" role="menuitem"><?= Yii::t('system', 'next') ?></a></li>
					<li aria-hidden="true" style="display: none;"><a href="#finish" role="menuitem"><?= Yii::t('system', 'finish') ?></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>