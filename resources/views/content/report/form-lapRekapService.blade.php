<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Rekap Service 
        <!-- <small>preview of simple tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Laporan</a></li>
        <li class="active"><a href="#">Rekap Service</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Laporan Rekap Service</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <form class="form-horizontal" id="karyawan" method="post" action="{{ url($act) }}" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="act" name="act">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Periode Tanggal</label>
                        <div class="col-lg-2">
                          <input type="text" class="form-control" id="tgl_awal" name="tgl_awal">
                        </div>
                        <label class="col-lg-2 control-label">Sampai Tanggal</label>
                        <div class="col-lg-2">
                          <input type="text" class="form-control" id="tgl_akhir" name="tgl_akhir">
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Download</button>
                  <button type="reset" class="btn btn-danger">Reset</button>
                </div>
              </form>
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  <script type="text/javascript">
    $(document).ready(function(){
      $("#tgl_awal").datepicker({
        autoclose: true, 
        todayHighlight: true,      
        format: 'dd-mm-yyyy',
      });
      $("#tgl_akhir").datepicker({
        autoclose: true, 
        todayHighlight: true,      
        format: 'dd-mm-yyyy',
      });

      
    });
  </script>