<?php $this->load->view($this->foldername.'/template/header'); ?>

<div class="row">
    <div class="col-md-6">
    
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        Login As Admin:
                    </h2>
                </div>
                <div class="panel-body">
                    <?php if($this->ci_message->messages){ ?>
                        <?php $this->ci_message->display('login'); ?>
                    <?php } ?>
                    <?php echo form_open(base_url("login")); ?>
                    <div class="form-group">
                        <label>
                            Username:
                            <?php echo form_input("user_username","","class='form-control'"); ?>
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            Password:
                            <?php echo form_password("user_password","","class='form-control'"); ?>
                        </label>
                    </div>
                    <?php echo form_submit("submit","Login","class='btn btn-large btn-success'") ; ?>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    
    </div>
    <div class="col-md-6">
    
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        Login As User:
                    </h2>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $request_url; ?>" class="btn btn-large btn-info">Login Through Moves APP</a>
                </div>
            </div>
        </div>
    
    </div>
</div>       

<?php $this->load->view($this->foldername.'/template/footer'); ?>