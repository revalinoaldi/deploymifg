<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\base\ErrorException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\QuestionsCategory;
use common\models\QuestionsOption;
use common\models\ClosingStatement;
use common\models\FormPermintaan;
use kartik\mpdf\Pdf;
use linslin\yii2\curl;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'send-mail' => ['post'],
                    'send-form' => ['post'],
                    'from-province' => ['post'],
                    'verify-otp' => ['post'],
                    'verify-agent' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actionError()
    {
       $exception = Yii::$app->errorHandler->exception;
       if ($exception instanceof \yii\web\NotFoundHttpException) {
           return $this->render('error', ['exception' => $exception]);
       } else {
	   return $this->render('error', ['exception' => $exception]);
       }
    }



    /**
     * Displays homepage.
     *
     * @return mixed
     */

    public function actionIndex($slug="", $agent="")
    {
        if($slug != ""){
            $model = null;
            if($model != null){
                \Yii::$app->view->registerMetaTag([
                    'name' => 'description',
                    'content' => $model->meta_descriptions
                ]);
                \Yii::$app->view->registerMetaTag([
                    'name' => 'keywords',
                    'content' => $model->meta_keyword
                ]);
                return $this->render('about');
            }
        }
        switch ($slug) {
            case 'form-permintaan':
			$session = Yii::$app->session;
			if(!$session->has('verifAgent')){
				return $this->goHome();
			}
			$agent = base64_decode($agent);
			if(strtotime(date("d-m-Y H:i:s")) >= strtotime($session->get('verifAgent')['expire']) || !password_verify($agent, $session->get('verifAgent')['agen'])){
				$session->remove('verifAgent');
				return $this->goHome();
			}

            	$params = [
		    		"noagen"=> $agent
		    	];
				
				$curl = curl_init();

				curl_setopt_array($curl, array(
					CURLOPT_URL => 'https://asuransi.ifg-life.id/api/mifg/?noagen='. $agent,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'GET',
					CURLOPT_SSL_VERIFYPEER => false,
					CURLOPT_SSL_VERIFYHOST => false,
					CURLOPT_HTTPHEADER => array(
						'Authorization: Basic bWlmZzIwMjE6bTFmOUAkNG5kMQ=='
					),
				));

				$response = curl_exec($curl);

				curl_close($curl);
				$ag = \yii\helpers\Json::decode($response);
				
				
				if($ag["data"]==null){
					return $this->render('not_found');
                	break;
				}
				
				$dataagent = $ag["data"];

                $category = QuestionsCategory::find()->orderBy('sort_order asc')->all();
                \Yii::$app->view->registerMetaTag([
                    'name' => 'description',
                    'content' => Yii::$app->generalFunction->getSetting('description')
                ]);
                \Yii::$app->view->registerMetaTag([
                    'name' => 'keywords',
                    'content' => Yii::$app->generalFunction->getSetting('keyword')
                ]);
				
				
				$provs = $this->getAddress();
				$prov = \yii\helpers\Json::decode($provs);
				
				
                return $this->render('request-form', compact('agent', 'category', 'dataagent','prov'));
                break;
			case 'form-permintaan-smpl':
            	$params = [
					"noagen" => '9999999999'
		    	];
								
				if ($params['noagen'] == '9999999999') {
					$ag = [
						"error" => false,
						"message" => "SUCCESS",
						"data" => [
							"NOAGEN" => "9999999999",
							"NOLISENSIAGEN" => null,
							"NAMAAGEN" => "AGEN DUMMY LEADER INDIVIDUAL BUSINESS",
							"TELEPONAGEN" => "081383850xxx",
							"EMAILAGEN" => "agen.dummy@Ifg-life.id"
						]
					];
				}else{
					$ag = [
						"error" => true,
						"message" => "ERROR",
						"data" => null
					];
				}
				
				if($ag["data"]==null){
					return $this->render('not_found');
                	break;
				}
				
				
				$dataagent = $ag["resp"]["data"];

                $category = QuestionsCategory::find()->orderBy('sort_order asc')->all();
                \Yii::$app->view->registerMetaTag([
                    'name' => 'description',
                    'content' => Yii::$app->generalFunction->getSetting('description')
                ]);
                \Yii::$app->view->registerMetaTag([
                    'name' => 'keywords',
                    'content' => Yii::$app->generalFunction->getSetting('keyword')
                ]);
				
				
				$provs = $this->getAddress();
				$prov = \yii\helpers\Json::decode($provs);
				
				
                return $this->render('request-form-smpl', compact('agent', 'category', 'dataagent','prov'));
                break;
			case 'otp':
				return $this->render('otp');
				break;
            case 'manual':
				
				return $this->render('manual');
				break;
            case 'scan':
                \Yii::$app->view->registerMetaTag([
                    'name' => 'description',
                    'content' => Yii::$app->generalFunction->getSetting('description')
                ]);
                \Yii::$app->view->registerMetaTag([
                    'name' => 'keywords',
                    'content' => Yii::$app->generalFunction->getSetting('keyword')
                ]);
                return $this->render('scan');
                break;

			
            default:
                \Yii::$app->view->registerMetaTag([
                    'name' => 'description',
                    'content' => Yii::$app->generalFunction->getSetting('description')
                ]);
                \Yii::$app->view->registerMetaTag([
                    'name' => 'keywords',
                    'content' => Yii::$app->generalFunction->getSetting('keyword')
                ]);
                return $this->render('index');
                break;
        }
        
    }
	
	
	function yatidak($dipilih){
		switch($dipilih){
			case "0":
				$yatidak = "Tidak";
			break;
			case "1":
			default:
				$yatidak = "Ya";
			break;
		}
		
		return $yatidak;
	}
	
	
	public function actionSendForm()
	{
		/**/
		
		try{
			
			
			$post = Yii::$app->request->post();
			if(isset($post)<>''){

				parse_str($_POST["data"], $output);
				
				

				//switching manually		
				$jenisKelamin = QuestionsOption::find()->where(['question_id' => '6', 'point_value' => isset($output['jenisKelamin']) ? $output['jenisKelamin'] : "1"])->one();
				$statusPerkawinan = QuestionsOption::find()->where(['question_id' => '7', 'point_value' => isset($output['statusPerkawinan']) ? $output['statusPerkawinan'] : "0" ])->one();
				$pekerjaan = QuestionsOption::find()->where(['question_id' => '27', 'point_value' => isset($output['pekerjaan']) ? $output['pekerjaan'] : "1" ])->one();
				$pekerjaanTertanggung = QuestionsOption::find()->where(['question_id' => '27', 'point_value' => isset($output['pekerjaanTertanggung']) ? $output['pekerjaanTertanggung'] : "1" ])->one();
				$alamatSuratMenyurat = QuestionsOption::find()->where(['question_id' => '40', 'point_value' => isset($output['alamatSuratMenyurat']) ? $output['alamatSuratMenyurat'] : "0"])->one();
				$hubungan = QuestionsOption::find()->where(['question_id' => '41', 'point_value' => isset($output['hubungan']) ? $output['hubungan'] : "0"])->one();
				$jenisKelaminTertanggung = QuestionsOption::find()->where(['question_id' => '47', 'point_value' => isset($output['jenisKelaminTertanggung']) ? $output['jenisKelaminTertanggung'] : "1"])->one();
				$statusPerkawinanTertanggung = QuestionsOption::find()->where(['question_id' => '48', 'point_value' => isset($output['statusPerkawinanTertanggung']) ? $output['statusPerkawinanTertanggung'] : "0"])->one();
				$jumlahPenghasilanKotorPertahun = QuestionsOption::find()->where(['question_id' => '84', 'point_value' => isset($output['jumlahPenghasilanKotorPertahun']) ? $output['jumlahPenghasilanKotorPertahun'] : "0"])->one();
				$MetodePembayaranPremi = QuestionsOption::find()->where(['question_id' => '85', 'point_value' => isset($output['MetodePembayaranPremi']) ? $output['MetodePembayaranPremi'] : "0"])->one();
				$periodeBayarPremi = QuestionsOption::find()->where(['question_id' => '86', 'point_value' => isset($output['periodeBayarPremi']) ? $output['periodeBayarPremi'] : "2"])->one();
				$merokok = QuestionsOption::find()->where(['question_id' => '96', 'point_value' => isset($output['L00003']) ? $output['L00003'] : "0"])->one();
				$alkohol = QuestionsOption::find()->where(['question_id' => '97', 'point_value' => isset($output['L00004']) ? $output['L00004'] : "0"])->one();
				$obat = QuestionsOption::find()->where(['question_id' => '98', 'point_value' => isset($output['L00005']) ? $output['L00005'] : "0"])->one();
				$perlindungan = QuestionsOption::find()->where(['question_id' => '99', 'point_value' => isset($output['G00001']) ? $output['G00001'] : "0"])->one();
				$rawatjalan = QuestionsOption::find()->where(['question_id' => '100', 'point_value' => isset($output['G00002']) ? $output['G00002'] : "0"])->one();
				$rawatinap = QuestionsOption::find()->where(['question_id' => '101', 'point_value' => isset($output['G00003']) ? $output['G00003'] : "1"])->one();
				$tesmedis = QuestionsOption::find()->where(['question_id' => '102', 'point_value' => isset($output['G00004']) ? $output['G00004'] : "0"])->one();
				$hamil = QuestionsOption::find()->where(['question_id' => '103', 'point_value' => isset($output['KW00001']) ? $output['KW00001'] : "0"])->one();
				$tbc= QuestionsOption::find()->where(['question_id' => '120', 'point_value' => isset($output['MH0005']) ? $output['MH0005'] : "0"])->one();
				$amandel = QuestionsOption::find()->where(['question_id' => '124', 'point_value' => isset($output['MH0009']) ? $output['MH0009'] : "0"])->one();
				$hepatitis= QuestionsOption::find()->where(['question_id' => '125', 'point_value' => isset($output['MH0010']) ? $output['MH0010'] : "0"])->one();
				$prostat = QuestionsOption::find()->where(['question_id' => '126', 'point_value' => isset($output['MH0011']) ? $output['MH0011'] : "0"])->one();
				$tiroid = QuestionsOption::find()->where(['question_id' => '127', 'point_value' => isset($output['MH0012']) ? $output['MH0012'] : "0"])->one();
				$ayan = QuestionsOption::find()->where(['question_id' => '128', 'point_value' => isset($output['MH0013']) ? $output['MH0013'] : "0"])->one();
				$otot = QuestionsOption::find()->where(['question_id' => '129', 'point_value' => isset($output['MH0014']) ? $output['MH0014'] : "0"])->one();
				$manfaatTambahan = QuestionsOption::find()->where(['question_id' => '90', 'point_value' => isset($output['manfaatTambahan']) ? $output['manfaatTambahan'] : "0"])->one();
				$fungsitubuh = QuestionsOption::find()->where(['question_id' => '135', 'point_value' => isset($output['MH0020']) ? $output['MH0020'] : "0"])->one();
				$alamatPengirimanPolis = QuestionsOption::find()->where(['question_id' => '89', 'point_value' => isset($output['alamatPengirimanPolis']) ? $output['alamatPengirimanPolis'] : "0"])->one();
				$statusKepemilikan = QuestionsOption::find()->where(['question_id' => '87', 'point_value' => isset($output['G00001']) ? $output['G00001'] : "0"])->one();
				
				
				
				
				/*temporarily closed*/
				
				$tujuanPengajuanAsuransi = "";
				for($tuj=0; $tuj< count($output['tujuanPengajuanAsuransi']); $tuj++){
					$tpa = QuestionsOption::find()->where(['question_id' => '82', 'point_value' => isset($output['tujuanPengajuanAsuransi'][$tuj]) ? $output['tujuanPengajuanAsuransi'][$tuj] : "" ])->one();
					$tujuanPengajuanAsuransi .= $tpa->option_text . ", ";
				}
				$tujuanPengajuanAsuransi = rtrim($tujuanPengajuanAsuransi,", ");
				
				
				$sumberPenghasilanPerbulan = "";
				for($tuj=0; $tuj< count($output['sumberPenghasilanPerbulan']); $tuj++){
					$tpa = QuestionsOption::find()->where(['question_id' => '83', 'point_value' => isset($output['sumberPenghasilanPerbulan'][$tuj]) ? $output['sumberPenghasilanPerbulan'][$tuj] : "" ])->one();
					$sumberPenghasilanPerbulan .= $tpa->option_text . ", ";
				}
				$sumberPenghasilanPerbulan = rtrim($sumberPenghasilanPerbulan,", ");
				
				$arr_pm = "";
				$namaLengkappm = isset($output['namaLengkappm']) ? $output['namaLengkappm'] : "";
				
				$arr_pm = [];
				
				
				
				$arr_mt = [];
				if(isset($output['manfaatTambahan0'])){
					if($output['manfaatTambahan0']=='1'){
						$arr_mt[] = array(
							"kode" => "Santunan Kematian", 
							"nama" => "Santunan Kematian"
						);
					}
				}
				if(isset($output['manfaatTambahan1'])){
					if($output['manfaatTambahan1']=='1'){
						$arr_mt[] = array(
							"kode" => "Santunan Harian Rawat Inap", 
							"nama" => "Santunan Harian Rawat Inap"
						);
					}
				}
				
				
				
				if(isset($output['manfaatTambahan0'])=='1'){
					for($no=0; $no<count($namaLengkappm); $no++){
						if($output['namaLengkappm'][$no]<>''){ 
							$jenisKelaminpm = $this->cekJenisKelamin(isset($output['jenisKelaminpm'][$no]) ? $output['jenisKelaminpm'][$no] : "Laki-laki");
							
							$arr_pm[] = array(
								"namaLengkap"=>$output['namaLengkappm'][$no], 
								"nomorIndukKependudukan"=>$output['nomorIndukKependudukanpm'][$no],
								"tanggalLahir" => $output['tanggalLahirpm'][$no],
								"jenisKelamin" => $jenisKelaminpm,
								"hubungan" => $output['hubunganpm'][$no],
								"persentase" => $output['persentasepm'][$no]
							);
						}					
					}
				}
				
				
				
				/*Hepatitis B, Hepatitis C, Hepatitis D, Hepatitis E?*/
				$list_hepatitis = "";
				$arr_hepatitis['MH0010'] = [];
				for($tuj=0; $tuj< count($output['MH0010']); $tuj++){
					$tpa = QuestionsOption::find()->where(['question_id' => '125', 'point_value' => isset($output['MH0010'][$tuj]) ? $output['MH0010'][$tuj] : "" ])->one();
					$list_hepatitis .= $tpa->option_text . ", ";
					$arr_hepatitis['MH0010'] = array(
							"point" => $tpa->point_value
						);
				}
				$list_hepatitis = rtrim($list_hepatitis,", ");
				
				
				
				/*Kelenjar Gondok/Thyroid, Sinus*/
				$list_gondok = "";
				$arr_gondok = [];
				for($tuj=0; $tuj< count($output['MH0012']); $tuj++){
					$tpa = QuestionsOption::find()->where(['question_id' => '127', 'point_value' => isset($output['MH0012'][$tuj]) ? $output['MH0012'][$tuj] : "" ])->one();
					$list_gondok .= $tpa->option_text . ", ";
					$arr_gondok[] = array(
							"kode" => "MH0012", 
							"point" => $tpa->point_value
						);
				}
				$list_gondok = rtrim($list_gondok,", ");
				
				/*Nyeri Sendi, Nyeri Otot, Nyeri Punggung, Nyeri Pinggang*/
				$list_sendi = "";
				$arr_sendi = [];
				for($tuj=0; $tuj< count($output['MH0014']); $tuj++){
					$tpa = QuestionsOption::find()->where(['question_id' => '129', 'point_value' => isset($output['MH0014'][$tuj]) ? $output['MH0014'][$tuj] : "" ])->one();
					$list_sendi .= $tpa->option_text . ", ";
					$arr_sendi[] = array(
							"kode" => "MH0014", 
							"point" => $tpa->point_value
						);
				}
				$list_sendi = rtrim($list_sendi,", ");
				
				/*Kehilangan fungsi pada anggota tubuh?*/
				$list_tubuh = "";
				$arr_tubuh = [];
				for($tuj=0; $tuj< count($output['MH0020']); $tuj++){
					$tpa = QuestionsOption::find()->where(['question_id' => '135', 'point_value' => isset($output['MH0020'][$tuj]) ? $output['MH0020'][$tuj] : "" ])->one();
					$list_tubuh .= $tpa->option_text . ", ";
					$arr_tubuh[] = array(
							"kode" => "MH0020", 
							"point" => $tpa->point_value
						);
				}
				$list_tubuh = rtrim($list_tubuh,", ");
				
				

				if(isset($output['pemegangPolis']) ? $output['pemegangPolis'] : "" =='1') $pemegangPolis = true; else $pemegangPolis = false;
				$G00001 = $statusKepemilikan->option_text;
				
				if($G00001=="Ya") {
					$statusKepemilikannya = true; 
					$G00001nya = "1";
				}else{
					$statusKepemilikannya = false;
					$G00001nya = "0";
				}
				// var_dump($G00001nya);die;
				// var_dump($G00001);die;
				if(isset($output['pencetakanPolis']) ? $output['pencetakanPolis'] : "" =='1'){
					$pencetakanPolis = true;
				}else{
					$pencetakanPolis = false;
				}
				
				if(isset($output['ikhtisarPengirimanPolis'])){
					if($output['ikhtisarPengirimanPolis']=='0'){
						$ikhtisarPengirimanPolis = "Dititipkan kepada Penanggung";
					}else{
						$ikhtisarPengirimanPolis = "Dikirim ke alamat pemegang polis";
					}
				}else{
					$ikhtisarPengirimanPolis = "Dikirim ke alamat Pemegang Polis";
				}
				
				if(isset($output['alasan']) ? $output['alasan'] : "" ) $alasan = addslashes($output['alasan']); else $alasan = "-";
				
				
				$original_string = '1234567890abcdefghijklmnopqrstuvwxyz';
				$original_num = '1234567890';
				$random_string = $this->get_random_string($original_string, 5);
				$nomorPolis = strtoupper($this->get_random_string($original_string, 4));
				$generate_otp = $this->get_random_string($original_num, 6);
				
				$nomorSPAJ = "SPAJ-" . strtoupper(date("ym")) . "-" . strtoupper($random_string);
				
				// var_dump($output['tanggalLahir']);die;
				
				/*SIMPAN DATA*/
				
				$apakah_sehat = [
					"idPernyataan" => "L00006",
								"opsi" => true,
								"textValue" => [
									isset($output['L00006']) ? $output['L00006'] : "0"
								]
				];
				
				$questionnaire = 
				[
								[
								"idPernyataan" => "L00001",
								"opsi" => true,
								"textValue" => [
									isset($output['L00001']) ? $output['L00001'] : "150 cm"
								]
								],
								[
								"idPernyataan" => "L00002",
								"opsi" => false,
								"textValue" => [
									isset($output['L00002']) ? $output['L00002'] : "0 kg"
								]
								],
								[
								"idPernyataan" => "L00003",
								"opsi" => false,
								"textValue" => [
										$merokok->option_text
									]
								],
								[
								"idPernyataan" => "L00004",
								"opsi" => false,
								"textValue" => [
											$alkohol->option_text
										]
								],
								[
								"idPernyataan" => "L00005",
								"opsi" => true,
								"textValue" => [
											$obat->option_text
										]
								],
								[
								"idPernyataan" => "G00001",
								"opsi" => false,
								"textValue" => [
											$G00001
											// $perlindungan->option_text
										]
								],
								[
								"idPernyataan" => "G00002",
								"opsi" => false,
								"textValue" => [
											$rawatjalan->option_text
										]
								],
								[
								"idPernyataan" => "G00003",
								"opsi" => false,
								"textValue" => [
											$rawatinap->option_text
										]
								],
								[
								"idPernyataan" => "G00004",
								"opsi" => true,
								"textValue" => [
											$tesmedis->option_text
										]
								],
								[
								"idPernyataan" => "KW00001",
								"opsi" => false,
								"textValue" => [
											$hamil->option_text
										]
								],
								[
								"idPernyataan" => "KA00001",
								"opsi" => false,
								"textValue" => [
											$this->yatidak(isset($output['KA00001']) ? $output['KA00001'] : "1")
									]
								],
								[
								"idPernyataan" => "KA00002",
								"opsi" => false,
								"textValue" => [
											$this->yatidak(isset($output['KA00002']) ? $output['KA00002'] : "1")
										]
								],
								[
								"idPernyataan" => "KA00003",
								"opsi" => false,
								"textValue" => [
											$this->yatidak(isset($output['KA00003']) ? $output['KA00003'] : "1")
										]
								],
								[
								"idPernyataan" => "KA00004",
								"opsi" => false,
								"textValue" => [
											$this->yatidak(isset($output['KA00004']) ? $output['KA00004'] : "1")
										]
								],
								[
								"idPernyataan" => "KA00005",
								"opsi" => false,
								"textValue" => [
											$this->yatidak(isset($output['KA00005']) ? $output['KA00005'] : "1")
										]
								],
								[
								"idPernyataan" => "KA00006",
								"opsi" => false,
								"textValue" => [
											$this->yatidak(isset($output['KA00006']) ? $output['KA00006'] : "1")
										]
								],
								[
								"idPernyataan" => "MH0001",
								"opsi" => false,
								"textValue" => [
											$this->yatidak(isset($output['MH0001']) ? $output['MH0001'] : "0")
										]
								],
								[
								"idPernyataan" => "MH0002",
								"opsi" => false,
								"textValue" => [
										$this->yatidak(isset($output['MH0002']) ? $output['MH0002'] : "0")
								]
								],
								[
								"idPernyataan" => "MH0003",
								"opsi" => false,
								"textValue" => [
											$this->yatidak(isset($output['MH0003']) ? $output['MH0003'] : "0")
										]
								],
								[
								"idPernyataan" => "MH0004",
								"opsi" => false,
								"textValue" => [
											$this->yatidak(isset($output['MH0004']) ? $output['MH0004'] : "0")
										]
								],
								[
								"idPernyataan" => "MH0005",
								"opsi" => false,
								"textValue" => [
											$tbc->option_text
										]
								],
								[
								"idPernyataan" => "MH0006",
								"opsi" => false,
								"textValue" => [
											$this->yatidak(isset($output['MH0006']) ? $output['MH0006'] : "0")
										]
								],
								[
								"idPernyataan" => "MH0007",
								"opsi" => false,
								"textValue" => [
											$this->yatidak(isset($output['MH0007']) ? $output['MH0007'] : "0")
										]
								],
								[
								"idPernyataan" => "MH0008",
								"opsi" => false,
								"textValue" => [
											$this->yatidak(isset($output['MH0008']) ? $output['MH0008'] : "0")
								]
								],
								[
								"idPernyataan" => "MH0009",
								"opsi" => false,
								"textValue" => [
											$amandel->option_text
										]
								],
								[
								"idPernyataan" => "MH0010",
								"opsi" => false,
								"textValue" => [
											// $hepatitis->option_text
											$list_hepatitis
									]
								],
								[
								"idPernyataan" => "MH0011",
								"opsi" => false,
								"textValue" => [
										$prostat->option_text
									]
								],
								[
								"idPernyataan" => "MH0012",
								"opsi" => false,
								"textValue" => [
										// $tiroid->option_text
										$list_gondok
									]
								],
								[
								"idPernyataan" => "MH0013",
								"opsi" => false,
								"textValue" => [
										$ayan->option_text
									]
								],
								[
								"idPernyataan" => "MH0014",
								"opsi" => false,
								"textValue" => [
										// $otot->option_text
										$list_sendi
									]
								],
								[
								"idPernyataan" => "MH0015",
								"opsi" => false,
								"textValue" => [
										$this->yatidak(isset($output['MH0007']) ? $output['MH0007'] : "0")
									]
								],
								[
								"idPernyataan" => "MH0016",
								"opsi" => false,
								"textValue" => [
										$this->yatidak(isset($output['MH0016']) ? $output['MH0016'] : "0")
									]
								],
								[
								"idPernyataan" => "MH0017",
								"opsi" => false,
								"textValue" => [
										$this->yatidak(isset($output['MH0017']) ? $output['MH0017'] : "0") . ", " . 
										$this->yatidak(isset($output['MH0021']) ? $output['MH0021'] : "0") . ", " . 
										$this->yatidak(isset($output['MH0022']) ? $output['MH0022'] : "0") . ", " .
										$this->yatidak(isset($output['MH0023']) ? $output['MH0023'] : "0")
									]
								],
								[
								"idPernyataan" => "MH0018",
								"opsi" => false,
								"textValue" => [
										$this->yatidak(isset($output['MH0018']) ? $output['MH0018'] : "0")
									]
								],
								[
								"idPernyataan" => "MH0019",
								"opsi" => false,
								"textValue" => [
										$this->yatidak(isset($output['MH0019']) ? $output['MH0019'] : "0")
									]
								],
								[
								"idPernyataan" => "MH0020",
								"opsi" => false,
								"textValue" => [
										$list_tubuh
									]
								],
								
								
				];
				
				
				/*PERHITUNGAN RUMUS*/

				// var_dump($questionnaire);die;
				// 'nomorPolis' => 'PLS-' . $nomorPolis,

				$kesehatanTertanggung = $this->rumusKesehatan(\yii\helpers\Json::encode($apakah_sehat), \yii\helpers\Json::encode($questionnaire), $output['L00001'], $output['L00002'], $output['MH0017'], $output['MH0021'], $output['MH0022'], $output['MH0023'],$output['MH0010'],$output['MH0012'],$output['MH0014'],$output['MH0020']);
				$resKesehatanTertanggung = \yii\helpers\Json::decode($kesehatanTertanggung);
				
				if($resKesehatanTertanggung['resp_code']<>'00'){
					// var_dump($output['L00002']);die;
					
					/*SIMPAN DATA TERTOLAK*/
					$sql_resp = "INSERT INTO kesehatan_resp(resp) VALUES('".\yii\helpers\Json::encode($resKesehatanTertanggung)."')";
					Yii::$app->db->createCommand($sql_resp)->execute();
					
					$kirimdata_rejected=[
					'applicationList' => [
							[
								'nomorSPAJ' => $nomorSPAJ,
								'statusPengajuan' => 'REJECTED',
								'pemegangPolis' => [
									"namaLengkap" => isset($output['fullname']) ? $output['fullname'] : "",
									"jenisKartuIdentitas" => "eKTP",
									"nomorKartuIdentitas" => isset($output['nomorKartuIdentitas']) ? $output['nomorKartuIdentitas'] : "",
									"tempatLahir" => isset($output['tempatLahir']) ? $output['tempatLahir'] : "",
									"tanggalLahir" => isset($output['tanggalLahir']) ? $output['tanggalLahir'] : "",
									"jenisKelamin" => $jenisKelamin->option_text,
									"statusPerkawinan" => $statusPerkawinan->option_text,
									"alamatSesuaiIdentitas" => [
											"alamat" => isset($output['alamatSesuaiIdentitas']) ? $output['alamatSesuaiIdentitas'] : "",
											"RT" => isset($output['RT']) ? $output['RT'] : "",
											"RW" => isset($output['RW']) ? $output['RW'] : "",
											"kelurahan" => isset($output['kelurahan']) ? $output['kelurahan'] : "",
											"kecamatan" => isset($output['kecamatan']) ? $output['kecamatan'] : "",
											"kota" => isset($output['kota']) ? $output['kota'] : "",
											"provinsi" => isset($output['provinsi']) ? $output['provinsi'] : "",
											"kodePos" => isset($output['kodepos']) ? $output['kodepos'] : "",
										],
										
									],
									"agenPenutup" => [
										"noAgen" => isset($output['noAgen']) && $output['noAgen'] != ""  ? $output['noAgen'] : "000",
										"noLisensiAgen" => isset($output['noLisensiAgen'])  && $output['noLisensiAgen'] != "" ? $output['noLisensiAgen'] : "AGEN-A-001",
										"namaAgen" => isset($output['namaAgen']) && $output['namaAgen'] != "" ? $output['namaAgen'] : "NOTSETNAME",
										"emailAgen" => isset($output['emailAgen'])  && $output['emailAgen'] != "" ? $output['emailAgen'] : "dianput31@gmail.com",
										"teleponAgen" => isset($output['teleponAgen']) && $output['teleponAgen'] != "" ? $output['teleponAgen'] : "081000000"
									// "teleponAgen" => "089668473831"
									]
								]
							]
						];
					
					$sql_simpan = "INSERT INTO form_permintaan(ref_agent,no_spaj,data_spaj,status,otp_code, api_response, rumus_response, jumlah_bayar_premi, plan, kelas, no_polis, paid_status, doku, premi_tambahan, upload_ktp, upload_kk, upload_ktp_tertanggung, upload_kk_tertanggung) 
					VALUES('".$output['noAgen']."','".$nomorSPAJ."','".\yii\helpers\Json::encode($kirimdata_rejected)."','".$resKesehatanTertanggung['resp_code']."','-','".\yii\helpers\Json::encode($resKesehatanTertanggung)."','".\yii\helpers\Json::encode($resKesehatanTertanggung)."','0', '".substr($output['kelas'],0,1)."', '".substr($output['kelas'],1,1)."', no_polis, paid_status,'','','".$output['uploadKtp']."','".$output['uploadKK']."','".$output['uploadKtpTertanggung']."','".$output['uploadKKTertanggung']."')";
					Yii::$app->db->createCommand($sql_simpan)->execute();
					
					$res_notif = $this->push_notif_email_rejected($nomorSPAJ);
					
					if($res_notif=="00"){
						$retval = array("respcode" => $resKesehatanTertanggung['resp_code'], "msg" => "error", "row" => "mbel", "resp_msg" => $resKesehatanTertanggung['resp_msg'], "otp" => "", "resp_cpp" => $resKesehatanTertanggung['resp_cpp']);
					}
				}else{
					
				$statusPengajuan = $resKesehatanTertanggung['resp_cpp'];
				
				/*STATUS KESEHATAN*/
				$resp_status = $resKesehatanTertanggung['resp_status'];
				
				$poin_terkumpul = $resKesehatanTertanggung['total_poin'];
				
				/*LANJUTKAN*/
				
				/**JIKA TERTANGGUNG ADALAH DIRI SENDIRI*/
				if($output['hubungan']=='0') {
					$namaLengkapTertanggung = $output['fullname'];
					$nomorKartuIdentitasTertanggung = $output['nomorKartuIdentitas'];
					$tempatLahirTertanggung = $output['tempatLahir'];
					$tanggalLahirTertanggung  = $output['tanggalLahir'];
					$jenisKelaminTertanggungText = $jenisKelamin->option_text;
					$statusPerkawinanTertanggungText = $statusPerkawinan->option_text;
					$alamatSesuaiIdentitasTertanggung = $output['alamatSesuaiIdentitas'];
					$RTtertanggung = $output['RT'];
					$RWTertanggung = $output['RW'];
					$KelurahanTertanggung = $output['kelurahan'];
					$KecamatanTertanggung = $output['kecamatan'];
					$KotaTertanggung = $output['kota'];
					$ProvinsiTertanggung = $output['provinsi'];
					$KodePosTertanggung = $output['kodepos'];
					
					$alamatDomisiliTertanggung = $output['alamatDomisili'];
					$RTDomisiliTertanggung = $output['RTDomisili'];
					$RWDomisiliTertanggung = $output['RWDomisili'];
					$kelurahanDomisiliTertanggung = $output['kelurahanDomisili'];
					$kecamatanDomisiliTertanggung = $output['kecamatanDomisili'];
					$kotaDomisiliTertanggung = $output['kotaDomisili'];
					$provinsiDomisiliTertanggung = $output['provinsiDomisili'];
					$kodeposDomisiliTertanggung = $output['kodeposDomisili'];
					
					$handphoneDomisiliTertanggung = $output['handphone'];
					$teleponDomisiliTertanggung = $output['telepon'];
					$emailDomisiliTertanggung = $output['email'];
					
					
					
					$pekerjaantertanggung = $pekerjaan->option_text;
					$bidangUsahaTertanggung = isset($output['bidangUsaha']) ? $output['bidangUsaha'] : "" ;
					$jabatanTertanggung = isset($output['jabatan']) ? $output['jabatan'] : "" ;
					$namaInstitusiTempatKerjaTertanggung = isset($output['namaInstitusiTempatKerja']) ? $output['namaInstitusiTempatKerja'] : "" ;
					$alamatinstitusiTertanggung = isset($output['alamatinstitusi']) ? $output['alamatinstitusi'] : "" ;
					$RTInstitusiTertanggung = isset($output['RTInstitusi']) ? $output['RTInstitusi'] : "";
					$RWInstitusiTertanggung = isset($output['RWInstitusi']) ? $output['RWInstitusi'] : "";
					$kelurahanInstitusiTertanggung = isset($output['kelurahanInstitusi']) ? $output['kelurahanInstitusi'] : "";
					$kecamatanInstitusiTertanggung = isset($output['kecamatanInstitusi']) ? $output['kecamatanInstitusi'] : "" ;
					$kotaInstitusiTertanggung = isset($output['kotaInstitusi']) ? $output['kotaInstitusi'] : "" ;
					$provinsiInstitusiTertanggung = isset($output['provinsiInstitusi']) ? $output['provinsiInstitusi'] : "" ;
					$kodePosInstitusiTertanggung = isset($output['kodePosInstitusi']) ? $output['kodePosInstitusi'] : ""; 
					$teleponInstitusiTertanggung = isset($output['teleponInstitusi']) ? $output['teleponInstitusi'] : "";
					
				}else{
					
					$namaLengkapTertanggung = isset($output['namaLengkapTertanggung']) ? $output['namaLengkapTertanggung'] : "";
					$nomorKartuIdentitasTertanggung = isset($output['nomorKartuIdentitasTertanggung']) ? $output['nomorKartuIdentitasTertanggung'] : "";
					$tempatLahirTertanggung = isset($output['tempatLahirTertanggung']) ? $output['tempatLahirTertanggung'] : "";
					$tanggalLahirTertanggung  = isset($output['tanggalLahirTertanggung']) ? $output['tanggalLahirTertanggung'] : "";
					$jenisKelaminTertanggungText = $jenisKelaminTertanggung->option_text;
					$statusPerkawinanTertanggungText = $statusPerkawinanTertanggung->option_text;
					$alamatSesuaiIdentitasTertanggung = isset($output['alamatSesuaiIdentitasTertanggung']) ? $output['alamatSesuaiIdentitasTertanggung'] : "";
					$RTtertanggung = isset($output['RTtertanggung']) ? $output['RTtertanggung'] : "";
					$RWTertanggung = isset($output['RWTertanggung']) ? $output['RWTertanggung'] : "";
					$KelurahanTertanggung = isset($output['KelurahanTertanggung']) ? $output['KelurahanTertanggung'] : "";
					$KecamatanTertanggung = isset($output['KecamatanTertanggung']) ? $output['KecamatanTertanggung'] : "";
					$KotaTertanggung = isset($output['KotaTertanggung']) ? $output['KotaTertanggung'] : "";
					$ProvinsiTertanggung = isset($output['ProvinsiTertanggung']) ? $output['ProvinsiTertanggung'] : "";
					$KodePosTertanggung = isset($output['KodePosTertanggung']) ? $output['KodePosTertanggung'] : "";
					
					$alamatDomisiliTertanggung = isset($output['alamatDomisiliTertanggung']) ? $output['alamatDomisiliTertanggung'] : $alamatSesuaiIdentitasTertanggung;
					$RTDomisiliTertanggung = isset($output['RTDomisiliTertanggung']) ? $output['RTDomisiliTertanggung'] : $RTtertanggung;
					$RWDomisiliTertanggung = isset($output['RWDomisiliTertanggung']) ? $output['RWDomisiliTertanggung'] : $RWTertanggung;
					$kelurahanDomisiliTertanggung = isset($output['kelurahanDomisiliTertanggung']) ? $output['kelurahanDomisiliTertanggung'] : "";
					$kecamatanDomisiliTertanggung = isset($output['kecamatanDomisiliTertanggung']) ? $output['kecamatanDomisiliTertanggung'] : $KecamatanTertanggung;
					$kotaDomisiliTertanggung = isset($output['kotaDomisiliTertanggung']) ? $output['kotaDomisiliTertanggung'] : $KotaTertanggung;
					$provinsiDomisiliTertanggung = isset($output['provinsiDomisiliTertanggung']) ? $output['provinsiDomisiliTertanggung'] : $ProvinsiTertanggung;
					$kodeposDomisiliTertanggung = isset($output['kodeposDomisiliTertanggung']) ? $output['kodeposDomisiliTertanggung'] : $KodePosTertanggung;
					
					$handphoneDomisiliTertanggung = isset($output['handphoneDomisiliTertanggung']) ? $output['handphoneDomisiliTertanggung'] : "" ;
					$teleponDomisiliTertanggung = isset($output['teleponDomisiliTertanggung']) ? $output['teleponDomisiliTertanggung'] : "" ;
					$emailDomisiliTertanggung = isset($output['emailDomisiliTertanggung']) ? $output['emailDomisiliTertanggung'] : "" ;
					
					
					$pekerjaantertanggung = $pekerjaanTertanggung->option_text;
					$bidangUsahaTertanggung = isset($output['bidangUsahaTertanggung']) ? $output['bidangUsahaTertanggung'] : "-" ;
					$jabatanTertanggung = isset($output['jabatanTertanggung']) ? $output['jabatanTertanggung'] : "-" ;
					$namaInstitusiTempatKerjaTertanggung = isset($output['namaInstitusiTempatKerjaTertanggung']) ? $output['namaInstitusiTempatKerjaTertanggung'] : "-" ;
					$alamatinstitusiTertanggung = isset($output['alamatinstitusiTertanggung']) ? $output['alamatinstitusiTertanggung'] : "-" ;
					$RTInstitusiTertanggung = isset($output['RTInstitusiTertanggung']) ? $output['RTInstitusiTertanggung'] : "-";
					$RWInstitusiTertanggung = isset($output['RWInstitusiTertanggung']) ? $output['RWInstitusiTertanggung'] : "-";
					$kelurahanInstitusiTertanggung = isset($output['kelurahanInstitusiTertanggung']) ? $output['kelurahanInstitusiTertanggung'] : "";
					$kecamatanInstitusiTertanggung = isset($output['kecamatanInstitusiTertanggung']) ? $output['kecamatanInstitusiTertanggung'] : "" ;
					$kotaInstitusiTertanggung = isset($output['kotaInstitusiTertanggung']) ? $output['kotaInstitusiTertanggung'] : "" ;
					$provinsiInstitusiTertanggung = isset($output['provinsiInstitusiTertanggung']) ? $output['provinsiInstitusiTertanggung'] : "" ;
					$kodePosInstitusiTertanggung = isset($output['kodePosInstitusiTertanggung']) ? $output['kodePosInstitusiTertanggung'] : ""; 
					$teleponInstitusiTertanggung = isset($output['teleponInstitusiTertanggung']) ? $output['teleponInstitusiTertanggung'] : "";
									
				}
				
				/*usia*/
				$birthDate = date_create($tanggalLahirTertanggung);
				$today = date_create("today");
				$diff  = date_diff($birthDate, $today);
				$usia = $diff->y;
				
				if($usia < 5){
					throw new \Exception("Maaf, Usia yang Anda masukkan tidak memenuhi kriteria untuk produk ini...");
				}
				
				$dataTarif = $this->cekTarif(substr($output['kelas'],0,1),substr($output['kelas'],1,1),$jenisKelaminTertanggungText,$usia,$periodeBayarPremi->option_text,$poin_terkumpul,isset($output['manfaatTambahan0']) ? $output['manfaatTambahan0'] : "" =='0',isset($output['manfaatTambahan1']) ? $output['manfaatTambahan1'] : "" =='0');
				$resDataTarif = \yii\helpers\Json::decode($dataTarif);
				if($pencetakanPolis===true)	$biayaCetakPolis = 150000; else $biayaCetakPolis = 0;
				$jumlahBayarPremi = $resDataTarif['total_tarif'] + $biayaCetakPolis;
				

				/*
				removed 17/02/2021
					// "periodeBayarPremi" => $periodeBayarPremi->option_text,
					// "tanggalBayarPremi" => date("Y-m-d H:i:s"),
					// "jumlahBayarPremi" => $jumlahBayarPremi
					// 'nomorPolis' => 'PLS-' . $nomorPolis,
				*/
				/*DATA SPAJ*/
				$kirimdata=[
					'applicationList' => [
							[
							'nomorSPAJ' => $nomorSPAJ,
							'statusPengajuan' => $statusPengajuan,
							'pemegangPolis' => [
								"namaLengkap" => isset($output['fullname']) ? $output['fullname'] : "",
								"jenisKartuIdentitas" => "eKTP",
								"nomorKartuIdentitas" => isset($output['nomorKartuIdentitas']) ? $output['nomorKartuIdentitas'] : "",
								"tempatLahir" => isset($output['tempatLahir']) ? $output['tempatLahir'] : "",
								"tanggalLahir" => isset($output['tanggalLahir']) ? $output['tanggalLahir'] : "",
								"jenisKelamin" => $jenisKelamin->option_text,
								"statusPerkawinan" => $statusPerkawinan->option_text,
								"alamatSesuaiIdentitas" => [
									"alamat" => isset($output['alamatSesuaiIdentitas']) ? $output['alamatSesuaiIdentitas'] : "",
									"RT" => isset($output['RT']) ? $output['RT'] : "",
									"RW" => isset($output['RW']) ? $output['RW'] : "",
									"kelurahan" => isset($output['kelurahan']) ? $output['kelurahan'] : "",
									"kecamatan" => isset($output['kecamatan']) ? $output['kecamatan'] : "",
									"kota" => isset($output['kota']) ? $output['kota'] : "",
									"provinsi" => isset($output['provinsi']) ? $output['provinsi'] : "",
									"kodePos" => isset($output['kodepos']) ? $output['kodepos'] : "",
								],
								"alamatDomisili" => [
											"alamat" => trim($output['alamatDomisili'])<>'' ? $output['alamatDomisili'] : $output['alamatSesuaiIdentitas'] ,
											"RT" => trim($output['RTDomisili'])<>'' ? $output['RTDomisili'] : $output['RT'] ,
											"RW" => trim($output['RWDomisili'])<>'' ? $output['RWDomisili'] : $output['RW'] ,
											"kelurahan" => trim($output['kelurahanDomisili'])<>'' ? $output['kelurahanDomisili'] : $output['kelurahan'] ,
											"kecamatan" => trim($output['kecamatanDomisili'])<>'' ? $output['kecamatanDomisili'] : $output['kecamatan'] ,
											"kota" => trim($output['kotaDomisili'])<>'' ? $output['kotaDomisili'] : $output['kota'] ,
											"provinsi" => trim($output['provinsiDomisili'])<>'' ? $output['provinsiDomisili'] : $output['provinsi'] ,
											"kodePos" => trim($output['kodeposDomisili'])<>'' ? $output['kodeposDomisili'] : $output['kodepos']
										],
								"handphone" => isset($output['handphone']) ? $output['handphone'] : "" ,
								"telepon" => isset($output['telepon']) ? $output['telepon'] : "" ,
								"email" => isset($output['email']) ? $output['email'] : "" ,
								"pekerjaan" => [
											"pekerjaan" => $pekerjaan->option_text,
											"bidangUsaha" => isset($output['bidangUsaha']) ? $output['bidangUsaha'] : "" ,
											"jabatan" => isset($output['jabatan']) ? $output['jabatan'] : "" ,
											"namaInstitusiTempatKerja" => isset($output['namaInstitusiTempatKerja']) ? $output['namaInstitusiTempatKerja'] : "" ,
											"alamat" => [
													"alamat" => isset($output['alamatinstitusi']) ? $output['alamatinstitusi'] : "" ,
													"RT" => isset($output['RTInstitusi']) ? $output['RTInstitusi'] : "" ,
													"RW" => isset($output['RWInstitusi']) ? $output['RWInstitusi'] : "" ,
													"kelurahan" => isset($output['kelurahanInstitusi']) ? $output['kelurahanInstitusi'] : "" ,
													"kecamatan" => isset($output['kecamatanInstitusi']) ? $output['kecamatanInstitusi'] : "" ,
													"kota" => isset($output['kotaInstitusi']) ? $output['kotaInstitusi'] : "" ,
													"provinsi" => isset($output['provinsiInstitusi']) ? $output['provinsiInstitusi'] : "" ,
													"kodePos" => isset($output['kodePosInstitusi']) ? $output['kodePosInstitusi'] : ""
												],
											"telepon" => isset($output['teleponInstitusi']) ? $output['teleponInstitusi'] : "" 
										],
								"alamatSuratMenyurat" => $alamatSuratMenyurat->option_text,
								"hubungan" => $hubungan->option_text,
							],
							"tertanggung" => [
											"namaLengkap" => $namaLengkapTertanggung ,
											"jenisKartuIdentitas" => "eKTP",
											"nomorKartuIdentitas" => $nomorKartuIdentitasTertanggung ,
											"tempatLahir" => $tempatLahirTertanggung ,
											"tanggalLahir" => $tanggalLahirTertanggung,
											"jenisKelamin" => $jenisKelaminTertanggungText,
											"statusPerkawinan" => $statusPerkawinanTertanggungText,
											"alamatSesuaiIdentitas" => [
												"alamat" => $alamatSesuaiIdentitasTertanggung ,
												"RT" => $RTtertanggung ,
												"RW" => $RWTertanggung ,
												"kelurahan" => $KelurahanTertanggung,
												"kecamatan" => $KecamatanTertanggung ,
												"kota" => $KotaTertanggung ,
												"provinsi" => $ProvinsiTertanggung ,
												"kodePos" => $KodePosTertanggung
											],
											"alamatDomisili" => [
												"alamat" => $alamatDomisiliTertanggung ,
												"RT" => $RTDomisiliTertanggung,
												"RW" => $RWDomisiliTertanggung ,
												"kelurahan" => $kelurahanDomisiliTertanggung ,
												"kecamatan" => $kecamatanDomisiliTertanggung ,
												"kota" => $kotaDomisiliTertanggung ,
												"provinsi" => $provinsiDomisiliTertanggung ,
												"kodePos" => $kodeposDomisiliTertanggung
											],
										"handphone" => $handphoneDomisiliTertanggung ,
										"telepon" => $teleponDomisiliTertanggung,
										"email" => $emailDomisiliTertanggung ,
										"pekerjaan" => [
											"pekerjaan" => $pekerjaantertanggung ,
											"bidangUsaha" => $bidangUsahaTertanggung ,
											"jabatan" => $jabatanTertanggung ,
											"namaInstitusiTempatKerja" => $namaInstitusiTempatKerjaTertanggung ,
											"alamat" => [
												"alamat" => $alamatinstitusiTertanggung ,
												"RT" => $RTInstitusiTertanggung ,
												"RW" => $RWInstitusiTertanggung ,
												"kelurahan" => $kelurahanInstitusiTertanggung ,
												"kecamatan" => $kecamatanInstitusiTertanggung ,
												"kota" => $kotaInstitusiTertanggung ,
												"provinsi" => $provinsiInstitusiTertanggung ,
												"kodePos" => $kodePosInstitusiTertanggung 
												],
											"telepon" => $teleponInstitusiTertanggung
											]
								],
								"pembayaranPremi" => [
											"pemegangPolis" => $pemegangPolis,
											"sumberDana" => [
												"tujuanPengajuanAsuransi" => [
													$tujuanPengajuanAsuransi
													],
												"sumberPenghasilanPerbulan" => [
													$sumberPenghasilanPerbulan
													],
												"jumlahPenghasilanKotorPertahun" => $jumlahPenghasilanKotorPertahun->option_text,
												"metodePembayaranPremi" => $MetodePembayaranPremi->option_text,
												"caraBayarPremi" => $periodeBayarPremi->option_text,
												"premi" => "$jumlahBayarPremi"
											]
									],
										
								"penerimaManfaat" => 
											$arr_pm
								,
								"dataAsuransi" => [
										"produk" => "Managed Care Individu",
										"manfaatUtama" => [
											[
												"kode" => null,
												"nama" => null
											]
										],
										"plan" => isset($output['kelas']) ? substr($output['kelas'],0,1) : "P",
										"kelas" => isset($output['kelas']) ? substr($output['kelas'],1,1) : "0",
										"manfaatTambahan" => $arr_mt
										,
										"provider" => "0902R012",
										"masaAsuransi" => "1 Tahun",
										"mataUang" => "Rupiah (Rp)"
								],
								"kepemilikanAsuransi" => [
											"statusKepemilikan" => $statusKepemilikannya,
											"alasan" => $alasan
								],
								
								"kesehatanTertanggung" => $questionnaire,
								"pencetakanPolis" =>  $pencetakanPolis,
								"alamatPengirimanPolis" => $alamatPengirimanPolis->option_text,
								"ikhtisarCetakanPolis" => $ikhtisarPengirimanPolis,
								"agenPenutup" => [
									"noAgen" => isset($output['noAgen']) && $output['noAgen'] != ""  ? $output['noAgen'] : "000",
									"noLisensiAgen" => isset($output['noLisensiAgen'])  && $output['noLisensiAgen'] != "" ? $output['noLisensiAgen'] : "AGEN-A-001",
									"namaAgen" => isset($output['namaAgen']) && $output['namaAgen'] != "" ? $output['namaAgen'] : "NOTSETNAME",
									"emailAgen" => isset($output['emailAgen'])  && $output['emailAgen'] != "" ? $output['emailAgen'] : "dianput31@gmail.com",
									"teleponAgen" => isset($output['teleponAgen']) && $output['teleponAgen'] != "" ? $output['teleponAgen'] : "081000000"
									// "teleponAgen" => "089668473831"
									]	
								]
							]
						];

						//echo \yii\helpers\Json::encode($kirimdata); die;
						// $sql_simpan = "INSERT INTO kesehatan_resp(resp)  VALUES('".\yii\helpers\Json::encode($kirimdata)."')";
						// Yii::$app->db->createCommand($sql_simpan)->execute();
						
						
						$curl = curl_init();

						curl_setopt_array($curl, array(
						  CURLOPT_URL => 'http://10.10.20.186/mi/individual_insurance',
						  CURLOPT_RETURNTRANSFER => true,
						  //CURLOPT_ENCODING => '',
						  //CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  //CURLOPT_FOLLOWLOCATION => true,
						  //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'POST',
						  CURLOPT_SSL_VERIFYPEER => false,
						  CURLOPT_POSTFIELDS =>\yii\helpers\Json::encode($kirimdata),
						  CURLOPT_HTTPHEADER => array(
							'Content-Type: application/json'
						  ),
						));

						$response = curl_exec($curl);

						curl_close($curl);
						$res = \yii\helpers\Json::decode($response);
						
						//echo \yii\helpers\Json::encode($kirimdata);
						//echo "<br/>--------";
						
						//echo $res;
						//exit;
						
						/* SIMPAN KE DALAM DATABASE */
						$sql_simpan = "INSERT INTO form_permintaan(ref_agent,no_spaj,data_spaj,status,otp_code, api_response, rumus_response, jumlah_bayar_premi, plan, kelas, no_polis, paid_status, doku, premi_tambahan, upload_ktp, upload_kk, upload_ktp_tertanggung, upload_kk_tertanggung) VALUES('".$output['noAgen']."','".$nomorSPAJ."','".\yii\helpers\Json::encode($kirimdata)."','".$resp_status."','".$generate_otp."','".\yii\helpers\Json::encode($res)."','".\yii\helpers\Json::encode($resKesehatanTertanggung)."','$jumlahBayarPremi', '".substr($output['kelas'],0,1)."', '".substr($output['kelas'],1,1)."', no_polis, paid_status,'',".\yii\helpers\Json::encode($dataTarif).",'".$output['uploadKtp']."','".$output['uploadKK']."','".$output['uploadKtpTertanggung']."','".$output['uploadKKTertanggung']."')";
						Yii::$app->db->createCommand($sql_simpan)->execute();
						//var_dump($sql_simpan);die;
						//var_dump($res["resp"]['resultCode']);die;
						
						if($res["resp"]['resultCode']=='1000'){
							
							$this->espaj($nomorSPAJ);
							
							/*Kirim data KTP, KK dan eSPAJ v1*/
							$curl = curl_init();
							
							
							
							$kirimdataupload = [
								"nomorSPAJ" => $nomorSPAJ,
								"nomorPolis" => "",
								"fileKTPPemegangPolis" => $output['uploadKtp'],
								"fileKKPemegangPolis" => $output['uploadKK'],
								"fileKTPTertanggung" => $output['uploadKtpTertanggung'],
								"fileKKTertanggung" => $output['uploadKKTertanggung']
							];

							curl_setopt_array($curl, array(
							  CURLOPT_URL => 'http://10.10.20.186/mi/upload_spaj',
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => '',
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 0,
							  CURLOPT_FOLLOWLOCATION => true,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => 'POST',
							  CURLOPT_SSL_VERIFYPEER => false,
							  CURLOPT_POSTFIELDS =>\yii\helpers\Json::encode($kirimdataupload),
							  CURLOPT_HTTPHEADER => array(
								'Content-Type: application/json'
							  ),
							));
							
							$response = curl_exec($curl);
							//var_dump($response);die;
							curl_close($curl);
							
							
							$res_otp = $this->get_req_otp($output['handphone'],$generate_otp,"PLS-".$nomorPolis);
							//$res_otp = "123456";
							//$res_notif = $this->push_notif_email($nomorSPAJ);

							//var_dump($res_otp);die;
							// /*update link doku*/
							//$sql_update = "UPDATE form_permintaan SET doku = '".$res_notif."' WHERE no_spaj = '".$nomorSPAJ."' AND otp_code='".$generate_otp."' ORDER BY id DESC LIMIT 1";
							//Yii::$app->db->createCommand($sql_update)->execute();
							
							//$this->espaj($nomorSPAJ);
							
							/*SET SESION OTP*/
							$session = Yii::$app->session;
							$session['sess_otp'] = ['polishp' => $output['handphone'],'polisno' => "PLS-".$nomorPolis,'polisspaj' => $nomorSPAJ];
							
							$retval = array("respcode" => "1", "msg" => "success", "row" => "mbel", "resp_msg" => "Berhasil Menyimpan Data..", "otp" => $res_otp);
						}else{
							
							$sql_simpan = "INSERT INTO form_permintaan(ref_agent,no_spaj,data_spaj,status,otp_code, api_response, rumus_response, jumlah_bayar_premi, plan, kelas, no_polis, paid_status, doku, premi_tambahan, upload_ktp, upload_kk, upload_ktp_tertanggung, upload_kk_tertanggung) VALUES('".$output['noAgen']."','".$nomorSPAJ."','".\yii\helpers\Json::encode($kirimdata)."','".$resp_status."','-','".\yii\helpers\Json::encode($res)."','".\yii\helpers\Json::encode($resKesehatanTertanggung)."','0', '".substr($output['kelas'],0,1)."', '".substr($output['kelas'],1,1)."', no_polis, paid_status,'','','".$output['uploadKtp']."','".$output['uploadKK']."','".$output['uploadKtpTertanggung']."','".$output['uploadKKTertanggung']."')";
							Yii::$app->db->createCommand($sql_simpan)->execute();
							
							// $retval = array("respcode" => "00", "msg" => "error", "row" => "mbel", "resp_msg" => "Gagal Mendapatkan Respon dari Server IFG ", "otp" => "000000");
							$retval = array("respcode" => "00", "msg" => "error", "row" => "mbel", "resp_msg" => $res["resp"]['data']['resultList'][0]['resultMessage'], "otp" => "000000");
						}
					}
				}else{
					$retval = array("respcode" => "00", "msg" => "error", "row" => "mbel", "resp_msg" => "Tidak ada Data yang dikirim!");
			}
		
		 }catch(\Exception $e){
			//var_dump($e);exit;
			 $retval = array("respcode" => "69", "msg" => "error", "row" => "mbel", "resp_msg" => $e->getMessage());
		}
		
		
        return json_encode($retval); 
	}


	function cekJenisKelamin($jk){
		switch($jk){
			case "1":
				$jeniskelamin = "Laki-laki";
				break;
			case "0":
				$jeniskelamin = "Perempuan";
				break;
		}
		return $jeniskelamin;
	}

    public function actionSendMail()
    {
        $post = Yii::$app->request->post();
        // $post['club'] = 1;
        // $post['name'] = 'Subur Legowo';
        // $post['id'] = 6;
        // $content = $this->renderPartial('aboutyou', [
        //     'model' => AboutYou::findOne($post['id']),
        // ]);
        // $mails = ClubsManagers::find()->select(['email'])->where(['clubs_id'=>$post['club']])->all();
        // $mail = [];
        // foreach ($mails as $key => $value) {
        //     array_push($mail, trim($value->email));
        // }
        
        // Yii::$app->mailer->compose()
        //     ->setFrom('noreply@fitplanplus.co.id')
        //     ->setTo($mail)
        //     ->setSubject('DPP ABOUT YOU Questionare data - '.$post['name'].' - '.date('d M Y'))
        //     ->setHtmlBody("<p>To download PDF data, click here: <br><a href='http://cf-jakarta.myfitplan.co.id/index.php?r=site/downloads&id=".$post['id']."'>download</a> <br><br><br><strong>Thank you</strong><br><strong>Digital Product Presenter</strong></p>")
        //     //  ->attach(Yii::$app->urlManager->createUrl(['/site/report', 'id'=>$post['id']]))
        //     ->send();
        // return \yii\helpers\Json::encode(['rc'=>'00','msg'=>'Success']);
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        \Yii::$app->view->registerMetaTag([
                    'name' => 'description',
                    'content' => Yii::$app->generalFunction->getSetting('description')
                ]);
                \Yii::$app->view->registerMetaTag([
                    'name' => 'keywords',
                    'content' => Yii::$app->generalFunction->getSetting('keyword')
                ]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
	    return $this->goHome();
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionDetails($id, $title="")
    {
        $model = DoctorServices::findOne($id);
        \Yii::$app->view->registerMetaTag([
                    'name' => 'description',
                    'content' => $model->descriptions
                ]);
                \Yii::$app->view->registerMetaTag([
                    'name' => 'keywords',
                    'content' => $model->service_name
                ]);
        $related = DoctorServices::find()->orderBy('id desc')->limit(4)->all();
        return $this->render('details', compact('model', 'related'));
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
	
	function get_random_string($valid_chars, $length)
	{
		$random_string = "";
		$num_valid_chars = strlen($valid_chars);

		for ($i = 0; $i < $length; $i++)
		{
			$random_pick = mt_rand(1, $num_valid_chars);
			$random_char = $valid_chars[$random_pick-1];
			$random_string .= $random_char;
		}

		return $random_string;
	}

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    public function actionCheckAgent($id){

    	$params = [
    		// "noagen"=>$_POST["noagen"]
    		"noagen"=>$id
    	];

    	$curl = new curl\Curl();

		$response = $curl->setRawPostData(\yii\helpers\Json::encode($params))
			->setHeaders([
		        'Content-Type' => 'application/json',
		        // 'accept' => 'application/json',
		        'Content-Length' => strlen(json_encode($params))
		    ])
		    ->setOption(CURLOPT_SSL_VERIFYHOST, '0')
		    ->setOption(CURLOPT_SSL_VERIFYPEER, '0')
		    ->post('http://10.10.20.186/ifg/agen');

		$ret = \yii\helpers\Json::decode($response);

		return \yii\helpers\Json::encode($ret);
    }

    public function getAddress(){

    	$params = [
			"provinsi" => "",
			"kota" => "",
			"kecamatan" => "",
			"kelurahan" => ""
    	];

    	$curl = new curl\Curl();

		$response = $curl->setRawPostData(\yii\helpers\Json::encode($params))
			->setHeaders([
		        'Content-Type' => 'application/json',
		        'Content-Length' => strlen(json_encode($params))
		    ])
		    ->setOption(CURLOPT_SSL_VERIFYHOST, '0')
		    ->setOption(CURLOPT_SSL_VERIFYPEER, '0')
		    ->post('http://10.10.20.186/address/mapping');

		$ret = \yii\helpers\Json::decode($response);
		return \yii\helpers\Json::encode($ret);
    }
	
	
	
	public function actionVerifyOtp()
	{
		
		$session = Yii::$app->session;
		$no_spaj = $session['sess_otp']['polisspaj'];
		
		$cek = "SELECT COALESCE(COUNT(id),0)AS total FROM form_permintaan WHERE no_spaj = '".$no_spaj."' AND otp_code = '".$_POST["data"]."'";
		$data_otp = Yii::$app->db->createCommand($cek)->queryOne();
		$res_otp = $data_otp['total'];

		if($res_otp == 0){
			$retval = array("respcode" => "00", "msg" => "error", "row" => "mbel", "resp_msg" => 'OTP yang anda masukkan salah!');
		}else{
			// $upd_otp = "UPDATE form_permintaan SET status='VERIFIED' WHERE no_spaj = '".$no_spaj."' AND otp_code = '".$_POST["data"]."';";
			// Yii::$app->db->createCommand($upd_otp)->execute();
			
			$res_notif = $this->push_notif_email($no_spaj);
							
			/*update link doku*/
			$sql_update = "UPDATE form_permintaan SET status='VERIFIED' , doku = '".$res_notif."' WHERE no_spaj = '".$no_spaj."' AND otp_code='".$_POST['data']."' ORDER BY id DESC LIMIT 1";
			Yii::$app->db->createCommand($sql_update)->execute();
							
			
			/*RESET SESSION*/
			$session = Yii::$app->session;
			$session['sess_otp'] = ['polishp' => '','polisno' => '','polisspaj' => ''];
					
			/*RETURN TO VIEW*/
			$retval = array("respcode" => "1", "msg" => "success", "row" => "mbel", "resp_msg" => "Berhasil melakukan verifikasi OTP", "no_spaj" => $no_spaj);
		}
		
		return json_encode($retval); 
		
	
		
	}
	
	function get_req_otp($msisdn,$pin,$nopolis){

    	$params = [
    		"msisdn"=>$msisdn,
    		"pin"=>$pin,
    		"nopolis"=>$nopolis
    	];

    	$curl = new curl\Curl();

		$response = $curl->setRawPostData(\yii\helpers\Json::encode($params))
			->setHeaders([
		        'Content-Type' => 'application/json',
		        'Content-Length' => strlen(json_encode($params))
		    ])
		    ->setOption(CURLOPT_SSL_VERIFYHOST, '0')
		    ->setOption(CURLOPT_SSL_VERIFYPEER, '0')
		    ->post('http://10.10.20.186/sms/otp');

		$res = \yii\helpers\Json::decode($response);

		return $res["status"]['rc'];
    }
	
	public function actionResendOtp($msisdn,$nopolis,$nospaj){

		$original_num = '1234567890';
		$random_string = "";
		$num_valid_chars = strlen($original_num);

		for ($i = 0; $i < 6; $i++)
		{
			$random_pick = mt_rand(1, $num_valid_chars);
			$random_char = $original_num[$random_pick-1];
			$random_string .= $random_char;
		}

		$pin = $random_string;
		
    	$params = [
    		"msisdn"=>$msisdn,
    		"pin"=>$pin,
    		"nopolis"=>$nopolis
    	];

    	$curl = new curl\Curl();

		$response = $curl->setRawPostData(\yii\helpers\Json::encode($params))
			->setHeaders([
		        'Content-Type' => 'application/json',
		        'Content-Length' => strlen(json_encode($params))
		    ])
		    ->setOption(CURLOPT_SSL_VERIFYHOST, '0')
		    ->setOption(CURLOPT_SSL_VERIFYPEER, '0')
		    ->post('http://10.10.20.186/sms/otp');

		$res = \yii\helpers\Json::decode($response);
		
		$sql_update = "UPDATE form_permintaan SET otp_code = '".$pin."' WHERE no_spaj = '".$nospaj."' ORDER BY id DESC LIMIT 1";
		Yii::$app->db->createCommand($sql_update)->execute();

		return $this->redirect(['./otp']);
    }
	
	
	function push_notif_email($nomorSPAJ){

    	$params = [
    		"nospaj"=>$nomorSPAJ
    	];

    	$curl = new curl\Curl();

		$response = $curl->setRawPostData(\yii\helpers\Json::encode($params))
			->setHeaders([
		        'Content-Type' => 'application/json',
		        'Content-Length' => strlen(json_encode($params))
		    ])
		    ->setOption(CURLOPT_SSL_VERIFYHOST, '0')
		    ->setOption(CURLOPT_SSL_VERIFYPEER, '0')
		    ->post('http://10.10.20.186/notification/email');

		$res = \yii\helpers\Json::decode($response);

		return $res["doku"];
    }
	
	function push_notif_email_rejected($nomorSPAJ){

    	$params = [
    		"nospaj"=>$nomorSPAJ
    	];

    	$curl = new curl\Curl();

		$response = $curl->setRawPostData(\yii\helpers\Json::encode($params))
			->setHeaders([
		        'Content-Type' => 'application/json',
		        'Content-Length' => strlen(json_encode($params))
		    ])
		    ->setOption(CURLOPT_SSL_VERIFYHOST, '0')
		    ->setOption(CURLOPT_SSL_VERIFYPEER, '0')
		    ->post('http://10.10.20.186/notification/email_reject');

		$res = \yii\helpers\Json::decode($response);

		return "00";
    }
	
	
	
	public function actionFromProvince()
	{
		
		$post = Yii::$app->request->post();
		
		$params = [
			"provinsi" => $_POST['provinsi'],
			"kota" => $_POST['kota'],
			"kecamatan" => $_POST['kecamatan'],
			"kelurahan" => $_POST['kelurahan']
    	];

    	$curl = new curl\Curl();

		$response = $curl->setRawPostData(\yii\helpers\Json::encode($params))
			->setHeaders([
		        'Content-Type' => 'application/json',
		        'Content-Length' => strlen(json_encode($params))
		    ])
		    ->setOption(CURLOPT_SSL_VERIFYHOST, '0')
		    ->setOption(CURLOPT_SSL_VERIFYPEER, '0')
		    ->post('http://10.10.20.186/address/mapping');
			
		$datakota = \yii\helpers\Json::encode($response);

		return $datakota;
	}
	
	public function actionClosingSave(){
		$model = new ClosingStatement();
		$rc = '00';
		$msg = 'success';
		
		$model->no_spaj = $_POST['no_spaj'];
		$model->no_agent = $_POST['ClosingStatement']['no_agent'];
		$model->nama_agent = $_POST['ClosingStatement']['nama_agent'];
		$model->no_lisensi = $_POST['ClosingStatement']['no_lisensi'];
		$model->phone = $_POST['ClosingStatement']['phone'];
		$model->kenal_pp_selama = $_POST['ClosingStatement']['kenal_pp_selama'];
		$model->kenal_sebagai = $_POST['ClosingStatement']['kenal_sebagai'];
		$model->kenal_tertanggung_selama = $_POST['ClosingStatement']['kenal_tertanggung_selama'];
		$model->kenal_tertanggung_sebagai = $_POST['ClosingStatement']['kenal_tertanggung_sebagai'];
		$model->kenal_pembayar_premi_selama = $_POST['ClosingStatement']['kenal_pembayar_premi_selama'];
		$model->kenal_pembayar_premi_sebagai = $_POST['ClosingStatement']['kenal_pembayar_premi_sebagai'];
		$model->kesehatan_tertanggung = $_POST['ClosingStatement']['kesehatan_tertanggung'];
		$model->kondisi_keuangan_sesuai = $_POST['ClosingStatement']['kondisi_keuangan_sesuai'];
		$model->awal_penutupan_oleh = $_POST['ClosingStatement']['awal_penutupan_oleh'];
		$model->lokasi_closing = $_POST['ClosingStatement']['lokasi_closing'];
		$model->tanggal_closing = $_POST['ClosingStatement']['tanggal_closing'];
		$model->created_date = date('Y-m-d H:i:s');
		
		if($_POST['ClosingStatement']['kenal_sebagai']=='Lainnya'){
			$model->kenal_sebagai = $_POST['kenal_sebagai_lainnya'];
		}
		
		if($_POST['ClosingStatement']['kenal_tertanggung_sebagai']=='Lainnya'){
			$model->kenal_tertanggung_sebagai = $_POST['kenal_tertanggung_lainnya'];
		}
		
		if($_POST['ClosingStatement']['kenal_pembayar_premi_sebagai']=='Lainnya'){
			$model->kenal_pembayar_premi_sebagai = $_POST['kenal_pembayar_premi_lainnya'];
		}
		
		if($_POST['ClosingStatement']['awal_penutupan_oleh']=='Lainnya'){
			$model->awal_penutupan_oleh = $_POST['awal_penutupan_lainnya'];
		}
		
		$espaj = $_POST['no_spaj'];
		
		
				
		$model->save();	
		$this->closing_espaj($espaj);
		
		// if(!$model->save()){
			
			
			
			$path = "closing/";
				$fileStatement = $path . str_replace("/","-", "CLOSING-STATEMENT-". $espaj). ".pdf";
				
				// $fileStatement = "";
				
				$kirimdataupload = [
					"nomorSPAJ" => $espaj,
					"fileStatement" => $fileStatement,
				];
				
				/*Kirim data eSPAJ v2 (closing statement)*/
				$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => 'http://10.10.20.186/mi/upload_closing_agent',
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => '',
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => 'POST',
				  CURLOPT_SSL_VERIFYPEER => false,
				  CURLOPT_POSTFIELDS =>\yii\helpers\Json::encode($kirimdataupload),
				  CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json'
				  ),
				));

				$response = curl_exec($curl);

				curl_close($curl);
			
			$rc = '00';
			$msg = "ok";
			// $msg = json_encode($model->getErrors());
		// }
		echo json_encode(['respcode'=>$rc, 'resp_msg'=>$msg]);
		exit;
	}
	
	
	public function actionClosing($spajform=""){
		
		$model = new ClosingStatement();
		try{
		$getagen = FormPermintaan::find()->where(['id'=>$spajform])->one();
		
		if($getagen != null){
			$agen = $getagen->data_spaj;
			
			if($agen != ''){
				$json_data = json_decode($agen);
				$agen = $json_data->applicationList[0]->agenPenutup;
				$model->no_agent = $agen->noAgen;
				$model->nama_agent = $agen->namaAgen;
				$model->no_lisensi = $agen->noLisensiAgen;
				$model->phone = $agen->teleponAgen;
				
			}
		}
		}catch(\Exception $e){
			echo $e->getMessage();exit;
		}
		
		
		return $this->render('closing', ['model'=>$model, 'no_spaj'=>$getagen->no_spaj]);
	}

	public function actionClosingSpaj($spajform=""){
		
		$model = new ClosingStatement();
		try{
		$getagen = FormPermintaan::find()->where(['no_spaj'=>$spajform])->one();
		
		if($getagen != null){
			$agen = $getagen->data_spaj;
			
			if($agen != ''){
				$json_data = json_decode($agen);
				$agen = $json_data->applicationList[0]->agenPenutup;
				$model->no_agent = $agen->noAgen;
				$model->nama_agent = $agen->namaAgen;
				$model->no_lisensi = $agen->noLisensiAgen;
				$model->phone = $agen->teleponAgen;
				
			}
		}
		}catch(\Exception $e){
			echo $e->getMessage();exit;
		}
		
		
		return $this->render('closing', ['model'=>$model, 'no_spaj'=>$getagen->no_spaj]);
	}


	function rumusKesehatan($apakah_sehat, $questionnaire, $tinggi, $berat, $ppok, $bronkhitis, $pneumonia, $asthma,$arr_hepatitis,$arr_gondok,$arr_sendi,$arr_tubuh)
	{
		try{
			
			
			$resp_msg = 'Data Anda ditolak karena....';
			$resp_cpp = 'CPP01';
			$resp_code = '00';
			$total_poin = 0;
			$result_nilai = 0;
			$perhitungan = 0;
			$resp_status = 'REJECTED';
			
			$result_data = [];
			
			
			
			#$apakah_sehat = '{"idPernyataan":"L00006","opsi":true,"textValue":["0"]}';
			$apakah_sehat = json_decode($apakah_sehat);
			
			$point_value_sehat = $apakah_sehat->textValue[0];
			
			
			/*SEHAT ATAU TIDAK*/
			$cek = QuestionsOption::find()
					->alias('a')
					->innerJoin("questions b", "a.question_id=b.id")
					->where(['b.input_name'=>$apakah_sehat->idPernyataan, 'a.point_value'=>$point_value_sehat])->one();
					
			
					
			if($cek == null){
				$resp_msg = "Komponen nilai tidak ditemukan untuk ".$apakah_sehat->idPernyataan." dengan poin ".$point_value_sehat;
				$resp_code = '99';
				$resp_cpp = '';
				goto hasil;
			}else{
				$total_poin += $cek->ifg_value;
				$result_data[$apakah_sehat->idPernyataan] = $apakah_sehat->idPernyataan."-".$point_value_sehat;
			}

			$questionnaire = json_decode($questionnaire);
			foreach($questionnaire as $item){
				
				if($item->opsi == true){
					$point_value = 1;
				}else{
					$point_value = 0;
				}
				
				$point_value = $item->textValue[0];
				
				/*JIKA BUKAN TINGGI, BERAT DAN MH0017*/
				if(($item->idPernyataan <> 'L00001')&&($item->idPernyataan <> 'L00002')&&($item->idPernyataan <> 'MH0017')&&($item->idPernyataan <> 'L00006')&&($item->idPernyataan <> 'MH0010')&&($item->idPernyataan <> 'MH0012')&&($item->idPernyataan <> 'MH0014')&&($item->idPernyataan <> 'MH0020')){
					
					$cek = QuestionsOption::find()
						->alias('a')
						->innerJoin("questions b", "a.question_id=b.id")
						->where(['b.input_name'=>$item->idPernyataan, 'a.option_text'=>$point_value])->one();
					if($cek == null){
						$resp_msg = "Komponen nilai tidak ditemukan untuk ".$item->idPernyataan." dengan poin ".$point_value;
						$resp_code = '99';
						$resp_cpp = '';
					}else{
						$total_poin += $cek->ifg_value;
						$result_data[$item->idPernyataan] = $item->idPernyataan."-".$cek->ifg_value;
					}
				}
				
			}
			
			
			
			/*hepatitis*/
			
			for($tuj=0; $tuj< count($arr_hepatitis); $tuj++){
				$point_value = $arr_hepatitis[$tuj];
				$idPernyataan = 'MH0010';
				
				$cek = QuestionsOption::find()
						->alias('a')
						->innerJoin("questions b", "a.question_id=b.id")
						->where(['b.input_name'=>$idPernyataan, 'a.point_value'=>$point_value])->one();
					if($cek == null){
						$resp_msg = "Komponen nilai tidak ditemukan untuk ".$item->idPernyataan." dengan poin ".$point_value;
						$resp_code = '99';
						$resp_cpp = '';
					}else{
						$total_poin += $cek->ifg_value;
						$result_data[$idPernyataan] = $idPernyataan."-".$cek->ifg_value;
					}					
			}
			
			
			
			/*gondok*/
			for($tuj=0; $tuj< count($arr_gondok); $tuj++){
				$point_value = $arr_gondok[$tuj];
				$idPernyataan = 'MH0012';
				
				$cek = QuestionsOption::find()
						->alias('a')
						->innerJoin("questions b", "a.question_id=b.id")
						->where(['b.input_name'=>$idPernyataan, 'a.point_value'=>$point_value])->one();
					if($cek == null){
						$resp_msg = "Komponen nilai tidak ditemukan untuk ".$item->idPernyataan." dengan poin ".$point_value;
						$resp_code = '99';
						$resp_cpp = '';
					}else{
						$total_poin += $cek->ifg_value;
						$result_data[$idPernyataan] = $idPernyataan."-".$cek->ifg_value;
					}
					
			}
			
			/*sendi*/
			for($tuj=0; $tuj< count($arr_sendi); $tuj++){
				$point_value = $arr_sendi[$tuj];			
				$idPernyataan = 'MH0014';
				
				$cek = QuestionsOption::find()
						->alias('a')
						->innerJoin("questions b", "a.question_id=b.id")
						->where(['b.input_name'=>$idPernyataan, 'a.point_value'=>$point_value])->one();
					if($cek == null){
						$resp_msg = "Komponen nilai tidak ditemukan untuk ".$item->idPernyataan." dengan poin ".$point_value;
						$resp_code = '99';
						$resp_cpp = '';
					}else{
						$total_poin += $cek->ifg_value;
						$result_data[$idPernyataan] = $idPernyataan."-".$cek->ifg_value;
					}
					
			}
			
			
			
			/*fungsi tubuh*/
			for($tuj=0; $tuj< count($arr_tubuh); $tuj++){
				$point_value = $arr_tubuh[$tuj];	
				$idPernyataan = 'MH0020';
				
				$cek = QuestionsOption::find()
						->alias('a')
						->innerJoin("questions b", "a.question_id=b.id")
						->where(['b.input_name'=>$idPernyataan, 'a.point_value'=>$point_value])->one();
					if($cek == null){
						$resp_msg = "Komponen nilai tidak ditemukan untuk ".$item->idPernyataan." dengan poin ".$point_value;
						$resp_code = '99';
						$resp_cpp = '';
					}else{
						$total_poin += $cek->ifg_value;
						$result_data[$idPernyataan] = $idPernyataan."-".$cek->ifg_value;
					}
					
			}
			
			
			
			/*PERHITUNGAN BERAT DAN TINGGI BADAN*/
			$bmi = $berat / (($tinggi/100)*($tinggi/100));
			if($bmi > 38){
				$total_poin += 100;
			}else if($bmi >= 35.1 && $bmi <= 38){
				$total_poin += 75;
			}else if($bmi >= 33.1 && $bmi <= 35){
				$total_poin += 50;
			}else if($bmi >= 28.1 && $bmi <= 33){
				$total_poin += 25;
			}else if($bmi >= 17.1 && $bmi <= 28){
				$total_poin += 0;
			}else if($bmi >= 15 && $bmi <= 17){
				$total_poin += 50;
			}
			// var_dump($total_poin);die;
			$result_data['bmi'] =['bmi'=>$bmi, 'berat'=>$berat, 'tinggi'=>$tinggi];	
			
			/*PERHITUNGAN PPOK, BRONKHITIS, PNEUMONIA DAN ASTHMA*/
			if($ppok=='1'){
				$total_poin += 25;
				$result_data['ppok'] =['value'=>$ppok, 'point'=>25];
			}else{
				$result_data['ppok'] =['value'=>$ppok, 'point'=>0];
			}
			
			if($bronkhitis=='1'){
				$total_poin += 25;
				$result_data['bronkhitis'] =['value'=>$bronkhitis, 'point'=>25];
			}else{
				$result_data['bronkhitis'] =['value'=>$bronkhitis, 'point'=>0];
			}
			
			if($pneumonia=='1'){
				$total_poin += 25;
				$result_data['pneumonia'] =['value'=>$pneumonia, 'point'=>25];
			}else{
				$result_data['pneumonia'] =['value'=>$pneumonia, 'point'=>0];
			}
			
			if($asthma=='1'){
				$total_poin += 25;
				$result_data['asthma'] =['value'=>$asthma, 'point'=>25];
			}else{
				$result_data['asthma'] =['value'=>$asthma, 'point'=>0];
			}
			
			
			
			if($total_poin >= 100){
				$resp_code = '99';
				$resp_cpp = 'CPP01';
				$resp_msg = 'Mohon maaf pengajuan anda ditolak';
				$resp_status = 'REJECTED';
			}else{
				
				$resp_code = '00';
				$resp_cpp = 'CPP02';
				$resp_msg = 'Selamat pengajuan anda telah diterima';
				$resp_status = 'APPROVED';
			}
			
			
		}catch(\Exception $e){
			$resp_code = '99';
			$resp_cpp = '';
			$resp_msg = $e->getMessage();
		}
		// var_dump($resp_code);die;
		hasil:
		return json_encode(['resp_code'=>$resp_code, 'resp_cpp'=>$resp_cpp, 'resp_msg'=>$resp_msg, 'total_poin'=>(string) $total_poin, 'result_nilai'=>(string) $result_nilai, 'perhitungan'=>$perhitungan, 'result_data'=>$result_data, 'resp_status'=>$resp_status]);
		
	}


	public function actionSpaj($id){
		
		/*DAPATKAN DETAIL FORM SPAJ*/
		$sql_spaj = "SELECT * FROM form_permintaan WHERE no_spaj = '".$id."'";
		$data_spaj = Yii::$app->db->createCommand($sql_spaj)->queryOne();
		
		
		return $this->render('spaj', ['dataspaj' => $data_spaj['api_response'], 'doku' => $data_spaj['doku'], 'premi_tambahan' => $data_spaj['premi_tambahan'], 'id' => $data_spaj['id']]);
	}
	
	
	function cekTarif($plan,$kelas,$jenisKelamin,$usia,$periodeBayarPremi,$poin_terkumpul,$kematian,$inap)
	{
		
		$result_data = [];
		$remark_kesehatan = "";
		$nominal_kesehatan = 0;
		$remark_kematian = "";
		$nominal_kematian = 0;
		$remark_inap = "";
		$nominal_inap = 0;
		$remark_extra_kematian = "";
		$nominal_extra_kematian = 0;
		$remark_extra_inap = "";
		$nominal_extra_inap = 0;
		
		if($usia >= 5 && $usia < 21){
			$age_group = "5-20";
		}elseif($usia >= 21 && $usia < 31){
			$age_group = "21-30";
		}elseif($usia >= 31 && $usia < 41){
			$age_group = "31-40";
		}elseif($usia >= 41 && $usia < 51){
			$age_group = "41-50";
		}elseif($usia >= 51 && $usia < 56){
			$age_group = "51-55";
		}else{
			$age_group = "0";
		}
		
		/*PLAN P: Platinum, G: Gold, S: Silver*/
		if(strtoupper($plan) == 'P'){
			$jenis = "Platinum";
		}else if(strtoupper($plan) == 'G'){
			$jenis = "Gold";
		}else{
			$jenis = "Silver";
		}
		
		/*KELAS 0: VIP, 1: I, 2: II*/
		if(strtoupper($kelas) == 1){
			$kelasnya = "I";
		}else if(strtoupper($kelas) == 2){
			$kelasnya = "II";
		}else{
			$kelasnya = "VIP";
		}

		/*HITUNG GROSS*/
		$total_tarif = 0;
		$sql = "SELECT COALESCE(tarif,0)AS tarif FROM tarif WHERE jenis = '$jenis' AND kelas = '$kelasnya' AND jenis_kelamin='$jenisKelamin' AND age_group = '$age_group' AND cara_bayar = '$periodeBayarPremi' AND tipe='GROSS'";

		//var_dump($sql); die;
		$exe = Yii::$app->db->createCommand($sql)->queryOne();
		$total_tarif += $exe['tarif']; //GROSS
		
		if($poin_terkumpul==25){
			$persen_ekstra = 5;
		}else if($poin_terkumpul==50){
			$persen_ekstra = 10;
		}else if($poin_terkumpul==75){
			$persen_ekstra = 15;
		}
		
		// var_dump($poin_terkumpul);die;
		
		/*EKSTRA PREMI JIKA MELEBIHI KETENTUAN POIN KESEHATAN*/
		if($poin_terkumpul>=25){
			$sql = "SELECT COALESCE(tarif,0)AS extrapremi FROM tarif WHERE jenis = '$jenis' AND kelas = '$kelasnya' AND jenis_kelamin='$jenisKelamin' AND age_group = '$age_group' AND cara_bayar = '$periodeBayarPremi' AND tipe='EXTRA'";
			$exe = Yii::$app->db->createCommand($sql)->queryOne();
			$total_tarif += $exe['extrapremi'] * $persen_ekstra/100; //EXTRA
			$remark_kesehatan = "Extra Premi Atas Riwayat Kesehatan";
			$nominal_kesehatan = $exe['extrapremi'] * $persen_ekstra/100;
		}
		
		
		/*JIKA MENGAMBIL EKSTRA PREMI*/
		/*TAMBAHAN MANFAAT : KEMATIAN*/
		if($kematian=='1'){
			$sql = "SELECT COALESCE(tarif,0)AS kematian FROM tarif WHERE jenis = '$jenis' AND kelas = '$kelasnya' AND jenis_kelamin='$jenisKelamin' AND age_group = '$age_group' AND cara_bayar = '$periodeBayarPremi' AND tipe='KEMATIAN'";
			$exe = Yii::$app->db->createCommand($sql)->queryOne();
			$total_tarif += $exe['kematian']; //kematian
			$remark_kematian = "Santunan Kematian";
			$nominal_kematian = $exe['kematian'];
			
			/*JIKA MELEBIHI POIN KESEHATAN*/
				if($poin_terkumpul>=25){
					$sql = "SELECT COALESCE(tarif,0)AS extrakematian FROM tarif WHERE jenis = '$jenis' AND kelas = '$kelasnya' AND jenis_kelamin='$jenisKelamin' AND age_group = '$age_group' AND cara_bayar = '$periodeBayarPremi' AND tipe='EXTRA-KEMATIAN'";
					$exe = Yii::$app->db->createCommand($sql)->queryOne();
					$total_tarif += $exe['extrakematian'] * $persen_ekstra/100; //EXTRA KEMATIAN
					$remark_extra_kematian = "Extra Premi Atas Riwayat Kesehatan";
					$nominal_extra_kematian = $exe['extrakematian'] * $persen_ekstra/100;
				}
		}
		
		/*TAMBAHAN MANFAAT : RAWAT INAP*/
		if($inap=='1'){
			$sql = "SELECT COALESCE(tarif,0)AS inap FROM tarif WHERE jenis = '$jenis' AND kelas = '$kelasnya' AND jenis_kelamin='$jenisKelamin' AND age_group = '$age_group' AND cara_bayar = '$periodeBayarPremi' AND tipe='INAP'";
			$exe = Yii::$app->db->createCommand($sql)->queryOne();
			$total_tarif += $exe['inap']; //inap
			$remark_inap = "Santunan Harian Rawat Inap";
			$nominal_inap = $exe['inap'];
			
			/*JIKA MELEBIHI POIN KESEHATAN*/
				if($poin_terkumpul>=25){
					$sql = "SELECT COALESCE(tarif,0)AS extrainap FROM tarif WHERE jenis = '$jenis' AND kelas = '$kelasnya' AND jenis_kelamin='$jenisKelamin' AND age_group = '$age_group' AND cara_bayar = '$periodeBayarPremi' AND tipe='EXTRA-INAP'";
					$exe = Yii::$app->db->createCommand($sql)->queryOne();
					$total_tarif += $exe['extrainap'] * $persen_ekstra/100; //EXTRA INAP
					$remark_extra_inap = "Extra Premi Atas Riwayat Kesehatan";
					$nominal_extra_inap = $exe['extrainap'] * $persen_ekstra/100;
				}
			
		}
		
		
		
		// return $total_tarif;
				
		
		return json_encode(['total_tarif'=>$total_tarif,'remark_extra' => $remark_kesehatan, 'nominal_extra' => $nominal_kesehatan, 
		'remark_kematian' => $remark_kematian, 'nominal_kematian' => $nominal_kematian, 
		'remark_inap' => $remark_inap, 'nominal_inap' => $nominal_inap, 
		'remark_extra_kematian' => $remark_extra_kematian, 'nominal_extra_kematian' => $nominal_extra_kematian, 
		'remark_extra_inap' => $remark_extra_inap, 'nominal_extra_inap' => $nominal_extra_inap]);
		
			
	}







	public function actionVerifyAgent()
		{
			$session = Yii::$app->session;
			$noagen = preg_replace("/[^a-zA-Z0-9]/", "", $_POST["data"]);
			
			
			$curl = curl_init();

						curl_setopt_array($curl, array(
						  CURLOPT_URL => 'https://asuransi.ifg-life.id/api/mifg/?noagen='. $noagen,
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => '',
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'GET',
						CURLOPT_SSL_VERIFYPEER => false,
						CURLOPT_SSL_VERIFYHOST => false,
						  CURLOPT_HTTPHEADER => array(
							'Authorization: Basic bWlmZzIwMjE6bTFmOUAkNG5kMQ=='
						  ),
						));

						$response = curl_exec($curl);

						curl_close($curl);
						$ag = \yii\helpers\Json::decode($response);
				

				if($ag["data"]==null){
					if($session->has('verifAgent')){
						$session->remove('verifAgent');
					}
					$retval = array("respcode" => "0", "msg" => "failed", "row" => "mbel", "resp_msg" => "Data Agen tidak ditemukan");
					return json_encode($retval); 
				}
				
				
				$encrypted = base64_encode($noagen);
				$retval = array("respcode" => "1", "msg" => "success", "row" => "mbel", "resp_msg" => "Berhasil", "agen" => $encrypted);
				$session['verifAgent'] = [
					'agen' => password_hash($noagen, PASSWORD_DEFAULT),
					'expire' => date("d-m-Y H:i:s", strtotime('+30 minutes'))
				];
				/*RETURN TO VIEW*/
			
			
			return json_encode($retval); 
			
		}




	public function actionPrintOld($id){
		$model = FormPermintaan::findOne($id);
        $content = $this->renderPartial('print', [
            'id'=>$id,
        ]);
		
		$pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // set file name
            'filename' => str_replace("/","-",$model->no_spaj),
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // 'format' => [215, 179], // page will be 190mm wide x 236mm height
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            //'cssFile' => 'https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css',
            // any css to be embedded if required
            //'cssInline' => '@page { sheet-size: 215mm 139mm; }', 
            /*'cssInline' => '
                @media print {
                    @page {
                        margin-top: 10px;
                        margin-left: 20px;
                        margin-right: 10px;
                    }
                }
            ',*/
            'marginLeft'=>18,
            'marginRight'=>20,
            'defaultFontSize'=>18,
            'defaultFont'=>'calibri',
             // set mPDF properties on the fly
            'options' => ['title' => str_replace("/","-",$model->no_spaj), 'defaultfooterline' => false],
             // call mPDF methods on the fly
            'methods' => [ 
                //'SetHeader'=>[$judule], 
                //'SetFooter'=>['{PAGENO}'],
                //'SetHeader'=>['Bukti Serah Terima Distribusi'], 
                //'SetFooter'=>['{PAGENO}'],
            ]
        ]);
       // Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
       // Yii::$app->response->headers->add('Content-Type', 'application/pdf');
        // return the pdf output as per the destination setting
       
        return $pdf->render();
		
	}
	
	
	public function espaj($nomorSPAJ){
		
		$model = FormPermintaan::find()->where(['no_spaj' => $nomorSPAJ])->one();
		$modelagent = ClosingStatement::find()->where(['no_spaj'=>$nomorSPAJ])->one();
		if($modelagent == null){
			$modelagent = (object) [];
		}
        $content = $this->renderPartial('spaj_pdf', [
            'id'=>$model->id,
            'modelagent'=>$modelagent,
			
        ]);
		
		// $path = 'C:\xampp\htdocs\ifg-life\frontend\controllers';
		$path = "/var/www/ifgl_frontend/frontend/web/uploads/";
		
		$pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, 
            'filename' => str_replace("/","-",$model->no_spaj),
            'format' => Pdf::FORMAT_A4, 
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            'destination' => Pdf::DEST_FILE, 
            // 'filename' => 'C:\xampp\htdocs\ifg-life\frontend\controllers\haha.pdf', 
            'filename' => $path . str_replace("/","-",$model->no_spaj). ".pdf" , 
            'content' => $content,
			'marginLeft'=>18,
            'marginRight'=>20,
            'defaultFontSize'=>18,
            'defaultFont'=>'calibri',
            'options' => ['title' => str_replace("/","-",$model->no_spaj), 'defaultfooterline' => false, 'defaultheaderline' => 0],
            'methods' => [ 
                'SetHeader'=>['<div class="row"><div class="col company-details" style="text-align:left;float:left;width:300px;padding-top:10px;margin-left:0px;padding-left:0px;"><img src="./images/logo/logo.png" height="60" style="text-align:left;"></div><div class="col company-details" style="float:right;width:300px;text-align:right;"><img src="./images/logo/ihealth.png" height="70"></div><div style="width:800px;float:left;text-align:left;font-size:8pt;color:#003b70;margin-top:20px;font-weight:Bold;"><b>No SPAJ: '.strtoupper($model->no_spaj).'</b></div></div>'],
                'SetFooter'=>['<div class="col company-details" style="float:center;width:880px;padding-top:20px;text-align:center;">
							<img src="./images/banner/footerpdf.PNG" style="width:880px;"/>
						</div>'],
            ]
        ]);
       
        return $pdf->render();
	}
	
	
	public function closing_espaj($nomorSPAJ){
		
		$model = FormPermintaan::find()->where(['no_spaj' => $nomorSPAJ])->one();
		$modelagent = ClosingStatement::find()->where(['no_spaj'=>$nomorSPAJ])->one();
		if($modelagent == null){
			$modelagent = (object) [];
		}
        $content = $this->renderPartial('spaj_closing_pdf', [
            'id'=>$model->id,
            'modelagent'=>$modelagent,
			
        ]);
		
		// $path = 'C:\xampp\htdocs\ifg-life\frontend\controllers';
		$path = "/var/www/ifgl_frontend/frontend/web/uploads/closing/";
		
		$pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, 
            'filename' => str_replace("/","-",$model->no_spaj),
            'format' => Pdf::FORMAT_A4, 
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            'destination' => Pdf::DEST_FILE, 
            // 'filename' => 'C:\xampp\htdocs\ifg-life\frontend\controllers\haha.pdf', 
            'filename' => $path . str_replace("/","-", "CLOSING-STATEMENT-". $model->no_spaj). ".pdf" , 
            'content' => $content,
			'marginLeft'=>18,
            'marginRight'=>20,
            'defaultFontSize'=>18,
            'defaultFont'=>'calibri',
            'options' => ['title' => str_replace("/","-", "CLOSING-STATEMENT-". $model->no_spaj), 'defaultfooterline' => false, 'defaultheaderline' => 0],
            'methods' => [ 
                'SetHeader'=>['<div class="row"><div class="col company-details" style="text-align:left;float:left;width:300px;padding-top:10px;margin-left:0px;padding-left:0px;"><img src="./images/logo/logo.png" height="60" style="text-align:left;"></div><div class="col company-details" style="float:right;width:300px;text-align:right;"><img src="./images/logo/ihealth.png" height="70"></div><div style="width:800px;float:left;text-align:left;font-size:8pt;color:#003b70;margin-top:20px;font-weight:Bold;"><b>No SPAJ: '.strtoupper($model->no_spaj).'</b></div></div>'],
                'SetFooter'=>['<div class="col company-details" style="float:center;width:880px;padding-top:20px;text-align:center;">
							<img src="./images/banner/footerpdf.PNG" style="width:880px;"/>
						</div>'],
            ]
        ]);
       
        return $pdf->render();
	}
	
	
	
	public function actionPrint($id){
		return $this->goHome();
		$model = FormPermintaan::findOne($id);
		$modelagent = ClosingStatement::find()->where(['no_spaj'=>$model->no_spaj])->one();
		if($modelagent == null){
			$modelagent = (object) [];
		}
        $content = $this->renderPartial('spaj_pdf', [
            'id'=>$id,
            'modelagent'=>$modelagent,
			
        ]);
		
		
		
		$pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // set file name
            'filename' => str_replace("/","-",$model->no_spaj),
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // 'format' => [215, 179], // page will be 190mm wide x 236mm height
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            //'cssFile' => 'https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css',
            // any css to be embedded if required
            // 'cssInline' => '@page { font-family:"Myriad Pro Regular"; }', 
            /*'cssInline' => '
                @media print {
                    @page {
                        margin-top: 10px;
                        margin-left: 20px;
                        margin-right: 10px;
                    }
                }
            ',*/
            'marginLeft'=>18,
            'marginRight'=>20,
            'defaultFontSize'=>18,
            'defaultFont'=>'calibri',
             // set mPDF properties on the fly
            'options' => ['title' => str_replace("/","-",$model->no_spaj), 'defaultfooterline' => false, 'defaultheaderline' => 0],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['<div class="row"><div class="col company-details" style="text-align:left;float:left;width:300px;padding-top:10px;margin-left:0px;padding-left:0px;"><img src="./images/logo/logo.png" height="60" style="text-align:left;"></div><div class="col company-details" style="float:right;width:300px;text-align:right;"><img src="./images/logo/ihealth.png" height="70"></div><div style="width:800px;float:left;text-align:left;font-size:8pt;color:#003b70;margin-top:20px;font-weight:Bold;"><b>No SPAJ: '.strtoupper($model->no_spaj).'</b></div></div>'],
                //'SetHeader'=>[$judule], 
                'SetFooter'=>['<div class="col company-details" style="float:center;width:880px;padding-top:20px;text-align:center;">
							<img src="./images/banner/footerpdf.PNG" style="width:880px;"/>
						</div>'],
                //'SetHeader'=>['Bukti Serah Terima Distribusi'], 
                //'SetFooter'=>['{PAGENO}'],
            ]
        ]);
       // Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
       // Yii::$app->response->headers->add('Content-Type', 'application/pdf');
        // return the pdf output as per the destination setting
       
        return $pdf->render();
		
	}	
}
