<?php echo $header; ?>
<div class="jumbotron">
	<div class="container-fluid">
		<h2 class="display-5"><?php echo $text_post; ?></h2>
</div>
</div>
<div class="container-fluid">
<div class="row">
<div class="col-12">
	<nav id="breadcrumbs">
		<ul>
			<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
			<?php } ?>
		</ul>
	</nav>
</div>
</div>
	<div class="row">	
		<!-- Inner Content -->
			<div class="col-sm-12 col-md-9 mb-4">
			<!-- Blog Post -->
			<div class="blog-post single-post">
				<!-- Blog Post Thumbnail -->
				<div class="blog-post-thumbnail">
					<div class="blog-post-thumbnail-inner">
						<!-- <span class="blog-item-tag">Tips</span> -->
						<img src="<?php echo $image; ?>" alt="">
					</div>
				</div>
				<!-- Blog Post Content -->
				<div class="blog-post-content">
					<h3 class="margin-bottom-10"><?php echo $title; ?></h3>

					<div class="blog-post-info-list margin-bottom-20">
						<a href="#" class="blog-post-info"><?php echo $date_added; ?></a>
						<!-- <a href="#"  class="blog-post-info">5 Comments</a> -->
					</div>
					<p><?php echo $body; ?></p>
					<!-- Share Buttons -->
					<div class="share-buttons margin-top-25">
						<div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>
						<div class="share-buttons-content">
							<span>Interesting? <strong>Share It!</strong></span>
							<ul class="share-buttons-icons">
								<li><a href="#" data-button-color="#3b5998" title="Share on Facebook" data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>
								<li><a href="#" data-button-color="#1da1f2" title="Share on Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
								<li><a href="#" data-button-color="#dd4b39" title="Share on Google Plus" data-tippy-placement="top"><i class="icon-brand-google-plus-g"></i></a></li>
								<li><a href="#" data-button-color="#0077b5" title="Share on LinkedIn" data-tippy-placement="top"><i class="icon-brand-linkedin-in"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="sidebar-container">
				<!-- Widget -->
				<div class="sidebar-widget">
					<h3><?php echo $text_trending; ?></h3>
					<ul class="widget-tabs">
						<?php foreach ($trending as $value) { ?>
						<li>
							<a href="#" class="widget-content active">
								<img src="<?php echo $value['image']; ?>" alt="">
								<div class="widget-text">
									<h5><?php echo $value['title']; ?></h5>
									<span><?php echo $value['date_added']; ?></span>
								</div>
							</a>
						</li>
						<?php } ?>
					</ul>
				</div>
				<!-- Widget / End-->
				<!-- Widget -->
				<div class="sidebar-widget">
					<h3><?php echo $text_social; ?></h3>
					<div class="freelancer-socials margin-top-25">
						<ul>
							<li><a href="#" title="Dribbble" data-tippy-placement="top"><i class="icon-brand-dribbble"></i></a></li>
							<li><a href="#" title="Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
							<li><a href="#" title="Behance" data-tippy-placement="top"><i class="icon-brand-behance"></i></a></li>
							<li><a href="#" title="GitHub" data-tippy-placement="top"><i class="icon-brand-github"></i></a></li>
						</ul>
					</div>
				</div>
				<!-- Widget -->
				<!-- <div class="sidebar-widget">
					<h3>Tags</h3>
					<div class="task-tags">
						<a href="#"><span>employer</span></a>
						<a href="#"><span>recruiting</span></a>
						<a href="#"><span>work</span></a>
						<a href="#"><span>salary</span></a>
						<a href="#"><span>tips</span></a>
						<a href="#"><span>income</span></a>
						<a href="#"><span>application</span></a>
					</div>
				</div> -->
			</div>
		</div>
		</div>
			<!-- Blog Post Content / End -->
			

			
			<!-- Related Posts -->
			<!-- <div class="row"> -->
				<!-- Headline -->
				<!-- <div class="col-xl-12">
					<h3 class="margin-top-40 margin-bottom-35">Related Posts</h3>
				</div> -->
				<!-- Blog Post Item -->
				<!-- <div class="col-xl-6">
					<a href="pages-blog-post.html" class="blog-compact-item-container">
						<div class="blog-compact-item">
							<img src="images/blog-02a.jpg" alt="">
							<span class="blog-item-tag">Recruiting</span>
							<div class="blog-compact-item-content">
								<ul class="blog-post-tags">
									<li>29 June 2018</li>
								</ul>
								<h3>How to "Woo" a Recruiter and Land Your Dream Job</h3>
								<p>Appropriately empower dynamic leadership skills after business portals. Globally myocardinate interactive.</p>
							</div>
						</div>
					</a>
				</div>
			</div> -->
			<!-- Related Posts / End -->
				
			<!-- Comments -->
			<?php if ($post_comments) { ?>
			<div class="row">
				<div class="col-12">
					<section class="comments">
						<h3 class="margin-top-45 margin-bottom-0"><?php echo $text_comments; ?></h3>
						<ul>
						<?php foreach ($post_comments as $comment) { ?>
							<li>
								<div class="avatar"></div>
								<div class="comment-content"><div class="arrow-comment"></div>
									<div class="comment-by"><?php echo $comment['name']; ?><span class="date"><?php echo $comment['date_added']; ?></span>
										<!-- <a href="#" class="reply"><i class="fa fa-reply"></i> Reply</a> -->
									</div>
									<p><?php echo $comment['text']; ?></p>
								</div>
							</li>
						<?php } ?>
						 </ul>

					</section>
				</div>
			</div>
			<?php } ?>
			<!-- Comments / End -->
			<!-- Leava a Comment -->
			<div class="row">
				<div class="col-6">
					<h3 class="margin-top-35 margin-bottom-30"><?php echo $text_add_comment; ?></h3>
					<!-- Form -->
					<form method="post" id="form-comment" class="form-post-comment">
					<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
					<input type="hidden" name="post_id" value="<?= $post_id ?>" />
						<div class="form-row">
							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1"><i class="icon-material-outline-account-circle"></i></span>
							  </div>
								<input type="text" class="form-control" name="name" id="name" placeholder="<?php echo $entry_name; ?>"/>
							</div>
							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1"><i class="icon-material-baseline-mail-outline"></i></span>
							  </div>
								<input type="text" class="form-control" name="email" id="input-email" placeholder="<?php echo $entry_email; ?>" required/>
							</div>
							<textarea  name="comment" cols="30" rows="5" class="form-control" placeholder="Comment"></textarea>
					  </div>
					  <button class="button button-sliding-icon ripple-effect margin-bottom-40 margin-top-20" type="button" id="add-comment"><?php echo $button_add; ?> <i class="icon-material-outline-arrow-right-alt"></i></button>
					</form>
				</div>
			</div>
			<!-- Leava a Comment / End -->
	</div>
<!-- Spacer -->
<div class="padding-top-40"></div>
<script type="text/javascript">
$("#add-comment").on('click', function () {
	$.ajax({
		url: 'extension/blog/blog/addComment',
		method:'post',
		data: $('#form-comment').serialize(),
		dataType: 'json',
        beforeSend: function() {
			$('#add-comment').prop('disabled');
		},
        success: function(json) {
			if(json['success']) {
				 $('#form-comment').before('<div class="notification success closeable"><p><i class="fas fa-check-circle"></i> ' + json['success'] + '</p><a class="close" href="#"></a></div>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
});
</script>
<?php echo $footer; ?>
