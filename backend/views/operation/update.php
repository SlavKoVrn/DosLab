<?php
use common\models\Operation;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Operation $model */
/** @var $operationBooks */

$this->title = 'Изменить: ' . Operation::$types[$model->type]. ' ' .date('d.m.Y H:i',strtotime($model->datetime));
$this->params['breadcrumbs'][] = ['label' => 'Выдача, возврат книг', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => Operation::$types[$model->type]. ' ' .date('d.m.Y H:i',strtotime($model->datetime)),
    'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="operation-update">

    <?= $this->render('_form', [
        'model' => $model,
        'operationBooks' => $operationBooks,
        'data' => $data,
    ]) ?>

</div>
