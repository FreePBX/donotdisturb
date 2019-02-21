<?php
namespace FreePBX\modules\Donotdisturb;
use FreePBX\modules\Backup as Base;
class Backup Extends Base\BackupBase{
  public function runBackup($id,$transaction){

    $configs = $this->FreePBX->Donotdisturb->getAllStatuses();
    $this->addConfigs($configs);
  }
}
