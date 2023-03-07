<?php

namespace api\components;

use Yii;
use yii\filters\auth\HttpBearerAuth;

class ApiHttpBearerAuth extends HttpBearerAuth
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
		$authHeader = $request->getHeaders()->get('Authorization');
		if ($authHeader !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
			
			$user = Yii::$app->user;

			$identity = $user->loginByAccessToken($matches[1]);
			if ($identity === null) {
				$this->handleFailure($response);
			}
			return $identity;
		}

		return null;
	}
}