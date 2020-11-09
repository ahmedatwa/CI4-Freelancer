<div class="clearfix"></div>
<nav class="navbar navbar-expand-md navbar-light bg-white" id="navbar-header-category">
	<div class="navbar-collapse">
		<ul class="navbar-nav mx-auto">
			<?php foreach($categories as $category) { ?>
				<?php if ($category['children']) { ?>	
					<li class="nav-item dropdown megamenu-li" id="cats-navbar-dropdown">
						<a class="nav-link dropdown-toggle" href="" id="dropdown<?php echo $category['category_id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $category['name']; ?></a>
						<div class="dropdown-menu megamenu" aria-labelledby="dropdown<?php echo $category['category_id']; ?>" id="cats-navbar-dropdown">
							<div class="row">
								<?php foreach (array_chunk($category['children'], ceil(count($category['children']) / 2)) as $children) { ?>
									<ul class="col">
										<?php foreach ($children as $child) { ?>
											<a class="dropdown-item" href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
										<?php } ?>  
									</ul>
								<?php } ?>
							</div>
						</div>
					</li>
				<?php } else { ?>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
					</li>
				<?php } ?> 
			<?php } ?> 
		</ul>
	</div>
</nav>

