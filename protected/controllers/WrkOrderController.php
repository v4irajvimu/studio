<?php

class WrkOrderController extends Controller
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
				'actions'=>array('index','view','jsondata','create','update','delete','cust_list','codegen','item_list'),
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
        public function actioncodegen(){
            $sql = "SELECT * FROM `wrk_order` WHERE `wo_type`='".$_POST['wo_type']."'";
            $count = Yii::app()->db->createCommand($sql)->query()->rowCount;
            if($_POST['wo_type'] == "CASH"){
                $pre = "CS";
            }
            elseif ($_POST['wo_type'] == "CREDIT") {
                $pre = "CR";
            }
            $str = ++$count;
            $paded = str_pad($str,5,"0",STR_PAD_LEFT);
            $code = $pre."_".date('d')."".date('m')."".date('Y')."_".$paded;
            //print_r($code);
            echo $code;
        }

        public function actioncust_list() {
            $search = "";
            if(isset($_POST['search'])){
                $search = $_POST['search'];
            }
            $sql = "SELECT  * FROM `customer` WHERE (`name` LIKE '%$search%' OR `nic` LIKE '%$search%' OR `tp_fixed` LIKE '%$search%' OR `tp_mobile` LIKE '%$search%') LIMIT 0,10 ";
            $cust_det = Yii::app()->db->createCommand($sql)->queryAll();

            foreach ($cust_det as $value) {
                echo '<tr>';
                echo '<td>'.$value['name'].'</td>';
                echo '<td>'.$value['nic'].'</td>';
                echo '<td>'.$value['tp_mobile'].' '.$value['tp_fixed'].'</td>';
                echo '<td><button type="button" data-name="'.$value['name'].'" data-id="'.$value['id'].'" class="cust_row btn btn-info btn-sm"><span class="glyphicon glyphicon-plus"></span></button></td>';
                echo '</tr>';

            }
        }

        public function actionitem_list() {
            $search = "";
            if(isset($_POST['search'])){
                $search = $_POST['search'];
            }
            $sql = "SELECT  i.*,s.name as supplier FROM `items` i JOIN `supplier` s ON s.id=i.supplier_id WHERE (i.`name` LIKE '%$search%' OR s.`name` LIKE '%$search%' ) LIMIT 0,10 ";
            $item_det = Yii::app()->db->createCommand($sql)->queryAll();

            foreach ($item_det as $value) {
                echo '<tr>';
                echo '<td>'.$value['name'].'</td>';
                echo '<td>'.$value['selling'].'</td>';
                echo '<td><button type="button"
																	data-name="'.$value['name'].'"
																	data-id="'.$value['id'].'"
																	data-cost="'.$value['cost'].'"
																	data-selling="'.$value['selling'].'"
																	data-min_price="'.$value['min_price'].'"
																	data-max_price="'.$value['max_price'].'" 
																	class="item_row btn btn-info btn-sm"><span class="glyphicon glyphicon-plus"></span></button></td>';
                echo '</tr>';

            }
        }

        public function actionjsondata($id) {
                $data = WrkOrder::model()->findByPk($id);
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

                    $model = new WrkOrder;

                    $model->attributes = $_POST;
                    $model->created = date('y-m-d H:i:s');
                    $model->wo_status_id = 1;
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
                    $searchtxt = " WHERE (name LIKE '%" . $_GET['val'] . "%' OR code LIKE '%" . $_GET['val'] . "%') ";
                }

                if (empty($_GET['pages'])) {
                    $pages = 10;
                } else {
                    $pages = $_GET['pages'];
                }


                $sql = "SELECT * FROM wrk_order   $searchtxt ORDER BY name ASC ";
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
		$model=new WrkOrder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['WrkOrder']))
			$model->attributes=$_GET['WrkOrder'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return WrkOrder the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=WrkOrder::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param WrkOrder $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='wrk-order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
