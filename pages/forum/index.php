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
<section id="bel_cms_forum_main" class="padding-bottom-60">
	<div class="">
		<div class="headline">
		<?php
		foreach ($forum as $k => $v):
			if ($k == 0):
				?>
					<h4 class="no-padding-top"><?=defixUrl($v->title)?> <small><?=$v->subtitle?></small></h4>
				</div>
				<?php
			else:
				?>
				<div class="headline margin-top-60">
					<h4><?=$v->title?> <small><?=$v->subtitle?></small></h4>
				</div>
				<?php
			endif;
			if (!empty($v->threads)):
			?>
				<div class="forum">
			<?php
				foreach ($v->threads as $k_threads => $v_threads):
					$lock = $v_threads->options['lock'] ? 'lock' : '';
					$link = $v_threads->options['lock'] ? Common::CurrentPage() : 'Forum/Threads/'.$v_threads->title.'/'.$v_threads->id;
					$span_profil  = '<span>';
					$span_profil .= '<a href="Members/View/'.$v_threads->lastThreads->author.'"><i class="fa fa-user"></i> '.$v_threads->lastThreads->author.'</a> <i class="fa fa-clock-o"></i> '.$v_threads->lastThreads->date_post;
					$span_profil .= '</span>';
					$profil = $v_threads->lastThreads->author == UNKNOWN ? '' : $span_profil;
					$none   = $v_threads->lastThreads->title == NO_POST ? '<h4 style="line-height:35px">'.NO_POST.'</h4>' : '<h4><a href="Forum/Post/'.$v_threads->lastThreads->title.'/'.$v_threads->lastThreads->id.'">'.common::truncate(defixUrl($v_threads->lastThreads->title), 25).'</a></h4>';
				?>
					<div class="forum-group <?=$lock?>">
						<div class="forum-icon hidden-xs"><i class="<?=$v_threads->icon?>"></i></div>
						<div class="forum-title">
							<h4><a href="<?=$link?>"><?=defixUrl($v_threads->title)?></a></h4>
							<p><?=$v_threads->subtitle?></p>
						</div>
						<div class="forum-activity visible-md visible-lg">
							<img src="<?=$v_threads->lastThreads->avatar?>" alt="avatar_user">
							<div>
								<?=$none?>
								<?=$profil?>
							</div>
						</div>
						<div class="forum-meta visible-lg"><?=$v_threads->count_post?> <?=THREADS?></div>
					</div>
				<?php
				endforeach;
				?>
				</div>
			<?php
			endif;
		endforeach;
		?>
	</div>
</section>
