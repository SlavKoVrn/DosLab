<?php

use common\models\Operation;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\OperationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Выдача, возврат книг';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operation-index">

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['timeout' => 0]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'type',
                'content' => function($model){
                    return Operation::$types[$model->type];
                }
            ],
            [
                'attribute' => 'datetime',
                'content' => function($model){
                    return date('d.m.Y H:i',strtotime($model->datetime));
                }
            ],
            [
                'attribute' => 'employee_id',
                'content' => function($model){
                    return $model->employee->fio ?? '';
                }
            ],
            [
                'attribute' => 'client_id',
                'content' => function($model){
                    return $model->client->fio ?? '';
                }
            ],
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Operation $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
