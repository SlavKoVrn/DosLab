<?php
use common\models\Operation;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Operation $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="operation-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col col-sm-6">
            <?= $form->field($model, 'type')->dropDownList(Operation::$types) ?>
        </div>
        <div class="col col-sm-6">
            <?= $form->field($model, 'client_id')->widget(Select2::class, [
                'data' => $model->getClientData(),
                'options' => [
                    'placeholder' => 'Клиент',
                    'multiple' => false,
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 1,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Подождите...'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['operation/client']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) {return {q:params.term}; }'),
                        'delay' => 250,
                        'cache' => true,
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(data) {return data.text; }'),
                    'templateSelection' => new JsExpression('function (data) {  return data.text; }'),
                ],
            ]); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
