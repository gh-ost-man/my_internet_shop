<?php 
    namespace backend\controllers;
    
    use Yii;
    use yii\web\Controller;
    use backend\models\TovarForm;
    use backend\models\Category;
    use backend\models\Tovar;
    

    class TovarController extends Controller
    {
        public function actionIndex()
        {
            $tovar =Tovar::find()->all();
            
            return $this->render('index',[
                'tovar' => $tovar
            ]);
        }

        public function actionCreate()
        {
            $model = new TovarForm;

            if($model->load(Yii::$app->request->post()) && $model->validate()){
                $tovar = new Tovar;
                 $tovar->name = $model->name;
                 $tovar->description = $model->description;
                // public $imageFile;
                $tovar->count = $model->count;
                $tovar->category_id = $model->category_id;
                $tovar->price = $model->price;

                if($tovar->save()){
                    Yii::$app->session->setFlash('success', 'Товар збережено в БД');
                } else {
                    Yii::$app->session->setFlash('error', 'Помилка збереження товару в БД');
                }
                $this->redirect('index');
            }

            $categories = Category::find()->all();
            foreach($categories as $category){
                $category_array[$category->id] = $category->name;
            }
            return $this->render('create', [
                'model' => $model,
                'categories' => $category_array,
            ]);
        }

    }