<?php
/**
 * Bel-CMS [Content management system]
 * @version 0.0.1
 * @link https://bel-cms.be
 * @link https://stive.eu
 * @license http://opensource.org/licenses/GPL-3.0 copyleft
 * @copyright 2014-2019 Bel-CMS
 * @author Stive - determe@stive.eu
 */

if (!defined('CHECK_INDEX')) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit(ERROR_INDEX);
}

final class Secures
{
	#########################################
	# Accès au page via les groupes
	#########################################
	public static function getAccessPage ($page = null)
	{
		if ($page === null) {
			return false;
		} else {
			$bdd = self::accessSqlPages($page);
			if (in_array(0, $bdd[$page]->access_groups)) {
				return true;
			} else {
				foreach ($bdd[$page]->access_groups as $k => $v) {
					if (in_array($v, self::accessSqlUser()[$_SESSION['USER']['HASH_KEY']]->access)) {
						return true;
						break;
					} else {
						return false;
					}
				}
			}
		}
	}
	#########################################
	# Accès aux page si activer
	#########################################
	public static function getPageActive ($page) 
	{
		$bdd = self::accessSqlPages($page);
		if ($bdd[$page]->active == 1) {
			return true;
		} else {
			return false;
		}
	}
	#########################################
	# BDD Complet de la page demandé
	#########################################
	public static function accessSqlPages ($name)
	{
		$sql = New BDD();
		$sql->table('TABLE_PAGES_CONFIG');
		$sql->where(array('name' => 'name', 'value' => $name));
		$sql->queryAll();
		if (empty($sql->data)) {
			$return = false;
		} else {
			$return = $sql->data;
			foreach ($return as $k => $v) {
				$return[$v->name] = $v;
				$return[$v->name]->access_groups = explode('|', $return[$v->name]->access_groups);
				$return[$v->name]->access_admin  = explode('|', $return[$v->name]->access_admin);
				if (!empty($v->config)) {
					$return[$v->name]->config = Common::transformOpt($return[$v->name]->config);
				} else {
					unset($return[$v->name]->config);
				}
				unset($return[$k], $return[$v->name]->name);
			}
		}
		return $return;
	}
	#########################################
	# Accès uniquement aux groupes et au 
	# groupe principal (assemblé) 
	# securisé par le hash_key
	#########################################
	public static function accessSqlUser ()
	{
		$return = false;

		if (isset($_SESSION['USER']['HASH_KEY']) and !empty($_SESSION['USER']['HASH_KEY'])) {
			$sql = New BDD();
			$sql->table('TABLE_USERS');
			$sql->where(array('name' => 'hash_key', 'value' => $_SESSION['USER']['HASH_KEY']));
			$sql->fields(array('hash_key', 'groups', 'main_groups'));
			$sql->isObject('false');
			$sql->queryOne();
			if (empty($sql->data)) {
				$return = false;
			} else {
				$return[$sql->data['hash_key']] = (object) $sql->data;
				unset($return[$sql->data['hash_key']]->hash_key);
				$return[$sql->data['hash_key']]->groups = explode('|', $sql->data['groups']);
				$return[$sql->data['hash_key']]->main_groups = explode('|', $sql->data['main_groups']);

				$return[$sql->data['hash_key']]->access = array_merge($return[$sql->data['hash_key']]->main_groups, $return[$sql->data['hash_key']]->groups);
				$return[$sql->data['hash_key']]->access = array_unique($return[$sql->data['hash_key']]->access);

				unset($return[$sql->data['hash_key']]->groups, $return[$sql->data['hash_key']]->main_groups);
			}
		}

		return $return;
	}

}
