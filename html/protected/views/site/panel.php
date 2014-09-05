<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this -> pageTitle = Yii::app() -> name . ' - Panel';
?>

<h3>Settings</h3>

<p>
	Settings defined here only affect future messages.
</p>

<div class="form">

	<?php $form = $this -> beginWidget('CActiveForm', array('id' => 'panel-form', )); ?>

	<?php echo $form -> errorSummary($model); ?>

	<div class="row">
		<?php echo $form -> labelEx($model, 'alias'); ?>
		<?php echo $form -> dropDownList($model, 'alias', $model -> aliases, array('class' => 'form-control')); ?>
		<?php echo $form -> error($model, 'alias'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-primary')); ?>
	</div>

	<?php $this -> endWidget(); ?>
</div><!-- form -->
