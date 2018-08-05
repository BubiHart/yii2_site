<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Change your data';
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Html::encode($this->title)?></h1>

<div class="row">
    <div class="col-lg-5">
        <h4>Your current login: <?php echo Yii::$app->user->identity->login; ?></h4>
        <?php $form = ActiveForm::begin([
            'id' => 'update-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}{error}",
            ],
        ]); ?>

        <?= $form->field($model, 'new_login')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'new_password')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
