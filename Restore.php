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
}
