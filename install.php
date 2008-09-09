<?php

// Register FeatureCode - Activate
$dndactivate = _("DND Activate");
$fcc = new featurecode('donotdisturb', 'dnd_on');
$fcc->setDescription($dndactivate);
$fcc->setDefault('*78');
$fcc->update();
unset($fcc);

// Register FeatureCode - Deactivate
$dnddeactivate = _("DND Deactivate");
$fcc = new featurecode('donotdisturb', 'dnd_off');
$fcc->setDescription($dnddeactivate);
$fcc->setDefault('*79');
$fcc->update();
unset($fcc);	

// Register FeatureCode - Activate
$dndtoggle = _("DND Toggle");
$fcc = new featurecode('donotdisturb', 'dnd_toggle');
$fcc->setDescription($dndtoggle);
$fcc->setDefault('*76');
$fcc->update();
unset($fcc);

?>
