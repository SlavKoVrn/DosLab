<?php

namespace backend\controllers;

use common\models\Book;
use common\models\Operation;
use common\models\OperationBook;
use common\models\OperationSearch;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\db\Query;

/**
 * OperationController implements the CRUD actions for Operation model.
 */
class OperationController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'view', 'client', 'book'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                        [
                            'actions' => ['create', 'update'],
                            'allow' => true,
                            'roles' => [User::USER_ROLE_EMPLOYEE],
                        ],
                        [
                            'actions' => ['delete'],
                            'allow' => true,
                            'roles' => [User::USER_ROLE_ADMINISTRATOR],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Operation models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OperationSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Operation model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Operation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Operation();

        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post) and $model->save()) {
                $model->saveBooks($post['Operation']['books']);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'operationBooks' => json_encode([]),
            'data' => [],
        ]);
    }

    /**
     * Updates an existing Operation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $operationBooks = array_map(function($operationBook){
            return (object)[
                'book_id' => $operationBook->book_id,
                'name' => $operationBook->book->name,
                'book_status_id' => $operationBook->book_status_id,
            ];
        },$model->operationBooks);
        $operationBooks = json_encode($operationBooks,JSON_UNESCAPED_UNICODE);

        $data = array_map(function($operationBook){
            return [
                'book_id' => $operationBook->book_id,
                'name' => $operationBook->book->name,
                'book_status_id' => $operationBook->book_status_id,
            ];
        },$model->operationBooks);

        if ($this->request->isPost){
            $post = $this->request->post();
            if ($model->load($post) && $model->save()) {
                $model->saveBooks($post['Operation']['books']);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'operationBooks' => $operationBooks,
            'data' => $data,
        ]);
    }

    /**
     * Deletes an existing Operation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Operation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Operation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Operation::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionClient() {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $q = Yii::$app->request->get('q');
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = (new Query)
                ->select('id AS id, fio AS text')
                ->from('client')
                ->where(['like', 'fio', $q]);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        return $out;
    }

    public function actionBook() {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $q = Yii::$app->request->get('q');
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = (new Query)
                ->select('id AS id, name AS text, book_status_id AS status')
                ->from('book')
                ->where(['like', 'name', $q]);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        return $out;
    }

}
