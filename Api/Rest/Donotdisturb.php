<?php
namespace FreePBX\modules\Donotdisturb\Api\Rest;
use FreePBX\modules\Api\Rest\Base;
class Donotdisturb extends Base {
	protected $module = 'donotdisturb';
	public function setupRoutes($app) {

		/**
		* @verb GET
		* @return - a list of users' donotdisturb settings
		* @uri /donotdisturb/users
		*/
		$app->get('/users', function ($request, $response, $args) {
			\FreePBX::Modules()->loadFunctionsInc('donotdisturb');
			$response->getBody()->write(json_encode(donotdisturb_get()));
			return $response->withHeader('Content-Type', 'application/json');
		})->add($this->checkAllReadScopeMiddleware());

		/**
		* @verb GET
		* @returns - a users' donotdisturb settings
		* @uri /donotdisturb/users/:id
		*/
		$app->get('/users/{id}', function ($request, $response, $args) {
			\FreePBX::Modules()->loadFunctionsInc('donotdisturb');
			$response->getBody()->write(json_encode(array('status' => donotdisturb_get($args['id'] ?? ''))));
			return $response->withHeader('Content-Type', 'application/json');
		})->add($this->checkAllReadScopeMiddleware());

		/**
		* @verb PUT
		* @uri /donotdisturb/users/:id
		*/
		$app->put('/users/{id}', function ($request, $response, $args) {
			\FreePBX::Modules()->loadFunctionsInc('donotdisturb');
			$params = $request->getParsedBody();
			donotdisturb_set($args['id'], $params['status']);
			$response->getBody()->write(json_encode(true));
			return $response->withHeader('Content-Type', 'application/json');
		})->add($this->checkAllWriteScopeMiddleware());
	}
}
