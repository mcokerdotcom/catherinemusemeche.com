<?
include('db.php');
connectdb('drkatem');
date_default_timezone_set('America/Chicago');
header("Content-Type: application/rss+xml; charset=ISO-8859-1");?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>Catherine Musemeche's Blog</title>
		<link>http://www.catherinemusemeche.com</link>
		<description>Dr Kate's blog, and the life of a pediatric surgeon</description>
<?
$query = 'select * from posts where active=1 order by date desc limit 1';
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$date = date('D, d M Y H:i:s T',strtotime($row['date']));
?>
		<lastBuildDate><?=$date?></lastBuildDate>
		<language>en-us</language>
<?
$query2 = 'select * from posts where active=1 order by date desc limit 20';
$result2 = mysql_query($query2);
while ($row2 = mysql_fetch_assoc($result2)) {
	$date2 = date('D, d M Y H:i:s T',strtotime($row2['date']));
?>
		<item>
			<title><?=htmlentities($row2['subject'])?></title>
			<link>http://www.catherinemusemeche.com/<?=$row2['id']?></link>
			<guid>http://www.catherinemusemeche.com/<?=$row2['id']?></guid>
			<pubDate><?=$date2?></pubDate>
			<description><?=htmlentities($row2['body'])?></description>
		</item>
<?} mysql_close();?>
</channel>
</rss>
