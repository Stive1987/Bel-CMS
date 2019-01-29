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
<section id="bel_cms_members_index" class="padding-bottom-60">
	<?php
	foreach ($members as $k_name => $v_name):
	?>
	<h4><?=$k_name?></h4>
	<div class="bel_cms_members_index_table">
		<table class="table table-striped">
			<thead>
				<tr>
					<th class="hidden-xs">#</th>
					<th><?=USERNAME?></th>
					<th class="hidden-xs"><?=BIRTHDAY?></th>
					<th><?=LOCATION?></th>
					<th class="hidden-xs"><?=GENDER?></th>
					<th><?=WEBSITE?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				if (empty($v_name)) {
					?>
					<tr>
						<td colspan="6">Aucun utilisateur</td>
					</tr>
					<?php
				} else {
					foreach ($v_name as $k => $v):
						if (!empty($v->profils)) {
							if ($v->profils->gender == 'male') {
								$gender = MALE;
							} else if ($v->profils->gender == 'female') {
								$gender = FEMALE;
							} else {
								$gender = UNISEXUAL;
							}	
							$birthday = Common::TransformDate($v->profils->birthday);
							$country  = $v->profils->country;
							$websites = '<a href="'.$v->profils->websites.'"><i class="fa fa-link"></i></a>';
							$flag = array_search($country, Common::contryList());
							$flag = 'flag-icon flag-icon-'.strtolower($flag);
						} else {
							$gender   = '-';
							$birthday = '-';
							$country  = '-';
							$websites = '<i class="fa fa-link"></i>';
							$flag     = '';
						}
						?>
						<tr>
							<td class="hidden-xs"></td>
							<td><a href="Members/View/<?=$v->username?>"><?=$v->username?></a></td>
							<td class="hidden-xs"><?=$birthday?></td>
							<td><span class="<?=$flag?>"></span><span class="hidden-xs" style="padding-left: 10px;"><?=$country?></span></td>
							<td class="hidden-xs"><?=$gender?></td>
							<td><?=$websites?></td>
						</tr>
					<?php
					endforeach;
				}
				?>
			</tbody>
		</table>
	</div>	
	<?php
	endforeach;
	?>	
</section>