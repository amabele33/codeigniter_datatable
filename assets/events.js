$(document).ready(function(){
  var id = null;
  var base_url = $('#base_url').val();
  var curr_url = window.location.href;

  $(document).on('click', '.delete', function(){
    id = $(this).attr('data-id');
    $.ajax({
      url: base_url+'delete_data',
      type: 'POST',
      data: {id:id},
      success: function(res){
        console.log(res);
        // alert(res);
        location.reload();
      }
    })
  })

  $(document).on('click', '.searchbtn', function(){
    var search = $('input[name=search]').val();
    if(search == ''){
      alert('please enter a keyword to search');
    }else{

      var redirect_to = curr_url+(curr_url[curr_url.length-1] == '/' ? '' : '/')+search+'/0';
      var curr_url_splt = curr_url.split('/');
      if(curr_url_splt.length > 6){
        curr_url_splt[5] = search;
        curr_url_splt[6] = 0;
        redirect_to = curr_url_splt.join('/');
      }
      // console.log(curr_url_splt); return;
      // console.log(redirect_to);
      // console.log(curr_url_splt);
      // return;
      //
      // if(curr_url_splt[6] == '' || typeof(curr_url_splt[6]) == 'undefined'){
      //   curr_url_splt[6] = 0;
      //   redirect_to = curr_url_splt.join('/')+'/'+search;
      // }
      //
      // if(curr_url_splt.length > 5){
      //   curr_url_splt[5] = search;
      //   redirect_to = curr_url_splt.join('/');
      //   console.log(redirect_to);
      // }

      window.location.href = redirect_to;
    }
  })

  $(document).on('submit', '#AddContactForm', function(){
    var formData = $(this).serialize();
    $.ajax({
      url: base_url+'add_data',
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function(res){
        if(res.restype == 'error')
          $('.msg').html(res.resmsg);
        else
          window.location.href = base_url;
      }
    })

  });

  $(document).on('submit', '#UpdateContactForm', function(){
    var curr_url_splt = curr_url.split('/');
    var param = curr_url_splt[curr_url_splt.length - 1];
    var formData = $(this).serialize();
    $.ajax({
      url: base_url+'update_data',
      type: 'POST',
      data: formData+'&id='+param,
      dataType: 'json',
      success: function(res){
        if(res.restype == 'error')
          $('.msg').html(res.resmsg);
        else
          window.location.href = base_url;
          // alert('yes');
      }
    })

  });

  $.fn.dataTable.ext.errMode = 'none'; //prevent error message when datatable is not yet fully loaded
  var table_files = $('#ContactsDataTable').DataTable({
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
          "order": [[0,'desc']], //Initial no order.
          "columns":[
               {"data":"name"},
               {"data":"phone"},
               {"data":"", "render" : function(data, type, row, meta){
                 return '<button class="btn btn-warning">Edit</button>';
                }
              },
          ],
          // Load data for the table's content from an Ajax source
          "ajax": {
               "url": base_url+"my_contacts_datatable_",
               "type": "POST"
          },
          //Set column definition initialisation properties.
          "columnDefs": [
               {
                    "targets": [ ], //first column / numbering column
                    "orderable": false, //set not orderable

                },
           ],
     });


});
