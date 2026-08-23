<div class="content-wrapper">
<section class="content-header">
<h1>
View Calls of <?=$name;?>
</h1>
<ol class="breadcrumb">
<li class="active">View Calls of <?=$name;?></li>
</ol>
</section>
<section class="content">
<!-- 5 min call -->
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Calls of <?=$name;?></h3>
</div>
<div class="panel panel-default">

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
<th>Call</th>
<th>Price</th>
<th>Type</th>
<th>Type2</th>
<th>High</th>
<th>High %</th>
<th>Time</th>

  </tr>
</thead>
<tbody>
<?php $i=1; foreach($stock_call_5min->result() as $data) { ?>
<tr>
<td><?php echo $i ?> </td>
<td><?php $timeframe = $data->call_timeframe;
if($timeframe == 1){
echo "5 Min";
}
if($timeframe == 2){
echo "15 Min";
}
if($timeframe == 3){
echo "1 hr";
}
if($timeframe == 4){
echo "1 Day";
}
?></td>
<td><?php echo $p1 = $data->price; ?> </td>
<td><?php $type = $data->call_type;
if($type == 1){
echo '<p class="label bg-green" >Buy</p>';
}
if($type == 2){
echo '<p class="label bg-red" >Sell</p>';
}

?></td>
<td><?php $type2 = $data->call_open_close;
if($type2 == 1){
echo '<p class="label bg-yellow" >Open</p>';
}
if($type2 == 2){
echo '<p class="label bg-green" >Close</p>';
}

?></td>
<td><?php echo $h1 = $data->high_price; ?> </td>
<td><?php if($h1 != 0){ $s1 = $h1-$p1;
$p1 = $s1/$h1*100;
echo round($p1,2);
}
?>
</td>
<td><?php echo $data->date; ?> </td>

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
    <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Calls of <?=$name;?></h3>
</div>
   <div class="panel panel-default">

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
                <th>Call</th>
                <th>Price</th>
                <th>Type</th>
                <th>Type2</th>
                <th>High</th>
                <th>High %</th>
                <th>Time</th>

                  </tr>
              </thead>
              <tbody>
<?php $i=1; foreach($stock_call_15min->result() as $data) { ?>
<tr>
<td><?php echo $i ?> </td>
<td><?php $timeframe = $data->call_timeframe;
if($timeframe == 1){
echo "5 Min";
}
if($timeframe == 2){
echo "15 Min";
}
if($timeframe == 3){
echo "1 hr";
}
if($timeframe == 4){
echo "1 Day";
}
?></td>
<td><?php echo $p1 = $data->price; ?> </td>
<td><?php $type = $data->call_type;
if($type == 1){
echo '<p class="label bg-green" >Buy</p>';
}
if($type == 2){
echo '<p class="label bg-red" >Sell</p>';
}

?></td>
<td><?php $type2 = $data->call_open_close;
if($type2 == 1){
echo '<p class="label bg-yellow" >Open</p>';
}
if($type2 == 2){
echo '<p class="label bg-green" >Close</p>';
}

?></td>
<td><?php echo $h1 = $data->high_price; ?> </td>
<td><?php if($h1 != 0){ $s1 = $h1-$p1;
$p1 = $s1/$h1*100;
echo round($p1,2);
}
?>
</td>
<td><?php echo $data->date; ?> </td>


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

<!-- 1hr call -->

<div class="row">
<div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Calls of <?=$name;?></h3>
                </div>
                   <div class="panel panel-default">

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
                                <th>Call</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>Type2</th>
                                <th>High</th>
                                <th>High %</th>
                                <th>Time</th>

                                  </tr>
                              </thead>
                              <tbody>
  <?php $i=1; foreach($stock_call_1hr->result() as $data) { ?>
      <tr>
          <td><?php echo $i ?> </td>
          <td><?php $timeframe = $data->call_timeframe;
          if($timeframe == 1){
            echo "5 Min";
          }
          if($timeframe == 2){
            echo "15 Min";
          }
          if($timeframe == 3){
            echo "1 hr";
          }
          if($timeframe == 4){
            echo "1 Day";
          }
           ?></td>
       <td><?php echo $p1 = $data->price; ?> </td>
       <td><?php $type = $data->call_type;
       if($type == 1){
         echo '<p class="label bg-green" >Buy</p>';
       }
       if($type == 2){
         echo '<p class="label bg-red" >Sell</p>';
       }

        ?></td>
        <td><?php $type2 = $data->call_open_close;
        if($type2 == 1){
          echo '<p class="label bg-yellow" >Open</p>';
        }
        if($type2 == 2){
          echo '<p class="label bg-green" >Close</p>';
        }

         ?></td>
         <td><?php echo $h1 = $data->high_price; ?> </td>
         <td><?php if($h1 != 0){
           $s1 = $h1-$p1;
         $p1 = $s1/$h1*100;
         echo round($p1,2);
         }
         ?>
         </td>
        <td><?php echo $data->date; ?> </td>


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

        <!-- 1 day -->

        <div class="row">
           <div class="col-lg-12">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Calls of <?=$name;?></h3>
                                </div>
                                   <div class="panel panel-default">

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
                                                <th>Call</th>
                                                <th>Price</th>
                                                <th>Type</th>
                                                <th>Type2</th>
                                                <th>High</th>
                                                <th>High %</th>
                                                <th>Time</th>

                                                  </tr>
                                              </thead>
                                              <tbody>
                  <?php $i=1; foreach($stock_call_1day->result() as $data) { ?>
                      <tr>
                          <td><?php echo $i ?> </td>
                          <td><?php $timeframe = $data->call_timeframe;
                          if($timeframe == 1){
                            echo "5 Min";
                          }
                          if($timeframe == 2){
                            echo "15 Min";
                          }
                          if($timeframe == 3){
                            echo "1 hr";
                          }
                          if($timeframe == 4){
                            echo "1 Day";
                          }
                           ?></td>
                       <td><?php echo $p1 = $data->price; ?> </td>
                       <td><?php $type = $data->call_type;
                       if($type == 1){
                         echo '<p class="label bg-green" >Buy</p>';
                       }
                       if($type == 2){
                         echo '<p class="label bg-red" >Sell</p>';
                       }

                        ?></td>
                        <td><?php $type2 = $data->call_open_close;
                        if($type2 == 1){
                          echo '<p class="label bg-yellow" >Open</p>';
                        }
                        if($type2 == 2){
                          echo '<p class="label bg-green" >Close</p>';
                        }

                         ?></td>
                         <td><?php echo $h1 = $data->high_price; ?> </td>
                         <td><?php if($h1 != 0){ $s1 = $h1-$p1;
                         $p1 = $s1/$h1*100;
                         echo round($p1,2);
                         }
                         ?>
                         </td>
                        <td><?php echo $data->date; ?> </td>


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
