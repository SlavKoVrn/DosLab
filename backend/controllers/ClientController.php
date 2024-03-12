<?php

namespace backend\controllers;

use common\models\Client;
use common\models\ClientSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
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
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Client models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client model.
     * @param int $id Ид
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
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Client();

        if ($this->request->isPost) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($model->load($this->request->post()) && $model->save()) {

                    $user = new User;
                    $user->setAttributes([
                        'username' => $model->username,
                        'auth_key' => md5(time()),
                        'password_hash' => \Yii::$app->security->generatePasswordHash('123456'),
                        'password_reset_token' => \Yii::$app->security->generateRandomString(),
                        'email' => $model->email,
                        'verification_token' => '',
                        'created_at' => time(),
                        'updated_at' => time(),
                    ],false);
                    if (!$user->validate()) {
                        $errors = $user->errors;
                        foreach ($errors as $attribute => $errorMessages) {
                            foreach ($errorMessages as $errorMessage) {
                                throw new \Exception($errorMessage);
                            }
                        }
                    }
                    $user->save();

                    $model->user_id = $user->id;
                    $model->save();

                    $auth = \Yii::$app->authManager;
                    $clientRole = $auth->getRole(User::USER_ROLE_CLIENT);
                    $auth->assign($clientRole, $user->id);

                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                $model->loadDefaultValues();
                $transaction->rollBack();
            } catch (\Exception $e) {
                \Yii::$app->session->addFlash('danger', $e->getMessage());
                $model->loadDefaultValues();
                $transaction->rollBack();
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id Ид
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($model->load($this->request->post()) && $model->save()){
                    $user = User::findOne($model->user_id);
                    $user->setAttributes([
                        'email' => $model->email,
                        'username' => $model->username,
                    ]);
                    if (!$user->validate()) {
                        $errors = $user->errors;
                        foreach ($errors as $attribute => $errorMessages) {
                            foreach ($errorMessages as $errorMessage) {
                                throw new \Exception($errorMessage);
                            }
                        }
                    }
                    $user->save();
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (\Exception $e) {
                \Yii::$app->session->addFlash('danger', $e->getMessage());
                $transaction->rollBack();
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id Ид
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Ид
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
