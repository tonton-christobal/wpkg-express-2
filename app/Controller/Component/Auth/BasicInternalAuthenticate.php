<?php
/**
 * This file is the authentication component file of the application
 *  uses Basic Authentication for protect XML output.
 *
 * This file is part of wpkgExpress II.
 *
 * wpkgExpress II is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * wpkgExpress II is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with wpkgExpress II. If not, see <https://www.gnu.org/licenses/>.
 *
 * wpkgExpress II: A web-based frontend to WPKG.
 *  Based on wpkgExpress by Brian White.
 * @copyright Copyright 2009, Brian White.
 * @copyright Copyright 2018, Andrey Klimov.
 * @package app.Controller.Component.Auth
 */

App::uses('BasicAuthenticate', 'Controller/Component/Auth');
App::uses('ClassRegistry', 'Utility');

/**
 * Basic Authentication.
 *
 * @package app.Controller.Component.Auth
 */
class BasicInternalAuthenticate extends BasicAuthenticate {

/**
 * Find a user record using the standard options.
 *
 * @param string|array $username The username/identifier, or an array of find conditions.
 * @param string $password The password, only used if $username param is string.
 * @return bool|array Either false on failure, or an array of user data.
 */
	protected function _findUser($username, $password = null) {
		if (empty($username) || !is_string($password) || empty($password)) {
			$this->passwordHasher()->hash($password);
			return false;
		}

		$modelSetting = ClassRegistry::init('Setting');
		$cfgUser = $modelSetting->getConfig('XmlAuthUser');
		$cfgPass = $modelSetting->getConfig('XmlAuthPassword');
		if (empty($cfgUser) || empty($cfgPass)) {
			$this->passwordHasher()->hash($cfgPass);
			return false;
		}

		if (strcmp($cfgUser, $username) !== 0) {
			return false;
		}

		if (strcmp($cfgPass, $password) !== 0) {
			return false;
		}

		$user = $username;
		$role = USER_ROLE_USER | USER_ROLE_EXPORT;
		$prefix = null;

		return compact('user', 'role', 'prefix');
	}

}
