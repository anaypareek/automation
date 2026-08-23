<div class="content-wrapper">
<section class="content-header">
<h1>
Orders
</h1>
<ol class="breadcrumb">
<li class="active">View Orders</li>
</ol>
</section>
<section class="content">
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Orders</h3>
    </div>
       <div class="panel panel-default">
<pre><b>Average High Movement</b> - <?=round($high1,2);?>%, <b>Total Income</b> - ₹<?=round($profitloss_all1,2);?> || <b>Today Average</b> - <?=round($today_high1,2);?>% <b>Today Income</b> - ₹<?=round($today_profitloss_all1,2);?></pre>
               <? if(!empty($this->session->flashdata('smessage'))){ ?>
                     <div class="alert alert-success alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-check"></i> Alert!</h4>
               <? echo $this->session->flashdata('smessage'); ?>
               </div>
                 <? }
                  if(!empty($this->session->flashdata('emessage'))){ ?>
                  <div class="alert alert-danger alert-dismissible">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               <h4><i class="icon fa fa-ban"></i> Alert!</h4>
             <? echo $this->session->flashdata('emessage'); ?>
             </div>
               <? } ?>


    <div class="panel-body">
        <div class="box-body table-responsive no-padding">
        <table class="table table-bordered table-hover table-striped" id="userTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Stock</th>
                    <th>Type</th>
                    <th>Buy Amount</th>
                    <th>Sell Amount</th>
                    <th>Qty</th>
                    <th>Buy Time</th>
                    <th>Sell Time</th>
                    <th>High</th>
                    <th>High %</th>
                    <th>P/L</th>
                    <th>P/L Amount</th>
                    <th>Status</th>
                      </tr>
                  </thead>
                  <tbody>
<?php $i=1; foreach($orders->result() as $data) { ?>
<tr>
<td><?php echo $i ?> </td>
<td><?php echo $data->stock ?></td>
<td><?php if($data->type==1){ ?>
<p class="label bg-green" >Stock</p>

<?php } else { ?>
<p class="label bg-yellow" >Option</p>


<?php    }   ?>
</td>
<td><?php echo $data->buy_amount ?></td>
<td><?php echo $data->sell_amount ?></td>
<td><?php echo $data->qty ?></td>
<td><?php echo $data->buy_time ?></td>
<td><?php echo $data->sell_time ?></td>
<td><?php echo $data->highest_value ?></td>
<td><?php echo $data->highest_percentage ?></td>
<td><?php if($data->profit_loss_status==1){ ?>
<p class="label bg-green" >Profit</p>

<?php } else { ?>
<p class="label bg-red" >loss</p>


<?php    }   ?>
</td>
<td><?php echo $data->profit_loss_amt ?></td>
<td><?php if($data->status==1){ ?>
<p class="label bg-yellow" >Running</p>

<?php } else { ?>
<p class="label bg-green" >Completed</p>


<?php    }   ?>
</td>

</tr>
<?php $i++; } ?>
</tbody>
</table>






        </div>
    </div>


</div>

</div>

</div>
</div>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Orders 15 min</h3>
    </div>
       <div class="panel panel-default">
<pre><b>Average High Movement</b> - <?=round($high2,2);?>%, <b>Total Income</b> - ₹<?=round($profitloss_all2,2);?> || <b>Today Average</b> - <?=round($today_high2,2);?>% <b>Today Income</b> - ₹<?=round($today_profitloss_all2,2);?></pre>
               <? if(!empty($this->session->flashdata('smessage'))){ ?>
                     <div class="alert alert-success alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-check"></i> Alert!</h4>
               <? echo $this->session->flashdata('smessage'); ?>
               </div>
                 <? }
                  if(!empty($this->session->flashdata('emessage'))){ ?>
                  <div class="alert alert-danger alert-dismissible">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               <h4><i class="icon fa fa-ban"></i> Alert!</h4>
             <? echo $this->session->flashdata('emessage'); ?>
             </div>
               <? } ?>


    <div class="panel-body">
        <div class="box-body table-responsive no-padding">
        <table class="table table-bordered table-hover table-striped" id="userTable2">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Stock</th>
                    <th>Type</th>
                    <th>Buy Amount</th>
                    <th>Sell Amount</th>
                    <th>Qty</th>
                    <th>Buy Time</th>
                    <th>Sell Time</th>
                    <th>High</th>
                    <th>High %</th>
                    <th>P/L</th>
                    <th>P/L Amount</th>
                    <th>Status</th>
                      </tr>
                  </thead>
                  <tbody>
