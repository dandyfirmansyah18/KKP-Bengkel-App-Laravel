<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Klaim Garansi
        <!-- <small>preview of simple tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Transaksi</a></li>
        <li class="active">Data Klaim Garansi</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Klaim Garansi</h3>
            </div>
            <form role="form" action="#" method="POST">
	            {!! csrf_field() !!}
	            <div class="box-footer">
	              <span class="btn btn-info" onclick="call('<?= url('listAddGaransi'); ?>','_content_')" id="tambah" name="tambah">Tambah Data</span>
	            </div>
            </form>

            <!-- /.box-header -->
            <div class="box-body">
              <table id="tb_garansi" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No Klaim</th>
                  <th>No Kwitansi</th>                  
                  <th>Tanggal Bayar</th>
                  <!-- <th>Tanggal Service</th> -->
                  <th>Tanggal Klaim</th>
                  <th>Nama Pelanggan</th>                  
                  <th>Merk Mobil</th>
                  <th>No Polisi</th>                  
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $datas)
                <tr>
                  <td>{{$datas->id_klaim}}</td>
                  <td>{{$datas->id_byr}}</td>
                  <td>{{$datas->tanggal_bayar}}</td>
                  <!-- <td>{{$datas->tanggal_service}}</td> -->
                  <td>{{$datas->tanggal_klaim}}</td>
                  <td>{{$datas->nm_plg}}</td>
                  <td>{{$datas->merk_mobil}}</td>
                  <td>{{$datas->no_polisi}}</td> 
                  <td>
                      <a class="btn btn-primary btn-xs" onclick="call('<?= url('showgaransi/'.$datas->id_klaim); ?>','_content_')">Show</a>                      
                      <a class="btn btn-warning btn-xs" onclick="call('<?= url('editgaransi/'.$datas->id_klaim); ?>','_content_')">Edit</a>
                      <a class="btn btn-danger btn-xs" onclick="deletedata('delgaransi','<?= $datas->id_klaim ?>')">Delete</a>                      
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
        $('#tb_garansi').DataTable()
      })

      $('#datepicker').datepicker({
        autoclose: true
      })
    </script>