<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Barang
        <!-- <small>preview of simple tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Master</a></li>
        <li><a href="#">Data Barang</a></li>
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
              <form class="form-horizontal" id="barang" method="post" action="{{ url($act) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">No Barang</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="id_brg" name="id_brg" value="{{ isset($datas->id_brg) ? $datas->id_brg : $id_brg }}" readonly="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kategori Barang</label>
                      <div class="col-sm-6">
                        <select class="form-control" id="kategori" name="kategori">
                          @foreach($option as $options)
                              <option {{ isset($datas->kategori) ? ($options == $datas->kategori) ? 'selected="selected"' : '' : '' }}>{{$options}}</option>
                          @endforeach
                        </select>
                      </div>  
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nama Barang</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ isset($datas->nm_brg) ? $datas->nm_brg : '' }}">
                      </div>  
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Harga Barang</label>
                      <div class="col-sm-6">
                        <textarea class="form-control" rows="3" id="harga" name="harga">{{ isset($datas->harga) ? $datas->harga : '' }}</textarea>
                      </div>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  <input type="button" value="Submit" class="btn btn-primary" onclick="post('#barang'); return false;">
                  <button type="submit" class="btn btn-danger">Reset</button>
                </div>
              </form>
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