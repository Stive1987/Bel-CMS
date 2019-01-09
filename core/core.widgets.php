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

class Widgets
{
	var $vars = array();
	var $widgets = null;

	function __construct () {

		if (isset($this->models)){
			foreach($this->models as $v){
				$this->loadModel($v);
			}
		}
	}

	function set ($d) {
		$this->vars = array_merge($this->vars,$d);
	}

	public function render ($filename)
	{
		extract($this->vars);
		ob_start();
		$str = str_replace('Widget', '', get_class($this));
		$dir = DIR_WIDGETS.strtolower($str).DS.$filename.'.php';
		if (is_file($dir)) {
			include $dir;
		} else {
			Notification::Error ('file : '.$filename.' no found', 'Error File !');
		}
		$this->widgets = ob_get_contents();
		if (ob_get_length() != 0) {
			ob_end_clean();
		}
		return $this->widgets;
	}

	function loadModel ($name)
	{
		$str = str_replace('Widget', '', get_class($this));
		if (is_file(DIR_WIDGETS.strtolower($str).DS.'models.php')) {
			require_once DIR_WIDGETS.strtolower($str).DS.'models.php';
			$this->$name = new $name();
		} else {
			ob_start();
			Notification::Error ('file models no found<br>'.DIR_WIDGETS.get_class($this).DS.'models.php', 'Error File !');
			$this->widgets = ob_get_contents();
			if (ob_get_length() != 0) {
				ob_end_clean();
			}
		}
	}

	protected static function getWidgetsPos ($pos = null)
	{
		if ($pos !== null) {
			$sql = New BDD();
			$sql->table('TABLE_WIDGETS');
			$where[] = array('name' => 'activate', 'value' => 1);
			$where[] = array('name' => 'pos', 'value' => $pos);
			$sql->where($where);
			$sql->orderby(array('name' => 'orderby', 'value' => 'ASC'));
			$sql->queryAll();

			return $sql->data;
		}
	}

	protected static function getControllers ($pos = null)
	{
		$widgets = array();

		$sql = self::getWidgetsPos ($pos);

		foreach ($sql as $k => $v) {
			$dir = DIR_WIDGETS.$v->name.DS.'controller.php';
			if (is_file($dir)) {
				$title = !empty($v->title) ? $v->title : $v->name;
				require_once $dir;
				$controller = 'Widget'.ucfirst($v->name);
				$widget = new $controller;
				$widget->index();
				$widgets[$title] = $widget->widgets;

			}
		}
		return $widgets;
	}

	public static function getAllWidgets($pos = null)
	{
		$tplWidgets = self::renderExtWidgts($pos);
		echo $tplWidgets;
	}

	public static function GetWidget($name = null, $pos = null)
	{
		if (empty($name)) {
			Notification::error('Aucun nom de widgets');
		} else {
			$sql = New BDD();
			$sql->table('TABLE_WIDGETS');
			$sql->where(array('name' => 'name', 'value' => $name));
			$sql->queryOne();
		}

		if ($sql->rowCount == 0) {
			Notification::error('Aucun Widget portant ce nom');
		}

		$data = $sql->data;

		ob_start();

		$dir = DIR_WIDGETS.$data->name.DS.'controller.php';

		if (is_file($dir)) {
			require_once $dir;
			$title = !empty($data->title) ? $data->title : $v->name;
			require_once $dir;
			$controller = 'Widget'.ucfirst($data->name);
			$widget = new $controller;
			$widget->index();
			$widgets[$title] = $widget->widgets;
		}	

		if ($pos === null) {
			$dir = DIR_ASSET.'widgets'.DS.'widgets.static.tpl';
		} else if ($pos == 'right' or $pos == 'top' or $pos == 'bottom' or $pos == 'top') {
			switch ($pos) {
				case 'top':
					$dir = DIR_ASSET.'widgets'.DS.'widgets.top.tpl';
					break;

				case 'bottom':
					$dir = DIR_ASSET.'widgets'.DS.'widgets.bottom.tpl';
					break;

				case 'left':
					$dir = DIR_ASSET.'widgets'.DS.'widgets.left.tpl';
					break;

				case 'right':
					$dir = DIR_ASSET.'widgets'.DS.'widgets.right.tpl';
					break;

				default:
					$dir = DIR_ASSET.'widgets'.DS.'widgets.static.tpl';
					break;
			}
		}

		$title   = $title;
		$content = $widgets[$title];
		require $dir;

		$widgets = ob_get_contents();
		if (ob_get_length() != 0) {
			ob_end_clean();
		}
		echo $widgets;
	}

	public static function getController ($pos = null)
	{
		$widgets = array();

		$sql = self::getWidgetsPos ($pos);

		foreach ($sql as $k => $v) {
			$dir = DIR_WIDGETS.$v->name.DS.'controller.php';
			if (is_file($dir)) {
				$title = !empty($v->title) ? $v->title : $v->name;
				require_once $dir;
				$controller = 'Widget'.ucfirst($v->name);
				$widget = new $controller;
				$widget->index();
				$widgets[$title] = $widget->widgets;
			}
		}
		return $widgets;
	}

	protected static function renderExtWidgts ($pos = null)
	{
		ob_start();

		if ($pos != null) {
			if ($pos = 'right') {
				foreach (self::getControllers($pos) as $k => $v) {
					$dir = DIR_ASSET.'widgets'.DS.'widgets.right.tpl';
					if (is_file($dir)) {
						$title = $k;
						$content = $v;
						require $dir;
					}
				}
			} else if ($pos = 'left') {
				foreach (self::getControllers($pos) as $k => $v) {
					$dir = DIR_ASSET.'widgets'.DS.'widgets.left.tpl';
					if (is_file($dir)) {
						$title = $k;
						$content = $v;
						require $dir;
					}
				}
			} else if ($pos = 'top') {
				foreach (self::getControllers($pos) as $k => $v) {
					$dir = DIR_ASSET.'widgets'.DS.'widgets.top.tpl';
					if (is_file($dir)) {
						$title = $k;
						$content = $v;
						require $dir;
					}
				}
			} else if ($pos = 'bottom') {
				foreach (self::getControllers($pos) as $k => $v) {
					$dir = DIR_ASSET.'widgets'.DS.'widgets.bottom.tpl';
					if (is_file($dir)) {
						$title = $k;
						$content = $v;
						require $dir;
					}
				}
			} else {
				foreach (self::getControllers(null) as $k => $v) {
					$dir = DIR_ASSET.'widgets'.DS.'widgets.static.tpl';
					if (is_file($dir)) {
						$title = $k;
						$content = $v;
						require $dir;
					}
				}	
			}
		}
		$widgets = ob_get_contents();
		if (ob_get_length() != 0) {
			ob_end_clean();
		}
		return $widgets;
	}
}