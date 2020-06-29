<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Karyawan
        <!-- <small>preview of simple tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Master</a></li>
        <li><a href="#">Data Karyawan</a></li>
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
              <form class="form-horizontal" id="karyawan" method="post" action="{{ url($act) }}" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="act" name="act">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">NIK</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="nik" name="nik" value="{{ isset($datas->id_karyawan) ? $datas->id_karyawan : $nik }}" readonly="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nama</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ isset($datas->nm_karyawan) ? $datas->nm_karyawan : '' }}">
                      </div>  
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Email</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="email" name="email" value="{{ isset($datas->email) ? $datas->email : '' }}">
                      </div>  
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Jabatan</label>
                      <div class="col-sm-6">
                        <select class="form-control" id="jabatan" name="jabatan">
                          @foreach($option as $options)
                              <option {{ isset($datas->jabatan) ? ($options == $datas->jabatan) ? 'selected="selected"' : '' : '' }}>{{$options}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Alamat</label>
                      <div class="col-sm-6">
                        <textarea class="form-control" rows="3" id="alamat" name="alamat">{{ isset($datas->alamat) ? $datas->alamat : '' }}</textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nomer Telepon</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="notelp" name="notelp" value="{{ isset($datas->no_telp) ? $datas->no_telp : '' }}">
                      </div>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  <input type="button" value="Submit" class="btn btn-primary" onclick="post('#karyawan'); return false;">
                  <button type="reset" class="btn btn-danger">Reset</button>
                </div>
              </form>
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    