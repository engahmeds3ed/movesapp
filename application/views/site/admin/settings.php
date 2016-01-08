<?php $this->load->view($this->foldername.'/template/header_admin'); ?>

<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title">
                <?php echo $title; ?>
            </h1>
        </div>
        <div class="panel-collapse in collapse">
            <div class="panel-body">
                
                <?php if(!empty($msg) && isset($msg)){ ?>
                    <div class="alert alert-info">
                        <?php echo $msg; ?>
                    </div>
                <?php } ?>
                
                <?php echo form_open(base_url("admin/settings")); ?>
        
                <div class="form-group">
                    <label>
                        إسم الموقع
                        <?php echo form_input("cfg_sitename",$config->cfg_sitename,"class='form-control'"); ?>
                    </label>
                </div>
                
                <div class="form-group">
                    <label>
                        الكلمات المفتاحية
                        <?php echo form_input("cfg_keywords",$config->cfg_keywords,"class='form-control'"); ?>
                    </label>
                </div>
                
                <div class="form-group">
                    <label>
                        وصف الميتا<br />
                        <?php echo form_textarea("cfg_metadesc",$config->cfg_metadesc,"class='form-control'"); ?>
                    </label>
                </div>
                
                <div class="form-group">
                    <label>
                        عدد الزوار
                        <?php echo form_input("cfg_visitors",$config->cfg_visitors,"class='form-control'"); ?>
                    </label>
                    <label>
                        بريد الموقع
                        <?php echo form_input("cfg_contactemail",$config->cfg_contactemail,"class='form-control'"); ?>
                    </label>
                </div>
                
                <div class="form-group">
                    <label>
                        الفيسبوك
                        <?php echo form_input("cfg_facebook",$config->cfg_facebook,"class='form-control'"); ?>
                    </label>
                    <label>
                        جوجل بلس
                        <?php echo form_input("cfg_googleplus",$config->cfg_googleplus,"class='form-control'"); ?>
                    </label>
                    <label>
                        تويتر
                        <?php echo form_input("cfg_twitter",$config->cfg_twitter,"class='form-control'"); ?>
                    </label>
                    <label>
                        يوتيوب
                        <?php echo form_input("cfg_youtube",$config->cfg_youtube,"class='form-control'"); ?>
                    </label>
                    <label>
                        RSS
                        <?php echo form_input("cfg_rss",$config->cfg_rss,"class='form-control'"); ?>
                    </label>
                </div>
                
                <div class="form-group">
                    <label>
                        بيانات الاتصال<br />
                        <?php echo form_textarea("cfg_contactsdata",$config->cfg_contactsdata,"class='ckeditor'"); ?>
                    </label>
                </div>
                
                <hr />
                
                <div class="form-group">
                    <label>
                        <?php echo form_checkbox("cfg_sitestatus",1,$config->cfg_sitestatus,"class=''"); ?>
                        الموقع مغلق للصيانة ؟
                    </label>
                </div>
                
                <div class="form-group">
                    <label>
                        رسالة الإغلاق<br />
                        <?php echo form_textarea("cfg_closemsg",$config->cfg_closemsg,"class='ckeditor'"); ?>
                    </label>
                </div>
                
                <hr />
                <fieldset>
                    <legend>صفحة ماركات السيارات</legend>
                    <div class="form-group">
                        <label>
                            الكلمات المفتاحية
                            <?php echo form_input("cfg_brandmetakey",$config->cfg_brandmetakey,"class='form-control'"); ?>
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            وصف الميتا<br />
                            <?php echo form_textarea("cfg_brandmetadesc",$config->cfg_brandmetadesc,"class='form-control'"); ?>
                        </label>
                    </div>
                </fieldset>
                
                <hr />
                <fieldset>
                    <legend>صفحة معارض السيارات</legend>
                    <div class="form-group">
                        <label>
                            الكلمات المفتاحية
                            <?php echo form_input("cfg_dealersmetakey",$config->cfg_dealersmetakey,"class='form-control'"); ?>
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            وصف الميتا<br />
                            <?php echo form_textarea("cfg_dealersmetadesc",$config->cfg_dealersmetadesc,"class='form-control'"); ?>
                        </label>
                    </div>
                </fieldset>
                
                <hr />
                <fieldset>
                    <legend>صفحة أقسام السيارات</legend>
                    <div class="form-group">
                        <label>
                            الكلمات المفتاحية
                            <?php echo form_input("cfg_catmetakey",$config->cfg_catmetakey,"class='form-control'"); ?>
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            وصف الميتا<br />
                            <?php echo form_textarea("cfg_catmetadesc",$config->cfg_catmetadesc,"class='form-control'"); ?>
                        </label>
                    </div>
                </fieldset>
                
                <?php echo form_submit("submit","حفظ الإعدادات","class='btn btn-large fonted btn-success'") ; ?>
        
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view($this->foldername.'/template/footer_admin'); ?>