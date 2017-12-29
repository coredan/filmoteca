<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Restore"),
);
?>

<h3><?php echo UserModule::t("Restore password"); ?></h3>

<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
</div>
<?php else: ?>

<div class="form">
<?php echo CHtml::beginForm(); ?>

	<?php echo CHtml::errorSummary($form); ?>

	<div class="row">
        <p class="hint"><?php echo UserModule::t("Enter your login or email addres and we send you an e-mail with instructions for recovery your account"); ?></p>
        <div class="col-lg-12">
		    <?php echo CHtml::activeLabel($form,'login_or_email'); ?>
        </div>
        <div class="col-lg-12">
		<?php echo CHtml::activeTextField($form,'login_or_email', array('class'=>'form-control')) ?>
        </div>
	</div>

	<div class="row submit">
		<?php echo CHtml::submitButton(UserModule::t("Restore")); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
<?php endif; ?>