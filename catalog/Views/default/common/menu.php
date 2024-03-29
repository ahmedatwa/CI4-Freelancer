<div class="clearfix"></div>
<nav class="navbar navbar-expand navbar-light bg-white shadow-sm border-bottom p-0" id="navbar-header-category">
	<div class="navbar-collapse">
		<ul class="navbar-nav mx-auto">
			<?php foreach($categories as $category) { ?>
				<?php if ($category['children']) { ?>	
					<li class="nav-item dropdown megamenu-li" id="cats-navbar-dropdown">
						<a class="nav-link dropdown-toggle" href="<?php echo $category['href']; ?>" id="dropdown<?php echo $category['category_id']; ?>" aria-haspopup="true" aria-expanded="false"><?php echo $category['name']; ?></a>
						<div class="dropdown-menu megamenu rounded-0" aria-labelledby="dropdown<?php echo $category['category_id']; ?>" id="cats-navbar-dropdown">
							<div class="row">
								<?php foreach (array_chunk($category['children'], ceil(count($category['children']) / 4)) as $children) { ?>
									<ul class="col list-unstyled">
										<?php foreach ($children as $child) { ?>
											<li class="ml-4"><a class="dropdown-item" href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
										<?php } ?> 
									</ul>
								<?php } ?>
								<!-- <div class="col m-auto"><i class="<?php //echo $category['ico']; ?> fa-10x"></i></div> -->
							</div>
						</div>
					</li>
				<?php } else { ?>
					<li class="nav-item d-sm-none d-md-block">
						<a class="nav-link" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
					</li>
				<?php } ?> 
			<?php } ?> 
		</ul>
	</div>
</nav>

