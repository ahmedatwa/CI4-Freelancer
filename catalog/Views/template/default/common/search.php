<?php echo $header; ?><?php echo $menu; ?>
<section class="search-wrapper">
    <div class="search-area2 bgimage">
        <div class="bg_image_holder">
            <img src="images/search.jpg" alt="">
        </div>
        <div class="container content_above">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="search">
                        <div class="search__title">
                            <h3>
                                <?php echo $heading_title; ?>
                            </h3>
                        </div>
                        <div class="search__field">
                            <div class="field-wrapper">
                                <input class="relative-field rounded" type="text" name="search"
                                    placeholder="<?php echo $text_search; ?>" value="<?php echo $search; ?>">
                                <button class="btn btn--round btn-primary" type="button"
                                    id="button-search"><?php echo $button_search; ?></button>
                            </div>
                        </div>
                        <div class="breadcrumb">
                            <ul>
                                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                                <li>
                                    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="filter-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="filter-bar">
                    <div class="filter__option filter--dropdown">
                        <a href="#" id="drop1" class="dropdown-trigger dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"><?php echo $text_categories; ?>
                            <span class="lnr lnr-chevron-down"></span>
                        </a>
                        <ul class="custom_dropdown custom_drop2 dropdown-menu" aria-labelledby="drop1">
                            <?php foreach ($categories as $category) { ?>
                            <li>
                                <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?>
                                    <span><?php echo $category['total']; ?></span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="filter__option filter--dropdown filter--range">
                        <a href="#" id="drop3" class="dropdown-trigger dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Price Range
                            <span class="lnr lnr-chevron-down"></span>
                        </a>
                        <div class="custom_dropdown dropdown-menu" aria-labelledby="drop3">
                            <div class="range-slider price-range"></div>

                            <div class="price-ranges">
                                <span class="from rounded">$30</span>
                                <span class="to rounded">$300</span>
                            </div>
                        </div>
                    </div>
                    <!-- end /.filter__option -->
                    <div class="filter__option filter--select">
                        <div class="select-wrap">
                            <select id="input-sort" class="form-control" onchange="location = this.value;">
                                <?php foreach ($sorts as $sort) { ?>
                                <?php if ($sort['value']== $sort_by  . '-' . $order_by) { ?>
                                <option value="<?php echo $sort['href']; ?>" selected="selected">
                                    <?php echo $sort['text']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $sort['href']; ?>">
                                    <?php echo $sort['text']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <span class="lnr lnr-chevron-down"></span>
                        </div>
                    </div>
                    <!-- end /.filter__option -->
                    <div class="filter__option filter--select">
                        <div class="select-wrap">
                            <select id="input-limit" class="form-control" onchange="location = this.value;">
                                <?php foreach ($limits as $limits) { ?>
                                <?php if ($limits['value'] == $limit) { ?>
                                <option value="<?php echo $limits['href']; ?>" selected="selected">
                                    <?php echo $limits['text']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?>
                                </option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <span class="lnr lnr-chevron-down"></span>
                        </div>
                    </div>
                    <!-- end /.filter__option -->
                    <div class="filter__option filter--layout">
                        <a href="#" id="grid" data-toggle="tooltip" data-placement="top"
                            title="<?php echo $text_grid; ?>">
                            <div class="svg-icon">
                                <img class="svg" src="<?php echo img_url('svg/grid.svg'); ?>">
                            </div>
                        </a>
                        <a href="#" id="list" data-toggle="tooltip" data-placement="top"
                            title="<?php echo $text_list; ?>">
                            <div class="svg-icon">
                                <img class="svg" src="<?php echo img_url('svg/list.svg'); ?>">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="products">
    <div class="container">
        <div class="row">
            <?php if ($services) { ?>
            <?php foreach ($services as $service) { ?>
            <div class="col-lg-4 col-md-6">
                <!-- start .single-product -->
                <div class="product product--card">
                    <div class="product__thumbnail">
                        <img src="<?php echo $service['image']; ?>" alt="Product Image">
                        <div class="prod_btn">
                            <a href="<?php echo $service['href']; ?>"
                                class="transparent btn--sm btn--round"><?php echo $button_more_info; ?></a>
                        </div>
                        <!-- end /.prod_btn -->
                    </div>
                    <!-- end /.product__thumbnail -->
                    <div class="product-desc">
                        <a href="<?php echo $service['href']; ?>" class="product_title">
                            <h4><?php echo $service['name']; ?></h4>
                        </a>
                        <ul class="titlebtm">
                            <li>
                                <img class="auth-img" src="<?php echo $service['seller_img']; ?>" alt="author image">
                                <p>
                                    <a href="#"><?php echo $service['seller']; ?></a>
                                </p>
                            </li>
                            <li class="product_cat">
                                <a href="#">
                                    <span class="lnr lnr-book"></span><?php echo $service['category']; ?></a>
                            </li>
                        </ul>
                        <p><?php echo $service['description']; ?></p>
                    </div>
                    <!-- end /.product-desc -->
                    <div class="product-purchase">
                        <div class="price_love">
                            <span><?php echo $service['price']; ?></span>
                        </div>
                    </div>
                    <!-- end /.product-purchase -->
                </div>
                <!-- end /.single-product -->
            </div>
            <!-- end /.col-md-4 -->
            <?php } ?>
            <?php } else { ?>
            <div class="col-lg-12 text-center">
                <div class="shortcode_modules">
                    <div class="modules__content typog">
                        <p><?php echo $text_empty; ?></p>
                        <a class="btn btn-lg btn--icon btn--round" href="<?php echo base_url('service/category'); ?>" role="button">
                            <span class="lnr lnr-bullhorn"></span><?php echo $text_categories; ?></a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <!-- end /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="pagination-area pull-right">
                    <?php echo strlen($pagination) ? $pagination : ''; ?>
                </div>
            </div>
        </div>
        <!-- end /.row -->
    </div>
    <!-- end /.container -->
</section>
<?php echo $content_bottom; ?><?php echo $footer; ?>
<script type="text/javascript">
$(document).ready(function() {
    $('#list').click(function(event) {
        event.preventDefault();
        $('.product').removeClass('product--card product--card-small');
        $('.product_card_container').removeClass('row');
        $('.product_card_mian_wrapper').removeClass('col-lg-4 col-md-6');
        $('.product').addClass('product--list product--list-small');
    });
    $('#grid').click(function(event) {
        event.preventDefault();
        $('.product').removeClass('product--list product--list-small');
        $('.product').addClass('product--card product--card-small');
        $('.product_card_container').addClass('row');
        $('.product_card_mian_wrapper').addClass('col-lg-4 col-md-6');
    });
});
</script>
<script type="text/javascript">
$('input[name=\'filter[]\']').on('click', function() {
    filter = [];

    $('input[name^=\'filter\']:checked').each(function(element) {
        filter.push(this.value);
    });

    location = '<?php echo $action; ?>&filter=' + filter.join(',');
});
</script>