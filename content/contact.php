<?
if (isset($_POST['contactName']) && isset($_POST['contactEmail']) && isset($_POST['contactBody'])) {
	$contactName = trim($_POST['contactName']);
	$contactEmail = trim($_POST['contactEmail']);
	$contactBody = trim($_POST['contactBody']);
	$contactSubject = "Dr Kate's Contact Form";
	$_SESSION['contactName'] = $contactName;
	$_SESSION['contactEmail'] = $contactEmail;
	$_SESSION['contactBody'] = $contactBody;
	$error = 1;
	$msg = 'there were be an error';
	if (isset($_POST['jsValid']) || strlen($contactName) > '0' && strlen($contactBody) > '0' && preg_match('/^([\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+\.)*[\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+@((((([a-z0-9]{1}[a-z0-9\-]{0,62}[a-z0-9]{1})|[a-z])\.)+[a-z]{2,6})|(\d{1,3}\.){3}\d{1,3}(\:\d{1,5})?)$/i',$contactEmail)) {
		if (mail('kmusemeche@aol.com', $contactSubject, $contactBody, "From: \"$contactName\" <$contactEmail>")) {
			$sent = 1;
			unset($_SESSION['contactName']);
			unset($_SESSION['contactEmail']);
			unset($_SESSION['contactBody']);
		}
	}
}

if ($sent == "1") {
	?>
	<h3>Sent!</h3>
	<p>Thanks.</p>
	<?
} else {
?>
<? /*
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#contactName").focus();
	$("#contactForm").validate({
		submitHandler: function() {
			var contactName = $("#contactName").val();
			var contactEmail = $("#contactEmail").val();
			var contactBody = $("#contactBody").val();
			var dataString = "contactName="+contactName+"&contactEmail="+contactEmail+"&contactBody="+contactBody+"&jsValid";
			$.ajax({
				type: "POST",
				data: dataString,
				dataType: 'html',
				url: "<?=$_SERVER['REQUEST_URI'];?>",
				success: function(msg) {
					$("#contactForm").fadeOut('slow', function() {
						$("#contactForm").css("opacity","1");
						$("#contactForm").html('<p class="success">Thank you for your message!</p>');
						$("#contactForm").fadeIn();
						setTimeout("location.href = '<?=$_SERVER['REQUEST_URI'];?>';",3000);
					});
				}  
			});  
			return false;  
		}
	});
});
</script>
*/ ?>
<div id="contactArea">
<h1 class="title">Contact Dr. Kate</h1>
<h3><span>Email:</span> <a href="mailto:drkate@catherinemusemeche.com">drkate@catherinemusemeche.com</a></h3>
<h3><span>Twitter:</span> <a href="http://twitter.com/drkatem">@DrKateM</a></h3>
<h3>Represented by <a href="mailto:laurie@defliterary.com">Laurie Abkemeier</a>, Literary Agent for <a href="http://www.defliterary.com/">DeFiore and Company</a></h3>
<h3><span>Media Inquiries:</span> <a href="mailto:Barbara.L.Briggs@dartmouth.edu">Barbara.L.Briggs@dartmouth.edu</a></h3>
<?
/*
<br>
<h3 class="formHeader">Or use the form below:</h3>
<form name="contactForm" action="<?=$_SERVER['REQUEST_URI']?>" method="post" id="contactForm">
	<label for="contactName">Name:</label> <label class="error" for="contactName">What's your name?</label>
	<input name="contactName" id="contactName" class="txt required" type="text"<? echo ($_SESSION['contactName']) ? ' value="'.$_SESSION['contactName'].'"' : '' ?> />
	<label for="contactEmail">Email:</label> <label class="error" for="contactEmail">What's your email?</label>
	<input name="contactEmail" id="contactEmail" class="txt required email" type="text"<? echo ($_SESSION['contactEmail']) ? ' value="'.$_SESSION['contactEmail'].'"' : '' ?> />
	<label for="contactBody">Message:</label> <label class="error" for="contactBody">What's your message?</label>
	<textarea id="contactBody" class="required" name="contactBody"><? echo ($_SESSION['contactBody']) ? $_SESSION['contactBody'] : '' ?></textarea>
	<input type="submit" value="Send" />
	<?
	if ($error && $msg) {
		print '<span class="error">' . $error . '</span>';
		print '<span class="error">' . $msg . '</span>';
	}
	?>
</form>
*/
?>
</div>
<? } ?>
