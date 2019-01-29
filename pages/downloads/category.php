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
<h1 class="bel-cms_title_page"><span><?=$name?></span></h1>
<?php
if (count($dls) > 0):
?>
<div id="bel_cms_downloads_index_table" class="table-responsive">
	<table class="table table-hover table-bordered">
		<thead>
			<tr>
				<th><?=NAME?></th>
				<th><?=DOWNLOAD?> <span class="hidden-xs">| <?=SIZE?></span></th>
				<th class="hidden-xs"><?=DATE?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($dls as $k => $v):
			?>
			<tr>
				<td><a href="Downloads/Detail/<?=$v->id?>"><?=$v->name?></td>
				<td>
					<a class="alertAjaxLink" href="Downloads/GetFile/<?=$v->id?>&jquery">
						<i class="fa fa-download" aria-hidden="true"></i>
						<?=DOWNLOAD?>
					</a><span class="hidden-xs"> | (<?=$v->size?>) <?=SIZE?></span>
				</td>
				<td class="hidden-xs"><?=Common::transformDate($v->insert_date, true, 'd-M-Y # H:i')?></td>
			</tr>
			<?php
			endforeach;
			?>
		</tbody>
	</table>
</div>
<?php
endif;