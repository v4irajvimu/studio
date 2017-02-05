<?php

class StockController extends Controller
{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/settings';

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
			'actions'=>array('index','view','jsondata','create','update','delete'),
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


public function actionjsondata($id) {
	$data = Stock::model()->findByPk($id);
	$output = CJSON::encode($data);
	echo $output;
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
	try {
		$save = false;
		foreach ($_POST['woItem'] as $value) {
			$model = new Stock;
			$model->trans_type_id = 1;
			$model->items_id= $value['items_id'];
			$model->supplier_id= $value['supplier_id'];
			$model->qty_in= $value['qty'];
			$model->qty_out= null;
			$model->eff_date= date('Y-m-d');
			$model->cost= $value['cost'];
			$model->selling= $value['selling'];
			$model->amount= $value['amount'];
			$model->remark= null;
			$model->wo_type= null;
			$model->online= 1;
			$model->created= date('Y-m-d H:i:s');
			$model->wrk_order_id= null;
			$save = $model->save();
		}


		if (!$save) {

			$er = $model->getErrors();
			$err_txt = "";
			foreach ($er as $key => $value) {
				$lebel = $model->getAttributeLabel($key);
				$err_txt .= $lebel . " : " . $value[0] . "<br/>";
			}
			throw new Exception($err_txt);
		}

		echo "Successfully Created";
	} catch (Exception $exc) {
		echo $exc->getMessage();
	}
}

/**
* Updates a particular model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id the ID of the model to be updated
*/
public function actionUpdate($id)
{
	try {

		$model=$this->loadModel($id);

		$model->attributes = $_POST;

		if (!$model->save()) {

			$er = $model->getErrors();
			$err_txt = "";
			foreach ($er as $key => $value) {
				$lebel = $model->getAttributeLabel($key);
				$err_txt .= $lebel . " : " . $value[0] . "<br/>";
			}
			throw new Exception($err_txt);

		}

		echo "Successfully Created";
	} catch (Exception $exc) {
		echo $exc->getMessage();
	}


}

/**
* Deletes a particular model.
* If deletion is successful, the browser will be redirected to the 'admin' page.
* @param integer $id the ID of the model to be deleted
*/
public function actionDelete($id)
{
	try {
		if ($this->loadModel($id)->delete()) {
			echo "Successfully Deleted";
		} else {
			echo "Error Occurred";
		}
	} catch (CDbException $exc) {
		echo "You can't Delete This Record, Database Reject the request, this record related with different records";
	} catch (Exception $exc) {
		echo "Invalid Operation";
	}
}

/**
* Lists all models.
*/
public function actionIndex()
{

	//Handle Search Values
	if (empty($_GET['val'])) {
		$searchtxt = "";
	} else {
		$searchtxt = " AND name LIKE '%" . $_GET['val'] . "%' ";
	}

	if (empty($_GET['pages'])) {
		$pages = 10;
	} else {
		$pages = $_GET['pages'];
	}


	$sql = "SELECT * FROM stock WHERE online = 1 $searchtxt ORDER BY items_id ASC ";
	$count = Yii::app()->db->createCommand($sql)->query()->rowCount;
	$dataProvider = new CSqlDataProvider($sql, array(
		'totalItemCount' => $count,
		'pagination' => array(
			'pageSize' => $pages
		),
	)
);

$this->render('index',array(
	'dataProvider'=>$dataProvider,
));
}

/**
* Manages all models.
*/
public function actionAdmin()
{
	$model=new Stock('search');
	$model->unsetAttributes();  // clear any default values
	if(isset($_GET['Stock']))
	$model->attributes=$_GET['Stock'];

	$this->render('admin',array(
		'model'=>$model,
	));
}

/**
* Returns the data model based on the primary key given in the GET variable.
* If the data model is not found, an HTTP exception will be raised.
* @param integer $id the ID of the model to be loaded
* @return Stock the loaded model
* @throws CHttpException
*/
public function loadModel($id)
{
	$model=Stock::model()->findByPk($id);
	if($model===null)
	throw new CHttpException(404,'The requested page does not exist.');
	return $model;
}

/**
* Performs the AJAX validation.
* @param Stock $model the model to be validated
*/
protected function performAjaxValidation($model)
{
	if(isset($_POST['ajax']) && $_POST['ajax']==='stock-form')
	{
		echo CActiveForm::validate($model);
		Yii::app()->end();
	}
}
}
