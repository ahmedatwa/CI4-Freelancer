<?php
namespace Install\Models;

use CodeIgniter\Model;

class InstallModel extends Model {
	
	public function database($data) {
		$custom = [
		    'DSN'      => '',
		    'hostname' => $data['db_hostname'],
		    'username' => $data['db_username'],
		    'password' => $data['db_password'],
		    'database' => $data['db_database'],
		    'DBDriver' => $data['db_driver'],
		    'DBPrefix' => $data['db_driver'],
		    'pConnect' => TRUE,
		    'DBDebug'  => TRUE,
		    'charset'  => 'utf8',
		    'DBCollat' => 'utf8_general_ci',
		    'swapPre'  => '',
		    'encrypt'  => FALSE,
		    'compress' => FALSE,
		    'strictOn' => FALSE,
		    'failover' => [],
		    'port'     => $data['db_port']
        ];

        $db = \Config\Database::connect($custom);

		$file = ROOTPATH . 'install/ci4.sql';

		if (!file_exists($file)) {
			exit('Could not load sql file: ' . $file);
		}

		$lines = file($file);

		if ($lines) {
			$sql = '';

			foreach($lines as $line) {
				if ($line && (substr($line, 0, 2) != '--') && (substr($line, 0, 1) != '#')) {
					$sql .= $line;

					if (preg_match('/;\s*$/', $line)) {
						$sql = str_replace("DROP TABLE IF EXISTS `ci_", "DROP TABLE IF EXISTS `" . $data['db_prefix'], $sql);
						$sql = str_replace("CREATE TABLE `ci_", "CREATE TABLE `" . $data['db_prefix'], $sql);
						$sql = str_replace("INSERT INTO `ci_", "INSERT INTO `" . $data['db_prefix'], $sql);

						$db->query($sql);

						$sql = '';
					}
				}
			}

			helper('text');

			$db->query("SET CHARACTER SET utf8");

			$db->query("SET @@session.sql_mode = 'MYSQL40'");

			$db->query("DELETE FROM `" . $data['db_prefix'] . "user` WHERE user_id = '1'");

			$db->query("INSERT INTO `" . $data['db_prefix'] . "user` SET user_id = '1', user_group_id = '1', username = " . $db->escape($data['username']) . ", salt = " . $db->escape($salt = random_string('alnum', 9)) . ", password = " . $db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . ", firstname = 'John', lastname = 'Doe', email = " . $db->escape($data['email']) . ", status = '1', date_added = NOW()");

			$db->query("DELETE FROM `" . $data['db_prefix'] . "setting` WHERE `name` = 'config_email'");
			$db->query("INSERT INTO `" . $data['db_prefix'] . "setting` SET `code` = 'config', `name` = 'config_email', setting = " . $db->escape($data['email']) . "");
			
		}
	}
}
