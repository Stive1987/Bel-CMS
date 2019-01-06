		<!-- Page Content -->
		<div class="container">

			<div class="row">
				<div class="col-md-8">
					<?php echo $page; ?>
				</div>
				<div class="col-md-4">
					<?php
					Widgets::GetAllWidgets('right');
					Widgets::GetWidget('shoutbox', 'right');
					?>
				</div>