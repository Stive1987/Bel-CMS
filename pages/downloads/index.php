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
<h1 class="bel-cms_title_page"><span><?=DOWNLOADS?></span></h1>
<section id="bel_cms_downloads_index" class="padding-bottom-60">
	<?php
	if (count($cat) > 0):
	?>
	<p class="bel-cms_subtitle_page"><?=CAT?></p>
	<?php
	foreach ($cat as $k => $v):
	?>
	<div class="row bel_cms_downloads_index_cat">
		<div class="bel_cms_downloads_index_cat_img hidden-xs">
			<?php
			echo !empty($v->icon) ? '<img src="'.$v->icon.'" alt="'.$v->name.'">' : '';
			?>
		</div>
		<div class="bel_cms_downloads_index_cat_name">
			<div class="col-sm-6">
				<div>
					<a href="Downloads/Category/<?=$v->id?>"><?=$v->name?></a>
				</div>
				<?php
				echo empty($v->description) ? '' : '<span class="bel_cms_downloads_index_cat_desc">'.$v->description.'</span>';
				?>
			</div>
			<div class="col-sm-6 hidden-xs" style="height: 75px;text-align: center;">
				<span style="display: block; font-weight: bold; line-height: 20px; margin-top: 15px;">Nombre de fichier</span>
				<span style="display: block; font-style: italic; line-height: 20px;"><i class="fa fa-download" aria-hidden="true"></i> 526</span>
			</div>
		</div>
	</div>
	<?php
	endforeach;
	?>
	<div class="clear"></div>
	<?php
	endif;
	if (count($dls) > 0):
	?>
	<p class="bel-cms_subtitle_page"><?=DOWNLOADS?></p>

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
					<td><?=Common::transformDate($v->insert_date, true, 'd-M-Y')?></td>
				</tr>
				<?php
				endforeach;
				?>
			</tbody>
		</table>
	</div>
	<?php
	endif;
	?>
</section>