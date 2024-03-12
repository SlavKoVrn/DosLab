<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Position $model */

$this->title = 'Изменить: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Должности', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="position-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
