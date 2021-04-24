<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml" xml:lang="el" lang="el">
<head profile="https://gmpg.org/xfn/11">
    <!-- <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5"> -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <script async src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="alternate" href="https://oipeirates.pro" hreflang="el-GR" />
    <?php wp_head(); ?>
    <title><?php keremiya_titles(); ?></title>
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?>"
        href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="stylesheet" id="google-fonts-css" href="//fonts.googleapis.com/css?family=Oswald" type="text/css" media="all">
    <link rel="stylesheet" type="text/css" href="/wp-content/themes/keremiyav4/style.css" media="all">
	<?php if(get_option('keremiya_favicon')) { ?>
    <link rel="shortcut icon" href="<?php echo get_option('keremiya_favicon'); ?>" /><?php } else { ?>
    <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/fav.ico" /><?php } ?>
    <?php if(get_option('keremiya_seo_facebook') == 'on') { keremiya_facebook(); } // Facebook Meta ?>
    <?php if (get_option('keremiya_manset_slider') == 'Off'): ?>
    <?php endif; ?> 
    <meta property="og:image" content="https://oipeirates.pro/wp-content/uploads/fbimg3.jpg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-124591046-6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-124591046-6');
</script>

		   <!-- <meta http-equiv="refresh" content="0;URL='https://movielab.online/'" /> 	--> 
	
 <script type="text/javascript" src="//inpagepush.com/400/3108748" data-cfasync="false" async="async"></script>
	 
	<meta name="propeller" content="540d49309f4dc3874abed28ba6329efc">
	<script>(function(s,u,z,p){s.src=u,s.setAttribute('data-zone',z),p.appendChild(s);})(document.createElement('script'),'https://iclickcdn.com/tag.min.js',4023385,document.body||document.documentElement)</script>
	





	
		
	
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "52ad1336-b93d-4bc1-b46f-fcc330a318fe",
    });
  });
</script>
	

	
	
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "52ad1336-b93d-4bc1-b46f-fcc330a318fe",
    });
  });
</script>
	
</head>

<body>
    <div id="wrap">
        <div id="topnavbar">
            <div class="topnavbarleft">
                <?php toplamfilm('Αυτή τη στιγμή υπάρχουν', 'tainies online.'); ?>
            </div>
        </div>
        <div id="my_header" style="width:1150px; background: #181818;">
            <div style="width: 100%;margin: -18px auto 0; padding: 0;">
                <div id="header">
                    <div class="headerleft">
                        <a href="<?php echo get_option('home'); ?>"><?php if(get_option('keremiya_logo')) { ?><img
                                src="<?php echo get_option('keremiya_logo'); ?>" title="<?php bloginfo('name'); ?>"
                                alt="<?php bloginfo('name'); ?>" /><?php } else { ?><img
                                src="<?php bloginfo('template_directory'); ?>/logo/logo.png"
                                alt="<?php bloginfo('name'); ?>" /><?php } ?></a>
                    </div>
                    <div class="arama">
                        <?php include(TEMPLATEPATH.'/searchform.php'); ?>
                    </div>
                    <?php if(get_option('keremiya_sosyal') == 'On'): ?>
                    <div class="headerright">
                        <?php if(get_option('keremiya_facebook_id')) { ?><a target="_blank" class="fb-icon"
                            href="<?php echo get_option('keremiya_facebook_id'); ?>">Facebook</a><?php } else { ?><a
                            class="fb-icon" href="#">#</a><?php } ?>
                        <?php if(get_option('keremiya_twitter_id')) { ?><a target="_blank" class="tw-icon"
                            href="<?php echo get_option('keremiya_twitter_id'); ?>">Twitter</a><?php } else { ?><a
                            class="tw-icon" href="#">#</a><?php } ?>

                        <a target="_blank" class="rss-icon" href="https://instagram.com/oipeirates">Instagram</a>
                    </div>
                    <?php endif; ?>
                </div>

                <div id="newmenu">
                    <div class="tam">
                        <div id="navbarborder">
                            <div id="navbar">
                                <div id="navbarleft">
                                    <ul id="nav">
                                        <li
                                            <?php if ( is_front_page() ) { echo ' font-color="red" class="menu-item" '; } else { echo' class="menu-item"'; }?>>
                                            <a
                                                href="<?php echo get_settings('home'); ?>"><?php echo keremiya_anasayfa; ?></a>
                                        </li>
                                        <?php if ( has_nav_menu( 'header-nav' ) ) : ?><?php wp_nav_menu(array('theme_location' => 'header-nav', 'depth' => 3, 'container' => false)); ?><?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>