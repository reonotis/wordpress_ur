<?php


add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
}




include 'setting_stylist.php';





// ショートコード
function show_stylists_list($parameter) {
	// パラメータのデフォルトと引数の設定
	$parameter = shortcode_atts(array(
		"shop" => NULL,
	),$parameter);
	$shop = $parameter['shop'];
    if(!$shop) return "引数がありません" ;

	// データの取得
	global $wpdb;

	$query="SELECT stylist.*, shop.shop_code
            FROM stylist
            LEFT JOIN shop ON shop.id = stylist.shop_id
            WHERE stylist.shop_id = $shop
            AND stylist.display_flg = 1
            ORDER BY stylist.display_rank
            ";
	$results = $wpdb->get_results($query);

	$HTML = '' ;
	$HTML = '<div class="shopStaffs">';
    foreach ($results as $result){
        $HTML .= '<div class="staffItem">';
            $HTML .= '<a href="./staff?id='. $result->id .'" >';
                $HTML .= '<div class="listIMG scroll_animation scroll_animation_type_'. $result->shop_code .'"><img src="'. wp_get_attachment_url($result->img_pass) .'" class="" alt="" ></div>';
            $HTML .= '</a>';
            $HTML .= '<div class="staffName">'. $result->display_name .'</div>';
            // $HTML .= '<hr class="staffHR">';
            $HTML .= '<div class="staffCatchCopy">'. $result->catch_copy .'</div>';
        $HTML .= '</div>';
    }
    $HTML .= '</div>';

    return $HTML;

}
add_shortcode('show_stylists_list', 'show_stylists_list');

// スタイリストを表示する。
function show_stylist() {
    // パラメーター「id」の値を取得
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }else{
        $id = 1;
    }
    $id = htmlspecialchars($id, ENT_QUOTES);

    global $wpdb;
	$query="SELECT * FROM stylist
            WHERE id = $id ";
	$result = $wpdb->get_row($query);

    if(!$result){
        return "不正なパラメータが渡されました。";
    }

	$HTML = '' ;
	$HTML = '<div class="stylistContainer">';
        $HTML .= '<div class="stylistContents">';
            $HTML .= '<div class="stylistImgContent scroll_animation">';
                $HTML .= '<img src="'. wp_get_attachment_url($result->img_pass) .'" class=" alt="" >';
            $HTML .= '</div>';
            $HTML .= '<div class="stylistContent">';
                $HTML .= '<div class="stylistContentName scroll_animation">'.$result->display_name. '</div>';
                $HTML .= '<div class="stylistContentRead">'.$result->display_read. '</div>';
                $HTML .= '<div class="stylistContentCatchCopy">';
                    $HTML .= $result->catch_copy;
                $HTML .= '</div>';
                $HTML .= '<div class="stylistContentComment">';
                    $HTML .= '';
                $HTML .= '</div>';
            $HTML .= '</div>';
        $HTML .= '</div>';
	$HTML .= '</div>';

    return $HTML;
}
add_shortcode('show_stylist', 'show_stylist');








function set_shop_name($data){
    if($data->shop_id==1){
        $data->shop_name = "castle";
    }
    if($data->shop_id==2){
        $data->shop_name = "delta";
    }
    if($data->shop_id==3){
        $data->shop_name = "arche";
    }
    return $data;
}











function load_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'load_media_files' );

//画像アップロード用のタグを出力する
function generate_upload_image_tag($value){?>
    <!-- <input name="stylist_img_url" type="text" class="regular-text" value="<?= $value; ?>"  readonly /> -->

    <script type="text/javascript">
        (function ($) {
            var custom_uploader;
            $("input:button[name=stylist_img_url_slect]").click(function(e) {
                e.preventDefault();
                if (custom_uploader) {
                    custom_uploader.open();
                    return;
                }
                custom_uploader = wp.media({
                    title: "画像を選択してください",
                    /* ライブラリの一覧は画像のみにする */
                    library: {
                        type: "image"
                    },
                    button: {
                        text: "画像の選択"
                    },
                    /* 選択できる画像は 1 つだけにする */
                    multiple: false
                });
                custom_uploader.on("select", function() {
                    var images = custom_uploader.state().get("selection");
                    /* file の中に選択された画像の各種情報が入っている */
                    images.each(function(file){
                        /* テキストフォームと表示されたサムネイル画像があればクリア */
                        $("#stylist_img_url_thumbnail").empty();
                        $("input:hidden[name=stylist_img_url_id]").val("");
                        // console.log(file.attributes);

                        /* テキストフォームに画像の URL を表示 */
                        /* プレビュー用に選択されたサムネイル画像を表示 */
                        $("#stylist_img_url_thumbnail").append('<img src="'+file.attributes.sizes.medium.url+'" />');
                        $("input:hidden[name=stylist_img_url_id]").val(file.attributes.id);
                    });
                });
                custom_uploader.open();
            });
            /* クリアボタンを押した時の処理 */
            $("input:button[name=stylist_img_url_clear]").click(function() {
                $("#stylist_img_url_thumbnail").empty();
                $("input:hidden[name=stylist_img_url_id]").val("");
            });
        })(jQuery);
    </script>
<?php
}
?>