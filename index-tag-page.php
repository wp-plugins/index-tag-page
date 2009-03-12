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
function tagIndex_init($atts) {
	function tagIndexDisplay_function($atts) {
		extract(shortcode_atts(array(
			'nb' => '',
			'ul' => 'itpUl',
			'li' => 'itpLi',
			'letter' => 'itpLetter'
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
				$ret .= $start;
				
				 
				
				$ret .= "<ul>";
				$ret .= "<li>$untag</li>";
			}
		}
		
		if($menu){
			$retMenu = "<ul id=\"iapAlpha\">\n";
			foreach($alpha as $alphabet){
				$retMenu .= "\t<li><a href=\"#iap".$alphabet."\">".$alphabet."</a></li>\n";
			}
			$retMenu .= "</ul>";
		}
		$ret .= "</div>";
		$retMenu .= $ret;
		$retMenu .= '<div id="index-authors-page">';

		return $retMenu;
	} 
	
	add_shortcode('indextag', 'tagIndexDisplay_function');
}
add_action('plugins_loaded', 'tagIndex_init');

?>