<?php
if (isset($_POST['text_submission'])) {
        $submission = $_POST['text_submission'];
        $realfile = $_POST['file'];
        $submission = stripslashes("$submission");
        $fp = fopen($realfile,'w+');
        fwrite ($fp, "$submission");
        fclose ($fp);
        print "modifications done. return to the <a href=\"/\">main page</a>";
        exit;
}
if (isset($_GET['file'])) {
        $realfile = 'content/' . $_GET['file'];
        if (is_file($realfile)) {
                $file_array = file($realfile);
                {?>
                <html>
                <head>
                <title>editing <?}print $realfile;{?></title>
                </head>
                <body>
                <form method="post" action="<?}print $_SERVER["REQUEST_URI"];{?>">
                <textarea style="width:100%;height:500px" name="text_submission"><?}
                foreach ($file_array as $text) {
                        print $text;
                }
                {?></textarea><br>
                <input class="button" type="submit" value="submit">
                <input type="hidden" name="file" value="<?php echo $realfile;?>">
                </form>
                </body>
                </html>
        <?}
        } else {
                echo "file not there";
        }
} else {
        print 'Files you can edit:<ul>';
        $dirpath = "content";
        $dh = opendir($dirpath);
        while (false !== ($file = readdir($dh))) {
                if (!is_dir("$dirpath/$file") && !preg_match("/^\./",$file)) {
                        print "<li><a href=\"{$_SERVER["REQUEST_URI"]}&file=$file\">$file</a></li>\n";
                }
        }
        closedir($dh);
        print '</ul>';
}
?>
