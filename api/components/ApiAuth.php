<?php

namespace api\components;

use yii\filters\auth\AuthMethod;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class ApiAuth extends AuthMethod
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
		$username = $request->post('username');
		$password = $request->post('password');

		if ($username !== null && $password !== null) {
			$identity = call_user_func($this->auth, $username, $password);
			if ($identity !== null) {
				$user->switchIdentity($identity);
			} else {
				$this->handleFailure($response);
			}
			return $identity;
		}

		return null;
	}
}