<?php

/** WordPress Administration Bootstrap */
require_once __DIR__ . '/admin.php';

class Stylist {

	public function register() {
		try {
			// バリデーションチェック
			$this->validationCheck();

			// 登録処理
			$this->registerStylist();

			add_settings_error( 'settings_errors', 'settings_errors', '登録が完了しました。', 'success' );
			// add_settings_error()した内容を、DBに一時保存する
			set_transient( 'settings_errors', get_settings_errors(), 30 );

			$goBack = add_query_arg( 'settings-updated', 'true', get_home_url().'/wp-admin/admin.php?page=edit_stylist_page&id='.$this->_id );
			wp_redirect( $goBack );
			exit;
		} catch (\Exception $e) {
			foreach($this->_err_lists as $err_list){
				add_settings_error( 'settings_errors', 'settings_errors', $err_list, 'error' );
			}

			// add_settings_error()した内容を、DBに一時保存する
			set_transient( 'settings_errors', get_settings_errors(), 30 );

			$date = array(
				'settings-updated' => true,
				'display_name'      => $this->_display_name,
				'display_read'      => $this->_display_read,
				'shop_id'      => $this->_shop_id,
				'status_id'      => $this->_status_id,
				'display_flg'      => $this->_display_flg,
			);
			// Redirect back to the settings page that was submitted.
			$goback = add_query_arg( $date, wp_get_referer() );
			wp_redirect( $goback );
			exit;
		}
	}

	public function update() {
		try {
			// バリデーションチェック
			$this->validationCheck();
			$this->_id = $_POST['id'] ;

			// 更新処理
			$this->updateStylist();

			// var_dump($this->_id);exit;
			add_settings_error( 'settings_errors', 'settings_errors', '更新しました', 'success' );
			// add_settings_error()した内容を、DBに一時保存する
			set_transient( 'settings_errors', get_settings_errors(), 30 );

			$goBack = add_query_arg( 'settings-updated', 'true', wp_get_referer() );
			// $goBack = add_query_arg( 'settings-updated', 'true', get_home_url()."/wp-admin/admin.php?page=list_of_stylist");
			wp_redirect( $goBack );
			exit;

		} catch (\Exception $e) {

			// If no settings errors were registered add a general 'updated' message.
			foreach($this->_err_lists as $err_list){
			add_settings_error( 'settings_errors', 'settings_errors', $err_list, 'error' );
			}

			// add_settings_error()した内容を、DBに一時保存する
			set_transient( 'settings_errors', get_settings_errors(), 30 );

			// Redirect back to the settings page that was submitted.
			$goback = add_query_arg( 'settings-updated', 'true', wp_get_referer() );
			wp_redirect( $goback );
			exit;
		}
	}

	public function delete() {
		try {
			$id = $_POST['id'];
			$timestamp = date('Y-m-d h:i:s');
			$user = wp_get_current_user();
			$userId = $user->id;

			global $wpdb;
			$wpdb->update(
				'stylist',
				array(
					'deleted_at' => $timestamp,
					'deleted_by' => $userId,
				),
				// where句
				array( 'id' =>  $id )
			);

			add_settings_error( 'settings_errors', 'settings_errors', '削除が完了しました。', 'success' );
			// add_settings_error()した内容を、DBに一時保存する
			set_transient( 'settings_errors', get_settings_errors(), 30 );

			$goBack = add_query_arg( 'settings-updated', 'true', get_home_url()."/wp-admin/admin.php?page=list_of_stylist");
			wp_redirect( $goBack );
			exit;

		} catch (\Exception $e) {
			$_SESSION['error']= $e->getMessage();
		}
	}

	public function validationCheck(){

		$this->_display_name = $_POST['display_name'] ;
		$this->_display_read = $_POST['display_read'] ;
		$this->_shop_id = $_POST['shop_id'] ;
		$this->_display_flg = $_POST['display_flg'] ;
		$this->_img_pass = $_POST['stylist_img_url_id'] ;
		$this->_status_id = $_POST['status_id'] ;

		// エラーチェックを行う
		$this->_err_lists = [];
		if( !$this->_display_name ) array_push($this->_err_lists,'スタイリスト名 が入力されていません');
		if( !$this->_display_read ) array_push($this->_err_lists,'スタイリスト名 ヨミ が入力されていません');
		if( !$this->_shop_id ) array_push($this->_err_lists,'所属店舗が選択されていません');
		if( !isset($this->_status_id) ) array_push($this->_err_lists,'在籍が選択されていません');
		if( !isset($this->_display_flg) ) array_push($this->_err_lists,'HP表示が選択されていません');
		if( $this->_img_pass == "") array_push($this->_err_lists,'画像が選択されていません');

		if($this->_err_lists) throw new \Exception();
	}

	public function registerStylist(){
		global $wpdb;
		$wpdb->insert(
				'stylist',
			array(
				'display_name' => $this->_display_name,
				'display_read' => $this->_display_read,
				'shop_id' => $this->_shop_id,
				'display_flg' => $this->_display_flg,
				'status_id' => $this->_status_id,
				'img_pass' => $this->_img_pass,
				//	),array(
				//	  '%s', //date
				//	  '%s', //open_time
				//	  '%d', //course_id
				//	  '%d', //price
				//	  '%d', //instructor_id
				//	  '%d', //erea
				//	  '%s', //comment
				//	  '%s'  //
			)
		);

		$this->_id = $wpdb->insert_id;
		if(!$this->_id){
			array_push($this->_err_lists,'登録に失敗しました。');
			throw new \Exception();
		}

		// 並び順を最後尾に決めておく
		$wpdb->update(
			'stylist',
			array(
				'display_rank' => $this->_id
			),
			array( 'id' =>  $this->_id ),
		);
	}

	public function updateStylist(){
		global $wpdb;
		$wpdb->update(
			'stylist',
			array(
				'display_name' => $this->_display_name,
				'display_read' => $this->_display_read,
				'shop_id' => $this->_shop_id,
				'display_flg' => $this->_display_flg,
				'status_id' => $this->_status_id,
				'img_pass' => $this->_img_pass,
			),
			array( 'id' => $this->_id ), // WHERE句
		);
	}

}

$stylist = new Stylist();
if ($_SERVER['REQUEST_METHOD'] === 'POST') { //POSTが渡されたら
	if($_POST['update'] )$stylist -> update();
	if($_POST['register'] )$stylist -> register();
	if($_POST['delete'] )$stylist -> delete();
}

?>

