<?php
/**
 * This is the User Control Panel Object.
 *
 * Copyright (C) 2013 Schmooze Com, INC
 * Copyright (C) 2013 Andrew Nagy <andrew.nagy@schmoozecom.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package   FreePBX UCP BMO
 * @author   Andrew Nagy <andrew.nagy@schmoozecom.com>
 * @license   AGPL v3
 */
namespace UCP\Modules;
use \UCP\Modules as Modules;

class Donotdisturb extends Modules{
	protected $module = 'Donotdisturb';

	function __construct($Modules) {
		$this->Modules = $Modules;
	}

	public function getSettingsDisplay($ext) {
		$out[] = array(
			"title" => _('Do Not Disturb'),
			"content" => 'Ok Content!',
			"size" => 6
		);
		return $out;
	}

	private function getStatus($ext) {
			global $astman;

        $result = false;
        if ($extension) {
		$result = $astman->database_get("DND", $extension);
	} else {
		$result = $astman->database_show("DND");
	}

	return $result;
	}
}
