<?
include('db.php');
session_start();
if (isset($_GET['go'])) {
	$go = $_GET['go'];
} else {
	$go = 'home';
}
if ($go == 'blog' && isset($_GET['id'])) {
  $id = $_GET['id'];
  connectdb('drkatem');
  $subjectrow = mysql_fetch_assoc(mysql_query("select subject from posts where id='$id'"));
  $title = $subjectrow['subject'];
  mysql_close();
} elseif ($go == 'archives') {
	$title = 'Blog Archives';
} else {
  $title = ucfirst($go);
}
$baseURL='http://catherinemusemeche.com';

if (($go == 'edit' || $go == 'admin') && ! isset($_GET['disableMCE'])) {
	$editable = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<title><?=$title;?> | Catherine Musemeche, M.D</title>
		<link rel="stylesheet" href="/style.css">	
		<link href='https://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'>
		<link rel="alternate" type="application/rss+xml" title="" href="http://www.catherinemusemeche.com/rss.php">
		<link rel="stylesheet" href="/magnific-popup/magnific-popup.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="/magnific-popup/jquery.magnific-popup.js"></script>
		<? if ($editable) { ?>
		<script src='/tinymce/jscripts/tiny_mce/tiny_mce.js'></script>
		<? } ?>
		<meta property="og:image" content="<?=$baseURL?>/images/kate_og.jpg" />
</head>
<body class="<?=$go?>">
<? if ($editable) { ?>
<script>
tinyMCE.init({
	mode : "textareas"
});
</script>
<? } ?>
<div id="page">
	<div id="header" class="flex">
		<header> 
			<?
				if ($go == 'home') {
					$h = 'h1';
				} else {
					$h = 'span';
				}
			?>
			<<?=$h?> id="logo"><a href="/" title="Catherine Musemeche, M.D."><span class="first">Catherine</span> <span class="last">Musemeche,</span> <span class="creds">M.D.</span></a></<?=$h?>>
		</header>
		<nav>
			<ul id="nav" class="cf">
				<?
					$navelements = array(
						'home' => 'Home',
						'writing' => 'Writing',
						'news' => 'News',
						'about' => 'About',
						'contact' => 'Contact'
					);
					$i = 1;
					foreach ($navelements as $page => $display) {
						print '<li class="'.$page.'"><a class="';
						if (preg_match("/$page/i",$go)) {
							print 'active';
						}
						if ($i == 1) {
							print ' first';
						} elseif ($i == sizeof($navelements)) {
							print ' last';
						}
						print '"';
						print ' href="/'.$page.'"';
						print '>'.$display.'</a>';
						print '</li>';
						$i++;
					}
				?>
				</ul>
		</nav>
		<a href="#" class="toggle"><span></span><span></span><span></span><span></span></a>
	</div>

	<div id="content" class="cf">
		<div id="main" class="compact">
			<? 
				require_once('content/'.$go.'.php');
			?>
		</div>
	</div>

	<footer class="cf" id="footer">
		<p class="top">&copy; Catherine Musemeche, M.D. All rights reserved.</p>
		<p>Email - <a href="mailto:drkate@catherinemusemeche.com">DrKate@catherinemusemeche.com</a></p>
		<p>Twitter - <a href="https://twitter.com/drkatem" target="_blank" title="Catherine Musemeche, M.D. on Twitter">@DrKateM</a></p>
		<p class="blurb">This website is for general information only and not intended to constitute medical advice.</p>
	</footer>
</div>

<!-- custom JS -->
<script>
	$(function() {
	  $("a[rel='lightbox']").magnificPopup({type:'image'});

		var $toggle = $('.toggle'),
				$nav = $('nav');
		$toggle.on('click', function(e) {
			$(this).toggleClass('open');
			$nav.toggleClass('open');
			e.preventDefault();
		});
	});

	// Google Analytics
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount','UA-29826683-1']);
	_gaq.push(['_trackPageview']);
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>

<? if (isset($go) && $go == 'blog') { ?>
<!-- social -->
<div id="fb-root"></div>
<script>
	$(window).load(function() {
		setTimeout(function() {
			$.getScript('/social.js',function() {});
		},1000);
	});
</script>
<? } ?>

</body>
</html>
