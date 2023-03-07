<?php

namespace common\helpers;

use Yii;
use yii\web\Session;

class Tool
{
	// http://www.yiiframework.com/doc-2.0/guide-output-formatting.html
	public static function convertDate($yiiDate, $type='date', $format = null)
	{
		if ($type === 'datetime') {
			$fmt = ($format == null) ? 'php:' . Yii::$app->params['formatDateTime'] : 'php:' . $format;
		}
		elseif ($type === 'time') {
			$fmt = ($format == null) ? 'php:' . Yii::$app->params['formatTime'] : 'php:' . $format;
		}
		else {
			$fmt = ($format == null) ? 'php:' . Yii::$app->params['formatDate'] : 'php:' . $format;
		}
		return \Yii::$app->formatter->asDate($yiiDate, $fmt);
	}

	public static function convertDateToUnix($strDate, $type='date')
	{
		if ($type === 'datetime') {
			$unixDate 	= new \DateTime();
			$unixDate 	= $unixDate->createFromFormat(Yii::$app->params['formatDateTime'], $strDate);
		}
		elseif ($type === 'time') {
			$unixDate 	= new \DateTime();
			$unixDate 	= $unixDate->createFromFormat(Yii::$app->params['formatTime'], $strDate);
		}
		else {
			$unixDate 	= new \DateTime();
			$unixDate 	= $unixDate->createFromFormat(Yii::$app->params['formatDate'], $strDate);
		}
		return $unixDate 	= $unixDate->getTimestamp();
	}

	public static function convertDbDateToUnix($strDate, $type='date')
	{
		if ($type === 'datetime') {
			$unixDate 	= new \DateTime();
			$unixDate 	= $unixDate->createFromFormat(Yii::$app->params['dbDateTime'], $strDate);
		}
		elseif ($type === 'time') {
			$unixDate 	= new \DateTime();
			$unixDate 	= $unixDate->createFromFormat(Yii::$app->params['dbTime'], $strDate);
		}
		else {
			$unixDate 	= new \DateTime();
			$unixDate 	= $unixDate->createFromFormat(Yii::$app->params['dbDate'], $strDate);
		}
		return $unixDate 	= $unixDate->getTimestamp();
	}

	public static function formatMoney($number)
	{
		setlocale(LC_MONETARY, 'id_ID');
		return money_format('%#10n', $number);
	}

	public static function formatCurrency($number, $curType='IDR')
	{
		if($curType == 'IDR')
			$currency = Tool::formatRupiah($number);
		else    
			$currency = Tool::formatDolar($number);
		return $currency;
	}

	public static function formatDolar($number)
	{
		$dolar = number_format($number,0,'.',',');
		return '$ '.$dolar;
	}

	public static function formatRupiah($number)
	{
		$rupiah = number_format($number,0,',','.');
		return 'Rp '.$rupiah;
	}

	public static function checkPhoneNumber($phoneNbr)
	{
		$phoneNbr = trim($phoneNbr);
		if(substr($phoneNbr, 0, 1) == '+')
			$phoneNew = substr($phoneNbr, 1);
		else
			$phoneNew = $phoneNbr;

		if(substr($phoneNew, 0, 1) == '0')
			$phoneNbr   = "62".substr($phoneNew, 1);
		elseif(substr($phoneNew, 0, 2) != '62')
			$phoneNbr   = "62".$phoneNew;
		else
			$phoneNbr   = $phoneNew;

		return $phoneNbr;
	}

	public static function generateRandomString($length=5, $characters=null) {
		if($characters == null) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		}
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public static function generatePin($length=4)
	{
		return (string)rand(pow(10, $length-1), pow(10, $length)-1);
	}

	public static function isJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}

	public static function getUserUsername($id)
	{
		$query = new Query;
		$query->select("username")
				->from("user")
				->where("user_id = ".$id);
		$command = $query->createCommand();
		$val = $command->queryScalar();

		return $val;
	}

	public static function getCustomerUsername($id)
	{
		$query = new Query;
		$query->select("username")
				->from("customer")
				->where("customer_id = ".$id);
		$command = $query->createCommand();
		$val = $command->queryScalar();

		return $val;
	}
}
?>