<?php

// 管理画面のメインメニュー
function list_of_stylist(){
    add_menu_page(
        'course',                  //   第1引数　：　ページタイトル（title）,
        'スタイリスト一覧',                  //   第2引数　：　メニュータイトル,
        'manage_options',           //   第3引数　：　メニュー表示するユーザーの権限,
        'list_of_stylist',          //   第4引数　：　メニューのスラッグ,
        'add_list_of_stylist',      //   第5引数　：　メニュー表示時に使われる関数,
        'dashicons-admin-generic',  //   第6引数　：　メニューのテキスト左のアイコン,
        3                           //   第7引数　：　メニューを表示する位置;
    );
}
function add_list_of_stylist(){
    $stylists = get_stylists();
    include 'admin_views/stylist_list.php';
}
add_action('admin_menu', 'list_of_stylist');



// 管理画面のサブメニュー
function add_custom_submenu_page_stylist(){
    add_submenu_page('list_of_stylist', 'スタイリスト登録', 'スタイリスト登録', 'manage_options', 'register_stylist_page', 'add_register_stylist_menu_page', 2);
    add_submenu_page('list_of_stylist', 'スタイリストプロフィール', 'スタイリストプロフィール', 'manage_options', 'edit_stylist_page', 'add_edit_stylist_menu_page', 5);
}
function add_register_stylist_menu_page(){
    include 'admin_views/stylist_create.php';
}
function add_edit_stylist_menu_page(){
    include 'admin_views/stylist_edit.php';
}
add_action('admin_menu', 'add_custom_submenu_page_stylist');













function get_stylists(){
	global $wpdb;
	$query="SELECT *
            FROM stylist
            WHERE deleted_at IS NULL
            ";
	$results = $wpdb->get_results($query);
    $results = set_displayStatuses($results);
	return $results;
}

function get_stylist($id){
	global $wpdb;
	$query="SELECT *
            FROM stylist
            WHERE id = $id
            ";
	$result = $wpdb->get_row($query);
    $result = set_display_status($result);
	return $result;
}

function set_displayStatuses($dates){
    foreach($dates as $date){
        $date = set_display_status($date);
    }
    return $dates;
}

function set_display_status($date){
    if($date->display_flg == 1){
        $date->display_status = "表示";
    }else if($date->display_flg == 0){
        $date->display_status = "非表示";
    }
    return $date;
}

