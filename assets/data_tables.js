$(document).ready(function(){
  var base_url = 'http://localhost/lifesaverplace/';


  $('#RequestForm').validate({
      rules:{
          Full_Name:'required',
          Phone_No:'required',
          Email:'required',
      },
      messages:{
          Full_Name:'This field is required',
          Phone_No:'This field is required',
          Email:'This field is required',
      }
  });

  //Facility DataTable
  $.fn.dataTable.ext.errMode = 'none'; //prevent error message when datatable is not yet fully loaded
  var table_files = $('#FacilityDataTable').DataTable({
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
          "order": [[0,'desc']], //Initial no order.
          "columns":[
               {"data":"Facility_Type"},
               {"data":"Facility_Name"},
               {"data":"", "render" : function(data, type, row, meta){
                 return row.Facility_Address+', '+row.Facility_City+' '+row.Facility_State+' '+row.Facility_Zip;
                }
              },
               {"data":"Email"},
               {"data":"Facility_Status"},
               {"data":"type"},
          ],
          // Load data for the table's content from an Ajax source
          "ajax": {
               "url": base_url+"home/facilities_data",
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

  //Facility DataTable
  $.fn.dataTable.ext.errMode = 'none'; //prevent error message when datatable is not yet fully loaded




  // var table_files = $('#loadsDataTable').DataTable({
  //         "processing": true, //Feature control the processing indicator.
  //         "serverSide": true, //Feature control DataTables' server-side processing mode.
  //         "order": [[0,'desc']], //Initial no order.
  //         "columns":[
  //              {"data":"load_id"},
  //              {"data":"customer_name"},
  //              {"data":"load_weight"},
  //              {"data":"load_quantity"},
  //              {"data":"load_dimension"},
  //              {"data":"load_price"},
  //              {"data":"date_added"},
  //              {"data":"load_id","render":function(data,type,row,meta){
  //                var str = '';
  //                str += '<button class="btn btn-flat btn-primary updateLoadBtn"><i class="fa fa-pencil"></i></button>&nbsp;';
  //                str += '<button class="btn btn-flat btn-danger deleteLoadBtn"><i class="fa fa-trash"></i></button>';
  //                return str;
  //              }},
  //         ],
  //         // Load data for the table's content from an Ajax source
  //         "ajax": {
  //              "url": base_url+"loads/getLoadsDatatables",
  //              "type": "POST"
  //         },
  //         //Set column definition initialisation properties.
  //         "columnDefs": [
  //              {
  //                   "targets": [ ], //first column / numbering column
  //                   "orderable": false, //set not orderable
  //
  //               },
  //          ],
  //    });


/******************************
    Additional jquery events
*******************************/
  $('#addLoadForm').validate({
    rules:{
      customer_name: 'required',
      load_weight: 'required',
      load_quantity: 'required',
      load_dimension: 'required',
      load_price: 'required'
    },
    messages:{
      customer_name: 'Enter Customer Name',
      load_weight: 'Enter 0 if not provided',
      load_quantity: 'Enter Load quantity',
      load_dimension: '',
      load_price: ''
    }
  });
  $('#addLoadForm').on('submit',function(){

  });

}); // End of Code (Document Ready)

function admin_facilities_datatable(){
  return $('#AdminFacilityDataTable').DataTable({
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
          "order": [[0,'desc']], //Initial no order.
          "columns":[
               {"data":"Facility_Type"},
               {"data":"Facility_Name"},
               {"data":"", "render" : function(data, type, row, meta){
                 return row.Facility_Address+', '+row.Facility_City+' '+row.Facility_State+' '+row.Facility_Zip;
                }
              },
               {"data":"Email", "render" : function(data, type, row, meta){
                 return "<div style='min-width: 140px; display: inline-block;'>"+row.Email + "</div> <button class='btn btn-primary btn-sm btn-space btn-mrgn-r-5 edit-facility' data-facility-id='"+row.ID+"' title='Edit'><i class='fa fa-pencil'></i></button>";
                }
               },
               {"data":"Facility_Status"},
               {"data":"type"},
          ],
          // Load data for the table's content from an Ajax source
          "ajax": {
               "url": base_url+"home/facilities_data",
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
}

function customer_rep_datatable(){
  var data = $('#CustRepDataTable').DataTable({
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
          "order": [[0,'desc']], //Initial no order.
          "responsive": true,
          "columns":[
            {"data":"account_id"},
            {"data":"username"},
            {"data":"name"},
            {"data":"email"},
            {"data":"status"},
            {"data":"", "render" : function(data, type, row, meta){
                var str = '<button class="btn btn-primary btn-sm btn-space btn-mrgn-r-5 edit-rep" repid="'+row.account_id+'" title="Edit"><i class="fa fa-pencil"></i></button>';

                    if(row.status == 'Active'){
                      str += '<button class="btn btn-warning btn-sm btn-space btn-mrgn-r-5 deact-rep" repid="'+row.account_id+'" title="Deactivate"><i class="fa fa-remove"></i></button>';
                    }else{
                      str += '<button class="btn btn-primary btn-sm btn-space btn-mrgn-r-5 act-rep" repid="'+row.account_id+'" title="Activate"><i class="fa fa-thumbs-up"></i></button>';
                    }

                    str += '<button class="btn btn-danger btn-sm btn-space btn-mrgn-r-5 rem-rep" repid="'+row.account_id+'" title="Remove"><i class="fa fa-trash"></i></button>';
                return str;
              }
            },
          ],
          // Load data for the table's content from an Ajax source
          "ajax": {
               "url": base_url+"home/representativelist",
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

     return data;
}

function requests_datatable(req_status){
  var data = $('#RequestsDataTable').DataTable({
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
          "order": [[0,'desc']], //Initial no order.
          "columns":[
               {"data":"","render": function(data, type, row, meta){
                 return '#'+row.request_id+' '+row.zip_city;
                }
               },
               {"data":"full_name"},
               {"data":"phone"},
               {"data":"email"},
               {"data":"request_date"},
               {"data":"btn"},
          ],
          // Load data for the table's content from an Ajax source
          "ajax": {
               "url": base_url+"home/all_requests/"+req_status,
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

     return data;
}
