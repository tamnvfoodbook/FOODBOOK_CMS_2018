
    <table class="table table-striped table-bordered detail-view">
        <tbody>
        <tr>
            <th width="65%">Tên</th>
            <td width="35%"><?= @$model->MEMBER_NAME ?></td>
        </tr>
        <tr>
            <th>Số điện thoại</th>
            <td><?= @$model->ID ?></td>
        </tr>
        <tr>
            <th>Ngày sinh</th>
            <td>
                <?php if(@$model->BIRTHDAY){
                    echo date('d-m-Y',strtotime(@$model->BIRTHDAY));
                }
                ?>
            </td>
        </tr>
        <tr>
            <th>Giới tính</th>
            <td><?php
                if(isset($model->SEX)){
                    if(@$model->SEX == 1 ){
                        echo 'Nam';
                    }else if(@$model->SEX == 0){
                        echo 'Nữ';
                    }else{
                        echo 'Không xác định';
                    }
                }
                ?></td>
        </tr>
        <tr>
            <th>Nhóm khách</th>
            <td><?= @Yii::$app->params['groupMember'][@$model->USER_GROUPS] ?></td>
        </tr>
        </tbody>
    </table>
