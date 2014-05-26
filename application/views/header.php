<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <title>Swarming Logic - <?php echo $title ?></title>
	<meta name="description" content="Swarming Logic">
	<meta name="author" content="Roald Fernandez">
  <meta name="keywords" content="Game development, android, mobile, programming, java, c++"/>
	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="/css/base.css">
	<link rel="stylesheet" href="/css/skeleton.css">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/layout.css">
	<link rel="stylesheet" href="/css/lightbox.css">

  <!-- EXTERNAL FONTS
  ================================================== -->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700|Bree+Serif'
        rel='stylesheet'
        type='text/css'>
   <script src="//use.edgefonts.net/unkempt.js"></script>
<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="/favicon.ico">

  <!--
  ================================================== -->
  <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="/rss.xml"/>

</head>
<body<?php if(isset($useSpyScroll) && $useSpyScroll) { echo ' data-spy="scroll"'; } ?>>
<div class="wrapper">
	<div class="container">
    <!-- <div class="row"> -->
      <div class="six columns"> <!-- style="background-color: blue;" -->
        <!-- <figure class="logo"> -->
          <a class="logo" href="/" title="Home">
            <img src="/images/swl_logo_sm_light.png" alt="logo"/>
          </a>
        <!-- </figure> -->
      </div>
      <div class="ten columns"> <!-- style="background-color: red;" --> 
        <nav id="main">
          <ul class="main-nav">
            <?php
              foreach( $navbar as $key => $val) {
                echo '<li><a target="_self" class="noselect nav-button ';
                if ($navId == $key) {
                  echo 'green"';
                }
                else {
                  echo 'algae"';
                }
                echo ' href="/'.$val.'" unselectable="on">'.$key.'</a></li>';
              }
            ?>
          </ul>
        </nav>
      </div>
      <div class="clear" style="padding-bottom: 1%; margin-bottom:3%"></div><br/>

<?php
   if(isset($pageWrapperDiv)) {
     echo '<div class="'.$pageWrapperDiv.'">
';
   }
?>