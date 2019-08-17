<?php
namespace FreePBX\modules\Donotdisturb;
use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
	public function runRestore(){
		$configs = $this->getConfigs();
		$dnd = $this->FreePBX->Donotdisturb;
		/**
		 * Clear existing
		 */
		foreach($dnd->getAllStatuses() as $key => $value){
				$dnd->setStatusByExtension(str_replace('/DND/', '', $key));
		}
		foreach($configs['astdb'] as $key => $value){
				$dnd->setStatusByExtension(str_replace('/DND/', '', $key), $value);
		}
		$this->importFeatureCodes($configs['features']);
	}
	public function processLegacy($pdo, $data, $tables, $unknownTables){
		$dnd = $this->FreePBX->Donotdisturb;
		$astdb = $data['astdb'];
		if (!isset($astdb['DND'])) {
			return;
		}
		foreach ($astdb['DND'] as $key => $value) {
			$dnd->setStatusByExtension(str_replace('/DND/', '', $key), $value);
		}
		$this->restoreLegacyFeatureCodes($pdo);
	}
}
