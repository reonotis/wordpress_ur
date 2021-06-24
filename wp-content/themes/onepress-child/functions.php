<?php

function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );






include 'setting_stylist.php';





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
            AND display_flg = 1
            ";
	$results = $wpdb->get_results($query);

	$HTML = '' ;
	$HTML = '<div class="shopStaffs">';
    foreach ($results as $result){
        $HTML .= '<div class="staffItem scroll_animation">';
            $HTML .= '<div class="listIMG"><img src="'. wp_get_attachment_url($result->img_pass) .'" class=" alt="" ></div>';

            $HTML .= '<div class="staffName">'. $result->display_name .'</div>';
            // $HTML .= '<hr class="staffHR">';
            $HTML .= '<div class="staffCatchCopy">キャッチコピー</div>';
        $HTML .= '</div>';
    }
    $HTML .= '</div>';

    return $HTML;

}
add_shortcode('show_stylist', 'show_stylist_list');



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