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
if (isset($_SESSION['LOGIN_MANAGEMENT']) && $_SESSION['LOGIN_MANAGEMENT'] === true):
?>
<div class="main">
	<div class="main-inner">
		<div class="container">
			<div class="row">

				<div class="span12">
					<div class="widget">
						<!-- debut Titre full -->
						<div class="widget-header">
							<i class="icon-th-large"></i>
							<h3><?=FORUM?></h3>
						</div>
						<!-- fin Titre full -->
						<!-- debut du contenue -->
						<div class="widget-content">
							<!-- debut des boutton action -->
							<div class="form-actions">
								<button class="btn" onclick="window.location.href='Forum?management'"><i class="icon-home"></i> <?=HOME?></button>
								<button class="btn active" onclick="window.location.href='Forum/Category?management'"><i class="fa fa-object-group"></i> <?=CATEGORY?></button>
							</div>
							<!-- fin des boutton action -->
							<div class="widget-content">
								<form action="Forum/send?management" method="post" class="form-horizontal">
									<fieldset>
										<div class="control-group">
											<label class="control-label" for="labe_title"><?=TITLE?></label>
											<div class="">
												<label class="controls">
													<input name="title" class="span6" id="label_title" type="text" required="required" placeholder="Titre de la catégorie">
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="labe_subtitle"><?=SUBTITLE?></label>
											<div class="controls">
												<label class="">
													<input name="subtitle" class="span6" id="label_subtitle" type="text" placeholder="Sous-titre de la catégorie">
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="label_orderby"><?=ORDER?></label>
											<div class="controls">
												<label class="">
													<input name="orderby" class="span6" id="label_orderby" type="number" placeholder="1" min="1">
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="label_actif"><?=ACTIVE?></label>
											<div class="controls">
												<label class="radio inline">
													<input checked="checked" name="activate" id="label_actif" value="1" type="radio"><?=ACTIVATE?>
												</label>
												<label class="radio inline controls">
													<input name="activate" id="label_actif" value="0" type="radio"><?=DISABLE?>
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label"><?=GROUPS?></label>
											<div class="controls">
												<?php
												foreach (config::GetGroups() as $k => $v):
													?>
													<input class="span1" id="label_groups_<?=$k?>" type="checkbox" name="groups[]" value="<?=$k?>"><span for="label_groups_<?=$k?>"><?=$v?></span><br>
													<?php
												endforeach;
												?>
											</div>
										</div>
									</fieldset>
									<div class="form-actions">
										<input type="hidden" name="send" value="addcat">
										<button type="submit" class="btn btn-primary"><?=ADD?></button> 
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
endif;