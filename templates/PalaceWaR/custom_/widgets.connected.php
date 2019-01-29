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
	<h4 class="nk-widget-title"><span><?=$this->title ?></span></h4>
	<div class="nk-widget-content">
		<div id="bel_cms_widgets_connected" class="widget">
			<ul>
				<li>
					<span class="col-md-7">Hier</span>
					<span class="col-md-5"><strong><?=Visitors::getVisitorYesterday()->count?></strong></span>
				</li>
				<li>
					<span class="col-md-7">Aujourd'hui</span>
					<span class="col-md-5"><strong><?=Visitors::getVisitorDay()->count?></strong></span>
				</li>
				<li>
					<span class="col-md-7">Maintennant</span>
					<span class="col-md-5"><strong><?=Visitors::getVisitorConnected()->count?></strong></span>
				</li>
				<li>
					<ul id="getVisitorConnected">
						<?php
						$i = 0;
						foreach (Visitors::getVisitorConnected()->data as $k => $v):
							$visitor = autoUser::getNameAvatar($v->visitor_user) !== false ? autoUser::getNameAvatar($v->visitor_user)->username : 'Bot';
						autoUser::getNameAvatar($v->visitor_user)
							?>
							<li>
								<span class="col-md-7"><?=Common::truncate($visitor, 20)?></span>
								<span class="col-md-5" style="text-align: right;"><?=$v->visitor_page?></span>
							</li>
							<?php
							if ($i++ == 5) {
								break;
							}
						endforeach;
						?>
					</ul>
				</li>
			</ul>

		</div>
	</div>
</div>
