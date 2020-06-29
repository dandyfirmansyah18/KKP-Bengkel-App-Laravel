<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Customer
        <!-- <small>preview of simple tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Master</a></li>
        <li><a href="#">Data Customer</a></li>
        <li class="active">Tambah baru</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Baru</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <form class="form-horizontal" id="customer" method="post" action="{{ url($act) }}" enctype="multipart/form-data">
              {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">No Pelanggan</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="nik" name="nik" value="{{ isset($datas->id_plg) ? $datas->id_plg : $nik }}" readonly="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nama</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ isset($datas->nm_plg) ? $datas->nm_plg : '' }}">
                      </div>  
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">No Polisi</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="nopol" name="nopol" value="{{ isset($datas->no_polisi) ? $datas->no_polisi : '' }}">
                      </div>  
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Alamat</label>
                      <div class="col-sm-6">
                        <textarea class="form-control" rows="3" id="alamat" name="alamat">{{ isset($datas->alamat) ? $datas->alamat : '' }}</textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">No Telepon</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="notelp" name="notelp" value="{{ isset($datas->no_telp) ? $datas->no_telp : '' }}">
                      </div>
                    </div>

                     <div class="form-group">
                      <label class="col-sm-2 control-label">Merk Mobil</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="merkmobil" name="merkmobil" value="{{ isset($datas->merk_mobil) ? $datas->merk_mobil : '' }}">
                      </div>  
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">No mesin</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="nomesin" name="nomesin" value="{{ isset($datas->no_mesin) ? $datas->no_mesin : '' }}">
                      </div>  
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">No Chasis</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="nocasis" name="nocasis" value="{{ isset($datas->no_chasis) ? $datas->no_chasis : '' }}">
                      </div>  
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  <input type="button" value="Submit" class="btn btn-primary" onclick="post('#customer'); return false;">
                  <button type="reset" class="btn btn-danger">Batal</button>
                </div>
              </form>
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <script>

      
    </script>