<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Berita Acara Pekerjaan
        <!-- <small>preview of simple tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Transaksi</a></li>
        <li><a href="#">Berita Acara Pekerjaan</a></li>
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
              <form class="form-horizontal" id="bap_form" method="post" action="{{ url($act) }}" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="act" value="{{$jika}}" name="act">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">No BAP</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="nobap" name="nobap" value="{{ isset($datas->id_bap) ? $datas->id_bap : $nobap }}" readonly="">
                        </div>
                        <div class="col-lg-1">&nbsp;</div>
                        <label class="col-lg-2 control-label">Tanggal Selesai</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="tgl_slesai" name="tgl_slesai" value="{{ isset($datas->tgl_bap) ? $datas->tgl_bap : '' }}" @if($jika == 'detail') disabled @endif>
                        </div>
                      </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">No SPK</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="nospk" name="nospk" value="{{ isset($datas->id_spk) ? $datas->id_spk : '' }}" readonly="">
                        </div>  

                        <div class="col-lg-1" >
                          @if($jika != 'detail')
                            <a onclick="pilih_spk()"><span class="btn btn-default">...</span></a>
                          @endif
                        </div>
                        <label class="col-lg-2 control-label">Mekanik</label>
                        <div class="col-lg-3">
                          <select class="form-control select2" id="mekanik" name="mekanik" style="width: 100%;" @if($jika == 'detail') disabled @endif>
                            @foreach($mekanik as $mekans)
                              <option value="{{ $mekans->id_karyawan }}" @if($jika == 'edit') @if($mekans->id_karyawan == $datas->mekanik) selected @endif @endif>{{ $mekans->nm_karyawan}}</option>
                            @endforeach
                          </select>
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
                          <input type="text" class="form-control" id="nopol" name="nopol" value="{{ isset($datas->no_polisi) ? $datas->no_polisi : '' }}" readonly="">
                        </div>
                        <div class="col-lg-1">&nbsp;</div>
                        <label class="col-lg-2 control-label">KM/Odometer</label>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" id="km" name="km" value="{{ isset($datas->kilometer) ? $datas->kilometer : '' }}" readonly="">
                        </div>
                    </div>


                    @if($jika == 'edit' || $jika == 'detail')
                      @if(count($detailbap) > 0)
                        <?php $no = 1; ?>
                        @foreach($detailbap as $detailbaps)
                          <div class="form-group" <?php if($no == 1){ echo 'id="div_barang_update"';}else{ echo 'id="bap_'.$no.'"';} ?>>
                            <label class="col-lg-2 control-label"><?php if($no == 1){ echo 'Suku Cadang';}else{ echo '';} ?> </label>
                            <div class="col-lg-2">                            
                              <select class="form-control" name="barang_update[]" id="barang_update" @if($jika == 'detail') disabled @endif>
                                <option value="">--Pilih Barang--</option>
                                @foreach($barang as $barangs)
                                  <option value="{{$barangs->id_brg}}" @if($barangs->id_brg == $detailbaps->barang) selected @endif>{{$barangs->nm_brg}} - {{$barangs->harga}}</option>                                  
                                @endforeach
                              </select>                          
                            </div>

                            <div class="col-lg-1">
                              <input type="text" name="qty_update[]" id="qty_update" class="form-control" placeholder="qty" @if($jika == 'detail') disabled @endif value="{{ $detailbaps->qty }}">
                            </div>

                            <div class="col-lg-1">
                              @if($jika != 'detail')
                                @if($no == 1)                                  
                                  <a class="btn btn-success" id="addbarang_update"><i class="fa fa-fw fa-plus"></i></a>
                                @else                            
                                  <a class="btn btn-danger" onclick="deletebar('{{$no}}')"><span class="glyphicon glyphicon-trash"></span></a>
                                @endif
                              @endif
                            </div>                          
                        </div>
                        <?php $no++; ?>
                        @endforeach
                      @else

                        <div class="form-group" id="div_barang_update">
                          <label class="col-lg-2 control-label">Suku Cadang</label>
                          <div class="col-lg-2">                            
                            <select class="form-control" name="barang_update[]" id="barang_update" @if($jika == 'detail') disabled @endif>
                              <option value="">--Pilih Barang--</option>
                              @foreach($barang as $barangs)
                                <option value="{{$barangs->id_brg}}">{{$barangs->nm_brg}} - {{$barangs->harga}}</option>
                              @endforeach
                            </select>                          
                          </div>

                          <div class="col-lg-1">
                            <input type="text" name="qty_update[]" id="qty_update" class="form-control" placeholder="qty" @if($jika == 'detail') disabled @endif value="{{ isset($datas->no_telp) ? $datas->no_telp : '' }}">
                          </div>

                          <div class="col-lg-1">
                            @if($jika != 'detail')
                            <a class="btn btn-success" id="addbarang_update"><i class="fa fa-fw fa-plus"></i></a>
                            @endif
                          </div>                          
                      </div>

                      @endif
                    @else                    
                    <div class="form-group" id="div_barang">
                        <label class="col-lg-2 control-label">Suku Cadang</label>
                        <div class="col-lg-2">
                          <!-- <textarea class="form-control" rows="2">{{ isset($datas->nm_karyawan) ? $datas->nm_karyawan : '' }}</textarea> -->
                          <select class="form-control" name="barang[]" id="barang">
                            <option value="">--Pilih Barang--</option>
                            @foreach($barang as $barangs)
                              <option value="{{$barangs->id_brg}}">{{$barangs->nm_brg}} - {{$barangs->harga}}</option>
                            @endforeach
                          </select>                          
                        </div>

                        <div class="col-lg-1">
                          <input type="text" name="qty[]" id="qty" class="form-control" placeholder="qty" value="{{ isset($datas->no_telp) ? $datas->no_telp : '' }}">
                        </div>

                        <div class="col-lg-1">
                          <a class="btn btn-success" id="addbarang"><i class="fa fa-fw fa-plus"></i></a>
                        </div>                          
                    </div>
                    @endif
                    



                    <div class="form-group">
                      <label class="col-lg-2 control-label">Catatan</label>
                      <div class="col-lg-3">
                        <textarea class="form-control" name="catatan" id="catatan" rows="2" @if($jika == 'detail') disabled @endif>{{ isset($datas->catatan) ? $datas->catatan : '' }}</textarea>
                      </div>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  @if($jika != 'detail')
                  <input type="button" value="Submit" class="btn btn-primary" onclick="post('#bap_form',$('#nobap').val()); return false;">
                  <button type="reset" class="btn btn-danger">Reset</button>
                  @endif
                </div>
              </form>
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

     <div class="modal fade" id="pilihspk">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Pilih SUrat Perintah Kerja</h4>
          </div>
          <div class="modal-body">
            <table id="tb_pilihspk" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No SPK</th>
                  <th>Nama</th>
                  <th>No Polisi</th>
                  <th>Merk Mobil</th>
                  <th>KM/Odometer</th>
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
      $("#tgl_slesai").datepicker({
        autoclose: true, 
        todayHighlight: true,      
        format: 'dd-mm-yyyy',
      });

      $(".select2").select2();
  });

  function pilih_spk()
  {
    var page_url = window.location.origin;
    page_url = page_url+'/pilihspk'

    $.ajax({
      method: 'POST',
      url : page_url,
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data : 'kosong',
    }).done(function (loop) {
      var table = $('#tb_pilihspk').DataTable({
              destroy: true,
              data:loop,
              columns:[
                {data:'no'},
                {data:'id'},
                {data:'nama'},
                {data:'no_polisi'},
                {data:'merk_mobil'},
                {data:'kilometer'},
                // {defaultContent:'<a onclick="pilih()"><span class="btn btn-block btn-success btn-xs">Click!</span></a>'}]
                {data:'action'}]
             }); 
    });

    $(function () {
      $('#tb_recon').DataTable()
    })

    $('#pilihspk').modal('show');
  }

  function pilih(id_spk)
  {
    var page_url = window.location.origin;
    page_url = page_url+'/lookup_spk'

    $.ajax({
      method: 'POST',
      url : page_url,
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data : {id_spk:id_spk},
    }).done(function (dataplg) {
      $('#pilihspk').modal('hide');
      $('#nospk').val(dataplg['id']);
      $('#nama').val(dataplg['nama']);
      $('#nopol').val(dataplg['no_polisi']);
      $('#merk_mobil').val(dataplg['merk_mobil']);
      $('#km').val(dataplg['kilometer']);
    });
  }

   //untuk add
  $(function(){
     $("#addbarang").click(function() {
      var no = Math.floor(Math.random() * 1000)

      var isi = "";

      // ajax for list barang
      $.ajax({
        method: 'POST',
        url : '/listbarang_dd',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data : '',
      }).done(function (loop) {    
          isi += "<div class='form-group' id='bap_"+no+"'><label class='col-sm-2 control-label'>&nbsp;</label><div class='col-lg-2'><select class='form-control' name='barang[]'' id='barang'><option value=''>--Pilih Barang--</option>"
        $.each(loop,function(key,val) {
           isi += "<option value='" + val.id_brg + "'>" + val.nm_brg +' - '+ val.harga+ "</option>";
        }); 

        isi += "</select></div><div class='col-lg-1'><input type='text' name='qty[]'' id='qty' class='form-control' placeholder='qty'></div><div class='col-lg-1'><a type='button' onclick='deletebar("+no+")' class='btn-sm btn-danger'><span class='glyphicon glyphicon-trash'></span></a></div></div>";   

        $("#div_barang").after(isi);
      });

    })
  });

  function deletebar(no) {
    $("#bap_" + no).remove();
  }

  // untuk update
  $(function(){
     $("#addkel_update").click(function() {
      var no = Math.floor(Math.random() * 1000)
      $("#teknik_update").after("<div class='form-group' id='spk_"+no+"'><label class='col-sm-2 control-label'>&nbsp;</label><div class='col-sm-3'><textarea class='form-control' rows='2' name='keluhan_update[]' id='keluhan_update'></textarea></div><div class='col-sm-1'><div class='input-group'><button type='button' onclick='deletekel("+no+")' class='btn-sm btn-danger'><span class='glyphicon glyphicon-trash'></span></button></div></div></div>");
    })
  });

  $(function(){
     $("#addbarang_update").click(function() {
      var no = Math.floor(Math.random() * 1000)

      var isi = "";

      // ajax for list barang
      $.ajax({
        method: 'POST',
        url : '/listbarang_dd',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data : '',
      }).done(function (loop) {    
          isi += "<div class='form-group' id='bap_"+no+"'><label class='col-sm-2 control-label'>&nbsp;</label><div class='col-lg-2'><select class='form-control' name='barang_update[]'' id='barang_update'><option value=''>--Pilih Barang--</option>"
        $.each(loop,function(key,val) {
           isi += "<option value='" + val.id_brg + "'>" + val.nm_brg +' - '+ val.harga+ "</option>";
        }); 

        isi += "</select></div><div class='col-lg-1'><input type='text' name='qty_update[]'' id='qty_update' class='form-control' placeholder='qty'></div><div class='col-lg-1'><a type='button' onclick='deletebar("+no+")' class='btn-sm btn-danger'><span class='glyphicon glyphicon-trash'></span></a></div></div>";   

        $("#div_barang_update").after(isi);
      });

    })
  });
  
  // end untuk update
</script>
    