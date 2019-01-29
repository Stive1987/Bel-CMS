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
?>
<div class="nk-widget nk-widget-highlighted">
	<h4 class="nk-widget-title"><span>5 Dernier Connectés</span></h4>
	<div class="nk-widget-content">
		<div id="bel_cms_widgets_lastconnected" class="widget">
			<ul>
				<?php
				foreach ($last as $k => $v):
					?>
					<li>
						<img src="<?=$v->avatar?>" alt="avatar_<?=$v->username?>">
						<span>
							<p><?=$v->username?></p>
							<p><?=Common::transformDate($v->last_visit, true, 'd M Y # H:i') ?></p>
						</span>
					</li>
				<?php
				endforeach;
				?>
			</ul>
		</div>
	</div>
</div>
