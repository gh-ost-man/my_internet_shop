<?php

    namespace backend\controllers;

    use Yii;
    use yii\web\Controller;
    use backend\models\CategoryForm;
    use backend\models\Category;


    class CategoryController extends Controller
    {
        public function actionIndex()
        {
            return $this->render('index');
        }


        public function actionCreate()
        {
            $model = new CategoryForm;

            if($model->load(Yii::$app->request->post()) && $model->validate()){
               $category = new Category;
               $category->name = $model->name;
               $category->description = $model->description;
            
                if ($category->save()){
                    Yii::$app->session->setFlash('success', 'Категорію збережено в БД');
                } else {
                    Yii::$app->session->setFlash('success', 'Помилка збереження категорії в БД');
                }

            }

            return $this->render('create', [
                'model' => $model
            ]);
        }
    }
