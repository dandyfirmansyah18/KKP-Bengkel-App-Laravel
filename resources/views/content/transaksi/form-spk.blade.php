<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Surat Perintah Kerja
        <!-- <small>preview of simple tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Transaksi</a></li>
        <li class="active">Data Surat Perintah Kerja</li>
        <li class="active">
          @if($jika == 'add')
            Tambah baru
          @elseif($jika == 'edit')
            Edit SPK
          @else
            Detail SPK
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
                  Edit SPK
                @else
                  Detail SPK
                @endif
              </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <form class="form-horizontal" id="spk_form" method="post" action="{{ url($act) }}" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="act" value="{{$jika}}" name="act">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">No SPK</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="nospk" name="nospk" value="{{ isset($datas->id_spk) ? $datas->id_spk : $nospk }}" readonly="">
                        </div>
                        <div class="col-lg-1">&nbsp;</div>
                        <label class="col-lg-2 control-label">Tanggal Awal</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="tgl_awal" name="tgl_awal" value="{{ isset($datas->tgl_awal) ? $datas->tgl_awal : '' }}" @if($jika == 'detail') disabled @endif>
                        </div>
                      </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Nama Pelanggan</label>
                        <div class="col-lg-3">
                          <input type="hidden" class="form-control" id="id_pel" name="id_pel" value="{{ isset($datas->id_plg) ? $datas->id_plg : '' }}" readonly="">
                          <input type="text" class="form-control" id="nama" name="nama" value="{{ isset($datas->nm_plg) ? $datas->nm_plg : '' }}" readonly="">
                        </div>
                        <div class="col-lg-1" >
                          @if($jika != 'detail')  
                            <a onclick="pilih_pelanggan()"><span class="btn btn-default">...</span></a>
                          @endif
                        </div>
                        <label class="col-lg-2 control-label">Tanggal Akhir</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="tgl_akhir" name="tgl_akhir" value="{{ isset($datas->tgl_akhir) ? $datas->tgl_akhir : '' }}" @if($jika == 'detail') disabled @endif>
                        </div>  
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">No Polisi</label>
                        <div class="col-lg-3">
                        <input type="text" class="form-control" id="no_polisi" name="no_polisi" value="{{ isset($datas->no_polisi) ? $datas->no_polisi : '' }}" readonly="">    
                        </div>
                        <div class="col-lg-1">&nbsp;</div> 
                        <label class="col-lg-2 control-label">KM/Odometer</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="km" name="km" value="{{ isset($datas->kilometer) ? $datas->kilometer : '' }}" @if($jika == 'detail') disabled @endif>
                        </div>  
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Alamat</label>
                        <div class="col-lg-3">
                          <textarea class="form-control" rows="3" id="alamat" readonly="">{{ isset($datas->alamat) ? $datas->alamat : '' }}</textarea>
                        </div>
                        <div class="col-lg-1">&nbsp;</div>
                        <label class="col-lg-2 control-label">No Chasis</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="nocha" name="nocha" value="{{ isset($datas->no_chasis) ? $datas->no_chasis : '' }}" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Cuci</label>
                        <div class="col-lg-3">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="cuci" value="1" <?php if(isset($datas->cuci)){ if($datas->cuci == 1){ echo 'checked'; }else{ echo '';}  }else{ echo ''; } ?> @if($jika == 'detail') disabled @endif>
                              Mesin
                            </label>
                          </div>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="cuci" value="2" <?php if(isset($datas->cuci)){ if($datas->cuci == 2){ echo 'checked'; }else{ echo '';}  }else{ echo ''; } ?> @if($jika == 'detail') disabled @endif>
                              Body
                            </label>
                          </div>
                        </div>
                        <div class="col-lg-1">&nbsp;</div>
                        <div class="col-lg-3">
                          &nbsp;
                        </div>
                    </div>

                    @if($jika == 'edit' || $jika == 'detail')
                      @if(count($keluhan) > 0)
                        <?php $no = 1; ?>
                        @foreach($keluhan as $keluhans)
                        <div class="form-group" <?php if($no == 1){ echo 'id="teknik_update"';}else{ echo 'id="spk_'.$no.'"';} ?>>
                            <label class="col-lg-2 control-label"> <?php if($no == 1){ echo 'Keluhan Pelanggan';}else{ echo '';} ?> </label>
                            <div class="col-lg-3">
                              <textarea class="form-control" name="keluhan_update[]" id="keluhan_update" rows="2" @if($jika == 'detail') disabled @endif>{{ $keluhans->keluhan }}</textarea>
                            </div>  
                            <div class="col-lg-1">
                              @if($jika != 'detail')
                                @if($no == 1)
                                  <a class="btn btn-success" id="addkel_update"><i class="fa fa-fw fa-plus"></i></a>
                                @else                            
                                  <a class="btn btn-danger" onclick="deletekel('{{$no}}')"><span class="glyphicon glyphicon-trash"></span></a>
                                @endif
                              @endif
                            </div>
                        </div>
                          <?php $no++; ?>
                        @endforeach
                      @else
                        <div class="form-group" id="teknik_update">
                            <label class="col-lg-2 control-label">Keluhan Pelanggan</label>
                            <div class="col-lg-3">
                              <textarea class="form-control" name="keluhan_update[]" id="keluhan_update" rows="2" @if($jika == 'detail') disabled @endif>{{ isset($datas->nm_karyawan) ? $datas->nm_karyawan : '' }}</textarea>
                            </div>  
                            <div class="col-lg-1">
                              @if($jika != 'detail')
                                <a class="btn btn-success" id="addkel_update"><i class="fa fa-fw fa-plus"></i></a>
                              @endif
                            </div>
                        </div>    
                      @endif
                    @else
                    <div class="form-group" id="teknik">
                        <label class="col-lg-2 control-label">Keluhan Pelanggan</label>
                        <div class="col-lg-3">
                          <textarea class="form-control" name="keluhan[]" id="keluhan" rows="2">{{ isset($datas->nm_karyawan) ? $datas->nm_karyawan : '' }}</textarea>
                        </div>  
                        <div class="col-lg-1">
                            <a class="btn btn-success" id="addkel"><i class="fa fa-fw fa-plus"></i></a></div>
                    </div>
                    @endif
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  @if($jika != 'detail') 
                  <input type="button" value="Submit" class="btn btn-primary" onclick="post('#spk_form',$('#nospk').val());  return false;">
                  <button type="reset" class="btn btn-danger">Reset</button>
                  @endif
                </div>
              </form>
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

    <div class="modal fade" id="pilihpelanggan">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Pilih Pelanggan</h4>
          </div>
          <div class="modal-body">
            <table id="tb_pilihpelanggan" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>No Polisi</th>
                  <th>No Chasis</th>
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

  function pilih_pelanggan()
  {
    var page_url = window.location.origin;
    page_url = page_url+'/pilihpelanggan'

    $.ajax({
      method: 'POST',
      url : page_url,
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data : 'kosong',
    }).done(function (loop) {
      var table = $('#tb_pilihpelanggan').DataTable({
              destroy: true,
              data:loop,
              columns:[
                {data:'no'},
                {data:'nama'},
                {data:'alamat'},
                {data:'no_polisi'},
                {data:'no_chasis'},
                // {defaultContent:'<a onclick="pilih()"><span class="btn btn-block btn-success btn-xs">Click!</span></a>'}]
                {data:'action'}]
             }); 
    });

    $(function () {
      $('#tb_recon').DataTable()
    })

    $('#pilihpelanggan').modal('show');
  }
