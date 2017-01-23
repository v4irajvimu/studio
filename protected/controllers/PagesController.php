<?php

class PagesController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/settings';

    /**
     * @return array action filters
     */
    public function filters() {
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
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'jsondata', 'create', 'update', 'delete'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionjsondata($id) {
        $data = Pages::model()->findByPk($id);
        $output = CJSON::encode($data);
        echo $output;
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        try {
            $model = new Pages;
            $epaper_det = Epaper::model()->findByPk($_POST['epaper_id']);
            $thumb = "Issue_" . $epaper_det->publication_number . "_" . $epaper_det->eff_year . "_" . $epaper_det->eff_month . "_page_" . $_POST['page_number'];
            $model->attributes = $_POST;
            $model->eff_month = $epaper_det->eff_month;
            $model->eff_year = $epaper_det->eff_year;
            $model->publication_number = $epaper_det->publication_number;

            if (!$model->save()) {
                $er = $model->getErrors();
                $err_txt = "";
                foreach ($er as $key => $value) {
                    $lebel = $model->getAttributeLabel($key);
                    $err_txt .= $lebel . " : " . $value[0] . "<br/>";
                }
                throw new Exception($err_txt);
            }
            // Start Image Uploading Pages Image
            $file = CUploadedFile::getInstanceByName("news_img");
            if ($file === null) {
                throw new Exception("Please Upload a Page Image");
            }

            $path = "./uploaded_epaper/pages/";
            if (!file_exists($path)) {
                mkdir($path);
            }
            $ext = $file->getExtensionName();
            if (!$file->saveAs($path . "" . $thumb . "." . $ext)) {
                throw new Exception("Error Occured While Uploading the Image");
            }
            // Add data to faculty_image table in db
            $thumbObj = $this->loadModel($model->id);
            $thumbObj->id = $model->id;
            $thumbObj->thumb = $thumb . "." . $ext;
            $thumbObj->save();
            // End Image Uploading Faculty Main Image

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
    public function actionUpdate($id) {
        try {

            $model = $this->loadModel($id);

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
            // Start File Uploading and Delete
            $file = CUploadedFile::getInstanceByName("news_img");
            if ($file === null) {
                throw new Exception("Please Upload a file");
            } else {
                // Delete Current photo
                $this->unlinkFile("/../uploaded_epaper/pages/", $model->thumb);

                $path = "./uploaded_epaper/pages/";
                if (!file_exists($path)) {
                    mkdir($path);
                }
                if (!$file->saveAs($path . "" . $model->thumb)) {
                    throw new Exception("Error Occured While Uploading the Image");
                }
            }
            // End Fille Uploading

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
    public function actionDelete($id) {
        try {
            $datarow = Pages::model()->findByPk($id);
//            print_r($datarow);
//            echo '<br>rererererererere ererere';
//            die();
            if ($this->loadModel($id)->delete()) {
//                 $datarow = Pages::model()->findByPk($id);
                // Delete Current photo
                $this->unlinkFile("/../uploaded_epaper/pages/", $datarow->thumb);
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
    public function actionIndex() {

        //Handle Search Values
        if (empty($_GET['val'])) {
            $searchtxt = "";
        } else {
            $searchtxt = " WHERE thumb LIKE '%" . $_GET['val'] . "%' ";
        }

        if (empty($_GET['pages'])) {
            $pages = 10;
        } else {
            $pages = $_GET['pages'];
        }


        $sql = "SELECT * FROM pages  $searchtxt ORDER BY epaper_id DESC, page_number ASC  ";
        $count = Yii::app()->db->createCommand($sql)->query()->rowCount;
        $dataProvider = new CSqlDataProvider($sql, array(
            'totalItemCount' => $count,
            'pagination' => array(
                'pageSize' => $pages
            ),
                )
        );

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Pages('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Pages']))
            $model->attributes = $_GET['Pages'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Pages the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Pages::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Pages $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pages-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
