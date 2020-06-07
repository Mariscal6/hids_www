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
            <label style="width: 140px;" class="input-group-text" for="inputGroupSelect01">Minimum level:</label>
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
            <label style="width: 120px;" class="input-group-text" for="inputGroupSelect01">Category: </label>
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
            <label style="width: 140px;" class="input-group-text" for="inputGroupSelect01">Pattern: </label>
            </div>
            <input type="text" class="form-control" name="strpattern" value="<?php echo $u_pattern?>"/>
        </div>
        </div>
        <div class="col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <label style="width: 120px;" class="input-group-text" for="inputGroupSelect01">Log formats: </label>
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
            <label style="width: 140px;" class="input-group-text" for="inputGroupSelect01">Srcip: </label>
            </div>
            <input type="text" class="form-control" name="srcippattern" value="<?php echo $u_srcip?>"/>
        </div>
        </div>
        <div class="col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <label style="width: 120px;" class="input-group-text" for="inputGroupSelect01">User: </label>
            </div>
            <input type="text" class="form-control" name="srcippattern" value="<?php echo $u_srcip?>"/>
        </div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <label style="width: 140px;"class="input-group-text" for="inputGroupSelect01">Location: </label>
            </div>
            <input type="text" class="form-control" name="locationpattern" value="<?php echo $u_location?>"/>
        </div>
        </div>
        <div class="col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <label style="width: 120px;" class="input-group-text" for="inputGroupSelect01">Rule id: </label>
            </div>
            <input type="text" class="form-control" name="rulepattern" value="<?php echo $u_rule?>"/>
        </div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <label style="width: 140px;" class="input-group-text" for="inputGroupSelect01">Max Alerts: </label>
            </div>
            <input type="text" class="form-control" name="max_alerts_per_page" value="<?php echo $ossec_max_alerts_per_page?>"/>
        </div>
        </div>
        <div class="col-sm-6">
        <input type="submit" name="search" value="Search" class="btn btn-info" />
        </div>
    </div>
    <input type="hidden" name="searchid" value="<?php echo $USER_searchid ?>" />
</form>