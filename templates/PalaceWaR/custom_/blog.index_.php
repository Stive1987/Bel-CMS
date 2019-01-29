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
<section id="bel_cms_blog_main">
<?php
foreach ($blog as $k => $v):
$count_comment = new Comment('count', 'blog','readmore', $v->id);
$count_comment = $count_comment->count;
?>
<div class="col-md-12 bg-dark-2 main_blog clear">
	<div class="nk-blog-post nk-blog-post-border-bottom">
		<div class="nk-gap"></div>
		<h2 class="nk-post-title h4"><a href="<?=$v->link?>"><?=$v->name?></a></h2>
		<div class="nk-post-text">
			<?=$v->content?>
		</div>
		<div class="nk-gap"></div>
		<a href="<?php echo $v->link; ?>" class="nk-btn nk-btn-rounded nk-btn-color-dark-3 nk-btn-hover-color-main-1">Read More</a>
		<div class="nk-post-date pull-right">
			<span class="fa fa-calendar"></span> <?=Common::transformDate($v->date_create, 'FULL', 'NONE')?>
		</div>
	</div>
</div>
<?php
endforeach;
?>
</section>
<?=$pagination?>