<?php $i=1; foreach($orders2->result() as $data2) { ?>
<tr>
<td><?php echo $i ?> </td>
<td><?php echo $data2->stock ?></td>
<td><?php if($data2->type==1){ ?>
<p class="label bg-green" >Stock</p>

<?php } else { ?>
<p class="label bg-yellow" >Option</p>


<?php    }   ?>
</td>
<td><?php echo $data2->buy_amount ?></td>
<td><?php echo $data2->sell_amount ?></td>
<td><?php echo $data2->qty ?></td>
<td><?php echo $data2->buy_time ?></td>
<td><?php echo $data2->sell_time ?></td>
<td><?php echo $data2->highest_value ?></td>
<td><?php echo $data2->highest_percentage ?></td>
<td><?php if($data2->profit_loss_status==1){ ?>
<p class="label bg-green" >Profit</p>

<?php } else { ?>
<p class="label bg-red" >loss</p>


<?php    }   ?>
</td>
<td><?php echo $data2->profit_loss_amt ?></td>
<td><?php if($data2->status==1){ ?>
<p class="label bg-yellow" >Running</p>

<?php } else { ?>
<p class="label bg-green" >Completed</p>


<?php    }   ?>
</td>

</tr>
<?php $i++; } ?>
</tbody>
</table>






        </div>
    </div>


</div>

</div>

</div>
</div>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Orders 1 Hr</h3>

    </div>
       <div class="panel panel-default">
<pre><b>Average High Movement</b> - <?=round($high3,2);?>%, <b>Total Income</b> - ₹<?=round($profitloss_all3,2);?> || <b>Today Average</b> - <?=round($today_high3,2);?>% <b>Today Income</b> - ₹<?=round($today_profitloss_all3,2);?></pre>
               <? if(!empty($this->session->flashdata('smessage'))){ ?>
                     <div class="alert alert-success alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-check"></i> Alert!</h4>
               <? echo $this->session->flashdata('smessage'); ?>
               </div>
                 <? }
                  if(!empty($this->session->flashdata('emessage'))){ ?>
                  <div class="alert alert-danger alert-dismissible">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               <h4><i class="icon fa fa-ban"></i> Alert!</h4>
             <? echo $this->session->flashdata('emessage'); ?>
             </div>
               <? } ?>


    <div class="panel-body">

        <div class="box-body table-responsive no-padding">
        <table class="table table-bordered table-hover table-striped" id="userTable3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Stock</th>
                    <th>Type</th>
                    <th>Buy Amount</th>
                    <th>Sell Amount</th>
                    <th>Qty</th>
                    <th>Buy Time</th>
                    <th>Sell Time</th>
                    <th>High</th>
                    <th>High %</th>
                    <th>P/L</th>
                    <th>P/L Amount</th>
                    <th>Status</th>
                      </tr>
                  </thead>
                  <tbody>
<?php $i=1; foreach($orders3->result() as $data2) { ?>
<tr>
<td><?php echo $i ?> </td>
<td><?php echo $data2->stock ?></td>
<td><?php if($data2->type==1){ ?>
<p class="label bg-green" >Stock</p>

<?php } else { ?>
<p class="label bg-yellow" >Option</p>


<?php    }   ?>
</td>
<td><?php echo $data2->buy_amount ?></td>
<td><?php echo $data2->sell_amount ?></td>
<td><?php echo $data2->qty ?></td>
<td><?php echo $data2->buy_time ?></td>
<td><?php echo $data2->sell_time ?></td>
<td><?php echo $data2->highest_value ?></td>
<td><?php echo $data2->highest_percentage ?></td>
<td><?php if($data2->profit_loss_status==1){ ?>
<p class="label bg-green" >Profit</p>

<?php } else { ?>
<p class="label bg-red" >loss</p>


<?php    }   ?>
</td>
<td><?php echo $data2->profit_loss_amt ?></td>
<td><?php if($data2->status==1){ ?>
<p class="label bg-yellow" >Running</p>

<?php } else { ?>
<p class="label bg-green" >Completed</p>


<?php    }   ?>
</td>

</tr>
<?php $i++; } ?>
</tbody>
</table>






        </div>
    </div>


</div>

</div>

</div>
</div>
</section>
</div>


<style>
label{
margin:5px;
}
</style>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript">

$(document).ready(function(){
$('#userTable').DataTable({
responsive: true,
// bSort: true
});
$('#userTable2').DataTable({
responsive: true,
// bSort: true
});
$('#userTable3').DataTable({
responsive: true,
// bSort: true
});

$(document.body).on('click', '.dCnf', function() {
var i=$(this).attr("mydata");
console.log(i);

$("#btns"+i).hide();
$("#cnfbox"+i).show();

});

$(document.body).on('click', '.cans', function() {
var i=$(this).attr("mydatas");
console.log(i);

$("#btns"+i).show();
$("#cnfbox"+i).hide();
})

});

</script>
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>    -->
