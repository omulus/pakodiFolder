<div class="content">
    <div class="module">
        <div class="module-head">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td align="left"><h3>Waiting for Moderation</h3></td>
               </tr>
            </table>
        </div>
        <div class="module-body table">
            <form name="date" method="post">
                <span style="padding-left:10px;"> Uploded Between Start Date  : </span><input type="text" name="fromdate" id="fromdate" value="<?php if(!empty($_POST['fromdate'])){ echo $_POST['fromdate']; } ?>" readonly="readonly" >
                <span style="padding-left:20px;">End Date  : </span><input type="text" name="todate" id="todate" value="<?php if(!empty($_POST['todate'])){ echo $_POST['todate']; } ?>" readonly="readonly" >
                <input type="button" name="dubsubmit" id="dubsubmit" value="Go" class="btn pakodi">
                <input type="button" id="dubreset" value="Reset" class="btn pakodi">
            </form>
            
            <table cellpadding="0" cellspacing="0" border="0" class="datatable-11 table table-bordered table-striped display" width="100%">
                <thead>
                    <tr>
                        <th align="left">S.NO</th>
                        <th align="left">User Name</th>
                        <th align="left">Clip Title</th>
						<th align="left">Thumb</th>
						<th align="left">File</th>
                        <th align="left">Moderated By</th>
						<th align="left">Date</th>
						<th align="left">Status</th>
                        <th align="left">Action</th>
                    </tr>
                </thead>
                <tbody>
                 
                </tbody>
            </table>
        </div>
    </div>
</div>

