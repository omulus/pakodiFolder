<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#recommend_value").change(function(){
			$("#contentdownload_count1").css('display','block');
            $("#contentlike_count1").css('display','block');
            $("#contentshare_count1").css('display','block');
            $("#contentplay_count1").css('display','block');
            //$("#dub_count1").css('display','block');
			$("#content_rating1").css('display','block');
            $("#"+$(this).val()+"1").css('display','none');
            if($("#"+$(this).val()+"1").val() == $("#trending_value").val()){
                $("#trending_value").val('');
            }
        });
        $("#trending_value").change(function(){
            $("#contentdownload_count").css('display','block');
            $("#contentlike_count").css('display','block');
            $("#contentshare_count").css('display','block');
            $("#contentplay_count").css('display','block');
            //$("#dub_count").css('display','block');
			$("#content_rating").css('display','block');
            $("#"+$(this).val()).css('display','none');
            if($(this).val() == $("#recommend_value").val()){
                $("#recommend_value").val('');
            }
        });
    });
   
</script>
<div class="content">
    <div class="module">
        <div class="module-head"> <h3>Pakodi Recommends</h3></div>
        <div class="module-body">
		    <form id="updaterecommend" name="updaterecommend" method="post" action="" class="form-horizontal row-fluid">
<?php //print_r($recommends); 
//echo $this->session->userdata('recommend_value'); exit; ?>
                <div class="control-group">
					<div class="controls" style="float:left;width:250px; margin-left:185px; padding:12px 0px; font-weight: bold;">Sort By</div>
					<div class="controls" style="float:left;width:260px; margin-left:20px; padding:12px 0px; font-weight: bold;">Filter By</div>
					<div class="clear"></div>
				
                    <label class="control-label" for="recommend_value"><?php echo $recommends->page_name;?>:</label>
                    <div class="controls" style="float:left;width:260px; margin-left:20px;">
                        <select tabindex="1" data-placeholder="Select here.." class="span8" name="recommend_value" id="recommend_value" onchange="showrecommend(this.value)">
                            <option id="contentdownload_count" value="contentdownload_count" <?php if($recommends->column_name == 'contentdownload_count'){ echo 'selected="selected"'; } ?>>Most Downloaded</option>
                            <option id="contentlike_count" value="contentlike_count" <?php if($recommends->column_name == 'contentlike_count'){ echo 'selected="selected"'; } ?>>Most Liked</option>
                            <option id="contentshare_count" value="contentshare_count" <?php if($recommends->column_name == 'contentshare_count'){ echo 'selected="selected"'; } ?>>Most Shared</option>
                            <option id="contentplay_count" value="contentplay_count" <?php if($recommends->column_name  == 'contentplay_count'){ echo 'selected="selected"'; } ?>>Most Viewed</option>
							<option id="datecreated" value="datecreated" <?php if($recommends->column_name == 'datecreated'){ echo 'selected="selected"'; } ?>>Date Created</option>
                            <option id="content_rating" value="content_rating" <?php if($recommends->column_name == 'content_rating'){ echo 'selected="selected"'; } ?>>Most Rated</option>
							<?php if($recommends->page_name == 'Landing Recommends'){?>
							<option id="customized" value="recommend_sort" <?php if($recommends->column_name == 'recommend_sort'){ echo 'selected="selected"'; } ?>>Customized</option>
							<?php } ?>
						</select>
                        <?php echo form_error('recommend_value'); ?>
                    </div>
				    <div class="controls" id="recfilter" <?php if($recommends->column_name == 'recommend_sort'){ ?>style="float:left;width:260px; margin-left:10px;display: none;" <?php }else{?>style="float:left;width:260px; margin-left:10px;display: block;"<?php } ?>>
                        <select tabindex="1" data-placeholder="Select here.." class="span8" name="recommend_filter" id="recommend_filter">
                            <option value="None"	<?php if($recommends->filter_interval == 'None'){ 	echo 'selected="selected"'; } ?>>None</option>
                            <option  value="2 HOUR" <?php if($recommends->filter_interval == '2 HOUR'){ echo 'selected="selected"'; } ?>>2 HOUR</option>
                            <option  value="4 HOUR" <?php if($recommends->filter_interval == '4 HOUR'){ echo 'selected="selected"'; } ?>>4 HOUR</option>
                            <option  value="8 HOUR" <?php if($recommends->filter_interval == '8 HOUR'){ echo 'selected="selected"'; } ?>>8 HOUR</option>
                            <option  value="12 HOUR"<?php if($recommends->filter_interval == '12 HOUR'){echo 'selected="selected"'; } ?>>12 HOUR</option>
                            <option  value="16 HOUR"<?php if($recommends->filter_interval == '16 HOUR'){echo 'selected="selected"'; } ?>>16 HOUR</option>
                            <option  value="24 HOUR" <?php  if($recommends->filter_interval == '24 HOUR'){ echo  'selected="selected"'; } ?>>1 DAY</option>
                            <option  value="48 HOUR" <?php  if($recommends->filter_interval == '48 HOUR'){ echo  'selected="selected"'; } ?>>2 DAY</option>
                            <option  value="72 HOUR" <?php  if($recommends->filter_interval == '72 HOUR'){ echo  'selected="selected"'; } ?>>3 DAY</option>
                            <option  value="96 HOUR" <?php  if($recommends->filter_interval == '96 HOUR'){ echo  'selected="selected"'; } ?>>4 DAY</option>
                            <option  value="120 HOUR" <?php  if($recommends->filter_interval == '120 HOUR'){ echo  'selected="selected"'; } ?>>5 DAY</option>
                            <option  value="144 HOUR" <?php  if($recommends->filter_interval == '144 HOUR'){ echo  'selected="selected"'; } ?>>6 DAY</option>
                        </select>
                        <?php echo form_error('recommend_filter'); ?>
                    </div>
					<div class="clear"></div>
		 	    </div>
                <div class="control-group">
                    <div class="controls">
                        <?php echo form_submit('submit', 'Edit', 'id="submit"', 'name="submit"', 'class="btn-primary"'); ?>
                        <?php //echo form_submit('reset', 'Reset', 'id="reset"', 'name="reset"', 'class="btn-primary"'); ?>
						<a href="javascript:window.history.go(-1);" class="btn-inverse" style="padding:3px;">Back</a>
                    </div>
                </div>
                        <div class="clear"></div>
				<div id="mydiv" name="mydiv" <?php if($recommends->column_name == 'recommend_sort'){?>style="display: block;"<?php }else{?>style="display:none;"<?php }?>><table cellpadding="0" cellspacing="0" border="0" class="datatable-10 table table-bordered table-striped display" width="100%">
                <thead>
                    <tr>
                        <th align="left">S.NO</th>
                        <th align="left">Title</th>
                        <th align="left">Thumbnail</th>
                        <th align="left">Content Clip</th>
                        <th align="left">Priority</th>
                        </tr>
                </thead>
                <tbody>
                </tbody>
            </table></div>
            </form>
        </div>
    </div>
</div>