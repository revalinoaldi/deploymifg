<?php

namespace api\components;

use Yii;
use yii\base\InvalidConfigException;
use yii\filters\auth\AuthInterface;
use yii\filters\auth\AuthMethod;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class ApiCompositeAuth extends CompositeAuth
{
	/**
	 * @see yii\filters\auth\*Auth
	 */
	public $auth;

	/**
	 * @inheritdoc
	 */
	public function authenticate($user, $request, $response)
	{
		foreach ($this->authMethods as $i => $auth) {
			if (!$auth instanceof AuthInterface) {
				$this->authMethods[$i] = $auth = Yii::createObject($auth);
				if (!$auth instanceof AuthInterface) {
					throw new InvalidConfigException(get_class($auth) . ' must implement yii\filters\auth\AuthInterface');
				}
			}

			$identity = $auth->authenticate($user, $request, $response);
			if ($identity !== null) {
				return $identity;
			}
		}

		return null;
	}

	/**
	 * @inheritdoc
	 */
	public function challenge($response)
	{
		foreach ($this->authMethods as $method) {
			// var_dump($method); die(); //string(32) "api\components\ApiHttpBearerAuth"
			/** @var $method AuthInterface */
			$method->challenge($response);
		}
	}
}