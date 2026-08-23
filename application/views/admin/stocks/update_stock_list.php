<div class="content-wrapper">
<section class="content-header">
<h1>
Update New Stokes
</h1>

</section>
<section class="content">
<div class="row">
<div class="col-lg-12">

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Update New Stokes</h3>
</div>

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
<div class="col-lg-10">
 <form action="<?php echo base_url() ?>dcadmin/stocks/add_stocks_data/<? echo base64_encode(2); ?>/<?=$id;?>" method="POST" id="slide_frm" enctype="multipart/form-data">
<div class="table-responsive">
  <table class="table table-hover">

<tr>
              <td> <strong>Name</strong>  <span style="color:red;">*</span></strong> </td>
              <td>
<input type="text" name="name" id="stockName" class="form-control" placeholder="" required value="<?=$data->name;?>" />
            </td>
</tr>
<tr>
              <td> <strong>Logo</strong>  <span style="color:red;">*</span></strong> </td>
              <td>
<input type="text" name="logo" id="formattedStock"  class="form-control" placeholder="" required value="<?=$data->logo;?>" />
            </td>
</tr>
<tr>
              <td> <strong>Price</strong>  <span style="color:red;">*</span></strong> </td>
              <td>
<input type="text" name="price" id="price" class="form-control" placeholder="" value="" disabled/>
            </td>
</tr>
<tr>
              <td> <strong>Current Call 5 Min</strong>  <span style="color:red;">*</span></strong> </td>
              <td>
                  <select class="form-control" name="current_5">
                    <option value="1" <? if($data->current_5 == 1){echo "Selected"; }?>>BUY</option>
                    <option value="2" <? if($data->current_5 == 2){echo "Selected"; }?>>SELL</option>
                  </select>
                </div>
            </td>
</tr>
<tr>
              <td> <strong>Current Call 15 Min</strong>  <span style="color:red;">*</span></strong> </td>
              <td>
                  <select class="form-control" name="current_15">
                    <option value="1" <? if($data->current_15 == 1){echo "Selected"; }?>>BUY</option>
                    <option value="2" <? if($data->current_15 == 2){echo "Selected"; }?>>SELL</option>
                  </select>
                </div>
            </td>
</tr>
<tr>
              <td> <strong>Current Call 1 hr</strong>  <span style="color:red;">*</span></strong> </td>
              <td>
                  <select class="form-control" name="current_1hr">
                    <option value="1" <? if($data->current_1hr == 1){echo "Selected"; }?>>BUY</option>
                    <option value="2" <? if($data->current_1hr == 2){echo "Selected"; }?>>SELL</option>
                  </select>
                </div>
            </td>
</tr>
<tr>
              <td> <strong>Current Call 1 Day</strong>  <span style="color:red;">*</span></strong> </td>
              <td>
                  <select class="form-control" name="current_1day">
                    <option value="1" <? if($data->current_1day == 1){echo "Selected"; }?>>BUY</option>
                    <option value="2" <? if($data->current_1day == 2){echo "Selected"; }?>>SELL</option>
                  </select>
                </div>
            </td>
</tr>
<tr>
<td colspan="2" >
<input type="submit" class="btn btn-success" value="save">
</td>
</tr>
      </table>
  </div>

</form>

  </div>



</div>

</div>

</div>
</div>
</section>
</div>


<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<link href="<? echo base_url() ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
<script>
       // Get references to the input boxes
       const stockNameInput = document.getElementById('stockName');
       const formattedStockInput = document.getElementById('formattedStock');

       // Add an event listener to the stock name input box
       stockNameInput.addEventListener('input', function() {
           // Get the value of the stock name input
           const stockName = stockNameInput.value.trim().toUpperCase(); // Trim whitespace and convert to uppercase

           // Update the formatted stock input with the desired format
           if (stockName) {
               formattedStockInput.value = `NSE:${stockName}-EQ`;
           } else {
               formattedStockInput.value = ''; // Clear the second input if the first is empty
           }
       });
   </script>
    <script>
$(document).ready(function(){
  	$("#formattedStock").change(function(){
		var vf=$("#formattedStock").val();
    alert(vf);
    // var yr = $("#year_id option:selected").val();
		if(vf==""){
			return false;

		}else{
			// $('#price').remove();
			  // var opton="<option value=''>Please Select </option>";
			$.ajax({
				url:base_url+"dcadmin/Stocks/getPrice/"+vf,
				data : '',
				type: "get",
				success : function(html){
						if(html!="NA")
						{
			  $('#price').val(html);  // Assuming the response is the stock price
						}
						else
						{
							alert('No Branch Found');
							return false;
						}

					}

				})
		}


	})
  });

</script>
