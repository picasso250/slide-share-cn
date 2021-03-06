<?php

class PptController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        Yii::log('create', CLogger::LEVEL_INFO);
        $model=new Ppt;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ppt']))
		{
            Yii::log('start create', CLogger::LEVEL_INFO);
            $model->attributes=$_POST['Ppt'];
            if (!isset($_FILES['Ppt']['name']['url'])) {
                Yii::log('no $_FILES[Ppt]', CLogger::LEVEL_ERROR);
                $this->jsAlert('请选择文件');
            }
            $url = $this->upload();
            $model->url = $url;
            $model->created = date('Y-m-d H:i:s');
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

    public function jsAlert($msg)
    {
        echo "<script>alert('$msg');location.href='?';</script>";
        exit;
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ppt']))
		{
			$model->attributes=$_POST['Ppt'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $dataProvider=new CActiveDataProvider('Ppt');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Ppt('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ppt']))
			$model->attributes=$_GET['Ppt'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Ppt the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Ppt::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Ppt $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ppt-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /**
     * 上传文件
     * @return string
     */
    private function upload()
    {
        $upload_root = Yii::app()->params['upload_root'];
        $date = '/' . date('Ymd');
        $root = $upload_root . $date;
        if (!is_dir($root)) {
                Yii::log("$root is not dir", CLogger::LEVEL_WARNING);
            if (is_file($root)) {
                Yii::log("$root is file", CLogger::LEVEL_ERROR);
                return '';
            }
            mkdir($root, 0777, true);
        }
        $content = file_get_contents($_FILES['Ppt']['tmp_name']['url']);
        $len_in = strlen($content);
        $path = '/' . microtime() . '.pdf';
        $url = $root . $path;
        $len = file_put_contents($url, $content);
        if ($len != $len_in) {
            Yii::log(" $len $len_in not match, write not enough", CLogger::LEVEL_WARNING);
            return '';
        }
        return $date.$path;
    }
}
