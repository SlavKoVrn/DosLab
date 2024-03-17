<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Operation $model */
/** @var $operationBooks */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Выдача, возврат книг', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operation-create">

    <?= $this->render('_form', [
        'model' => $model,
        'operationBooks' => $operationBooks,
        'data' => $data,
    ]) ?>

</div>
