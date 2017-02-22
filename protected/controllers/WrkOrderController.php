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
	public function accessRules(){
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
			'actions'=>array('index','view','payment','jsondata','create','update','delete','cust_list','codegen','item_list','workdone','print'),
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

 public function actionPrint($id)
	{
		$this->renderPartial('printpdf', array(
                                    'wo_id' => $id,
                                    ));
	}
public function actionworkdone(){
	$wo_det = WrkOrder::model()->findByPk($_POST['id']);
	$wo_det->is_wrok_done = '1';
	if($wo_det->save()){

		$no = $wo_det->id;
		$mobile = $wo_det->customer->tp_mobile;
		$cust = $wo_det->customer->name;
		$wo = $wo_det->code;
		$msg ="Dear ".$cust.", Your Order (".$wo.") Completed at ".date('Y-m-d H:i:s')."";

		$this->store_xml($no, $mobile, $msg, $wo);
}
}
public function store_xml($no, $mobile, $msg, $wo){
		
    
    $doc = new DOMDocument('1.0');
    $root = $doc->createElement('Smslist');
    $root = $doc->appendChild($root);

    $doc->formatOutput = true;
    $user = $doc->createElement('SmsAlert');
    $user = $doc->appendChild($user);


    $title = $doc->createElement('indexNo');
    $title = $user->appendChild($title);
    $text = $doc->createTextNode($no);
    $text = $title->appendChild($text);

    $title = $doc->createElement('regCode');
    $title = $user->appendChild($title);
    $text = $doc->createTextNode('smtk2345');
    $text = $title->appendChild($text);

    $title = $doc->createElement('phnNo');
    $title = $user->appendChild($title);
    $text = $doc->createTextNode($mobile);
    $text = $title->appendChild($text);

    $title = $doc->createElement('message');
    $title = $user->appendChild($title);
    
        $text = $doc->createTextNode($msg);
    
    $text = $title->appendChild($text);

    $title = $doc->createElement('status');
    $title = $user->appendChild($title);
    $text = $doc->createTextNode('PENDING');
    $text = $title->appendChild($text);

    $title = $doc->createElement('active');
    $title = $user->appendChild($title);
    $text = $doc->createTextNode('TRUE');
    $text = $title->appendChild($text);
    $user = $root->appendChild($user);
    $doc->saveXML();

    $doc->formatOutput = true; 

    $file_data = "xml/wo_complete_".$wo."_".$no.".xml";

    $doc->save($file_data); 
    // $this->load->helper('download');

    $data = file_get_contents($file_data);
    force_download($file_data, $data);
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
	$code = $pre."_".date('d')."".date('m')."_".$paded;
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
		echo '<td>'.$value['cost'].'</td>';
		echo '<td>'.$value['selling'].'</td>';
		echo '<td><button type="button"
		data-name="'.$value['name'].'"
		data-id="'.$value['id'].'"
		data-cost="'.$value['cost'].'"
		data-selling="'.$value['selling'].'"
		data-min_price="'.$value['min_price'].'"
		data-max_price="'.$value['max_price'].'"
		data-supplier_id="'.$value['supplier_id'].'"
		class="item_row btn btn-info btn-sm"><span class="glyphicon glyphicon-plus"></span></button></td>';
		echo '</tr>';

	}
}

public function actionjsondata($id) {
	$data['sum'] = WrkOrder::model()->findByPk($id);
	$data['det'] = WrkOrderHasItems::model()->findAllByAttributes(array('wrk_order_id'=>$id));
	$output = CJSON::encode($data);
	echo $output;
}

/**
* Displays a particular model.
* @param integer $id the ID of the model to be displayed
*/
public function actionView($id){
	$this->render('view',array(
		'model'=>$this->loadModel($id),
	));
}

