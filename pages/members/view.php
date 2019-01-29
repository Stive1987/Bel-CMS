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
<section id="bel_cms_members_view" class="padding-top-60 padding-top-sm-30">
	<div class="">
		<div class="row">
			<div class="col-xs-12 col-sm-4 col-md-3">

				<div class="widget center">
					<div id="bel_cms_members_view_avatar">
						<img data-toggle="tooltip" title="<?=$members->username?>" src="<?=$members->avatar?>" alt="Avatar_<?=$members->username?>">
					</div>
				</div>

				<?php
				if (AutoUser::isLogged()) {
					if ($members->username != $_SESSION['user']->username):
						?>
						<div class="widget center">
							<a href="Members/AddFriend/<?=$members->username?>?jquery" class="btn btn-primary alertAjaxLink">Ajouter en ami</a>
						</div>
						<?php
					endif;
				}
				?>

				<div class="widget">
					<div class="panel panel-default">
						<div class="panel-heading">Groups</div>
						<div class="panel-body no-padding">
							<ul class="panel-list-bordered">
								<?php
								foreach ($members->groups as $k => $v):
									echo '<li id="groups_'.$k.'"><a href="Members/View/'.$members->username.'#groups_'.$k.'">'.$v.'</a></li>';
								endforeach;
								?>
							</ul>
						</div>
					</div>
				</div>

				<div class="widget">
					<div class="panel panel-default">
						<div class="panel-heading"><?=ABOUT_ME?></div>
						<div class="panel-body">
							<?=$members->info_text?>
						</div>
					</div>
				</div>

				<div class="widget widget-friends">
					<div class="panel panel-default">
						<div class="panel-heading">Friends (<?=count($members->friends)?>)</div>
						<div class="panel-body">
							<ul>
								<?php
								foreach ($members->friends as $k => $v):
									$li  = '<li>';
									$li .= '<a href="Members/View/'.$v['name'].'" data-toggle="tooltip" title="'.$v['name'].'">';
									$li .= '<img src="'.$v['avatar'].'" alt="friends_'.$v['name'].'">';
									$li .= '</a></li>';
									echo $li;
								endforeach;
								?>
							</ul>
						</div>
					</div>
				</div>

			</div>

			<div class="col-xs-12 col-sm-8 col-md-9">
				<div class="widget">
					<table class="table">
						<tr>
							<td class="col-md-6 col-sm-6">
								<span class="label label-primary label-icon-left"><i class="fa fa-facebook" aria-hidden="true"></i> facebook</span></td>
							<td class="col-md-6 col-sm-6"><?=$members->facebook?></td>
						</tr>
						<tr>
							<td class="col-md-6 col-sm-6"><span class="label label-info label-icon-left"><i class="fa fa-twitter" aria-hidden="true"></i> twitter</span></td>
							<td class="col-md-6 col-sm-6"><?=$members->twitter?></td>
						</tr>
						<tr>
							<td class="col-md-6 col-sm-6"><span class="label label-success label-icon-left"><i class="fa fa-linkedin" aria-hidden="true"></i> linkedin</span></td>
							<td class="col-md-6 col-sm-6"><?=$members->linkedin?></td>
						</tr>
						<tr>
							<td class="col-md-6 col-sm-6"><span class="label label-danger label-icon-left"><i class="fa fa-google-plus" aria-hidden="true"></i>
 googleplus</span></td>
							<td class="col-md-6 col-sm-6"><?=$members->googleplus?></td>
						</tr>
						<tr>
							<td class="col-md-6 col-sm-6"><span class="label label-warning label-icon-left"><i class="fa fa-pinterest" aria-hidden="true"></i> pinterest</span></td>
							<td class="col-md-6 col-sm-6"><?=$members->pinterest?></td>
						</tr>
					</table>
				</div>

				<h4 class="page-header text-center no-padding"><i class="fa fa-comments-o"></i> 3 <?=LAST_FORUM?></h4>
				<?php
				foreach ($forum as $k => $v):
				?>
				<div class="panel panel-default panel-post">
					<div class="panel-body">
						<div class="post">
							<div class="post-header post-author">
								<div class="post-title">
									<h3><?=$v->title?></h3>
									<span><i class="fa fa-calendar-o"></i> <?=$v->date_post?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
				endforeach;
				?>
			</div>
		</div>
	</div>
</section>
