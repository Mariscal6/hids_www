
<?php if($output_list[0]{'pg'} > 1): ?>
    <div class ="m-3 d-flex justify-content-end">
        <form name="dopage" method="post" action="search.php">
    <?php endif;?>


    <?php if($output_list[0]{'pg'} > 1): ?>

        <input type="submit" name="search" value="<< First"
            class="formText">

        <input type="submit" name="search" value="< Prev" class="button"
                    class="formText" />

        Page <b> <?php echo $USER_page.'/'.$output_list[0]{'pg'} ?> </b> ( <?php echo $output_list[0]{$real_page} ?> alerts)
    <?php endif; ?>

        <input type="hidden" name="initdate"
                value="<?php echo date('Y-m-d H:i', $u_init_time) ?>" />
        <input type="hidden" name="finaldate"
                value="<?php echo date('Y-m-d H:i', $u_final_time) ?>" />
        <input type="hidden" name="rulepattern" value="<?php echo $u_rule ?>" />
        <input type="hidden" name="srcippattern" value="<?php echo $u_srcip ?>" />
        <input type="hidden" name="userpattern" value="<?php echo $u_user ?>" />
        <input type="hidden" name="locationpattern" value="<?php echo $u_location ?>" />
        <input type="hidden" name="level" value="<?php echo $u_level ?>" />
        <input type="hidden" name="page" value="<?php echo $USER_page ?>" />
        <input type="hidden" name="searchid" value="<?php echo $USER_searchid ?>" />
        <input type="hidden" name="monitoring" value="<?php echo $USER_monitoring ?>" />
        <input type="hidden" name="max_alerts_per_page" value="<?php echo $ossec_max_alerts_per_page ?>" />


    <?php if($output_list[0]{'pg'} > 1): ?>

        <input type="submit" name="search" value="Next >" class="button"
                class="formText" />
        <input type="submit" name="search" value="Last >>" class="button"
            class="formText" />
    <?php endif;?>
    </form>
</div>