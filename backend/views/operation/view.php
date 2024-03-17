<?php
use common\models\Operation;
use common\models\BookStatus;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Operation $model */

$this->title = Operation::$types[$model->type]. ' ' .date('d.m.Y H:i',strtotime($model->datetime));
$this->params['breadcrumbs'][] = ['label' => 'Изменить', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="operation-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'type',
                'value' => function($model){
                    return Operation::$types[$model->type];
                }
            ],
            [
                'attribute' => 'datetime',
                'value' => function($model){
                    return date('d.m.Y H:i',strtotime($model->datetime));
                }
            ],
            [
                'attribute' => 'employee_id',
                'value' => function($model){
                    return $model->employee->fio ?? '';
                }
            ],
            [
                'attribute' => 'client_id',
                'value' => function($model){
                    return $model->client->fio ?? '';
                }
            ],
        ],
    ]) ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Название</th>
            <th scope="col">Артикул</th>
            <th scope="col">Дата поступления</th>
            <th scope="col">Автор</th>
            <th scope="col">Состояние</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($model->operationBooks as $operationBook) : ?>
        <tr>
            <td><?= $operationBook->book->name ?></td>
            <td><?= $operationBook->book->article_number ?></td>
            <td><?= $operationBook->book->date_receipt ?></td>
            <td><?= $operationBook->book->author ?></td>
            <td><?= BookStatus::getStatusById($operationBook->book_status_id) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
