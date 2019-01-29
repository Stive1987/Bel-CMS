<div id="bel_cms_widgets_connected" class="card bel_cms_widgets">
	<div class="panel-group">
		<div class="card-header"><h3 class="card-title"><?=$this->title ?></h3></div>
		<div class="card-body">
			<div id="bel_cms_widgets_connected" class="widget">
				<ul>
					<li>
						<span>Hier</span>
						<span><strong><?=Visitors::getVisitorYesterday()->count?></strong></span>
					</li>
					<li>
						<span>Aujourd'hui</span>
						<span><strong><?=Visitors::getVisitorDay()->count?></strong></span>
					</li>
					<li>
						<span>Maintennant</span>
						<span><strong><?=Visitors::getVisitorConnected()->count?></strong></span>
					</li>
					<li>
						<ul id="getVisitorConnected">
							<?php
							$i = 0;
							foreach (Visitors::getVisitorConnected()->data as $k => $v):
								$test = autoUser::getNameAvatar($v->visitor_user);
								$visitor = $test === false ? VISITOR : $test->username;
								?>
								<li>
									<span><?=Common::truncate($visitor, 20)?></span>
									<span><?=$v->visitor_page?></span>
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
</div>
