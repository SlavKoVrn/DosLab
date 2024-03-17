<?php
use common\models\Operation;
use common\models\BookStatus;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;
use unclead\multipleinput\MultipleInput;
/** @var yii\web\View $this */
/** @var common\models\Operation $model */
/** @var yii\widgets\ActiveForm $form */
/** @var $operationBooks */

\backend\assets\GlyphiconsAsset::register($this);
?>

<div class="operation-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col col-sm-6">
            <?= $form->field($model, 'type')->dropDownList(Operation::$types) ?>
        </div>
        <div class="col col-sm-6">
            <?= $form->field($model, 'client_id')->widget(Select2::class, [
                'data' => $model->getClientData(),
                'options' => [
                    'placeholder' => 'Клиент',
                    'multiple' => false,
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 1,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Подождите...'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['operation/client']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) {return {q:params.term}; }'),
                        'delay' => 250,
                        'cache' => true,
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(data) {return data.text; }'),
                    'templateSelection' => new JsExpression('function (data) {  return data.text; }'),
                ],
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col col-sm-12">
            <?= $form->field($model, 'book')->widget(Select2::class, [
                'options' => [
                    'placeholder' => 'Выбор книги',
                    'multiple' => false,
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 1,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Подождите...'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['operation/book']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) {return {q:params.term}; }'),
                        'delay' => 250,
                        'cache' => true,
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(data) {return data.text; }'),
                    'templateSelection' => new JsExpression('function (data) {  return data.text; }'),
                ],
            ]); ?>
        </div>
    </div>
    <?php
    $js=<<<JS
        window.books = {$operationBooks};

        function isBookExists(bookId) {
            return window.books.some(book => parseInt(book.book_id) === parseInt(bookId));
        }
        function removeBookById(bookId) {
            window.books = window.books.filter(function(book) {
                return parseInt(book.book_id) !== parseInt(bookId);
            });
        }
        $('#multiple-input').on('beforeDeleteRow', function(e, row, currentIndex){
            var rowElement = $(row);
            var book_id = rowElement.find('td.list-cell__book_id').find('input.form-control').val();
            removeBookById(book_id);
        });

        $('#operation-book').on('select2:select' ,function(e){
            var selectedData = e.params.data;
            $('#operation-book').val(null).trigger('change');
            var newBook = { 
                "book_id": selectedData.id, 
                "name": selectedData.text, 
                "book_status_id": selectedData.status 
            };
            if (isBookExists(newBook.book_id)) {
                alert("Книга уже в списке");
            } else {
                window.books.push(newBook);
                $('#multiple-input').multipleInput('add', newBook);
            }
        })
JS;
    $this->registerJs($js);
    ?>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'books')->widget(MultipleInput::class, [
                'id' => 'multiple-input',
                'min' => 0,
                'allowEmptyList' => false,
                'data' => $data,
                'columns' => [
                    [
                        'name'  => 'book_id',
                        'defaultValue' => 0,
                        'options' => [
                            'type' => 'hidden',
                        ]
                    ],
                    [
                        'name'  => 'name',
                        'title' => 'Название',
                        'options' => [
                            'maxlength' => '255',
                            'readonly' => 'readonly',
                        ]
                    ],
                    [
                        'name'  => 'book_status_id',
                        'type'  => 'dropDownList',
                        'title' => 'Состояние книги',
                        'items' => BookStatus::getStatuses(),
                    ],
                ]
            ]);
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