public function actionPayment($id){
	$this->render('payment',array(
		'model'=>$this->loadModel($id)
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
		// Add data to wrk order table
		$model->code = $_POST['code'];
		$model->eff_date = $_POST['eff_date'];
		$model->wo_type = $_POST['wo_type'];
		$model->delivery_date = $_POST['delivery_date'];
		$model->remark = $_POST['remark'];
		$model->wo_status_id = 1;
		$model->customer_id = $_POST['customer_id'];
		$model->created = date('Y-m-d H:i:s');
		$model->customer_name = $_POST['customer_name'];
		$model->discount_type_id = $_POST['discount_type_id'];
		$model->discount = $_POST['discount'];
		$model->total = $_POST['total'];
		$model->discount_percentage = $_POST['discount_percentage'];


		$save = $model->save();
		if (!$save) {

			$er = $model->getErrors();
			$err_txt = "";
			foreach ($er as $key => $value) {
				$lebel = $model->getAttributeLabel($key);
				$err_txt .= $lebel . " : " . $value[0] . "<br/>";
			}
			throw new Exception($err_txt);
		}
		else{
			$wo_id = $model->id;
			$wo_type = $model->wo_type;
			if($wo_type == "CASH"){
				$trans_type_id = 2;
			}elseif ($wo_type == "CREDIT") {
				$trans_type_id = 3;
			}
			foreach ($_POST['woItem'] as $value) {
				$wrkOrderItemModel = new WrkOrderHasItems;
				$wrkOrderItemModel->attributes = $value;
				$wrkOrderItemModel->wrk_order_id =$wo_id;
				$wrkOrderItemModel->save();

				$supplier_id = Items::model()->findByPk($value['items_id'])->supplier_id;
				$this->stockUpdate($trans_type_id, $value['items_id'], $supplier_id, null, $value['qty'], date('Y-m-d'), $value['cost'], $value['selling'], $value['amount'], null ,$wo_type,1,date('Y-m-d H:i:s'),$wo_id);
			}
		}

		echo "Successfully Created";
	} catch (Exception $exc) {
		echo $exc->getMessage();
	}
}

public function stockUpdate($trans_type_id, $items_id, $supplier_id, $qty_in, $qty_out, $eff_date, $cost, $selling, $amount, $remark ,$wo_type,$online,$created,$wrk_order_id){
	$model = new Stock;
	$model->trans_type_id = $trans_type_id;
	$model->items_id= $items_id;
	$model->supplier_id= $supplier_id;
	$model->qty_in= $qty_in;
	$model->qty_out= $qty_out;
	$model->eff_date= $eff_date;
	$model->cost= $cost;
	$model->selling= $selling;
	$model->amount= $amount;
	$model->remark= $remark;
	$model->wo_type= $wo_type;
	$model->online= $online;
	$model->created= $created;
	$model->wrk_order_id= $wrk_order_id;
	$save = $model->save();
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
		else{
			$wo_id = $model->id;
			WrkOrderHasItems::model()->deleteAll("wrk_order_id = '$wo_id'");
			foreach ($_POST['woItem'] as $value) {
				$wrkOrderItemModel = new WrkOrderHasItems;
				$wrkOrderItemModel->attributes = $value;
				$wrkOrderItemModel->wrk_order_id =$wo_id;
				$wrkOrderItemModel->save();
			}
		}

		echo "Successfully Created";
	} catch (Exception $exc) {
		echo $exc->getMessage();
	}


}

/**
* Stock Update
**/





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
		$searchtxt = " WHERE (remark LIKE '%" . $_GET['val'] . "%' OR code LIKE '%" . $_GET['val'] . "%') ";
	}

	if (empty($_GET['pages'])) {
		$pages = 10;
	} else {
		$pages = $_GET['pages'];
	}


	$sql = "SELECT wo.*,c.name AS cust_name,
					(SELECT IFNULL(SUM(amount),0) FROM payments p WHERE p.wrk_order_id = wo.id) AS paid,
					wos.name as status
					FROM wrk_order wo
					JOIN customer c ON c.id=wo.customer_id
					JOIN wo_status wos ON wos.id = wo.wo_status_id
					$searchtxt ORDER BY wo.code ASC ";

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
