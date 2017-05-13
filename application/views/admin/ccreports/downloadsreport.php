<div class="content">
    <div class="module">
        <div class="module-head">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td align="left"><h3>Most Downloaded Content Reports</h3></td>
                    <td align="right"><?php if(isset($downloads_file)){?><a href="http://sprintmediasg.s3.amazonaws.com/reports/<?php echo $downloads_file;?>" class='btn pakodi' >Export</a><?php }?><a href="javascript:window.history.go(-1);" style="float:right; display: inline-block" class="back-close btn pakodi">Back</a></td>
                </tr>
            </table>
        </div><?php //print_r($category);?>
        <div class="module-body table" style="border-bottom: 1px solid #d5d5d5;">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" >

                <tr style="background-color: #f6f6f6">
                    <form name="date" method="post" class="table-form">
                        <td align="left" style="width: 9.5%"><div id="column1" class="col1"><i class="iconred icon-filter"></i></div></td>
                        <td align="left" style="width:30%">
                            <div class='input-group date' id='from_date'><input type='text' class="form-control" name="fromdate" id="fromdate" value="<?php if (!empty($_POST['fromdate'])) {echo $_POST['fromdate'];}else{$start=date('m')."/01/".date('Y'); echo $start;} ?>" />
                                <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span></span></div>
                        </td>
                        <td style="width: 10.5%"></td>
                        <td align="right" style="width:30%">
                            <div class='input-group date' id='to_date'><input type='text' class="form-control" name="todate" id="todate" value="<?php if (!empty($_POST['todate'])) {echo $_POST['todate'];}else{$end=date('m')."/".date('d')."/".date('Y');echo $end;}  ?>" />
                                <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span></span></div>                        </td>

                        <td style="text-align: center">
                            <input type="submit" name="contentsubmit" id="reportsubmit" value="Search" class="pakodi" style="">
                        </td>
                    </form>
                </tr>
                <tr><td></td><td></td><td></td><td></td><td></td></tr>
            </table>

        </div>

        <!-- <div class="module-body table" style="background: url(../images/bg.png) #eee;">
             <div class="btn-controlls">
                 <div class="btn-box-row row-fluid">
                     <a href="#" class="btn-box small span6"><i class=" icon-download"></i><b>65</b>
                         <p class="">
                             Present Year Downloads</p>
                     </a><a href="#" class="btn-box small span6"><i class="icon-download"></i><b>15</b>
                         <p class="">
                             Present Month Downloads</p>
                     </a>
                 </div>
             </div>
         </div>-->

        <div class="module-body table">
            <table cellpadding="0" cellspacing="0" border="0"
                   class="datatable-32 table table-bordered table-striped display" width="100%">
                <thead>
                <tr>
                    <th align="left">User Name</th>
<!--                    <th align="left">Content ID</th>
                    <th align="left">Title</th>
                    <th align="left">Thumbnail</th>
                    <th align="left">Media file</th>-->
                    <th align="left">Count</th>
                     <th align="left">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($records as $key=>$value){ ?>
                    <tr>
                        <td align="left"><?php echo $value->name;?></td>
<!--                        <td align="left"><?php //echo $value->unique_code; ?></td>
                        <td align="left"><?php //echo $value->title; ?></td>
                        <td align="left"><?php //$path=$value->thumb_filename; ?>
                            <img src="http://sprintmedia.s3.amazonaws.com/appimages/<?php //echo $path;?>" border='0' alt='image' width='100' height='40' class='test'/>
                        </td>
                        <td align="left"><?php //$path= $value->contentclip_filename; ?>
                            <audio src="http://sprintmedia.s3.amazonaws.com/audios/<?php //echo $path;?>" width='0' height='30' controls ></audio>
                        </td>-->
                        <td align="left"><?php echo $value->cnt; ?></td>
                        <td align="left"><a href="<?php echo  base_url();?>Admin/ccreports/downloaddetails/<?php echo $value->user_id ?>/<?php if (!empty($_POST['fromdate'])) {echo $date1=date('Y-m-d', strtotime($_POST['fromdate']));}else{ echo date('Y-m-01'); }?>/<?php if (!empty($_POST['todate'])) {echo $date2=date('Y-m-d', strtotime($_POST['todate']));}else{ echo date('Y-m-d'); }?>"><i class="iconred icon-list" title="Details"></i></a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function getdivs(e) {
        if (e == 'dates') {
            document.getElementById('report-start-label').style.display = 'block';
            document.getElementById('report-start').style.display = 'block';
            document.getElementById('report-end-label').style.display = 'block';
            document.getElementById('report-end').style.display = 'block';
            document.getElementById('months').style.display = 'none';
            document.getElementById('month-label').style.display = 'none';
        } else {
            document.getElementById('report-start-label').style.display = 'none';
            document.getElementById('report-start').style.display = 'none';
            document.getElementById('report-end-label').style.display = 'none';
            document.getElementById('report-end').style.display = 'none';
            document.getElementById('months').style.display = 'block';
            document.getElementById('month-label').style.display = 'block';
        }
    }
</script>
    
