<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Client $model */

$this->title = 'Изменить: ' . $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fio, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="client-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
