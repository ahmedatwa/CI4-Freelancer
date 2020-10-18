<!DOCTYPE html>
<html>
<head>
<title></title>
<base href="<?php echo base_url(); ?>">
<link rel="stylesheet" href="catalog/default/vendor/bootstrap/css/bootstrap.min.css">
<link href="catalog/default/vendor/animate/animate.min.css" rel="stylesheet" type="text/css">
<script src="catalog/default/javascript/jquery-3.5.1.min.js"></script>
<script src="catalog/default/vendor/bootstrap-notify/bootstrap-notify.min.js"></script>
</head>
<body>

</body>
<script type="text/javascript">
$(document).ready(function() {
$.notify({
	// options
	icon: 'glyphicon glyphicon-warning-sign',
	title: 'Bootstrap notify',
	message: '<?php echo $name; ?>',
	url: 'https://github.com/mouse0270/bootstrap-notify',
	target: '_blank'
},{
	// settings
	element: 'body',
	type: "info",
	allow_dismiss: true,
	newest_on_top: false,
	showProgressbar: false,
	placement: {
		from: "top",
		align: "right"
	},
	offset: 20,
	spacing: 10,
	z_index: 1031,
	delay: 5000,
	timer: 1000,
	url_target: '_blank',
	mouse_over: null,
	animate: {
		enter: 'animated fadeInDown',
		exit: 'animated fadeOutUp'
	},
	onShow: null,
	onShown: null,
	onClose: null,
	onClosed: null,
	icon_type: 'class',
});
});
</script>
</html>
