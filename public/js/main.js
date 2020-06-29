function call(url, div) {
    //$(window).scrollTop(0);
    // $('#msgConfirm').hide();
    
    // $('#' + div).html('<div id="loadingImg" style="margin-left: auto; margin-top: auto;"><img src="' + base_url + 'img/loaders/loading.gif" /> loading...</div>');
    // jloadings();
    $.ajax({
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        timeout: 1200000,
        cache: false,
        data: {
        },
        success: function(data) {
            $('#' + div).fadeToggle("fast","linear",
                function () {
                    $('#' + div).html(data);
                    $('#' + div).fadeIn("slow");
                }
            );
            // Clearjloadings();
        }
    });
    
}

function delete_data(id,type){

  var result = confirm("Yakin Menghapus data ini?");
  if (result) {   
    $.ajax({
      method: 'POST',
      url : 'del'+type,
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data : {id:id},
    }).done(function (hasil) {  
      arrdata = hasil.split('||');
      if (arrdata[1] == "YES") {
          BootstrapDialog.show({
            title: 'Informasi',
            type: BootstrapDialog.TYPE_SUCCESS,
            message: '<p>'+arrdata[2]+'</p>',
            buttons: [{
              id: 'btn-ok',   
              icon: 'glyphicon glyphicon-check',       
              label: 'OK',
              cssClass: 'btn-primary',
              autospin: false,
              action: function(dialogRef){    
                  dialogRef.close();
              }
            }]
          });        

          if(arrdata.length > 3){
            setTimeout(function(){
              call(arrdata[3],'_content_');
            }, 2000);
          }
      } else if (arrdata[1] == "NO") {
        BootstrapDialog.show({
          title: 'Informasi',
          type: BootstrapDialog.TYPE_DANGER,
          message: '<p>'+arrdata[2]+'</p>'
        });
      }
    });
  }
}

function deletedata(url, id)
{
  var base_url = window.location.origin;  
  BootstrapDialog.confirm('Yakin akan Menghapus Data ini ?', function(r){
    if(r){
      $.ajax({
          type: "post",
          url: url+'/'+id,
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {id:id},
          error: function(data){
            BootstrapDialog.show({
              title: 'Informasi',
              type: BootstrapDialog.TYPE_DANGER,
              message: '<p>Maaf, request halaman tidak ditemukan</p>'
            });
          },
          success: function(data){
            arrdata = data.split('||');
            if (arrdata[1] == "YES") {
                BootstrapDialog.show({
                  title: 'Informasi',
                  type: BootstrapDialog.TYPE_SUCCESS,
                  message: '<p>'+arrdata[2]+'</p>',
                  buttons: [{
                    id: 'btn-ok',   
                    icon: 'glyphicon glyphicon-check',       
                    label: 'OK',
                    cssClass: 'btn-primary',
                    autospin: false,
                    action: function(dialogRef){    
                        dialogRef.close();
                    }
                  }]
                });

                if(arrdata.length > 3){
                  setTimeout(function(){
                    call(arrdata[3],'_content_');
                  }, 2000);
                }
            } else if (arrdata[1] == "NO") {
              BootstrapDialog.show({
                title: 'Informasi',
                type: BootstrapDialog.TYPE_DANGER,
                message: '<p>'+arrdata[2]+'</p>'
              });
            }
          }
      });
    }
  });
}

function post(a,val){
      var base_url = window.location.origin;
      BootstrapDialog.confirm('Apakah anda yakin dengan data yang Anda isikan ?', function(r){
        if(r){
          $.ajax({
              type: "post",
              url: $(a).attr('action'),
              data: $(a).serialize(),
              error: function(data){
                BootstrapDialog.show({
                  title: 'Informasi',
                  type: BootstrapDialog.TYPE_DANGER,
                  message: '<p>Maaf, request halaman tidak ditemukan</p>'
                });
              },
              success: function(data){
                arrdata = data.split('||');
                if (arrdata[1] == "YES") {
                    BootstrapDialog.show({
                      title: 'Informasi',
                      type: BootstrapDialog.TYPE_SUCCESS,
                      message: '<p>'+arrdata[2]+'</p>',
                      buttons: [{
                        id: 'btn-ok',   
                        icon: 'glyphicon glyphicon-check',       
                        label: 'OK',
                        cssClass: 'btn-primary',
                        autospin: false,
                        action: function(dialogRef){    
                            dialogRef.close();
                        }
                      }]
                    });        

                    if(a == '#spk_form') {
                      window.open(base_url+"/spk_form_cetak/"+val,"Cetak SPK","scrollbars=yes, resizable=yes,width=1100,height=700");
                    } else if(a == '#bap_form'){
                      window.open(base_url+"/bap_form_cetak/"+val,"Cetak BAP","scrollbars=yes, resizable=yes,width=1100,height=700");
                    } else if(a == '#kwitansi_form'){
                      window.open(base_url+"/kwi_form_cetak/"+val,"Cetak Kwitansi","scrollbars=yes, resizable=yes,width=1100,height=700");
                    } else if(a == '#f_klaimgaransi'){
                      window.open(base_url+"/garansi_form_cetak/"+val,"Cetak Klaim Garansi","scrollbars=yes, resizable=yes,width=1100,height=700");
                    }    

                    if(arrdata.length > 3){
                      setTimeout(function(){
                        call(arrdata[3],'_content_');
                      }, 2000);
                    }
                } else if (arrdata[1] == "NO") {
                  BootstrapDialog.show({
                    title: 'Informasi',
                    type: BootstrapDialog.TYPE_DANGER,
                    message: '<p>'+arrdata[2]+'</p>'
                  });
                }
              }
          });
        }
      });
    }
