<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Karyawan
        <!-- <small>preview of simple tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active">Data Karyawan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Data Karyawan</h3>
            </div>
            <form role="form" action="#" method="POST">
	            {!! csrf_field() !!}
	            <div class="box-footer">
	              <span class="btn btn-info" onclick="call('<?= url('listAddkar'); ?>','_content_')" id="tambah" name="tambah">Tambah Data</span>
	            </div>
            </form>

            <!-- /.box-header -->
            <div class="box-body">
              <table id="tb_karyawan" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Jabatan</th>
                  <th>Alamat</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $data)
                <tr>
                  <td>{{$data->id_karyawan}}</td>
                  <td>{{$data->nm_karyawan}}</td>
                  <td>{{$data->jabatan}}</td>
                  <td>{{$data->alamat}}</td>
                  <td>
                      <a class="btn btn-primary btn-xs" onclick="call('<?= url('showkaryawan/'.$data->id_karyawan); ?>','_content_')">Show</a>
                      <a class="btn btn-warning btn-xs" onclick="call('<?= url('listgetkar/'.$data->id_karyawan); ?>','_content_')">Edit</a>
                      <a class="btn btn-danger btn-xs" onclick="deletedata('delkaryawan','<?= $data->id_karyawan ?>')">Delete</a>
                  </td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <script>

     
      $(function () {
        $('#tb_karyawan').DataTable()
      })

    </script>