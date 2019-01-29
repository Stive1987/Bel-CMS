<?php
/**
 * Bel-CMS [Content management system]
 * @version 0.0.1
 * @link http://www.bel-cms.be
 * @link http://www.stive.eu
 * @license http://opensource.org/licenses/GPL-3.0 copyleft
 * @copyright 2014-2016 Bel-CMS
 * @author Stive - mail@stive.eu
 */

if (!defined('CHECK_INDEX')) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit(ERROR_INDEX);
}

class Downloads extends Pages
{
	var $models = array('ModelsDownloads');

	public function index ()
	{
		$d['cat'] = $this->ModelsDownloads->GetCat();
		foreach ($d['cat'] as $k => $v) {
			if (!in_array(0, $v->groups) && $_SESSION['user']->groups == 1) {
				foreach ($v->groups as $kg => $vg) {
					if (!in_array($vg, $_SESSION['user']->groups)) {
						unset($d['dls'][$k]);
					}
				}
			}
		}
		$d['dls'] = $this->ModelsDownloads->GetDlNoGroup();
		foreach ($d['dls'] as $k => $v) {
			if (!in_array(0, $v->groups) && $_SESSION['user']->groups == 1) {
				foreach ($v->groups as $kg => $vg) {
					if (!in_array($vg, $_SESSION['user']->groups)) {
						unset($d['dls'][$k]);
					}
				}
			}
		}
		$this->set($d);
		$this->render('index');
	}

	public function category ($id = null)
	{
		if ($id !== null && is_numeric($id)) {
			$id = (int) $id;
			$d['name'] = $this->ModelsDownloads->GetNameCat($id);
			$d['dls'] = $this->ModelsDownloads->GetDl($id);
				if (count($d['dls']) > 0) {
				foreach ($d['dls'] as $k => $v) {

					if (strpos($v->link, 'https://') > 0 or strpos($v->link, 'http://') > 0) {
						$d['dls'][$k]->size   = $v->size;
					} else {
						$d['dls'][$k]->size   = Common::ConvertSize(filesize($d['dls']->link));
					}

					if (!in_array(0, $v->groups) && $_SESSION['user']->groups == 1) {
						foreach ($v->groups as $kg => $vg) {
							if (!in_array($vg, $_SESSION['user']->groups)) {
								unset($d['dls'][$k]);
							}
						}
					}
				}
				$this->set($d);
				$this->render('category');
			} else {
				$this->error(INFO, 'Aucun téléchargement dans cette catégorie', 'info');
			}
		} else {
			$this->error(ERROR, 'La catégorie choisi n\'est pas valide');
		}
	}

	public function Getfile ($id = null)
	{
		if ($id !== null && is_numeric($id)) {
			$id = (int) $id;

			if (self::testAccessDls($id) === true) {
				$return = $this->ModelsDownloads->GetDetail($id);
				$this->ModelsDownloads->addClick($id);
				$this->jquery(array('type' => 'green', 'text' => 'Redirection en cours...', 'redirect' => $return->link));
			} else {
				$this->jquery(array('type' => 'red', 'text' => NO_ACCESS_GROUP_PAGE));
			}
		} else {
			$this->error(ERROR, 'ID incorrecte !');
		}
	}

	private function testAccessDls ($id = null)
	{
		$return = false;

		if ($id !== null && is_numeric($id)) {
			$id = (int) $id;
			$return = $this->ModelsDownloads->GetDetail($id);

			if ($return->groups == 0 or $_SESSION['user']->groups == 1) {
				return true;
			}

			$accessGroups = explode('|', $return->groups);

			foreach ($accessGroups as $k => $v) {
				if (in_array($v, $_SESSION['user']->groups)) {
					$return = true;
					break;
				}
			}
			return $return;
		}
	}

	public function Detail ($id = null)
	{
		if ($id !== null && is_numeric($id)) {
			$id = (int) $id;
			$d['dls'] = $this->ModelsDownloads->GetDetail($id);

			$d['dls']->groups = explode('|', $d['dls']->groups);
			$d['dls']->hash = md5($d['dls']->link);

			if (strpos($d['dls']->link, 'https://') > 0 or strpos($d['dls']->link, 'http://') > 0) {
				$d['dls']->size   = $d['dls']->size;
				$d['dls']->intern = false;
			} else {
				$d['dls']->intern = true;
				$d['dls']->size   = Common::ConvertSize(filesize($d['dls']->link));
			}

			$d['dls']->ext = mime_content_type($d['dls']->link);

			if (empty($d['dls']->ext)) {
				$d['dls']->ext = 'Inconnu';
			}

			$this->ModelsDownloads->addView($id);

			$this->set($d);
			$this->render('detail');
		} else {
			$this->error(ERROR, 'ID incorrecte !');
		}
	}
}
