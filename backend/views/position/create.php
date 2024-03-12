<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Position $model */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Должности', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
