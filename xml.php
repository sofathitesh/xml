<?php

/**
 * Plugin Name:XML PARSE
 * Auther:Hitesh Sofat
 * Url:hiteshkumarsofat.wordpress.com
 **/

header('Content-Type:text/html; charset=utf-8; charset=ISO-8859-1');
include("db_connection.php");
include("functions.php");

add_action('init', 'xml_button');

function xml_button()
{
    add_filter("mce_external_plugins", "xml_add_button");
    add_filter("mce_buttons", "xml_register_button");
}

function xml_add_button($plugin_array)
{
    $plugin_array['mycodebutton'] = $dir = plugins_url('shortcode.js', __FILE__);
    return $plugin_array;
}

function xml_register_button($buttons)
{
    array_push($buttons, 'codebutton');
    return $buttons;
}

add_action('admin_menu', 'register_my_custom_menu_page');

function register_my_custom_menu_page()
{
    add_menu_page('custom menu title', 'xml parser', 'manage_options', 'xmlparse', 'my_custom_menu_page', '', 6);
}

function my_custom_menu_page()
{
    if (isset($_POST['s'])) {
	set_path();
    }
    $html = "<form action='' method='post' enctype ='multipart/form-data'><table><tr><td>Set the brlcad article path</td><td><input type='text' name='t1' required>(ex:-/var/www/html/trunk/doc/docbook/articles/)</td></tr><tr><td>Set The Brlcad XSL stylesheet path</td><td><input type='text' name='f' required>(ex:-/var/www/html/trunk/doc/docbook/)</td></tr><tr><td><input type='submit' name='s' value='set or update'></td></tr></table></form>";
    echo $html;
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Mysql connection error");
    $article_path = $connection->query("select * from locat where flag='ap'");
    $show_all_location_paths = mysqli_fetch_array($article_path);
    $xsl_path = $connection->query("select * from locat where flag='xslp'");
    $show_all_xsl_paths = mysqli_fetch_array($xsl_path);
    echo "<table border='1' style='width:100%'><tr><th>Title</th><th>Path</th></tr>";
    echo "<tr><td>Article Path</td><td>".$show_all_location_paths['path']."</td></tr>";
    echo "<tr><td>XSL Stylesheet</td><td>".$show_all_xsl_paths['path']."</td></tr></table>";
    echo "<h4>Add this short code in your post for apply this plugin <code>[search]</code></h4>"; 
}

function language_convert()
{
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Mysql connection error");
    $article_path = $connection->query("select * from locat where flag='ap'");
    $show_all_location_paths = mysqli_fetch_array($article_path);
    $xsl_path = $connection->query("select * from locat where flag='xslp'");
    $show_all_xsl_paths = mysqli_fetch_array($xsl_path);
    $dir = $show_all_location_paths['path'].'*';
    $default_xsl_dir = $show_all_xsl_paths['path'];
    $default_dir = $show_all_location_paths['path'];
    $dir = glob($dir, GLOB_ONLYDIR);
    $size = sizeof($dir);
    $c = 0;
    for ($i = 0; $i < $size; $i++) {
	$explode_data_value = explode("/", $dir[$i]);
	$new_data_array[$c] = end($explode_data_value);
	$c++;
    }
    $new_size = sizeof($new_data_array);
    echo "<form action='' method='post'><table style='width:30%'><tr><td><select name='s1'><option>Select the lanuage</option>";
    for ($j = 0; $j <= $new_size; $j++) {
	if (strlen($new_data_array[$j]) < 4) {
	    echo "<option>".$new_data_array[$j]."</option>";
	}
    }
    echo "</select></td><td><input type='submit' value='change'></td></tr></table></form>";
    if (isset($_POST['s1'])) {
	if ($_POST['s1'] == 'en') {
	    $xml_def = new DOMDocument;
	    $xml_def->load($default_dir.'/en/about.xml');
	    $xsl_def = new DOMDocument;
	    $xsl_def->load($default_xsl_dir.'/resources/brlcad/brlcad-presentation-xhtml-stylesheet.xsl');
	    $proc_def = new XSLTProcessor;
	    $proc_def->importStyleSheet($xsl_def); // attach the xsl rules
	    $extra_content = $proc_def->transformToXML($xml_def);
	    $remove_extra_content = str_replace("Christopher", "", $extra_content);
	    $remove_extra_content2 = str_replace("Sean", "", $remove_extra_content);
	    $remove_extra_content3 = str_replace("Morrison", "", $remove_extra_content2);
	} else {
	    $xml = new DOMDocument;
	    $xml->load($default_dir.$_POST['s1'].'/about_'.$_POST['s1'].'.xml');
	    $xsl_def = new DOMDocument;
	    $xsl_def->load($default_xsl_dir.'/resources/brlcad/brlcad-presentation-xhtml-stylesheet.xsl');
	    $proc_def = new XSLTProcessor;
	    $proc_def->importStyleSheet($xsl_def); // attach the xsl rules
	    $extra_data = $proc_def->transformToXML($xml);
	    $remove_extra_data = str_replace("Christopher", "", $extra_data);
	    $remove_extra_data2 = str_replace("Sean", "", $remove_extra_data);
	    $remove_extra_data3 = str_replace("Morrison", "", $remove_extra_data2);
	    $remove_extra_data4 = str_replace("Karen", "", $remove_extra_data3);
	    $remove_extra_data5 = str_replace("Mgebrova", "", $remove_extra_data4);
	    echo $remove_extra_content6 = str_replace("Ilya", "", $remove_extra_data5);
	}
    } else {
	    $xml_def = new DOMDocument;
	    $xml_def->load($default_dir.'/en/about.xml');
	    $xsl_def = new DOMDocument;
	    $xsl_def->load($default_xsl_dir.'/resources/brlcad/brlcad-presentation-xhtml-stylesheet.xsl');
	    $proc_def = new XSLTProcessor;
	    $proc_def->importStyleSheet($xsl_def); // attach the xsl rules
	    $extra_data = $proc_def->transformToXML($xml_def);
	    $remove_extra_data = str_replace("Christopher", "", $extra_data);
	    $remove_extra_data2 = str_replace("Sean", "", $remove_extra_data);
	    echo $remove_extra_data3 = str_replace("Morrison", "", $remove_extra_data2);
	}
}

add_shortcode('search', 'language_convert');
?>
