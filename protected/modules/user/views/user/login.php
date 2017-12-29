<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
$this->breadcrumbs=array(
	UserModule::t("Login"),
);
?>

<div class="container-fluid">
    <div class="login-heading">
        <p class="panel-title"><span>La Filmoteca<?php //echo UserModule::t("Login"); ?></span></p>
    </div>
    <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
        <div class="flipper">
            <div class="front">
                <!-- front content -->
                <div class="panel panel-default panel-login" style="">
                    <div class="claqueta-decor"></div>
                    <div class="panel-body">
                        <?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

                        <div class="success">
                            <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
                        </div>

                        <?php endif; ?>

                        <div class="form">
                        <?php echo CHtml::beginForm(); ?>

                        <?php echo CHtml::errorSummary($model); ?>

                        <div class="row">
                            <div class="col-md-12">
                                <?php echo CHtml::activeLabel($model,'username'); ?>
                                <?php echo CHtml::activeTextField($model,'username', array('class'=>'form-control', 'placeholder'=> 'Nombre de usuario')); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo CHtml::activeLabel($model,'password'); ?>
                                <?php echo CHtml::activePasswordField($model,'password', array('class'=>'form-control', 'placeholder'=> 'Contraseña')) ?>
                            </div>
                        </div>

                        <div class="row rememberMe">
                            <div class="col-md-12 text-center">
                                <?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
                                <?php echo CHtml::activeLabelEx($model,'rememberMe',array('style'=>'font-weight:normal;')); ?>
                            </div>
                        </div>

                        <div class="row submit">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-default" type="submit" style="width: 50%"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</button>
                            </div>
                        </div>

                        <?php echo CHtml::endForm(); ?>
                        </div><!-- form -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="hint text-center">
                            <?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"),"#",array("id"=>"lostPasword")); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="back">
                <div class="panel panel-default panel-login" style="">
                    <div class="claqueta-decor"></div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial('application.modules.user.views.recovery.recovery', array('form'=>new UserRecoveryForm)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>