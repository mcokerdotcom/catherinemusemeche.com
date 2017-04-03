<?
$settings = parse_ini_file('admin-settings.ini');
// Handle login
if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  if ($username == $settings[username] && $password == $settings[password]) {
    $_SESSION['name'] = 'Dr. Kate';
    $_SESSION['email'] = 'drkate@catherinemusemeche.com';
    $_SESSION['type'] = 'admin';
  } else {
    $error = "Login failed";
  }
}

// If logged in
if (isset($_SESSION['type']) && $_SESSION['type'] == 'admin') {

	// Handle new/edited post
	if (isset($_POST['subject']) && isset($_POST['body'])) {
	  $name = addslashes($_POST['name']);
	  $email = addslashes($_POST['email']);
	  $subject = addslashes($_POST['subject']);
	  $body = addslashes($_POST['body']);
	  $active = $_POST['active'];
	  date_default_timezone_set('America/Chicago');
	  if (isset($_POST['date'])) {
	    $date = $_POST['date'];
	  } else {
	    $date = date("Y-m-d H:i:s");
	  }
	  if (isset($_POST['id'])) {
	    $id = $_POST['id'];
	  } else {
	    $id = '0';
	  }
		connectdb(drkatem);
		if (isset($_POST['delete']) && $_POST['delete'] == 1 && isset($_POST['id'])) {
			$query = "delete from posts where id=$id";
		} else {
	  	$query = "replace into posts (id,name,email,subject,date,body,active) values ('$id','$name','$email','$subject','$date','$body','$active')";
		}
	  if (mysql_query($query)) {
			echo "Success. Return to the <a href=\"/?go=admin\">admin page</a>.";
	  } else {
	    die('Error: ' . mysql_error());
	  }
	  mysql_close();

	// Handle a post action
	} elseif (isset($_GET['do']) && $_GET['do'] == 'post') {

		// List posts to edit
		if (isset($_GET['edit']) && $_GET['edit'] == 'yes' && !isset($_GET['id'])) {
      print '<h4>Select a post to edit</h4>';
      connectdb(drkatem);
      $query = "select * from posts order by date desc";
      $result = mysql_query($query);
      print '<ul>';
      while ($row = mysql_fetch_array($result)) {
        ?>
        <li><a href="/?go=admin&do=post&edit=yes&id=<?=$row['id']?>"><? if (strlen($row['subject']) > 0) { print $row['subject']; } else { print '<i>No Subject</i>'; } ?></a></li>
        <?
      }
      print '</ul>';

		// Add a new post or edit an existing one
    } else {
      ?>
      <form id="adminpost" action="<?=$PHP_SELF?>" method="post" enctype="multipart/form-data">
      <?
      if (isset($_GET['edit']) && $_GET['edit'] == 'yes' && isset($_GET['id'])) {
        $id = $_GET['id'];
        connectdb(drkatem);
        $query = "select * from posts where id=$id";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        mysql_close();
        $name = $row['name'];
        $email = $row['email'];
        $subject = $row['subject'];
        $body = $row['body'];
        $active = $row['active'];
        $date = $row['date'];
        ?>
        <input type="hidden" name="date" value="<?=$date?>" />
        <input type="hidden" name="id" value="<?=$id?>" />
        <?
      }
        ?>
				<div class="row">
        	<label for="name">Name:</label>
					<input type="text" class="txt" name="name" id="name" value="<?if(isset($name)) {echo $name;} else {echo $_SESSION['name'];}?>" />
				</div>
				<div class="row">
        <label for="email">Email:</label>
				<input type="text" class="txt" name="email" id="email" value="<?if(isset($email)) {echo $email;} else {echo $_SESSION['email'];}?>" />
				</div>
				<div class="row">
        <label class="fielddesc">Subject:</label>
        <input type="text" class="txt" name="subject" value="<?if(isset($subject)) {echo $subject;}?>" />
				</div>
				<div class="row">
        <label for="admintextarea">Content:</label>
        <textarea name="body" class="txt" id="admintextarea" style="width: 100%; height: 400px"><?if(isset($body)) {echo $body;}?></textarea>
				</div>
        <label for="active">Active:</label> <input type="checkbox" <?if(isset($active)){if($active == '1'){echo 'checked="checked"';}} else {echo 'checked="checked"';}?> name="active" id="active" value="1" />
				<br>
        <label for="delete">Delete this post:</label> <input type="checkbox" name="delete" id="delete" value="1" />
        <br /><br />
        <input class="button" type="submit" value="Submit" />
        </form>
      <?
    }
	} else {
?>
  <h4>Admin Stuff</h4>
  <ul>
  <li><a href="?go=admin&do=post">Add a new post</a></li>
  <li><a href="?go=admin&do=post&edit=yes">Edit a post</a></li>
  </ul>
<? }
} else { ?>
<h4>Admin Login</h4>
  <div id="adminlogin">
    <form method="post" action="<?=$PHP_SELF?>">
			<div class="row">
      <label for="username">Username:</label>
      <input type="text" name="username" class="text" id="username" />
			</div>
			<div class="row">
      <label for="password">Password:</label>
      <input type="password" name="password" class="text" id="password" />
			</div>
      <input class="button" type="submit" value="Log In" /> <span class="error"><?=$error?></span>
    </form>
  </div>
<? } ?>
