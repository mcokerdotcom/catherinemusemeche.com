<?
include_once 'markdown.php';
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$query = "select * from posts where id='$id' and active='1'";
	$htag = 'h1';
} else {
  $perpage = "5";
  if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $offset = $perpage * $_GET['page'] - $perpage;
  } else {
    $page = 1;
    $offset = 0;
  }
  connectdb(drkatem);
  $query = "select * from posts where active=1 order by date desc limit $perpage offset $offset";
  $htag = 'h2';
}
connectdb(drkatem);
$totalquery = "select * from posts where active='1'";
$totalresult = mysql_query($totalquery);
$totaltotal = mysql_num_rows($totalresult);
$result = mysql_query($query);
$count = '1';
$total = mysql_num_rows($result);
while ($row = mysql_fetch_array($result)) {
  $id = $row['id'];
  $name = $row['name'];
  $email = $row['email'];
  $body = $row['body'];
  $subject = $row['subject'];
  $datetime = strtotime($row['date']);
  $time = date("g:ia",$datetime);
  $monthyear = date("my",$datetime);
  $friendlydate = date('F d, Y',$datetime);
  $day = date("d",$datetime);
	$last = 0;
  if ("$count" == "$perpage" || "$count" == "$total") {
		$last = 1;
  } else {
    $count++;
  }
?>
<div class="post<? if ($last == 1) { ?> last<? } ?>">
	<header>
		<<?=$htag?> class="title"><a href="/<?=$id?>" title="<?=$subject?>"><?=$subject?></a></<?=$htag?>>
		<div class="byline cf">
			<span class="date"><?=$friendlydate?> at <?=$time?></span>
			<span class="share">
				<div class="social facebook">
					<div class="fb-like" <? if (!isset($_GET['id'])) {?>data-href="http://<?=$_SERVER["HTTP_HOST"].'/'.$id?>" <?} ?>data-layout="button" data-action="like" data-size="small" data-width="110" data-show-faces="false"></div>
				</div>
				<div class="social twitter">
					<a href="https://twitter.com/share" class="twitter-share-button" <? if (!isset($_GET['id'])) {?>data-url="http://<?=$_SERVER["HTTP_HOST"].'/'.$id?>" data-text="<?=$subject;?>" <?} ?>data-via="DrKateM">Tweet</a>
				</div>
				<div class="social pinterest">
					<a href="http://pinterest.com/pin/create/button/?media=<?= urlencode('http://catherinemusemeche.com/images/kate_og.jpg') ?>&url=<?=$baseURL.urlencode('/')?><? if (!isset($_GET['id'])) { print $id; } else {print $_GET['id']; } ?>" class="pin-it-button"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
				</div>
				<div class="social gplus">
					<g:plusone href="<? if (!isset($_GET['id'])) { print 'http://'.$_SERVER["HTTP_HOST"].'/'.$id; } ?>" size="medium"></g:plusone>
				</div>
			</span>
		</div>
	</header>
	<div class="body"><?=Markdown($body)?></div>
</div>
<?
}
$curreq = $page * $perpage;
if (!$_GET['id']) {
	?>
	<div class="footnote"><div class="cf">
	<?
	if ($page > 1) {
	?>
	<a href="/blog/<?=($page - 1)?>" class="back">Go back to page <?=($page - 1)?></a>
	<?
		if ($curreq >= $totaltotal) {
		?>
			<span class="forward">Page <?=($page + 1)?></span>
		<?
		} else {
		?>
	<a href="/blog/<?=($page + 1)?>" class="forward">Continue to page <?=($page + 1)?></a>
	<?
		}
	} else {
	?>
	<span class="back">Page 1</span> <a href="/blog/<?=($page + 1)?>" class="forward">Continue to page <?=($page + 1)?></a>
	<?
	}
	?>
	</div><a href="/archives" class="archives">Archive of all posts</a></div>
	<?
}
?>
