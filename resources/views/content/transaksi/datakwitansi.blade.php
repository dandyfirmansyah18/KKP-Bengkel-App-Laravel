<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Kwitansi
        <!-- <small>preview of simple tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Transaksi</a></li>
        <li class="active">Data Kwitansi</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Kwitansi</h3>
            </div>
            <form role="form" action="#" method="POST">
	            {!! csrf_field() !!}
	            <div class="box-footer">
	              <span class="btn btn-info" onclick="call('<?= url('listAddkwitansi'); ?>','_content_')" id="tambah" name="tambah">Tambah Data</span>
	            </div>
            </form>

            <!-- /.box-header -->
            <div class="box-body">
              <table id="tb_kwitansi" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No Kwitansi</th>
                  <th>No BAP</th>
                  <th>Nama</th>
                  <th>Merk Mobil</th>
                  <th>No Polisi</th>
                  <th>Tanggal Bayar</th>
                  <th>Total Bayar</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $datas)
                <tr>
                  <td>{{$datas->id_byr}}</td>
                  <td>{{$datas->id_bap}}</td>
                  <td>{{$datas->nm_plg}}</td>
                  <td>{{$datas->merk_mobil}}</td>
                  <td>{{$datas->no_polisi}}</td>
                  <td>{{$datas->tanggal_bayar}}</td>
                  <td>{{ number_format($datas->total_byr) }}</td>
                  <td>
                      <a class="btn btn-primary btn-xs" onclick="call('<?= url('showkwi/'.$datas->id_byr); ?>','_content_')">Show</a>
                      <a class="btn btn-warning btn-xs" onclick="call('<?= url('editkwi/'.$datas->id_byr); ?>','_content_')">Edit</a>
                      <a class="btn btn-danger btn-xs" onclick="deletedata('delkwi','<?= $datas->id_byr ?>')">Delete</a>
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

      function tb_kwitansi_cari(page_url)
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

          var table = $('#tb_kwitansi').DataTable({
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
        $('#tb_kwitansi').DataTable()
      })

      $('#datepicker').datepicker({
        autoclose: true
      })
    </script>