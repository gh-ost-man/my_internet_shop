<?php

    namespace backend\controllers;

    use Yii;
    use yii\web\Controller;
    use yii\data\ActiveDataProvider;
    use yii\filters\AccessControl;

    use backend\models\CategoryForm;
    use common\models\Category;


    class CategoryController extends Controller
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
                'query' => Category::find()
            ]);

            return $this->render('index',[
                'dataProvider' => $dataProvider
            ]);
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
                return $this->redirect(['category/index']);
            }

            return $this->render('create', [
                'model' => $model
            ]);
        }

        public function actionUpdate($id)
        {
            $model = new CategoryForm;
            $category = Category::findOne(['id' => $id]);

            if($model->load(Yii::$app->request->post())){
                $category->name = $model->name;
                $category->description = $model->description;
                    
                if($category->save()){
                    Yii::$app->session->setFlash('success', 'Категорію оновлено в БД');
                } else {
                    Yii::$app->session->setFlash('error', 'Помилка оновлення Категорії в БД');
                }
                return $this->redirect(['category/index']);
            }

            $model->name = $category->name;
            $model->description = $category->description;

            return $this->render('create', [
                'model' => $model,
                'category_id' => $category->id,
            ]);
        }

        public function actionDelete($id)
        {
            $category = Category::findOne(['id' => $id]);

            if($category->delete(['id' => $id])){
                Yii::$app->session->setFlash('success', "Категорію: < {$category->name} > видалено з БД");
            } else {
                Yii::$app->session->setFlash('error', 'Помилка видалення Категорії з БД');
            }

            return $this->redirect(['category/index']);
        }
    }
