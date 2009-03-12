<?php   
	/* 
	Plugin Name: Index Tag Page 
	Plugin URI: http://www.kune.fr 
	Description: Plugin for displaying tag link index 
	Author: Mat_
	Version: 1.2 
	Author URI: http://www.kune-studio.com 
	*/  
?>

<?php 
function tagIndexPage_init($atts) {
	function tagIndexPageDisplay_function($atts) {
		extract(shortcode_atts(array(
			'nb' => '',
			'ul' => 'itpUl',
			'li' => 'itpLi',
			'letter' => 'itpLetter',
			'menu' => true
		), $atts));
		if($nb != '') $nb = "number=$nb&";
		$tag = wp_tag_cloud($nb.'format=array&smallest=8&largest=8' );
		$start = "0";
		$ret = "";
		$ul = " class=\"$ul\" ";
		$li = " class=\"$li\" ";
		$alpha = array();
		$i = 0;
		foreach($tag as $untag){
			
			ereg(">([A-Za-z0-9\.|-|_éàèêç ]*)</a>",$untag, $letag);
			
			$letag[1] = ucfirst($letag[1]);

			if($start == "0"){
				$start = $letag[1][0];
				$alpha[$i] = $start;
				$i ++;
				$letter = " class=\"$letter itp".$start." \" ";
				$ret .= "<span ".$letter.">".$start."</span>";
				$ret .= "<ul $ul>";
			}
			if($letag[1][0] == $start)
				$ret .= "<li ".$li.">$untag</li>";
			else{
				$ret .= "</ul>";
				$start = $letag[1][0];
				$alpha[$i] = $start;
				$i ++;
				$ret .= "<span ".$letter.">".$start."</span>";

				 
				
				$ret .= "<ul $ul>";
				$ret .= "<li>$untag</li>";
			}
		}
		
		if($menu){
			$retMenu = "<ul id=\"itpAlpha\">\n";
			foreach($alpha as $alphabet){
				$retMenu .= "\t<li><a href=\"#itp".$alphabet."\">".$alphabet."</a></li>\n";
			}
			$retMenu .= "</ul>";
		}
		$ret .= "</div>";
		$retMenu .= $ret;
		$retMenu .= '<div id="index-tag-page">';

		return $retMenu;
	} 
	
	add_shortcode('indextag', 'tagIndexPageDisplay_function');
}
function tagsiindexpage_insert_css()
{
echo '<link rel="stylesheet" href="'.get_option('siteurl').'/wp-content/plugins/index-tag-page/tagindex.css" type="text/css" media="screen" />'."\n";
}
add_action('wp_head', 'tagsiindexpage_insert_css');
add_action('plugins_loaded', 'tagIndexPage_init');

?>