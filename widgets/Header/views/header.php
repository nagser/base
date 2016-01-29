<?
/**
 * @var $content
 * @var $options
 * @var $branding
 * @var $brandingOptions
 * */
use yii\bootstrap\Html;

?>

<?= Html::beginTag('header', $options) ?>

<?= Html::tag('div', $branding, $brandingOptions) ?>

<?= $content?>

<?= Html::endTag('header') ?>

