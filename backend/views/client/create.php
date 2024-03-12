<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Client $model */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
