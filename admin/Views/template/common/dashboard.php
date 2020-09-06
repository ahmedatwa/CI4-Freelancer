<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <!-- Page Header Begin -->
    <div class="page-header">
      <div class="container-fluid">
             <h1><?php echo $heading_dashboard; ?> </h1>
             <nav aria-label="breadcrumb" id="breadcrumb">
               <ol class="breadcrumb">
                   <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                      <li class="breadcrumb-item">
                          <a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb-link"><?php echo $breadcrumb['text']; ?></a>
                      </li>
                  <?php } ?>
              </ol>
          </nav>	
      </div>
  </div>

  <div class="container-fluid dashboard-tiles">
    <?php if ($error_install) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $error_install; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>

        <div id="dashboard-tiles">                            
        <div class="row">
        <?php foreach($dashboards as $dashboard) { ?>
            <?php if ($dashboard['width'] <= 3 ) {  ?>
                <div class="col-md-<?php echo $dashboard['width']; ?>">
                    <?php echo $dashboard['output']; ?>
                </div>
            <?php } else { ?>
                <div class="col-<?php echo $dashboard['width']; ?>">
                    <?php echo $dashboard['output']; ?>
                </div>
            <?php } ?> 
        <?php } ?> 
        </div>
       </div> 
    </div><!-- container-fluid -->
</div>
<?php echo $footer; ?>