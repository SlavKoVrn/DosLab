<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\BookStatus $model */

$this->title = 'Изменить: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Состояния книг', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="book-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
