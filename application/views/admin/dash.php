
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
          </h1>
          <ol class="breadcrumb">
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <section class="content">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">

              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Stocks</span>
                  <span class="info-box-number"><?=$total_stocks?></span>
                </div><!-- /.info-box-content -->
              </div>
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="<?=base_url()?>dcadmin/Farmer_details/view_details">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">5 Min Calls</span>
                  <span class="info-box-number"><?=$calls_5min?></span>
                </div><!-- /.info-box-content -->
              </div></a><!-- /.info-box -->
            </div><!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">

              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">15 Min</span>
                  <span class="info-box-number"><?=$calls_15min?></span>
                </div><!-- /.info-box-content -->
              </div>
            </div><!-- /.col -->

          </div><!-- /.row -->

          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">

              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">1 Hr</span>
                  <span class="info-box-number"><? echo $calls_1hr; ?></span>
                </div><!-- /.info-box-content -->
              </div>
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="<?=base_url()?>dcadmin/Farmer_details/view_details">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">1 Day</span>
                  <span class="info-box-number"><? echo $calls_1day; ?></span>
                </div><!-- /.info-box-content -->
              </div></a><!-- /.info-box -->
            </div><!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <!-- <div class="col-md-3 col-sm-6 col-xs-12">

              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Loss Trades</span>
                  <span class="info-box-number"></span>
                </div><!-- /.info-box-content -->
              </div>
            </div><!-- /.col --> -->

          </div><!-- /.row -->





        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


    </div><!-- ./wrapper -->
