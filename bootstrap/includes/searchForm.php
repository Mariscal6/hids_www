<form name="dosearch" method="post" action="search.php">
    <div class="row">
        <input type="hidden" name="monitoring" value="0" checked="checked"/>
        <div class="col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">From:</label>
            </div>
            <input type='datetime-local' class="form-control rounded-right" name="initdate" value="<?php echo date('Y-m-d\TH:i', $u_init_time) ?>"/>
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
        </div>
        <div class="col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">To:</label>
            </div>
            <input type='datetime-local' class="form-control rounded-right" name="finaldate" value="<?php echo date('Y-m-d\TH:i', $u_final_time) ?>"/>
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-12 pl-5">
       
        <label> Real time monitoring </label>
        <input type="checkbox" name="monitoring" value="1" <?php echo $rt_sk?>/>
        </div>
    </div>
    <hr/>
    <div class="row mt-1">
        <div class="col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <label style="width: 160px;" class="input-group-text" for="inputGroupSelect01">
                <i class="fas fa-info-circle" title="Specify the minimum alert level." style="margin-right:6px;" aria-hidden="true"></i>
                Minimum level:
            </label>
            </div>
            <select class="custom-select" name="level">
            <?php
                if($u_level == 1)
                {
                    echo '   <option value="1" selected="selected">All</option>';
                }
                else
                {
                    echo '   <option value="1">All</option>';
                }
                for($l_counter = 15; $l_counter >= 2; $l_counter--)
                {
                    if($l_counter == $u_level)
                    {
                        echo '   <option value="'.$l_counter.'" selected="selected">'.
                            $l_counter.'</option>';
                    }
                    else
                    {
                        echo '   <option value="'.$l_counter.'">'.$l_counter.'</option>';
                    }
                }
            ?>
            </select>
        </div>
        </div>
        <div class="col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <label style="width: 140px;" class="input-group-text" for="inputGroupSelect01">
                <i class="fas fa-info-circle" title="Specify the category of the alert." style="margin-right:6px;" aria-hidden="true"></i>    
                Category:
            </label>
            </div>
            <select class="custom-select" name="grouppattern" id="inputGroupSelect01">
            <option value="ALL" class="bluez">All categories</option>
            <?php 
                foreach($global_categories as $_cat_name => $_cat)
                {
                    foreach($_cat as $cat_name => $cat_val)
                    {
                        $sl = "";
                        if($USER_group == $cat_val)
                        {
                            $sl = ' selected="selected"';
                        }
                        if(strpos($cat_name, "(all)") !== FALSE)
                        {
                            echo '<option class="bluez" '.$sl.
                                ' value="'.$cat_val.'">'.$cat_name.'</option>';
                        }
                        else
                        {
                            echo '<option value="'.$cat_val.'" '.$sl.
                                '> &nbsp; '.$cat_name.'</option>';
                        }
                    }
                }
            ?>
            </select>
        </div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <label style="width: 160px;" class="input-group-text" for="inputGroupSelect01">
                <i class="fas fa-info-circle" title="String pattern matching." style="margin-right:6px;" aria-hidden="true"></i>
                Pattern: 
            </label>
            </div>
            <input type="text" class="form-control" name="strpattern" value="<?php echo $u_pattern?>"/>
        </div>
        </div>
        <div class="col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <label style="width: 140px;" class="input-group-text" for="inputGroupSelect01">
                <i class="fas fa-info-circle" title="Log file type." style="margin-right:6px;" aria-hidden="true"></i>
                Log formats: 
            </label>
            </div>
            <select class="custom-select" name="logpattern">
                <?php
                echo '<option value="ALL" class="bluez">All log formats</option>';

                foreach($log_categories as $_cat_name => $_cat)
                {
                    foreach($_cat as $cat_name => $cat_val)
                    {
                        $sl = "";
                        if($USER_log == $cat_val)
                        {
                            $sl = ' selected="selected"';
                        }
                        if(strpos($cat_name, "(all)") !== FALSE)
                        {
                            echo '<option class="bluez" '.$sl.
                                    ' value="'.$cat_val.'">'.$cat_name.'</option>';
                        }
                        else
                        {
                            echo '<option value="'.$cat_val.'" '.$sl.
                                    '> &nbsp; '.$cat_name.'</option>';
                        }
                    }
                }
                ?>
            </select>
        </div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <label style="width: 160px;" class="input-group-text" for="inputGroupSelect01">
                <i class="fas fa-info-circle" title="Source IP address." style="margin-right:6px;" aria-hidden="true"></i>
                Srcip: 
            </label>
            </div>
            <input type="text" class="form-control" name="srcippattern" value="<?php echo $u_srcip?>"/>
        </div>
        </div>
        <div class="col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <label style="width: 140px;" class="input-group-text" for="inputGroupSelect01">
                <i class="fas fa-info-circle" title="Specific file user." style="margin-right:6px;" aria-hidden="true"></i>
                User:
            </label>
            </div>
            <input type="text" class="form-control" name="srcippattern" value="<?php echo $u_srcip?>"/>
        </div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <label style="width: 160px;"class="input-group-text" for="inputGroupSelect01">
                <i class="fas fa-info-circle" title="File directory." style="margin-right:6px;" aria-hidden="true"></i>
                Location: </label>
            </div>
            <input type="text" class="form-control" name="locationpattern" value="<?php echo $u_location?>"/>
        </div>
        </div>
        <div class="col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <label style="width: 140px;" class="input-group-text" for="inputGroupSelect01">
            <i class="fas fa-info-circle" title="ID of the rule." style="margin-right:6px;" aria-hidden="true"></i>
            Rule id: </label>
            </div>
            <input type="text" class="form-control" name="rulepattern" value="<?php echo $u_rule?>"/>
        </div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <label style="width: 160px;" class="input-group-text" for="inputGroupSelect01">
            <i class="fas fa-info-circle" title="Maximum number of displayed alerts." style="margin-right:6px;" aria-hidden="true"></i>
            Max Alerts: </label>
            </div>
            <input type="text" class="form-control" name="max_alerts_per_page" value="<?php echo $ossec_max_alerts_per_page?>"/>
        </div>
        </div>
        <div class="col-sm-6">
        <input style="width: 160px;" type="submit" name="search" value="Search" class="btn btn-info" />
        </div>
    </div>
    <input type="hidden" name="searchid" value="<?php echo $USER_searchid ?>" />
</form>