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
								<button class="btn active"><i class="fa fa-object-group"></i> <?=CATEGORY?></button>
							</div>
							<!-- fin des boutton action -->

							<table class="table table-striped table-bordered">
								<thead class="thead-inverse">
									<tr>
										<th><?=TITLE?></th>
										<th><?=SUBTITLE?></th>
										<th><?=ACTIVATE?></th>
										<th class="td-actions"><?=OPTIONS?></th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($this->data as $k => $v):
										$v->activate = $v->activate == 1 ? ACTIVE : DISABLE;
										?>
										<tr>
											<td><?=$v->title?></td>
											<td><?=$v->subtitle?></td>
											<td><?=$v->activate?></td>
											<td class="td-actions">
												<a href="Forum/EditCategory/<?=$v->id?>?management" class="btn btn-small btn-success">
													<i class="btn-icon-only icon-edit"> </i>
												</a>
												<a href="#modal_<?=$v->id?>" role="button" data-toggle="modal" class="btn btn-danger btn-small">
													<i class="btn-icon-only icon-remove"> </i>
												</a>
												<div id="modal_<?=$v->id?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h3 id="myModalLabel">Suppression du forum</h3>
													</div>
													<div class="modal-body">
														<p>Etes vous certain de d'effacer le forum : <?=$v->title?></p>
													</div>
													<div class="modal-footer">
														<button class="btn" data-dismiss="modal" aria-hidden="true">Fermer</button>
														<a href="Forum/DelCategory/<?=$v->id?>?management" class="btn btn-primary">Supprimer</a>
													</div>
												</div>
											</td>
										</tr>
										<?php
									endforeach;
									?>
								</tbody>
							</table>
							<button class="btn" onclick="window.location.href='Forum/AddCategory?management'"><i class="icon-plus"></i> <?=ADD?></button>
						</div>
						<!-- fin du contenue -->
					</div>
				</div>
		  	</div>

		</div>
	</div>
</div>
<?php
endif;
