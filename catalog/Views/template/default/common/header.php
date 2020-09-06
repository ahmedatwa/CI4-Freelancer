<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $description; ?>">
    <meta name="keywords" content="<?php echo $keywords; ?>">
    <meta name="author" content="Ansonika">
    <base href="<?php echo $base; ?>">
    <title><?php echo $title; ?></title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

    <!-- BASE CSS -->
    <link href="catalog/default/vendor/bootstrap-4.5.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="catalog/default/css/style.css" rel="stylesheet">
    <!-- SPECIFIC CSS -->
    <?php if ($route == 'blog') { ?>
    <link href="catalog/default/css/blog.css" rel="stylesheet" type="text/css"> 
    <?php } else { ?>
    <link href="catalog/default/css/home.css" rel="stylesheet" type="text/css">
    <?php } ?>
    <!-- YOUR CUSTOM CSS -->
    <link href="catalog/default/css/custom.css" rel="stylesheet" type="text/css">
    <link href="catalog/default/vendor/fontawesome-free/css/all.css" rel="stylesheet" type="text/css">

    <?php if( $styles) { ?>
        <?php foreach ($styles as $style) { ?>
    <link type="text/css" href="<?php echo $style['href']; ?>" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
    <?php } ?>
    <?php } ?>

</head>

<body>
				
	