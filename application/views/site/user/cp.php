<?php $this->load->view($this->foldername.'/template/header'); ?>

<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title">
                <?php echo $title; ?>
            </h1>
        </div>
        <div class="panel-collapse in collapse">
            <div class="panel-body">
                
                <!-- The Timeline -->
                <?php if(!empty($activities)){ ?>
                <ul class="timeline">
                    <?php foreach($activities as $key=>$activity){ ?>
                	<!-- Item <?php echo $key; ?> -->
                	<li>
                		<div class="direction-<?php if($key%2){?>r<?php }else{?>l<?php } ?>">
                			<div class="flag-wrapper">
                				<span class="flag"><?php echo $activity->act_type; ?></span>
                				<span class="time-wrapper"><span class="time"><?php echo date("d-m-Y",strtotime($activity->act_date)); ?></span></span>
                			</div>
                			<div class="desc">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Duration</th>
                                        <td><?php echo $activity->act_duration; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Distance</th>
                                        <td><?php echo $activity->act_distance; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Steps</th>
                                        <td><?php echo $activity->act_steps; ?></td>
                                    </tr>
                                </table>
                            </div>
                		</div>
                	</li>
                    <?php } ?>
                </ul>
                <?php }else{ ?>
                <div class="alert alert-danger">You Don't have any activities Yet!</div>
                <?php } ?>
                
            </div>
        </div>
    </div>
</div>


<?php $this->load->view($this->foldername.'/template/footer'); ?>