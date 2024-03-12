<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Employee $model */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
