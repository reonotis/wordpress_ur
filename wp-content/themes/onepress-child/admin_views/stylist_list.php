
<div class="wrap">

    <h1 class="wp-heading-inline">スタイリスト一覧</h1>
    <a href="./admin.php?page=register_stylist_page" class="page-title-action">新規追加</a>

    <?php settings_errors(); ?>
    <!-- <table class="widefat fixed striped"> -->
    <table class="widefat fixed striped">
        <thead>
            <tr>
                <th>スタイリスト名</th>
                <th>スタイリスト名 ヨミ</th>
                <th>店舗</th>
                <th>HP表示</th>
                <th>並び替え</th>
                <th>編集</th>
                <th>削除</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if($stylists){
                foreach($stylists as $stylist){
                    ?>
                        <tr>
                            <td><?= $stylist->display_name ?></td>
                            <td><?= $stylist->display_read ?></td>
                            <td>
                                <?php
                                    if($stylist->shop_id==1) echo 'CASTLE' ;
                                    if($stylist->shop_id==2) echo 'DELTA' ;
                                    if($stylist->shop_id==3) echo 'Arche' ;
                                ?>
                            </td>
                            <td><?= $stylist->display_status ?></td>
                            <td></td>
                            <td><a href="./admin.php?page=edit_stylist_page&id=<?= $stylist->id ?>" >編集</a></td>
                            <td>
                                <form action="controller_stylist.php" method="post" >
                                    <input type="hidden" name="id" value="<?= $stylist->id ?>" >
                                    <input type="submit" name="delete" value="削除" onclick="return confirmDelete();" >
                                </form>
                            </td>
                        </tr>
                    <?php
                }

            }else{
                echo "<tr><td colspan='7'>登録されているコースはありません</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>





<script type="text/javascript">
    function confirmDelete(){
        var result = window.confirm('このコースを削除しますか？');
        if( result ) return true; return false;
    }

</script>

