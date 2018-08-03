<?php

namespace FreePBX\modules\Donotdisturb\Api\Gql;

use GraphQL\Type\Definition\Type;
use FreePBX\modules\Api\Gql\Base;

class Donotdisturb extends Base {
	protected $module = 'donotdisturb';

	public function postInitializeTypes() {
		if($this->checkAllReadScope()) {
			$user = $this->typeContainer->get('coreuser');

			$user->addFieldCallback(function() {
				return [
					'donotdisturb' => [
						'type' => Type::boolean(),
						'description' => 'Turn off/on Do Not Disturb',
						'resolve' => function($user) {
							if(!isset($user['extension'])) {
								return null;
							}
							return $this->freepbx->Donotdisturb->getStatusByExtension($user['extension']) === "YES";
						}
					]
				];
			});
		}
	}
}
