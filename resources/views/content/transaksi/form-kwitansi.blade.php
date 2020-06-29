<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kwitansi
        <!-- <small>preview of simple tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Transaksi</a></li>
        <li><a href="#">Kwitansi</a></li>
        <li class="active">
          @if($jika == 'add')
            Tambah baru
          @elseif($jika == 'edit')
            Edit Kwitansi
          @else
            Detail Kwitansi
          @endif
        </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">
                @if($jika == 'add')
                  Tambah baru
                @elseif($jika == 'edit')
                  Edit Kwitansi
                @else
                  Detail Kwitansi
                @endif
              </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <form class="form-horizontal" id="kwitansi_form" method="post" action="{{ url($act) }}" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="act" name="act" value="{{$jika}}">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">No Kwitansi</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="nokwi" name="nokwi" value="{{ isset($datas->id_byr) ? $datas->id_byr : $nokwi }}" readonly="">
                        </div>
                        <div class="col-lg-1">&nbsp;</div>
                        <label class="col-lg-2 control-label">Tanggal Bayar</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="tgl_byr" name="tgl_byr" value="{{ isset($datas->tanggal_bayar) ? $datas->tanggal_bayar : '' }}" @if($jika == 'detail') disabled @endif>
                        </div>
                      </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">No BAP</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="nobap" name="nobap" value="{{ isset($datas->id_bap) ? $datas->id_bap : '' }}" readonly="">
                        </div>  
                        <div class="col-lg-1">
                          @if($jika != 'detail')
                          <a onclick="pilih_bap()"><span class="btn btn-default">...</span></a>
                          @endif
                        </div>
                        <label class="col-lg-2 control-label">Mekanik</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="mekanik" name="mekanik" value="{{ isset($datas->nm_karyawan) ? $datas->nm_karyawan : '' }}" readonly="">
                        </div>  
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Nama Pelanggan</label>
                        <div class="col-lg-3">
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ isset($datas->nm_plg) ? $datas->nm_plg : '' }}" readonly="">    
                        </div>
                        <div class="col-lg-1">&nbsp;</div> 
                        <label class="col-lg-2 control-label">No Polisi</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="no_polisi" name="no_polisi" value="{{ isset($datas->no_polisi) ? $datas->no_polisi : '' }}" readonly="">
                        </div>  
                    </div>
                    <table class="table table-bordered table-hover" id="tb_detail">
                      <thead>
                        <tr style="background-color: #4CAF50;">
                          <th>No</th>
                          <th>Part/Service</th>
                          <th>Qty</th>
                          <th>Harga Satuan</th>
                          <th>SubTotal</th>
                        </tr>
                      </thead>  
                    </table>
                     <div class="form-group">
                        <label class="col-lg-2 control-label">&nbsp;</label>
                        <div class="col-lg-3">&nbsp;</div>
                        <div class="col-lg-1">&nbsp;</div> 
                        <label class="col-lg-4 control-label">&nbsp;</label>
                        <div class="col-lg-2">
                          <input type="text" class="form-control" id="total" name="total" value="{{ isset($datas->nm_karyawan) ? $datas->nm_karyawan : '' }}" readonly="">
                        </div>  
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  @if($jika != 'detail')
                  <input type="button" value="Submit" class="btn btn-primary" onclick="post('#kwitansi_form', $('#nokwi').val()); return false;">
                  <button type="reset" class="btn btn-danger">Reset</button>
                  @endif
                </div>
              </form>
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
     <div class="modal fade" id="pilihbap">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Pilih BAP</h4>
          </div>
          <div class="modal-body">
            <table id="tb_pilihbap" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No BAP</th>
                  <th>Nama</th>
                  <th>Mekanik</th>
                  <th>No Polisi</th>
                  <th>Action</th>
                </tr>
              </thead>  
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <script type="text/javascript">
      $(document).ready(function(){
          $("#tgl_byr").datepicker({
            autoclose: true, 
            todayHighlight: true,      
            format: 'dd-mm-yyyy',
          });

          @if($jika == "detail" || $jika == "edit")
            pilih($('#nobap').val());
          @endif
      });

      function pilih_bap()
        {
          var page_url = window.location.origin;
          page_url = page_url+'/pilihbap'

          $.ajax({
            method: 'POST',
            url : page_url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : 'kosong',
          }).done(function (loop) {
            var table = $('#tb_pilihbap').DataTable({
                    destroy: true,
                    data:loop,
                    columns:[
                      {data:'no'},
                      {data:'id'},
                      {data:'nama'},
                      {data:'mekanik'},
                      {data:'no_polisi'},
                      // {defaultContent:'<a onclick="pilih()"><span class="btn btn-block btn-success btn-xs">Click!</span></a>'}]
                      {data:'action'}]
                   }); 
          });

        $(function () {
          $('#tb_recon').DataTable()
        })

        $('#pilihbap').modal('show');
      }

      function pilih(id_bap)
        {
          var page_url = window.location.origin;
          page_url = page_url+'/lookup_bap'

          $.ajax({
            method: 'POST',
            url : page_url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {id_bap:id_bap},
          }).done(function (dataplg) {
            $('#pilihbap').modal('hide');
            $('#nobap').val(dataplg['header']['id']);
            $('#nama').val(dataplg['header']['nama']);
            $('#mekanik').val(dataplg['header']['nm_karyawan']);
            $('#no_polisi').val(dataplg['header']['no_polisi']);
            $('#total').val(dataplg['header']['grand_total']);
            
            var table = $('#tb_detail').DataTable({
                          destroy: true,
                          searching: false,
                          paging: false,
                          info: false,
                          ordering: false,
                          data:dataplg['detail'],
                          columns:[
                            {data:'no'},
                            {data:'nm_brg'},
                            {data:'qty'},
                            {data:'harga'},
                            {data:'total'}
                          ]
                        });   
          });
        }
    </script>
    