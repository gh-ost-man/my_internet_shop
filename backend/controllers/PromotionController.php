<?php
    namespace backend\controllers;
    
    use Yii;
    use yii\web\Controller;
    use yii\web\UploadedFile;
    use yii\data\ActiveDataProvider;
    use yii\helpers\ArrayHelper;
    use yii\filters\AccessControl;

    use backend\models\PromotionForm;
    use common\models\Promotion;

    class PromotionController extends Controller
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
            ];        }

        public function actionIndex()
        {
            $dataProvider = new ActiveDataProvider([
                'query' => Promotion::find()
            ]);

            return $this->render('index',[
                'dataProvider' => $dataProvider
            ]);
        }

        public function actionCreate()
        {
            $model = new PromotionForm;

            if($model->load(Yii::$app->request->post())){
                $promotion = new Promotion;
                $model->imageFile = UploadedFile::getInstances($model, 'imageFile');
                if ($imagePath = $model->upload()){
                    $promotion->name = $model->name;
                    $promotion->description = $model->description;
                    $promotion->url_image = json_encode($imagePath);

                    if($promotion->save()){
                        Yii::$app->session->setFlash('success', 'Рекламу збережено в БД');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Помилка збереження реклами в БД');
                }
                return $this->redirect(['promotion/index']);
            }

            return $this->render('create', [
                'model' => $model,
                'initialPreview' => [],
                'initialConfig' => [],
                'promotion_id' => ''
            ]);
        }

        public function actionUpdate($id)
        {
            $model = new PromotionForm;
            $promotion = Promotion::findOne(['id' => $id]);

            if($model->load(Yii::$app->request->post())){
                $model->imageFile = UploadedFile::getInstances($model, 'imageFile');
                $imagePath = $model->upload();
                if ($imagePath !== false){
                    $promotion->name = $model->name;
                    $promotion->description = $model->description;
                    
                    if($imagePath){
                        $image = json_decode($promotion->url_image, true);
                        $imagePath = array_merge($image, $imagePath);
                        $promotion->url_image = json_encode($imagePath);
                    } 
                    if($promotion->save()){
                        Yii::$app->session->setFlash('success', 'Рекламу оновлено в БД');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Помилка оновлення реклами в БД');
                }
                return $this->redirect(['promotion/index']);
            }

            $model->name = $promotion->name;
            $model->description = $promotion->description;
            $images = json_decode($promotion->url_image, true);
           
            $initialPreview = [];
            $initialConfig = [];

            foreach($images as $image){
                $initialPreview[] = '../../' . $image;
                $initialConfig[] = [
                    'key' => $image
                ];
            }
        
            return $this->render('create', [
                'model' => $model,
                'initialPreview' => $initialPreview,
                'promotion_id' => $promotion->id,
                'initialConfig' => $initialConfig,
            ]);
        }

        public function actionFileDeletePromotion($id)
        {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;// формат відповіді
            
            if (isset($_POST['key'])){
                $image = $_POST['key'];
                
                unlink($image);
                
                $promotion = Promotion::findOne(['id' => $id]);
                $images = json_decode($promotion->url_image, true);
                $result = [];

                foreach($images as $value){
                    if($image != $value){
                        $result[] = $value;
                    }
                }
                
                $promotion->url_image = json_encode($result);
                $promotion->save();
            }
            
            return true;
        }

        public function actionDelete($id)
        {
            $promotion = Promotion::findOne(['id' => $id]);
            $images = json_decode($promotion->url_image, true);
          
            if($promotion->delete(['id' => $id])) {
                foreach($images as $image){
                    unlink($image);
                }

                Yii::$app->session->setFlash('success', "Товар: < {$promotion->name} > видалено з БД");
            } else {
                Yii::$app->session->setFlash('error', 'Помилка видалення товару з БД');
            }

            return $this->redirect(['promotion/index']);
        }

        public function actionView($id)
        {
            $promotion = Promotion::findOne(['id' => $id]);
            $images = json_decode($promotion->url_image);
            return $this->render('view', [
                'promotion' => $promotion,
                'images' => $images
            ]);
        }
    }