<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Customer
        <!-- <small>preview of simple tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active">Data Customer</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Customer</h3>
            </div>
            <form role="form" action="#" method="POST">
	            {!! csrf_field() !!}
	            <div class="box-footer">
	              <span class="btn btn-info" onclick="call('<?= url('listAddcus'); ?>','_content_')" id="tambah" name="tambah">Tambah Data</span>
	            </div>
            </form>

            <!-- /.box-header -->
            <div class="box-body">
              <table id="tb_recon" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No Pelanggan</th>
                  <th>Nama</th>
                  <th>Nomer Polisi</th>
                  <th>Merk Mobil</th>
                  <th>Nomer Telp</th>
                  <th>Action</th>

                </tr>
                </thead>
                <tbody>
                @foreach($data as $data)
                <tr>
                  <td>{{$data->id_plg}}</td>
                  <td>{{$data->nm_plg}}</td>
                  <td>{{$data->no_polisi}}</td>
                  <td>{{$data->merk_mobil}}</td>
                  <td>{{$data->no_telp}}</td>
                  <td>
                      <a class="btn btn-primary btn-xs" onclick="call('<?= url('showcus/'.$data->id_plg); ?>','_content_')">Show</a>
                      <a class="btn btn-warning btn-xs" onclick="call('<?= url('listgetcus/'.$data->id_plg); ?>','_content_')">Edit</a>
                      <a class="btn btn-danger btn-xs" onclick="deletedata('delcus','<?= $data->id_plg ?>')">Delete</a>
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

      function tb_recon_cari(page_url)
      {
        var tanggal="", type="", recon=""
        if($('#datepicker').val().length > 0)
        {
          tanggal = $('#datepicker').val();
          $('#datepicker').val(tanggal);
        }

        if($('#type').val().length > 0)
        {
          type = $('#type').val();
          $('#type').val(type);
        }

        if($('#recon').val().length > 0)
        {
          recon = $('#recon').val();
          $('#recon').val(recon);
        }

        $.ajax({
          method: 'POST',
          url : page_url,
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data : { tanggal:tanggal, type:type, recon:recon },
        }).done(function (msg) {
          
          var type = msg['type']
          var query = msg['query'] 
          var myTable = "";

          var table = $('#tb_recon').DataTable({
                  destroy: true,
                  data:query,
                  columns:[
                    {data:'no'},
                    {data:'tanggal'},
                    {data:'type'},
                    {data:'recon'},
                    {data:'filename'},
                    {data:'c1'},
                    {data:'c2'}]
                 }); 
        });
      }

      $(function () {
        $('#tb_recon').DataTable()
      })

      $('#datepicker').datepicker({
        autoclose: true
      })
    </script>