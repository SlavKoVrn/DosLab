<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\BookStatus $model */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Состояния книг', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
