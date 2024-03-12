<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Employee $model */

$this->title = 'Изменить: ' . $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fio, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="employee-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
