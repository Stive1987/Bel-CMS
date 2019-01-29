<?php
/**
 * Bel-CMS [Content management system]
 * @version 0.0.3
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
if ($last !== null):
?>
<div id="bel_cms_widgets_lastconnected" class="card bel_cms_widgets">
	<div class="panel-group">
		<div class="card-header"><h3 class="card-title"><?=$this->title ?></h3></div>
		<div class="card-body">
			<ul>
				<?php
				foreach ($last as $k => $v):
					?>
					<li>
						<img data-toggle="tooltip" title="<?=$v->username?>" src="<?=$v->avatar?>" alt="avatar_<?=$v->username?>" style="max-width: 50px; max-height: 50px;">
						<span>
							<p><?=$v->username?></p>
							<p><?=Common::transformDate($v->last_visit, 'MEDIUM', 'SHORT') ?></p>
						</span>
					</li>
				<?php
				endforeach;
				?>
			</ul>
		</div>
	</div>
</div>
<?php
endif;
