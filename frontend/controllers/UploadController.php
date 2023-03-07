<?php

namespace frontend\controllers;

use Yii;
use common\models\UploadHandler;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContentsController implements the CRUD actions for Contents model.
 */
class UploadController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'send' => ['POST'],
                ],
            ],
        ];
    }

    public function actionSend(){
		// var_dump('db');die;
    	error_reporting(E_ERROR | E_WARNING | E_PARSE);
    	// $path = './';
    	$path = "/var/www/ifgl_frontend/frontend/web/uploads/";
		// echo getcwd();
		// echo $path;
		// die;
    	$uploader = new UploadHandler();
		// Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
		$uploader->allowedExtensions = array("jpeg","jpg","png","bmp","gif"); // all files types allowed by default
		// Specify max file size in bytes.
		$uploader->sizeLimit = null;
		// Specify the input name set in the javascript.
		$uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default
		// If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
		$uploader->chunksFolder = $path."chunks";
		$method = $_SERVER["REQUEST_METHOD"];
		if ($method == "POST") {
		    header("Content-Type: text/plain");
		    // Assumes you have a chunking.success.endpoint set to point here with a query parameter of "done".
		    // For example: /myserver/handlers/endpoint.php?done
		    if (isset($_GET["done"])) {
		        $result = $uploader->combineChunks($path."files");
		    }
		    // Handles upload requests
		    else {
		        // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
		        $result = $uploader->handleUpload($path."files");
		        // To return a name used for uploaded file you can use the following line.
		        $result["uploadName"] = $uploader->getUploadName();
		    }
		    return \yii\helpers\Json::encode($result);
		}
		// for delete file requests
		else if ($method == "DELETE") {
		    $result = $uploader->handleDelete($path."files");
		    return \yii\helpers\Json::encode($result);
		}
		else {
		    header("HTTP/1.0 405 Method Not Allowed");
		}
    }

}
