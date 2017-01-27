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
				'actions'=>array('index','view','updatesingle','jsondata','create','update','delete'),
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
        
        
        public function actionupdatesingle($id){   
            try{                
               
                $model = $this->loadModel($id);
                $model->{$_POST['key']} = $_POST['newVal'];
                
                if (!$model->save()) {
                    
                    $er = $model->getErrors();
                    $err_txt = "";
                    foreach ($er as $key => $value) {
                        $lebel = $model->getAttributeLabel($key);
                        $err_txt .= $lebel . " : " . $value[0] . "<br/>";
                    }                    
                    throw new Exception($err_txt);
                    
                }                
                echo "Successfully Updated !";
            
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		try {           
            
                    $model = new <?php echo $this->modelClass; ?>;

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
