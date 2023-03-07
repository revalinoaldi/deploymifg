<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use common\models\Settings;
use linslin\yii2\curl;

class GeneralFunction extends Component {
	function menuGenerator($items) {
        $i = 0;
        $menuItem = "";
        $menuItem .= '<ul class="list">';
        $menuItem .= '<li>
                        <div class="user-info">
                            <div class="image"><a href="'.Yii::$app->homeUrl.'"><img style="width:55%" src="'.Yii::$app->request->baseUrl.'/images/logo.png" alt="User"></a></div>
                                                      
                        </div>
                    </li>';
        foreach ($items as $item) {
            $class = Yii::$app->urlManager->createUrl([$item["route"]]) == Yii::$app->request->url ? 'active' : '';
            $menuItem .= '<li class="ini '.$class.'">
                   <a class="'.(count($item["children"]) > 0 ? 'menu-toggle':'').'" href="' . (count($item["children"]) > 0 ? 'javascript:;' : Yii::$app->urlManager->createUrl([$item["route"]])) . '"><i class="'.$item['data'].'"></i><span>'.str_replace("-", " ", $item["name"]).'</span></a>';
            if (count($item["children"]) > 0) {
                $menuItem .= '<ul class="ml-menu">';
                foreach ($item["children"] as $child) {
                    $menuItem .= '<li class="">
                                        <a href="' . Yii::$app->urlManager->createUrl([$child["route"]]) . '">' . str_replace("-", " ", $child["name"]) . '</a></li>';
                }
                $menuItem .= '</ul>';
            }
            $menuItem .= '</li>';
            $i++;
        }
        

        $menuItem .= '</ul>';
        return $menuItem;
    }

    function postData($path, $params=[]){
        
        if($path == 'product/create'){
            unset($params['keyword']);
            unset($params['page']);
        }
        $curl = new curl\Curl();
        $token = Yii::$app->session->get('access_token');

        $response = $curl->setRawPostData(\yii\helpers\Json::encode($params))
             ->setHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer $token"
             ])
             ->post(Yii::$app->params['baseUrl'].$path);
        $resp = \yii\helpers\Json::decode($response);
        // if($resp['status']['rc'] == 40){
        //     Yii::$app->user->logout();
        // }
        return $resp;
    }

    function postUrlEncoded($path, $params=[]){
        $curl = new curl\Curl();
        $token = Yii::$app->session->get('access_token');
        $response = $curl->setPostParams($params)
             ->setHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer $token"
             ])
             ->post(Yii::$app->params['baseUrl'].$path);
        return $response;
    }

    function getData($path, $params=[]){
        $curl = new curl\Curl();
        $token = Yii::$app->session->get('access_token');
        $response = $curl->setGetParams($params)
             ->setHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer $token"
             ])
             ->get(Yii::$app->params['baseUrl'].$path);
        $resp = \yii\helpers\Json::decode($response);
        // if($resp['status']['rc'] == 40){
        //     Yii::$app->user->logout();
        // }
        return $resp;
    }

    function generateProductCode(){
        $supp = substr(Yii::$app->user->identity->supplier_name, 0,3);
        return strtoupper($supp.strtotime(date("Y-m-d H:i:s")));
    }

    function generateProductSku(){
        $supp = substr(Yii::$app->user->identity->supplier_name, 0,3);
        return strtoupper("SKU-".$supp.strtotime(date("Y-m-d H:i:s")));
    }

    function postPublicData($path, $params=[]){
        $curl = new curl\Curl();
        $q = http_build_query($params);
        $response = $curl->setPostParams($params)
             ->post(Yii::$app->params['baseUrl'].$path."?".$q);
        return \yii\helpers\Json::decode($response);
    }

    function getCompanyCode(){
        return 'CAGAGN';
    }
    
    public function formatingDateRange($date, $type) {
        $mdy = explode('/', $date);

        if ($type == "1") {
            $result = $mdy[2] . '-' . $mdy[1] . '-' . $mdy[0] . ' 00:00:00';
        }

        if ($type == "2") {
            $result = $mdy[2] . '-' . $mdy[1] . '-' . $mdy[0] . ' 23:59:59';
        }
        return $result;
    }
    
    public function baseUrl($path) {
        return Yii::$app->request->baseUrl."/themes/images/". $path;
    }
    
    public function getImageBase64($path) {
        $fullpath = $path;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($fullpath);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        return $base64;
    }
    
    public function getLoader($loaderId) {
        $loader = '<div id="' . $loaderId . '" class="spiner-example">';
        $loader.= '<div class="sk-spinner sk-spinner-circle">';
        $loader.= '<div class="sk-circle1 sk-circle"></div>';
        $loader.= '<div class="sk-circle2 sk-circle"></div>';
        $loader.= '<div class="sk-circle3 sk-circle"></div>';
        $loader.= '<div class="sk-circle4 sk-circle"></div>';
        $loader.= '<div class="sk-circle5 sk-circle"></div>';
        $loader.= '<div class="sk-circle6 sk-circle"></div>';
        $loader.= '<div class="sk-circle7 sk-circle"></div>';
        $loader.= '<div class="sk-circle8 sk-circle"></div>';
        $loader.= '<div class="sk-circle9 sk-circle"></div>';
        $loader.= '<div class="sk-circle10 sk-circle"></div>';
        $loader.= '<div class="sk-circle11 sk-circle"></div>';
        $loader.= '<div class="sk-circle12 sk-circle"></div>';
        $loader.= '</div>';
        $loader.= '</div>';

        return $loader;
    }
    
    
    public function get_http_response_code($url) {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }
    
    public function curlTo($url, $params){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array());
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result = curl_exec($ch);
        if(!$result){
            $error = curl_error($ch);
            $debug = true;
            if ($debug) {
                echo "<br/> error <br/>";
                var_dump($error);
                echo "<br/>";
                var_dump($result);
            }
        }

        curl_close($ch);
        
        return $result;
    }
    
    public function curlToJson($url, $params)
    {
        $debug = false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($params)))
        );
        $result = curl_exec($ch);
        if (is_bool($result) && !$result)
            $error = curl_error($ch);
        curl_close($ch);

        if ($debug) {
            echo "<pre><br/>result<br/>:";
            var_dump($result);
            echo "<br/><br/> error: <br/>";
            var_dump($error);
        }

        $decodedResult = json_decode($result);
        return $decodedResult;
    }
    
    public function descMonth($month)
    {
        $arr_bulan = array("1"=>"January", "2"=>"February", "3"=>"March", "4"=>"April", "5"=>"May", "6"=>"June", "7"=>"July", "8"=>"August", "9"=>"September", "10"=>"October", "11"=>"Nopember", "12"=>"December");
        return $arr_bulan[$month];
    }

    public function getSetting($keys){
        $model = Settings::find()->where(['keys'=>$keys])->one();
        return $model != null ? $model->content : '';
    }
	
  public function getUrlWeb(){
    // $urlweb = "https://registration.ifg-life.id/";
     	$urlweb = "https://mifg.ifg-life.id";
	return $urlweb;
  }

}
