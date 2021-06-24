
<div class="wrap">

    <!-- 一覧画面 -->
    <h1 class="wp-heading-inline">スケジュール登録</h1>

    <?php settings_errors(); ?>
    <!-- <table class="widefat fixed striped"> -->

    <form name="createuser" action="controller_stylist.php" method="post" >
        <?php settings_fields( 'company_settings' ); ?>
        <?php do_settings_sections( 'company_settings' ); ?>

        <table class="form-table" role="presentation" >
            <tbody>
                <tr class="form-field form-required">
                    <th scope="row"><label for="display_name">スタイリスト名 <span class="description" >(必須)</span></label></th>
                    <td><input name="display_name" type="text" value="<?= $_GET['display_name'] ?>" id="display_name" style="width:25em;" ></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="display_read">スタイリスト名 ヨミ<span class="description" >(必須)</span></label></th>
                    <td><input name="display_read" type="text" value="<?= $_GET['display_read'] ?>" id="display_read" style="width:25em;" ></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="target">所属店舗<span class="description" >(必須)</span></label></th>
                    <td>
                        <label><input type="radio" name="shop_id" value="1" <?php if($_GET['shop_id'] == 1)echo ' checked="checked"' ;?> >CASTLE</label>
                        <label><input type="radio" name="shop_id" value="2" <?php if($_GET['shop_id'] == 2)echo ' checked="checked"' ;?> >DELTA</label>
                        <label><input type="radio" name="shop_id" value="3" <?php if($_GET['shop_id'] == 3)echo ' checked="checked"' ;?> >Arche</label>
                    </td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="course_text">在籍<span class="description" >(必須)</span></label></th>
                    <td>
                        <label><input type="radio" name="status_id" value="1" <?php if($_GET['status_id'] === "1")echo ' checked="checked"' ;?>  >在籍</label>
                        <label><input type="radio" name="status_id" value="0" <?php if($_GET['status_id'] === "0")echo ' checked="checked"' ;?>  ></label>
                    </td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="course_text">HP表示<span class="description" >(必須)</span></label></th>
                    <td>
                        <label><input type="radio" name="display_flg" value="1" <?php if($_GET['display_flg'] === "1")echo ' checked="checked"' ;?> >表示</label>
                        <label><input type="radio" name="display_flg" value="0" <?php if($_GET['display_flg'] === "0")echo ' checked="checked"' ;?> >非表示</label>
                    </td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><label for="course_text">画像</label></th>
                    <td>
                        <div id="stylist_img_url_thumbnail" class="uploded-thumbnail"></div>
                        <input type="button" name="stylist_img_url_slect" value="選択" />
                        <input type="button" name="stylist_img_url_clear" value="クリア" />
                        <input type="hidden" name="stylist_img_url_id" value="" />
                        <?php generate_upload_image_tag( get_option('stylist_img_url')); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="register" value="register" >
        <input type="submit" name="" value="送信" >
    </form>
</div>


<script type="text/javascript">


</script>
