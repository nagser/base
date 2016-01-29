<?php
/**
 * @var $iconLeft
 * @var $iconRight
 * @var $isActive
 * @var $isParent
 * @var $firstLevel
 * */
?>
<?if($isParent):?>
	<a class="accordion-toggle <?= $isActive ? 'menu-open' : ''?>" href="#">
		<?= $iconLeft?>
		<span class="sidebar-title">{label}</span>
		<span class="caret"></span>
	</a>
<?else:?>
	<a href="{url}">
		<?= $iconLeft?>
		<?= $firstLevel ? '<span class="sidebar-title">{label}</span>' : '{label}'?>
	</a>
<?endif?>
