    <nav id="sidebar">
        <div class="sidebar-header" id="navigation">
            <span><i class="fas fa-bars"></i> <?php echo $text_navigation; ?></span>
        </div>
        <ul id="menu">
        <?php foreach ($menus as $menu) { ?>
        <?php if (! empty($menu['children'])) { ?>
            <li class="<?php echo $menu['id']; ?>">
             <a href="#<?php echo $menu['id']; ?>" data-toggle="collapse" aria-expanded="false" class="parent dropdown-toggle">
             <i class="<?php echo $menu['icon']; ?>"></i> <?php echo $menu['name']; ?></a>
                    <ul class="collapse" id="<?php echo $menu['id']; ?>">
                    <?php foreach($menu['children'] as $child) { ?>
                    <?php if (!empty($child['children'])) { ?>
                    <a href="#<?php echo $child['id']; ?>" data-toggle="collapse" aria-expanded="false" class="parent dropdown-toggle">
                    <?php echo $child['name']; ?></a>
                    <ul class="collapse" id="<?php echo $child['id']; ?>">
                    <?php foreach($child['children'] as $child_2) { ?>
                        <li>
                            <a href="<?php echo $child_2['href']; ?>"><?php echo $child_2['name']; ?></a>
                        </li>
                     <?php } ?>
                    </ul> 
                    <?php } else { ?>
                        <li>
                            <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
                        </li>
                    <?php } ?>    
                    <?php } ?>
                    </ul>
                </li>
        <?php } else { ?>
            <li class="<?php echo $menu['id']; ?>">
              <a href="<?php echo $menu['href']; ?>"><i class="<?php echo $menu['icon']; ?>"></i> <?php echo $menu['name']; ?></a>
            </li>
        <?php } ?>
        <?php } ?>       
        </ul>
    </nav>
