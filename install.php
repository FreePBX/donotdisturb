<?php

// Register FeatureCode - Activate
$fcc = new featurecode('donotdisturb', 'dnd_on');
$fcc->setDescription('DND Activate');
$fcc->setDefault('*78');
$fcc->update();
unset($fcc);

// Register FeatureCode - Deactivate
$fcc = new featurecode('donotdisturb', 'dnd_off');
$fcc->setDescription('DND Deactivate');
$fcc->setDefault('*79');
$fcc->update();
unset($fcc);	

// Register FeatureCode - Activate
$fcc = new featurecode('donotdisturb', 'dnd_toggle');
$fcc->setDescription('DND Toggle');
$fcc->setDefault('*0078');
$fcc->update();
unset($fcc);

?>
