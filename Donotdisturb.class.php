<?php
// vim: set ai ts=4 sw=4 ft=php:

class Donotdisturb implements BMO {

	public function __construct($freepbx = null) {
		if ($freepbx == null) {
			throw new Exception("Not given a FreePBX Object");
		}

		$this->FreePBX = $freepbx;
		$this->db = $freepbx->Database;
	}

	public function doConfigPageInit($page) {

	}

	public function install() {}
	public function uninstall() {}

	public function genConfig() {}

	public function getAllStatuses() {
		return $this->FreePBX->astman->database_show('DND');
	}

	public function getStatusByExtension($extension) {
		return $this->FreePBX->astman->database_get('DND', $extension);
	}

	public function setStatusByExtension($extension, $state = '') {
		if ($state != "") {
			$ret = $this->FreePBX->astman->database_put('DND',$extension,$state);
			$value_opt = 'BUSY';
		} else {
			$ret = $this->FreePBX->astman->database_del('DND',$extension);
			$value_opt = 'UNAVAILABLE';
		}

		if ($this->FreePBX->Config->get_conf_setting('USEDEVSTATE')) {
			$AST_FUNC_DEVICE_STATE = $this->FreePBX->Config->get_conf_setting('AST_FUNC_DEVICE_STATE');
			$devices = $this->FreePBX->astman->database_get("AMPUSER", $extension . "/device");
			$device_arr = explode('&', $devices);
			foreach ($device_arr as $device) {
				$ret = $this->FreePBX->astman->set_global($AST_FUNC_DEVICE_STATE . "(Custom:DEVDND$device)", $value_opt);
			}
			// And also handle the state associated with the user
			$ret = $this->FreePBX->astman->set_global($AST_FUNC_DEVICE_STATE . "(Custom:DND$extension)", $value_opt);
		}
		return $ret;
	}

	/* UCP template to get the user assigned vm extension details
	* @defaultexten is the default_extensionof the userman userid
	* @userid is userman user id
	* @widget is an array we need to replace few item based on the userid
	*/
	public function getWidgetListByModule($defaultexten, $userid,$widget) {
		// if the widget_type_id is not defaultextension and widget_type_id is not in extensions
		// then return only the defaultexten details
		$widgets = array();
		$widget_type_id = $widget['widget_type_id'];// this will be an extension number
		$extensions = $this->FreePBX->Ucp->getCombinedSettingByID($userid,'Settings','assigned');
		if(in_array($widget_type_id,$extensions)){
			// nothing to do return the same widget
			return $widget;
		}else {// sent the default extension
			$data = $this->FreePBX->Core->getDevice($defaultexten);
			if(empty($data) || empty($data['description'])) {
				$data = $this->FreePBX->Core->getUser($defaultexten);
				$name = $data['name'];
			} else {
				$name = $data['description'];
			}
			$widget['widget_type_id'] = $defaultexten;
			$widget['name'] = $name;
			return $widget;
		}
		return false;
	}
}
