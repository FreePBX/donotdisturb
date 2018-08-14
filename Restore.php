<?php
namespace FreePBX\modules\Donotdisturb;
use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
  public function runRestore($jobid){
    $configs = $this->getConfigs();
    $dnd = $this->FreePBX->Donotdisturb;
    /**
     * Clear existing
     */
    foreach($dnd->getAllStatuses() as $key => $value){
        $dnd->setStatusByExtension(str_replace('/DND/', '', $key));
    }
    foreach($configs as $key => $value){
        $dnd->setStatusByExtension(str_replace('/DND/', '', $key), $value);
    }
  }
  public function processLegacy($pdo, $data, $tables, $unknownTables, $tmpfiledir){
    $dnd = $this->FreePBX->Donotdisturb;
    $astdb = $this->getAstDb($tmpfiledir . '/astdb');
    if (!isset($astdb['DND'])) {
      return $this;
    }
    foreach ($astdb['DND'] as $key => $value) {
      $dnd->setStatusByExtension(str_replace('/DND/', '', $key), $value);
    }
  }
}
