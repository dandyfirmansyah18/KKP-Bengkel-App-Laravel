<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Klaim Garansi
        <!-- <small>preview of simple tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Transaksi</a></li>
        <li><a href="#">Klaim Garansi</a></li>
        <li class="active">
          @if($jika == 'add')
            Tambah baru
          @elseif($jika == 'edit')
            Edit Berita Acara Pekerjaan
          @else
            Detail Berita Acara Pekerjaan
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
                  Edit Berita Acara Pekerjaan
                @else
                  Detail Berita Acara Pekerjaan
                @endif
              </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <form class="form-horizontal" id="f_klaimgaransi" method="post" action="{{ url($act) }}" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="act" value="{{$jika}}" name="act">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">No Klaim</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="noklaim" name="noklaim" value="{{ isset($datas->id_klaim) ? $datas->id_klaim : $noklaim }}" readonly="">
                        </div>
                        <div class="col-lg-1">&nbsp;</div>
                        <label class="col-lg-2 control-label">Tanggal Klaim</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="tgl_klaim" name="tgl_klaim" value="{{ isset($datas->tanggal_klaim) ? $datas->tanggal_klaim : '' }}" @if($jika == 'detail') disabled @endif>
                        </div>
                      </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">No Kwitansi</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="nokwi" name="nokwi" value="{{ isset($datas->id_byr) ? $datas->id_byr : '' }}" readonly="">
                        </div>  
                        <div class="col-lg-1" >
                          @if($jika != 'detail')
                          <a onclick="pilih_kwi()"><span class="btn btn-default">...</span></a>
                          @endif
                        </div>
                        <label class="col-lg-2 control-label">No SPK</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="nospk" name="nospk" value="{{ isset($datas->id_spk) ? $datas->id_spk : '' }}" readonly="">
                        </div>  
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Nama Pelanggan</label>
                        <div class="col-lg-3">
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ isset($datas->nm_plg) ? $datas->nm_plg : '' }}" readonly="">    
                        </div>
                        <div class="col-lg-1">&nbsp;</div> 
                        <label class="col-lg-2 control-label">Merk Mobil</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="merk_mobil" name="merk_mobil" value="{{ isset($datas->merk_mobil) ? $datas->merk_mobil : '' }}" readonly="">
                        </div>  
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">No Polisi</label>
                        <div class="col-lg-3">
                        <input type="text" class="form-control" id="no_polisi" name="no_polisi" value="{{ isset($datas->no_polisi) ? $datas->no_polisi : '' }}" readonly="">    
                        </div>
                        <div class="col-lg-1">&nbsp;</div> 
                        <label class="col-lg-2 control-label">Tanggal Service</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="tgl_service" name="tgl_service" value="{{ isset($datas->tanggal_service) ? $datas->tanggal_service : '' }}" readonly="">
                        </div>  
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Catatan</label>
                        <div class="col-lg-3">
                          <textarea type="text" class="form-control" id="catatan" name="catatan" @if($jika == 'detail') disabled @endif>{{ isset($datas->catatan) ? $datas->catatan : '' }}</textarea>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  @if($jika != 'detail')
                  <input type="button" value="Submit" class="btn btn-primary" onclick="post('#f_klaimgaransi',$('#noklaim').val()); return false;">
                  <button type="reset" class="btn btn-danger">Reset</button>
                  @endif
                </div>
              </form>
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
     <div class="modal fade" id="pilihkwitansi">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Pilih No Kwintansi</h4>
          </div>
          <div class="modal-body">
            <table id="tb_pilihkwitansi" class="table table-bordered table-hover  ">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No Kwitansi</th>
                  <th>Tanggal Kwitansi</th>
                  <th>No BAP</th>
                  <th>Nama</th>
                  <th>No Polisi</th>
                  <th>Total Bayar</th>
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
          $("#tgl_klaim").datepicker({
            autoclose: true, 
            todayHighlight: true,      
            format: 'dd-mm-yyyy',
          });
      });

      function pilih_kwi()
      {
        var page_url = window.location.origin;
        page_url = page_url+'/pilihkwitansi'

        $.ajax({
          method: 'POST',
          url : page_url,
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data : 'kosong',
        }).done(function (loop) {
          var table = $('#tb_pilihkwitansi').DataTable({
                  destroy: true,
                  data:loop,
                  columns:[
                    {data:'no'},
                    {data:'id_byr'},
                    {data:'tgl_kwitansi'},
                    {data:'id_bap'},
                    {data:'nama'},
                    {data:'no_polisi'},
                    {data:'total_byr'},
                    // {defaultContent:'<a onclick="pilih()"><span class="btn btn-block btn-success btn-xs">Click!</span></a>'}]
                    {data:'action'}]
                 }); 
        });

        $(function () {
          $('#tb_pilihkwitansi').DataTable()
        })

        $('#pilihkwitansi').modal('show');
      }

      function pilih(id_byr)
        {
          var page_url = window.location.origin;
          page_url = page_url+'/lookup_kwitansi'

          $.ajax({
            method: 'POST',
            url : page_url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {id_byr:id_byr},
          }).done(function (dataplg) {
            $('#pilihkwitansi').modal('hide');
            $('#nokwi').val(dataplg['header']['id_byr']);
            $('#nospk').val(dataplg['header']['id_spk']);
            $('#nama').val(dataplg['header']['nama']);
            $('#merk_mobil').val(dataplg['header']['merk_mobil']);
            $('#no_polisi').val(dataplg['header']['no_polisi']);
            $('#tgl_service').val(dataplg['header']['tgl_service']);
          });
        }
    </script>
    