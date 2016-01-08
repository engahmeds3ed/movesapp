<?php 
    if(isset($models) && !empty($models)){
        ?>
        <option <?php if(empty($cur_model)){ ?>selected="selected"<?php } ?> value="X">اختر موديل</option>
        <?php
        foreach($models as $model){
            ?>
            <option <?php if($model->model_id == $cur_model){ ?>selected="selected"<?php } ?> value="<?php echo $model->model_id; ?>"><?php echo $model->model_title; ?></option>
        <?php } ?>

<?php }else{ ?>
    <option selected="selected" value="X">لا توجد موديلات</option>
<?php } ?>