<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object sdsdsd
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass."\n"; ?>
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/inventory_stick';
        

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
				'actions'=>array('index','print','pdf','sendmail','view','loaditems','grandtotal','updateremark','jsondata','approved','changestatus','create','update','delete'),
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
        
        
        
               
        public function actionloaditems() {
        
            //put Custome SQL Conditions to Here
            $condition = Yii::app()->db->createCommand("SELECT description,id FROM items WHERE online = 1 AND ( description LIKE '%" . $_GET['term'] . "%' OR code LIKE '%" . $_GET['term'] . "%')  ")->queryAll();
            $json = array();
            foreach ($condition as $value) {

                $json[] = array(
                    'label' => $value['description'],
                    'value' => $value['id']
                );
            }
            echo json_encode($json);
        }
        
        public function actionprint($id){
        
            if(!isset($_GET['mode'])){
                $mode = "print";
            }else{
                $mode = $_GET['mode']; 
            }
            
            $model = $this->loadModel($id);
            $model->is_completed = 1;
            $model->status = "approved";
            $model->save();
        
            $this->render('print',array(
		'model'=>$model,
                'mode' => $mode
            ));
            
            
        }
        
        
        public function actionupdateremark($id){   
            try{                
               
                $model = $this->loadModel($id);
                $model->remark = $_POST['text'];
                
                if (!$model->save()) {
                    
                    $er = $model->getErrors();
                    $err_txt = "";
                    foreach ($er as $key => $value) {
                        $lebel = $model->getAttributeLabel($key);
                        $err_txt .= $lebel . " : " . $value[0] . "<br/>";
                    }                    
                    throw new Exception($err_txt);
                    
                }                
                echo "Remark Updated !";
            
            } catch(Exception $exc){
                echo $exc->getMessage();
            }
        
        }
        
        public function actiongrandtotal($id){            
            
            <?php                 
                $mod = new $this->modelClass;
                $tbl = $mod->tableName();                
                echo "\$sql = \"SELECT SUM(qty * cost) AS total FROM ".$tbl."_items WHERE online = 1 AND ".$tbl."_id = '\$id' AND online = 1 \";";              
            ?> 
        
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            $data = array(
                'total' => $result[0]['total'],
                "total_formated" => number_format($result[0]['total'],2)
            );
            echo json_encode($data);
        
        }
        
        public function actionapproved($id){
            
            try{
            
                $model = $this->loadModel($id);
                $model->status = "approved";
                
                if (!$model->save()) {
                    
                    $er = $model->getErrors();
                    $err_txt = "";
                    foreach ($er as $key => $value) {
                        $lebel = $model->getAttributeLabel($key);
                        $err_txt .= $lebel . " : " . $value[0] . "<br/>";
                    }                    
                    throw new Exception($err_txt);
                    
                }                
                echo "Successfully Approved !";
                
            } catch(Exception $exc){
                 echo $exc->getMessage();
            }   
                
        }
        
        public function actionchangestatus(){
            try{
                
                $id = $_POST['id'];
                $model = $this->loadModel($id);
                $model->status = $_POST['status'];
                
                if (!$model->save()) {
                    
                    $er = $model->getErrors();
                    $err_txt = "";
                    foreach ($er as $key => $value) {
                        $lebel = $model->getAttributeLabel($key);
                        $err_txt .= $lebel . " : " . $value[0] . "<br/>";
                    }                    
                    throw new Exception($err_txt);
                    
                }                
                echo "Successfully Changed !";
            
            } catch(Exception $exc){
                echo $exc->getMessage();
            }
        }
        
        
        public function actionjsondata($id) {
                $data = <?php echo $this->modelClass; ?>::model()->findByPk($id);
                $output = CJSON::encode($data);
                echo $output;
        }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		
                
                <?php                 
                $mod = new $this->modelClass;
                $tbl = $mod->tableName();                
                echo "\$sql = \"SELECT * FROM ".$tbl."_items WHERE online = 1 AND ".$tbl."_id = '\$id' ORDER BY id ASC \";";              
                ?>                 
                
                $count = Yii::app()->db->createCommand($sql)->query()->rowCount;
                $dataProvider = new CSqlDataProvider($sql, array(
                    'totalItemCount' => $count,
                    'pagination' => array(
                        'pageSize' => 100
                        ),
                    )
                );
        
                $this->render('view',array(
			'model'=>$this->loadModel($id),
                        'dataProvider' => $dataProvider
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		try {           
            
                    $model = new <?php echo $this->modelClass; ?>;

                    $model->attributes = $_POST;
                    $model->created = date("Y-m-d H:i:s");
                    
                    $returnedCode =  $this->returnCode("<?php echo strtolower($this->modelClass); ?>", "<?php echo strtoupper($this->modelClass); ?>"); 
                    if($returnedCode == "Error"){
                        throw new Exception("Error Occured When Creating THE CODE");
                    }
                    
                    $model->code = $returnedCode;

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
                    echo "You can't Delete This Record, Database Reject the request, this record related with Another records";
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
                    $searchtxt = " AND code LIKE '%" . $_GET['val'] . "%' ";
                }
                
                if (empty($_GET['pages'])) {
                    $pages = 10;
                } else {
                    $pages = $_GET['pages'];
                }
                
                
                <?php                 
                $mod = new $this->modelClass;
                $tbl = $mod->tableName();                
                echo "\$sql = \"SELECT * FROM $tbl WHERE online = 1 \$searchtxt ORDER BY id DESC \";";                
                ?>                
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
		$model=new <?php echo $this->modelClass; ?>('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['<?php echo $this->modelClass; ?>']))
			$model->attributes=$_GET['<?php echo $this->modelClass; ?>'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return <?php echo $this->modelClass; ?> the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=<?php echo $this->modelClass; ?>::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param <?php echo $this->modelClass; ?> $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='<?php echo $this->class2id($this->modelClass); ?>-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
