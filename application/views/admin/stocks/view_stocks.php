<div class="content-wrapper">
<section class="content-header">
<h1>
Stocks
</h1>
<ol class="breadcrumb">
<li class="active">View Stocks</li>
</ol>
</section>
<section class="content">
<div class="row">
<div class="col-lg-12">
 <a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/Stocks/add_stocks" role="button" style="margin-bottom:12px;"> Add Stocks</a>
 <a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/Stocks/refresh_price" role="button" style="margin-bottom:12px;"> Refresh Price</a>
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Stocks</h3>
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
                                  <th>Name</th>
                                  <th>Price</th>
                                  <th>5 Min</th>
                                  <th>15 Min</th>
                                  <th>1 Hr</th>
                                  <th>1 Day</th>
                                  <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
    <?php $i=1; foreach($stocks_list->result() as $data) { ?>
        <tr>
            <td><?php echo $i ?> </td>
            <td><?php echo $data->name ?></td>

            <td><?php echo $data->current_price; ?></td>
            <td><?php $this->db->select('*');
                        $this->db->from('tbl_stock_call');
                        $this->db->where('symbol',$data->id);
                        $this->db->where('call_open_close',2);
                        $this->db->where('call_timeframe',1);
                        $this->db->order_by('id','DESC');
                        $dsa= $this->db->get();
                        $da=$dsa->row();
                        if(!empty($da)){
                          if($da->call_type == 1){
                            $p1=$da->high_price;
                              if($p1 != 0 || !empty($p1)){
                            $p2 =$da->price;
                              $p3 = $p1-$p2;
                              $p4 = round($p3/$p1*100,2);
                            }
                              else{
                                $p4 = "";
                              }
                            echo '<p class="label bg-green" >Buy(₹'.$da->price.')</p>';
                            echo "<br/>";
                            echo "High -(₹".$da->high_price."(".$p4."%))";
                          }
                          elseif($da->call_type == 2){
                              echo '<p class="label bg-red" >Sell(₹'.$da->price.')</p>';
                          }
                        }
                      else{
                        if($data->current_5 == 1){
                          echo '<p class="label bg-green" >Buy</p>';
                        }
                        elseif($data->current_5 == 2){
                            echo '<p class="label bg-red" >Sell</p>';
                        }
                      }


            ?></td>
            <td><?php $this->db->select('*');
                        $this->db->from('tbl_stock_call');
                        $this->db->where('symbol',$data->id);
                        $this->db->where('call_open_close',2);
                        $this->db->where('call_timeframe',2);
                        $this->db->order_by('id','DESC');
                        $dsa= $this->db->get();
                        $da=$dsa->row();
                        if(!empty($da)){
                          if($da->call_type == 1){
                            $p1=$da->high_price;
                            if($p1 != 0 || !empty($p1)){
                            $p2 =$da->price;
                              $p3 = $p1-$p2;
                              $p4 = round($p3/$p1*100,2);
                            }
                            else{
                              $p4 = "";
                            }
                            echo '<p class="label bg-green" >Buy(₹'.$da->price.')</p>';
                            echo "<br/>";
                            echo "High -(₹".$da->high_price."(".$p4."%))";
                          }
                          elseif($da->call_type == 2){
                              echo '<p class="label bg-red" >Sell(₹'.$da->price.')</p>';
                          }
                        }
                      else{
                        if($data->current_15 == 1){
                          echo '<p class="label bg-green" >Buy</p>';
                        }
                        elseif($data->current_15 == 2){
                            echo '<p class="label bg-red" >Sell</p>';
                        }
                      }


            ?></td>
            <td><?php $this->db->select('*');
                        $this->db->from('tbl_stock_call');
                        $this->db->where('symbol',$data->id);
                        $this->db->where('call_open_close',2);
                        $this->db->where('call_timeframe',3);
                        $this->db->order_by('id','DESC');
                        $dsa= $this->db->get();
                        $da=$dsa->row();
                        if(!empty($da)){
                          if($da->call_type == 1){
                            $p1=$da->high_price;
                            if($p1 != 0 || !empty($p1)){
                            $p2 =$da->price;
                              $p3 = $p1-$p2;
                              $p4 = round($p3/$p1*100,2);
                            }
                            else{
                              $p4 = "";
                            }

                            echo '<p class="label bg-green" >Buy(₹'.$da->price.')</p>';
                            echo "<br/>";
                            echo "High -(₹".$da->high_price."(".$p4."%))";
                          }
                          elseif($da->call_type == 2){
                              echo '<p class="label bg-red" >Sell(₹'.$da->price.')</p>';
                          }
                        }
                      else{
                        if($data->current_1hr == 1){
                          echo '<p class="label bg-green" >Buy</p>';
                        }
                        elseif($data->current_1hr == 2){
                            echo '<p class="label bg-red" >Sell</p>';
                        }
                      }


            ?></td>
            <td><?php $this->db->select('*');
                        $this->db->from('tbl_stock_call');
                        $this->db->where('symbol',$data->id);
                        $this->db->where('call_open_close',2);
                        $this->db->where('call_timeframe',4);
                        $this->db->order_by('id','DESC');
                        $dsa= $this->db->get();
                        $da=$dsa->row();
                        if(!empty($da)){
                          if($da->call_type == 1){
                            $p1=$da->high_price;
                            if($p1 != 0 || !empty($p1)){
                            $p2 =$da->price;
                              $p3 = $p1-$p2;
                              $p4 = round($p3/$p1*100,2);
                            }
                            else{
                              $p4 = "";
                            }
                            echo '<p class="label bg-green" >Buy(₹'.$da->price.')</p>';
                            echo "<br/>";
                            echo "High -(₹".$da->high_price."(".$p4."%))";
                          }
                          elseif($da->call_type == 2){
                              echo '<p class="label bg-red" >Sell(₹'.$da->price.')</p>';
                          }
                        }
                      else{
                        if($data->current_1day == 1){
                          echo '<p class="label bg-green" >Buy</p>';
                        }
                        elseif($data->current_1day == 2){
                            echo '<p class="label bg-red" >Sell</p>';
                        }
                      }


            ?></td>

            <td><a href="<?=base_url()?>dcadmin/Stocks/update_stocks/<?=base64_encode($data->id);?>" type="button" class="btn btn-default">Edit</a> &nbsp;&nbsp;&nbsp;
            <a href="<?=base_url()?>dcadmin/Stocks/view_calls/<?=base64_encode($data->id);?>" type="button" class="btn btn-default">View</a></td>

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

<!-- 5 MIN CHART           -->
<div class="row">
<div class="col-lg-12">
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Stocks 5 Min</h3>
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
                      <table class="table table-bordered table-hover table-striped" id="userTable1">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Name</th>
                                  <th>Price</th>
                                  <th>5 Min</th>
                                  <th>Date</th>
                                  <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
    <?php $i=1; foreach($stocks_list_5min->result() as $data11) {

      $this->db->select('*');
                  $this->db->from('tbl_stock_list');
                  $this->db->where('id',$data11->symbol);
                  $dsa= $this->db->get();
                  $data=$dsa->row();


      ?>
        <tr>
            <td><?php echo $i ?> </td>
            <td><?php echo $data->name ?></td>

            <td><?php echo $data->current_price; ?></td>
            <td><?php $this->db->select('*');
                        $this->db->from('tbl_stock_call');
                        $this->db->where('symbol',$data->id);
                        $this->db->where('call_open_close',2);
                        $this->db->where('call_timeframe',1);
                        $this->db->order_by('id','DESC');
                        $dsa= $this->db->get();
                        $da=$dsa->row();
                        if(!empty($da)){
                          if($da->call_type == 1){
                            $p1=$da->high_price;
                              if($p1 != 0 || !empty($p1)){
                            $p2 =$da->price;
                              $p3 = $p1-$p2;
                              $p4 = round($p3/$p1*100,2);
                            }
                              else{
                                $p4 = "";
                              }
                            echo '<p class="label bg-green" >Buy(₹'.$da->price.')</p>';
                            echo "<br/>";
                            echo "High -(₹".$da->high_price."(".$p4."%))";
                          }
                          elseif($da->call_type == 2){
                              echo '<p class="label bg-red" >Sell(₹'.$da->price.')</p>';
                          }
                        }
                      else{
                        if($data->current_5 == 1){
                          echo '<p class="label bg-green" >Buy</p>';
                        }
                        elseif($data->current_5 == 2){
                            echo '<p class="label bg-red" >Sell</p>';
                        }
                      }


            ?></td>
              <td><?php echo $data11->date ?></td>
              <td>
            <a href="<?=base_url()?>dcadmin/Stocks/view_calls/<?=base64_encode($data->id);?>" type="button" class="btn btn-default">View</a></td>

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

          <!-- 15 min chart  -->
          <div class="row">
          <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Stocks of 15 Min</h3>
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
                                <table class="table table-bordered table-hover table-striped" id="userTable2">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>15 Min</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
              <?php $i=1; foreach($stocks_list_15min->result() as $data11) {

                $this->db->select('*');
                            $this->db->from('tbl_stock_list');
                            $this->db->where('id',$data11->symbol);
                            $dsa= $this->db->get();
                            $data=$dsa->row();
                            ?>
                  <tr>
                      <td><?php echo $i ?> </td>
                      <td><?php echo $data->name ?></td>

                      <td><?php echo $data->current_price; ?></td>
                      <td><?php $this->db->select('*');
                                  $this->db->from('tbl_stock_call');
                                  $this->db->where('symbol',$data->id);
                                  $this->db->where('call_open_close',2);
                                  $this->db->where('call_timeframe',2);
                                  $this->db->order_by('id','DESC');
                                  $dsa= $this->db->get();
                                  $da=$dsa->row();
                                  if(!empty($da)){
                                    if($da->call_type == 1){
                                      $p1=$da->high_price;
                                      if($p1 != 0 || !empty($p1)){
                                      $p2 =$da->price;
                                        $p3 = $p1-$p2;
                                        $p4 = round($p3/$p1*100,2);
                                      }
                                      else{
                                        $p4 = "";
                                      }
                                      echo '<p class="label bg-green" >Buy(₹'.$da->price.')</p>';
                                      echo "<br/>";
                                      echo "High -(₹".$da->high_price."(".$p4."%))";
                                    }
                                    elseif($da->call_type == 2){
                                        echo '<p class="label bg-red" >Sell(₹'.$da->price.')</p>';
                                    }
                                  }
                                else{
                                  if($data->current_15 == 1){
                                    echo '<p class="label bg-green" >Buy</p>';
                                  }
                                  elseif($data->current_15 == 2){
                                      echo '<p class="label bg-red" >Sell</p>';
                                  }
                                }


                      ?></td>
                        <td><?php echo $data11->date ?></td>
                      <td>
                      <a href="<?=base_url()?>dcadmin/Stocks/view_calls/<?=base64_encode($data->id);?>" type="button" class="btn btn-default">View</a></td>

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
          <!-- 1 hr chart -->
          <div class="row">
          <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Stocks of 1 Hr</h3>
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
                                <table class="table table-bordered table-hover table-striped" id="userTable22">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>1 Hr</th>
                                            <th>Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
              <?php $i=1; foreach($stocks_list_1hr->result() as $data11) {
                $this->db->select('*');
                            $this->db->from('tbl_stock_list');
                            $this->db->where('id',$data11->symbol);
                            $dsa= $this->db->get();
                            $data=$dsa->row();
                            ?>

                  <tr>
                      <td><?php echo $i ?> </td>
                      <td><?php echo $data->name ?></td>

                      <td><?php echo $data->current_price; ?></td>

                      <td><?php $this->db->select('*');
                                  $this->db->from('tbl_stock_call');
                                  $this->db->where('symbol',$data->id);
                                  $this->db->where('call_open_close',2);
                                  $this->db->where('call_timeframe',3);
                                  $this->db->order_by('id','DESC');
                                  $dsa= $this->db->get();
                                  $da=$dsa->row();
                                  if(!empty($da)){
                                    if($da->call_type == 1){
                                      $p1=$da->high_price;
                                      if($p1 != 0 || !empty($p1)){
                                      $p2 =$da->price;
                                        $p3 = $p1-$p2;
                                        $p4 = round($p3/$p1*100,2);
                                      }
                                      else{
                                        $p4 = "";
                                      }

                                      echo '<p class="label bg-green" >Buy(₹'.$da->price.')</p>';
                                      echo "<br/>";
                                      echo "High -(₹".$da->high_price."(".$p4."%))";
                                    }
                                    elseif($da->call_type == 2){
                                        echo '<p class="label bg-red" >Sell(₹'.$da->price.')</p>';
                                    }
                                  }
                                else{
                                  if($data->current_1hr == 1){
                                    echo '<p class="label bg-green" >Buy</p>';
                                  }
                                  elseif($data->current_1hr == 2){
                                      echo '<p class="label bg-red" >Sell</p>';
                                  }
                                }


                      ?></td>
                      <td><?php echo $data11->date ?></td>


                      <td>
                      <a href="<?=base_url()?>dcadmin/Stocks/view_calls/<?=base64_encode($data->id);?>" type="button" class="btn btn-default">View</a></td>

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
          <!-- 1 day chart -->
          <div class="row">
          <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Stocks of 1 Day</h3>
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
                                <table class="table table-bordered table-hover table-striped" id="userTable23">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>1 Day</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
              <?php $i=1; foreach($stocks_list_1day->result() as $data11) {
                $this->db->select('*');
                            $this->db->from('tbl_stock_list');
                            $this->db->where('id',$data11->symbol);
                            $dsa= $this->db->get();
                            $data=$dsa->row();
                ?>
                  <tr>
                      <td><?php echo $i ?> </td>
                      <td><?php echo $data->name ?></td>

                      <td><?php echo $data->current_price; ?></td>

                      <td><?php $this->db->select('*');
                                  $this->db->from('tbl_stock_call');
                                  $this->db->where('symbol',$data->id);
                                  $this->db->where('call_open_close',2);
                                  $this->db->where('call_timeframe',4);
                                  $this->db->order_by('id','DESC');
                                  $dsa= $this->db->get();
                                  $da=$dsa->row();
                                  if(!empty($da)){
                                    if($da->call_type == 1){
                                      $p1=$da->high_price;
                                      if($p1 != 0 || !empty($p1)){
                                      $p2 =$da->price;
                                        $p3 = $p1-$p2;
                                        $p4 = round($p3/$p1*100,2);
                                      }
                                      else{
                                        $p4 = "";
                                      }
                                      echo '<p class="label bg-green" >Buy(₹'.$da->price.')</p>';
                                      echo "<br/>";
                                      echo "High -(₹".$da->high_price."(".$p4."%))";
                                    }
                                    elseif($da->call_type == 2){
                                        echo '<p class="label bg-red" >Sell(₹'.$da->price.')</p>';
                                    }
                                  }
                                else{
                                  if($data->current_1day == 1){
                                    echo '<p class="label bg-green" >Buy</p>';
                                  }
                                  elseif($data->current_1day == 2){
                                      echo '<p class="label bg-red" >Sell</p>';
                                  }
                                }


                      ?></td>
                      <td><?php echo $data11->date ?></td>

                      <td>
                      <a href="<?=base_url()?>dcadmin/Stocks/view_calls/<?=base64_encode($data->id);?>" type="button" class="btn btn-default">View</a></td>

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
  var tableIds = ['#userTable', '#userTable1', '#userTable2', '#userTable22', '#userTable23'];

  tableIds.forEach(function(id) {
      $(id).DataTable({
          responsive: true,
          // bSort: true
      });
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
