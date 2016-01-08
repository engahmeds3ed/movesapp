<?php if(!empty($ads)){ ?>

    <?php if($ads->ads_type == "img"){ ?>
    
    <a href="<?php echo base_url("ads/click/".$ads->ads_id); ?>" target="<?php echo $ads->ads_target; ?>">
        <img class="img-responsive <?php echo $classes; ?>" src="<?php echo $resize; ?>?src=<?php echo $this->assets; ?>../ads/<?php echo $ads->ads_file; ?>&w=<?php echo $ads->adsp_width; ?>&h=<?php echo $ads->adsp_height; ?>&zc=2" alt="<?php echo $ads->ads_title; ?>" title="<?php echo $ads->ads_title; ?>" />
    </a>
    
    <?php }elseif($ads->ads_type == "flash"){ ?>
    
    <?php }elseif($ads->ads_type == "adsense"){ ?>
        <?php echo $ads->ads_code; ?>
    <?php } ?>
    
<?php } ?>