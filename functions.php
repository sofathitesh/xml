<?php
function set_path()
{
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Mysql connection error");
    $article_path = $connection->query("select * from locat where flag='ap'");
    $article_num_rows = $article_path->num_rows;
    if ($article_num_rows == 0) {
	$store_article_path = $connection->query("insert into locat values('','".$_POST['t1']."','ap')");
	echo "<b><font color='blue'>Article path is stored.</font></b>";
    } else {
	$update_article_path = $connection->query("update locat set `path`='".$_POST['t1']."' where flag='ap'");
	echo "<b><font color='blue'> Article path is stored.</font></b>";
    }

    $xsl_path = $connection->query("select * from locat where flag='xslp'");
    $xsl_num_rows = $xsl_path->num_rows;
   
    if ($xsl_num_rows == 0) {
	$store_xsl_path = $connection->query("insert into locat values('','".$_POST['f']."','xslp')");
	echo "<b><font color='blue'> XSL stylesheet path is stored.</font></b>";
    } else {
	$update_xsl_path = $connection->query("update locat set `path`='".$_POST['f']."' where flag='xslp'");
	echo "<b><font color='blue'> XSL stylesheet path is stored.</font></b>";
    }
}
?>
