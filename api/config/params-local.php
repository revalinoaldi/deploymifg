<?php
return [
	//dev
	#'ptpost_endpoit'=>'http://202.152.51.27:7879/finsbu/h2h',
	'ptpost_endpoit'=>'http://fintech-host.posindonesia.co.id:16331/finsbu/h2h',
	#'ptpost_account'=>'0000000018',
	'ptpost_account'=>'0000001768',
	#'ptpost_institutionCode'=>'180309000002',
	'ptpost_institutionCode'=>'180813000007',
	#'ptpost_password'=>'aad16aabac2b3d4e17f04a95e2a2372f',
	'ptpost_password'=>'5af20e21a0a1fda925a34ddcbf03a5ea',
	'ptpost_client_id'=>'finsbu',
	#'ptpost_client_secreet'=>'finsbu321!@#',
	'ptpost_client_secreet'=>'finsbu321!@#',
	#'ptpost_key'=>'f1ntechSBU@2018#',
	'ptpost_key'=>'b41a4f3909657f660fa313a44aa607c4',
	'finnet_endpoint'=>'https://demos.finnet.co.id/devofc/FinChannelServices/routeX2.php?wsdl',
	'finnet_username'=>'devlunari',
	'finnet_password'=>'devlunari',
	'finnet_merchant_code'=>'FNN778',
	'finnet_merchant_number'=>'+6281000111001',
	// 'mol_voucher_game_endpoint'=>'http://www.ayopay.com/h2h/voucher.aspx',
	// 'mol_msg_key'=>'4y0t35t1234',
	// 'mol_userid'=>'testh2h',
	'mol_voucher_game_endpoint'=>'http://www.ayopay.com/h2h/voucher.aspx',
	'mol_msg_key'=>'MYkWRmQrePRruDS',
	'mol_userid'=>'APH10062',

	//prod
	'finnet_endpoint_prod'=>'http://10.1.10.167:8800/h2h/FinChannelServices/routeX2-151.php?wsdl',
	'finnet_username_prod'=>'narindoLive',
	'finnet_password_prod'=>'narindo2017',
	'finnet_merchant_code_prod'=>'MCMEDM',
	'finnet_merchant_number_prod'=>'+628119886868',

	//PT Pos Price Maping prodcode => +/- price
	"p2001"=> 1100,
	"p2001"=> 1100,
	"p2047"=> 1100,
	"p2002"=> -2900,
	"p2002"=> -4350,
	"p2003"=> -3300,
	"p2004"=> -3850,
	"p2005"=> -3300,
	"p2007"=> -3300,
	"p2008"=> 1100,
	"p2009"=> -3900,
	"p2010"=> -4500,
	"p2011"=> -4400,
	"p2012"=> -2900,
	"p2013"=> 1100,
	"p2015"=> -4500,
	"p2016"=> -4400,
	"p2017"=> 1100,
	"p2020"=> -4400,
	"p2021"=> -4400,
	"p2022"=> -4400,
	"p2023"=> -3300,
	"p2026"=> -4400,
	"p2027"=> 1100,
	"p2028"=> -4400,
	"p2029"=> 1100,
	"p2030"=> -4400,
	"p2031"=> -4400,
	"p2032"=> -4400,
	"p2033"=> -4900,
	"p2035"=> -3300,
	"p2036"=> -3300,
	"p2037"=> -3300,
	"p2038"=> -3300,
	"p2018"=> -3300,
	"p2054"=> -4350,
	"p2014"=> -4400,
	"p2050"=> -3400,
	"p2052"=> 1650,
	"p2034"=> -4350,
	"p2049"=> 1100,
	"p2053"=> 1100,
	"p2048"=> -4400,
	"p2046"=> 1000,
	"p6012"=> -770,
	"p1001"=> -4350,
	"p1002"=> -4350,
	"p1003"=> -4250,
	"p9001"=> 1100,
	"p9007"=> (330+250), 
	"p9008"=> (330+250), 
	"p9009"=> (330+250), 
	"p9010"=> (330+250),
	"p9002"=> -1950,
	"p9004"=> -1950, 
	"p9005"=> -1950,
	"p2039"=> 1100,
	"p2040"=> 1100,
	"p2041"=> 1100,
	"p2042"=> 1100,
	"p2045"=> 1100,
	"p5001"=> 550,
	"p7015"=> 1100,
	"p7011"=> -2350,
	"p7003"=> -1400,
	"p7003"=> -3000,
	"p7003"=> -3900,
	"p7003"=> -5300,
	"p7003"=> -10500,
	"p7004"=> -3900,
	"p7005"=> -3900,
	"p7014"=> -1250,
	"p7014"=> -2500,
	"p7014"=> -4300,
	"p7014"=> -4650,
	"p7014"=> -7500,
	"p7014"=> -13400,
	"p7014"=> -16100,
	"p7014"=> -30100,
	"p7014"=> -34400,
	"p7014"=> -59200,
	"p7006"=> -3000,
	"p7012"=> -3900,
	"p7013"=> -3900,
	"p7010"=> -3300,
	"p3008"=> 220,
	"p3009"=> 220,
	"p3010"=> 1100,
	"finnet_status_maping"=>[
		'00'=>'1',
		'7066'=>'2',
		'7020'=>'3',
		'7107'=>'4',
		'7101'=>'5',
		'7136'=>'6',
		'7017'=>'11',
		'7011'=>'12',
		'7000'=>'13',
		'7065'=>'7',
		'7026'=>'8',
		'7133'=>'16',
		'7134'=>'17',
		'7050'=>'21',
	],
	'digisign_user_id' => 'ronald.handiwinata@narindo.com',
	'digisign_token' => 'adf5566596b509d71a68b4cd80837ffea5e42f155d4b6d79b53cc4a472cdfde549b',
	'digisign_baseUrl' => 'https://api.tandatanganku.com/',
	'digisign_pwd' => 'kimo123',
	'indomog_baseUrl' =>'https://dev.indomog.com/indomog2/new_core/index.php/h2h_rpc/server',
	'indomog_RMID' => '0910403545',
	'indomog_alg' => 'Alg',
	'indomog_secret_key'=>'123456'
];
