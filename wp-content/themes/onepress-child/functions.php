<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}




// ショートコード
function hello_func() {
    return "hello shortcode!";
}



function show_stylist_list($parameter) {
	// パラメータのデフォルトと引数の設定
	$parameter = shortcode_atts(array(
		"shop" => NULL,
	),$parameter);
	$shop = $parameter['shop'];
    if(!$shop) return "引数がありません" ;

	// データの取得
	global $wpdb;

	$query="SELECT * FROM stylist
            WHERE shop_id = $shop
            AND status_id = 1
            ";
	$results = $wpdb->get_results($query);

	$HTML = '' ;
	$HTML = '<div class="shopStaffs">';
    foreach ($results as $result){
        $HTML .= '<div class="staffItem scroll_animation">';
            $HTML .= '<div class="listIMG"><img src="https://ur-hairmake.com/img/staff/S__46334114.jpg" class=" alt="" ></div>';
            $HTML .= '<div class="staffName">'. $result->display_name .'</div>';
            // $HTML .= '<hr class="staffHR">';
            $HTML .= '<div class="staffCatchCopy">キャッチコピー</div>';
        $HTML .= '</div>';
    }
    $HTML .= '</div>';

    return $HTML;

}
add_shortcode('show_stylist', 'show_stylist_list');



