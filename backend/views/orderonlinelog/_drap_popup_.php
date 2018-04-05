<!-- TO DO List -->
<div class="box box-primary">
    <div class="box-body">
        <ul class="todo-list">
            <?php
            foreach((array)$oderDraft as $key => $order){
                echo '
                    <li>
                    <!-- drag handle -->
                          <span class="handle">
                            <i class="fa fa-ellipsis-v"></i>
                            <i class="fa fa-ellipsis-v"></i>
                          </span>

                    <!-- Phone text -->
                    <span class="text">'.$key.'</span>
                    <!-- Emphasis label -->
                    <!-- General tools such as edit or delete-->
                    <div class="tools">
                        <a href="index.php?r=orderonlinelog/updateshortcart&id='.$key.'"><i class="fa fa-edit" onclick="editOrder('.$key.')"></i></a>
                        <i class="fa fa-trash-o"> </i>
                    </div>
                </li>
                ';

//                echo '<pre>';
//                var_dump($oderDraft);
//                echo '</pre>';
            }
            ?>
        </ul>
    </div><!-- /.box-body -->
</div><!-- /.box -->

<script>
    function editOrder(a) {
        //alert(a);
    }
</script>