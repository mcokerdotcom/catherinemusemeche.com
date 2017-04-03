<h2 class="title">Dr. Kate's blog archived by date</h2>
<?
connectdb(drkatem);
$query = 'select * from posts where active=1 order by date desc';
$result = mysql_query($query);
$first = 1;
while ($row = mysql_fetch_assoc($result)) {
	
	$oldmonthyear = $monthyear;
	$monthyear = date('F Y',strtotime($row['date']));
	if ($monthyear != $oldmonthyear) {
		if ($first != '1') {
			echo '</ul>';
		}
		echo '<h3>'.$monthyear.'</h3>';
		echo '<ul>';
	}
	echo '<li><a href="/'.$row['id'].'">'.$row['subject'].'</a></li>';
	$first = '0';
}
?>
</ul>
