<?php   
	/* 
	Plugin Name: Index Tag Page 
	Plugin URI: http://www.kune.fr 
	Description: Plugin for displaying tag link index 
	Author: Mat_
	Version: 1.1 
	Author URI: http://www.kune-studio.com 
	*/  
?>

<?php 
function tagIndex_init($atts) {
	function tagIndexDisplay_function($atts) {
		extract(shortcode_atts(array(
			'nb' => '',
			'ul' => '',
			'li' => '',
			'letter' => ''
		), $atts));
		if($nb != '') $nb = "number=$nb&";
		$tag = wp_tag_cloud($nb.'format=array&smallest=8&largest=8' );
		$start = "0";
		$ret = "";
		if($ul != '') $ul = " class=\"$ul\" ";
		else $ul = " class=\"itpUl\" ";
		
		if($li != '') $li = " class=\"$li\" ";
		else $li = " class=\"itpLi\" ";
		
		foreach($tag as $untag){
			
			ereg(">([A-Za-z0-9\.|-|_éàèêç ]*)</a>",$untag, $letag);
			
			$letag[1] = ucfirst($letag[1]);

			if($start == "0"){
				$start = $letag[1][0];
				if($letter != '') $letter = " class=\"$letter itp".$start." \" ";
				else $letter = " class=\"itpLetter itp".$start." \" ";
				$ret .= "<span ".$letter.">".$start."</span>";
				$ret .= "<ul $ul>";
			}
			if($letag[1][0] == $start)
				$ret .= "<li ".$li.">$untag</li>";
			else{
				$ret .= "</ul>";
				$start = $letag[1][0];
				$ret .= $start;
				
				 
				
				$ret .= "<ul>";
				$ret .= "<li>$untag</li>";
			}
		}
		
		return $ret;
	} 
	
	add_shortcode('indextag', 'tagIndexDisplay_function');
}
add_action('plugins_loaded', 'tagIndex_init');

?>