// 
  function pilih(id_plg)
  {
    var page_url = window.location.origin;
    page_url = page_url+'/lookup_pelanggan'

    $.ajax({
      method: 'POST',
      url : page_url,
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data : {id_plg:id_plg},
    }).done(function (dataplg) {
      $('#pilihpelanggan').modal('hide');
      $('#id_pel').val(dataplg['id']);
      $('#nama').val(dataplg['nama']);
      $('#alamat').val(dataplg['alamat']);
      $('#nocha').val(dataplg['no_chasis']);
      $('#no_polisi').val(dataplg['no_polisi']);

       
    });
  }

  //untuk add
  $(function(){
     $("#addkel").click(function() {
      var no = Math.floor(Math.random() * 1000)
      $("#teknik").after("<div class='form-group' id='spk_"+no+"'><label class='col-sm-2 control-label'>&nbsp;</label><div class='col-sm-3'><textarea class='form-control' rows='2' name='keluhan[]' id='keluhan'></textarea></div><div class='col-sm-1'><div class='input-group'><button type='button' onclick='deletekel("+no+")' class='btn-sm btn-danger'><span class='glyphicon glyphicon-trash'></span></button></div></div></div>");
    })
  });
  
  function deletekel(no) {
    $("#spk_" + no).remove();
  }
  //end untuk add

  // untuk update
  $(function(){
     $("#addkel_update").click(function() {
      var no = Math.floor(Math.random() * 1000)
      $("#teknik_update").after("<div class='form-group' id='spk_"+no+"'><label class='col-sm-2 control-label'>&nbsp;</label><div class='col-sm-3'><textarea class='form-control' rows='2' name='keluhan_update[]' id='keluhan_update'></textarea></div><div class='col-sm-1'><div class='input-group'><button type='button' onclick='deletekel("+no+")' class='btn-sm btn-danger'><span class='glyphicon glyphicon-trash'></span></button></div></div></div>");
    })
  });
  
  // end untuk update
</script>
    