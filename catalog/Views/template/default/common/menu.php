<div id="blog">
<header class="header">
		<div class="container-fluid">
		<div id="logo">
			<a href="<?php echo $home; ?>">
				<img src="<?php echo img_url('logo.svg'); ?>" width="140" height="35" alt="">
			</a>
		</div>
		<?php if ($isLogged) { ?>
		<ul id="top_menu" class="drop_user">
			<li>
				<div class="dropdown user clearfix">
				    <a href="#" data-toggle="dropdown">
				        <figure><img src="<?php echo $image; ?>" alt=""></figure><?php echo $username; ?>
				    </a>
				    <div class="dropdown-menu">
				        <div class="dropdown-menu-content">
				            <ul>
				            	<li><a href="#0"><i class="icon_cog"></i><?php echo $button_dashboard; ?></a></li>
				            	<li><a href="#0"><i class="icon_mail"></i><?php echo $button_messages; ?></a></li>
				            	<li><a href="<?php echo $logout; ?>"><i class="icon_key"></i><?php echo $button_logout; ?></a></li>
				            </ul>
				        </div>
				    </div>
				</div>
				<!-- /dropdown -->
			</li>
		</ul>
		<?php } ?>
		<?php if (! $isLogged) { ?>
		<ul id="top_menu">
			<li><button type="button" class="btn btn-dark btn-sm btn_access" data-toggle="modal" data-target="#login"><?php echo $text_login; ?></button></li>
			<li><buttton type="button" class="btn btn-success btn-sm btn_access" data-toggle="modal" data-target="#register"><?php echo $text_register; ?></buttton></li>
		</ul>
		<?php } ?>
		<!-- /top_menu -->
		<a href="#0" class="open_close">
			<i class="icon_menu"></i><span><?php echo $text_menu; ?></span>
		</a>
		<nav class="main-menu">
			<ul>
			<?php if ($menus) { ?> 
			<?php foreach ($menus as $menu) { ?>
			<?php if (!empty($menu['children'])) { ?>
				<li class="submenu">
					<a href="<?php echo $menu['href']; ?>" class="show-submenu"><?php echo $menu['name']; ?></a>
					<ul>
					<?php foreach ($menu['children'] as $child) { ?>
						<li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
					<?php } ?>	
					</ul>
				</li>
			<?php } else { ?>
				<li><a href="<?php echo $menu['href']; ?>"><?php echo $menu['name']; ?></a></li>
			<?php } ?>	
			<?php } ?>
			<?php } ?>
			</ul>
		</nav>
	</div>
	</header>
	<!-- /header -->
	</div>
