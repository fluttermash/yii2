<?php

namespace frontend\controllers;


use Yii;
use yii\filters\VerbFilter;
use app\models\person\Person;

class PersonController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add'=>['POST'],
                    'delete' => ['DELETE'],
                    'update'=>['PUT'],
                    'get-list'=>['GET'],
                ],
            ],
      'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors'=>[],
                'actions' => [
                ],
            ],
        ];
    }
    
    
    public function actionAdd()
    {
        
        $postData = file_get_contents("php://input");
        
        $postData = json_decode($postData);
         
        
        $model = new Person();
        $model->name=$postData->name;
        $model->age=$postData->age;
       
        if($model->save())
        {
            Yii::$app->response->statusCode = 200;
            return json_encode(array('message'=>'Submitted Successfully','id'=>$model->id));
        } else {
            print_r($model->errors);
              Yii::$app->response->statusCode = 500;
            return json_encode(array('message'=>'Error in submission'));
        }
        
      
    }
    
    
    public function actionUpdate()
    {
        
        $postData = file_get_contents("php://input");
        
        $postData = json_decode($postData);
        
        $model = Person::find()->where(['id'=>$postData->id])->one();
        
        $model->name = $postData->name;
        $model->age = $postData->age;
        
        if($model->save())
        {
            Yii::$app->response->statusCode = 200;
            return json_encode(array('message'=>'Updated Successfully'));
        } else {
            print_r($model->errors);
              Yii::$app->response->statusCode = 500;
            return json_encode(array('message'=>'Error in updation'));
        }
        
    }
    
    
    public function actionDelete()
    {
        $postData = file_get_contents("php://input");
        
        $postData = json_decode($postData);
        
        $model = Person::findOne(['id'=>$postData->id])->delete();
        
        Yii::$app->response->statusCode = 200;
        
         return json_encode(array('message'=>'Deleted successfully'));
        
    }
    
    public function actionGetList()
    {
        
        $model = Person::find()->asArray()->all();
        
        Yii::$app->response->statusCode = 200;
        
        return json_encode($model);
        
        
    }
    
    
    
    
    
    
    
    

}
