<div class="content-wrapper">
        <section class="content-header">
           <h1>
          Add New Team
          </h1>
          <ol class="breadcrumb">
         <li><a href="<?php echo base_url() ?>dcadmin/Home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
         <li><a href="<?php echo base_url() ?>dcadmin/System/view_team"><i class="fa fa-dashboard"></i> View Team</a></li>
        </ol>
        </section>
		<section class="content">
		<div class="row">
       <div class="col-lg-12">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Team</h3>
                            </div>
                            <div class="panel-body">
                    		<?php if (!empty($this->session->flashdata('smessage'))) { ?>
                        <div class="alert alert-success alert-dismissible fade in">
                          <strong><?php echo $this->session->flashdata('smessage'); ?></strong>
                        </div>
                      <?php }
                       if (!empty($this->session->flashdata('emessage'))) { ?>
                      <div class="alert alert-danger alert-dismissible fade in">
                        <strong><?php echo $this->session->flashdata('emessage'); ?></strong>
                      </div>
                    <?php } ?>
                                <div class="col-lg-10">
                                   <form action="<?php echo base_url() ?>dcadmin/System/add_team_data" method="POST" id="slide_frm" enctype="multipart/form-data">
                                <div class="table-responsive">
                                    <table class="table table-hover">

											<tr>
                                                <td> <strong>Name</strong>  <span style="color:red;">*</span></strong> </td>
                                                <td>
													<input type="text" name="name"  class="form-control" placeholder="" required value="" />
	                                            </td>
    										</tr>
												<tr>
    <td> <strong>Email</strong>  <span style="color:red;">*</span></strong> </td>
    <td>

					<input type="email" name="email"  class="form-control" placeholder="" required value="" />
	                             </td>
    										</tr>
                        <tr>
    <td> <strong>Phone (optional)</strong>  </strong> </td>
    <td>

					<input type="text" name="phone"  class="form-control" placeholder="" value="" />
	                             </td>
    										</tr>
                        <tr>
    <td> <strong>Address (optional)</strong> </strong> </td>
    <td>

          <input type="text" name="address"  class="form-control" placeholder="" value="" />
                               </td>
                        </tr>
                        <tr>
                          <td> <strong>State</strong> <span style="color:red;">*</span></strong> </td>
                          <td> <select class="form-control" name="state_id" required id="state">
                              <option value="">------Select State---------</option>
                              <?php $i=1; foreach ($state_data->result() as $data) { ?>
                              <option value="<?=$data->id?>"><?=$data->name?></option>
                              <?php $i++; } ?>
                            </select> </td>
                        </tr>
                        <tr>
                          <td> <strong>Territory</strong> <span style="color:red;">*</span></strong> </td>
                          <td> <select class="form-control" name="territory_id" required id="territory">
                              <option value="">------Select Territory---------</option>
                              <?php $i=1; foreach ($territory_data->result() as $data) { ?>
                              <option value="<?=$data->id?>"><?=$data->name?></option>
                              <?php $i++; } ?>
                            </select> </td>
                        </tr>
                        <tr>
                          <td> <strong>Designation</strong> <span style="color:red;">*</span></strong> </td>
                          <td> <select class="form-control" name="designation_id" required id="designation">
                              <option value="">------Select Designation---------</option>
                              <?php $i=1; foreach ($designation_data->result() as $data) { ?>
                              <option value="<?=$data->id?>"><?=$data->name?></option>
                              <?php $i++; } ?>
                            </select> </td>
                        </tr>
                        <tr>
    <td> <strong>Password</strong>  <span style="color:red;">*</span></strong> </td>
    <td>

          <input type="text" name="password"  class="form-control" placeholder="" required value="" />
                               </td>
                        </tr>
                        <tr>
                  <td> <strong>Permission Level</strong>  <span style="color:red;">*</span></strong> </td>
                  <td>
            <div class="form-group">

  <select class="form-control" name="power" required >
      <option value="1">Please select Type</option>
    <option value="1">Super Admin</option>
    <option value="2">Admin</option>
    <option value="3">Manager</option>

  </select>
</div>
</td>
</tr>

<tr>
<td> <strong>services</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<div class="form-group">
  <div class="checkbox">
    <label><input type="checkbox" name="service" value="999">All</label>
  </div>
  <?php foreach ($side->result() as $s) {
                           ?>
    <div class="checkbox">
      <label><input type="checkbox" name="services[]" value="<?php echo $s->id; ?>"><?php echo $s->name; ?></label>
    </div>
    <?php
                       } ?>

</div>
</td>
</tr>


											<tr>
												<td> <strong>Image</strong> </td>
												<td>


													<input type="file" name="fileToUpload1"></input>

														</div>
												</td>
											</tr>


											<tr>
												<td colspan="2" >
													<input type="submit" class="btn custom_btn" value="save">
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
				<link href="<?php echo base_url() ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />



<style>

</style>
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>	  -->

<script>
  $(document).ready(function() {
    $("#state").change(function() {
      var vf = $(this).val();
      var yr = $("#territory option:selected").val();
      if (vf == "") {
        return false;

      } else {
        $('#territory option').remove();
        var opton = "<option value=''>Please Select </option>";
        $.ajax({
          url: base_url + "dcadmin/Employee/territory_change?isl=" + vf,
          data: '',
          type: "get",
          success: function(html) {
            if (html != "NA") {
              var s = jQuery.parseJSON(html);
              $.each(s, function(i) {
                opton += '<option value="' + s[i]['id'] + '">' + s[i]['name'] + '</option>';
              });
              $('#territory').append(opton);
              //$('#city').append("<option value=''>Please Select State</option>");

              //var json = $.parseJSON(html);
              //var ayy = json[0].name;
              //var ayys = json[0].pincode;
            } else {
              alert('No territory Found');
              return false;
            }

          }

        })
      }


    })
  });
</script>
