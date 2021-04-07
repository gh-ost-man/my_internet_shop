<?php 
    namespace backend\controllers;
    
    use Yii;
    use yii\web\Controller;
    use yii\web\UploadedFile;
    use yii\data\ActiveDataProvider;
    use yii\helpers\ArrayHelper;
    use yii\filters\AccessControl;

    use backend\models\DiscountForm;
    use common\models\Discount;

    class DiscountController extends Controller
    {
       
        public function behaviors()
        {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['index', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'create', 'update', 'delete'],
                            'roles' => ['admin', 'owner', 'manager'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['index'],
                            'roles' => ['user'],
                        ],
                    ],
                ],
            ];
        }
        public function actionIndex()
        {
            $dataProvider = new ActiveDataProvider([
                'query' => Discount::find()
            ]);

            return $this->render('index',[
                'dataProvider' => $dataProvider
            ]);
        }

        public function actionCreate()
        {
            $model = new DiscountForm;

            if($model->load(Yii::$app->request->post())){
                $discount = new Discount;
                $discount->name = $model->name;
                $discount->description = $model->description;
                $discount->percent = $model->percent;

                if($discount->save()){
                    Yii::$app->session->setFlash('success', 'Товар збережено в БД');
                } else {
                    Yii::$app->session->setFlash('error', 'Помилка збереження товару в БД');
                }
                return $this->redirect(['discount/index']);
            }

            return $this->render('create', [
                'model' => $model,
                'discount_id' => ''
            ]);
        }
        
        public function actionUpdate($id)
        {
            $model = new DiscountForm;
            $discount = Discount::findOne(['id' => $id]);

            if($model->load(Yii::$app->request->post())){
                $discount->name = $model->name;
                $discount->description = $model->description;
                $discount->percent = $model->percent;
                
                if($discount->save()){
                    Yii::$app->session->setFlash('success', 'Знижку оновлено в БД');
                } else {
                    Yii::$app->session->setFlash('error', 'Помилка оновлення знижки в БД');
                }
                return $this->redirect(['discount/index']);
            }

            $model->name = $discount->name;
            $model->description = $discount->description;
            $model->percent = $discount->percent;
          
        
            return $this->render('create', [
                'model' => $model,
                'discount_id' => $discount->id,
            ]);
        }

        public function actionDelete($id)
        {
            $discount = Discount::findOne(['id' => $id]);
          
            if($discount->delete(['id' => $id])) {
                Yii::$app->session->setFlash('success', "Знижку: < {$discount->name} > видалено з БД");
            } else {
                Yii::$app->session->setFlash('error', 'Помилка видалення товару з БД');
            }
            return $this->redirect(['discount/index']);
        }
    }