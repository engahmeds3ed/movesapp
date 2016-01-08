<?php if(!empty($pages)){ ?>
    <?php foreach($pages as $id=>$title){ ?>
        <option <?php if($cur == $id){ ?>selected="selected"<?php } ?> value="<?php echo $id; ?>"><?php echo $title; ?></option>
    <?php } ?>
<?php } ?>