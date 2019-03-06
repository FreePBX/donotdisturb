<?php
namespace FreePBX\modules\Donotdisturb;
use FreePBX\modules\Backup as Base;
class Backup Extends Base\BackupBase{
	public function runBackup($id,$transaction){
		$configs = [
			'astdb' => $this->FreePBX->Donotdisturb->getAllStatuses(),
			'features' => $this->dumpFeatureCodes()
		];
		$this->addConfigs($configs);
	}
}
