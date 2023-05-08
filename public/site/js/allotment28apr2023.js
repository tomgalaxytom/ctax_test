
     
var siteurl = "https://rtionline.tn.gov.in/ctax/ctax_test/";

    

        window.onload = function() 
        {

fetch_data_auto_load("" ,"","","all","auto") ;
//Column Hide /Show

if(session_roleid == '02'){

    var dt = $('#billSelectionTable').DataTable();
   //hide the first column
   dt.columns([4,5,6]).visible(false);
    



   


}
else{

    var dt = $('#billSelectionTable').DataTable();
   //hide the first column

   dt.columns([4,5,6,7]).visible(true);


   //debugger;

// $(document).on('click', '.dt-checkboxes-cell input:checkbox', function() { 
// debugger;     
//     $('.dt-checkboxes-select-all').find('input:checkbox').not(this).prop('checked', false);      
// });


   var b = false;
$('.dt-checkboxes-select-all').find('input:checkbox:first').attr('disabled', "disabled");

$('.dt-checkboxes-select-all').find('input:checkbox').not(this).prop('checked', false); 
    
  
  

   // var grid = document.getElementById("billSelectionTable");
 
   //      //Reference the CheckBoxes in Table.
   //      var checkBoxes = grid.getElementsByTagName("INPUT");
   //      var l = checkBoxes.length;
   //       var row = checkBoxes[0].value;
     
   //  $("#multipleCheckbox").attr('disabled', "disabled");
}





            //;

          //  emptyTableChecking( , "all");

           //   var userDataTable = $('#billSelectionTable').DataTable();

           // if ( ! userDataTable.data().any() ) {
           //      $('#dataTableBody').hide();
           //  }
           //  else{
           //     $('#dataTableBody').hide();
           //  }




            var valiator = $('#allotment_form').validate({


// Specify validation rules
rules: {
    menu: {
        required: true
    },
    menu_url: {
        required: true
    },
    cat_sub: {
        required: true
    },
    cat_name: {
        required: true
    },
    flexCheckChecked: {
        required: true
    },
},
// Specify validation error messages
messages: {
    menu:"Enter Maximum Count",
    key:"Enter Menu key ",
    menu_url:"Enter Year / Month",
    cat_sub:"Select Cateory or Sub Category",
    cat_name:"Select Cateory Name",
},
highlight: function(element, errorClass) 
{
    $(element).removeClass(errorClass); //prevent class to be added to selects
},
errorPlacement: function(error, element) 
{
    if(element.parent('.input-group').length) 
    {
        error.insertAfter(element.parent());
    }
    else
    {
        error.insertAfter(element);
    }
},
submitHandler: function(form) 
{
    event.preventDefault();
    var form_data = $('#allotment_form').serialize(); // All form data in a form_data variable.


    
    // $('#billSelectionTable').dataTable().fnDestroy();
    let selectCountValue = $('#menu').val();
   

     var district         = $("#distid option:selected").val();



     $.ajax({  //ajax start
                url: siteurl+'/Allotment/totalMaximumCountbasedConfigTable',
                paging: "true",
                dataType: "json",
                type    : 'POST',
                data    :{
                    csrf    :   $('#csrf').val(),
                    district :district,
                    selectCountValue : selectCountValue
        

                },
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                        

                      
                       if(data.message == 'true'){


                               

                                $('#allotment_confirmation_alert').modal('show');
                                 var final = data.count +"*"+data.scountvalue;
                                 var finalString = final+"= "+ data.finalcount;
                                 $('.winners_class').html(finalString);



                        
                                 
                      
                        
                        
                       }
                       else{

                        swal({
                                    title: "", 
                                    text: "Records is not available current Month" , 
                                    type:"success"
                                }).then(function(){ 
                                     location.reload();
                                }
                                );

                          
                       }
                       
                    }
                },
                error: function (xhr, status, error) 
                {
                    var err = JSON.parse(xhr.responseText);     

                    if(err.code==413)
                    {
                        // $("#display_error").show();
                        // $('#display_error').html("101_611 Please contact Admin");
                        alert('Extra characters included')

                    }   
                    if(err.code== 403)
                        alert('csrf token invalid')

                    if(err.code==400)
                        alert('Bad request');
                },
            }); // Ajax End

   

   
   
  
}
});

             
            
             var district         = $("#distid option:selected").val();
          
            
            
        };

        function reset_menuform()
        {
            valiator.resetForm();
            $('#action').val('insert');
            $('#button_action').val('Save');
            document.getElementById('button_action').style.backgroundColor ='#56a1e3';
            document.getElementById('button_action').style.color = "#FFFFFF";

        }

        function reset_enableform()
        {
            $('#enable_confirmation_alert').modal('show');

            //$("#menu").prop('disabled', true);
             //$('#enableButton').hide();

        }

        function enable_select_count_text_box(){

            $("#menu").prop('disabled', false);
             $('#enableButton').hide();

        }




        function enable_cat(value) 
        {
            if ($('#cat_sub').val() == '') 
            {
                passing_alert_value('Alert', 'Please select category/subcategory option', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
                $("#cat_name").attr("disabled", "disabled");

            } 
            else 
            {
                if ($('#cat_sub').val() == 1) 
                {
                    $("#cat_name").attr("disabled", "disabled");
                    $("#cat_name").val('');
                } 
                else 
                    $("#cat_name").removeAttr("disabled");
            }
            
        }

        function fun_close()
        {
            valiator.resetForm();
            
        }
        function fetch_data(selectCountValue ,yearmonth,seedValue,district) 
        {
            //  $("#datatables").html(`<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>`);
             

             fetch_data_auto_load(selectCountValue ,yearmonth,seedValue,district,actionfunc = 'form-submit' );
             
             



            
        
        }
        //$(".forward-btn").attr('disabled', "disabled");
        //$(".revert_back_btn").attr('disabled', "disabled");

        


        function fetch_data_auto_load(selectCountValue ,yearmonth,seedValue,district,actionfunc) 
        { 
           
           
             var formData = {
                select_count_value: selectCountValue,
                yearmonth: yearmonth,
                seedValue: seedValue,
                district : district,
                act : actionfunc
            };

          
           //emptyTableChecking(formData , district);

           if(district != 'all')
                             {
                                     $('#dataTableBody').show();

                              displayDatatable(formData);
                             }
                              else{
                                     $('#dataTableBody').show();
                                      $('#billSelectionTable').show();
                                displayDatatable(formData);
                                //emptyTableChecking(formData , district);
                             }

           

            
        }
        function emptyTableChecking(formData , district){
             $.ajax({
                url: siteurl+'/Allotment/EmptyTableCheckingToServer',
                paging: "true",
                dataType: "json",
                type    : 'POST',
                data    :{
                    csrf    :   $('#csrf').val(),
                    
               

                },
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                        ;
                                              
                         if(data.message == 'true'){

                             if(district != 'all')
                             {
                                    // $('#dataTableBody').show();
                              displayDatatable(formData);
                             }
                              else{
                                    // $('#dataTableBody').show();
                                displayDatatable(formData);
                             }
                                                        
                              
                        }
                        else{
                            swal({
                                    title: "", 
                                    text: "Records is not available Bill Details DB", 
                                    type:"success"
                                }).then(function(){ 
                                     location.reload();
                                }
                                );

                                $('#dataTableBody').hide();

                        }
                     
                    }
                },
                error: function (xhr, status, error) 
                {
                    var err = JSON.parse(xhr.responseText);     

                    if(err.code==413)
                    {
                        // $("#display_error").show();
                        // $('#display_error').html("101_611 Please contact Admin");
                        alert('Extra characters included')

                    }   
                    if(err.code== 403)
                        alert('csrf token invalid')

                    if(err.code==400)
                        alert('Bad request');
                },
            });
        }
        function displayDatatable(formData){
            //@stalin
            var baseurl = siteurl+'/Allotment/FetchingAllotmentDataAuto';
            var userDataTable = $('#billSelectionTable').DataTable({
                "fnInitComplete": function(oSettings) {
           if (oSettings.aiDisplayMaster.length <= 0) {
               $("#dataTableBody").hide();
           }
        },
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'paging': true,
            'pageLength' : 5,
             scrollY:        "300px",
        scrollX:        true,
        scrollCollapse: true,
       
      

            'lengthMenu': [[5, 10, 20, -1], [5, 10, 20,"All"]],
            'iDisplayLength': -1,
            'ajax': {
                'url': baseurl,
                data: formData,
            },
            
            'destroy':true,
            responsive: {
            details: {
                type: 'column'
            }
        },
            'columns': [
                {
                    data: 'bill_selection_id'
                },
                {
                    data: 'distename',
                },
                 {
                    data: 'billnumber'
                },
               
                 {
                    data: 'billamount'
                },
                
               
                {
                    data: 'process_code',
                },
                
                 {
                    data: 'action'
                },
                {
                    data: 'message',
                },
                
                {
                    data: 'name'
                },
                {
                    data: 'mobilenumber'
                },
                {
                    data: 'filepath'
                },

                 {
                    data: 'order_by_column'
                },
      

            ],
       
            'columnDefs': [
             { 
                    responsivePriority: 1,
                    targets: 0,
                    width:'5%',
                    // className: 'dtr-control',
                     orderable: false,
                     'checkboxes': {
                        'selectRow': true
                     }
                },
                 
                { 
                    responsivePriority: 2,
                     targets: -6 
                 },

             ],
             order: [ 1, 'asc' ],
            'select': {
                'style': 'multi'
            },

        });


//$('.dt-checkboxes').attr('name', 'test');

// $('#billSelectionTable .dt-checkboxes').eq(0).attr('name', 'yourNewname1');

  $('input[type="checkbox"]').closest("tr").find("td:eq(0)").attr('name', 'yourNewname1');


$('#frm-example').on('submit', function(e){
      var form = this;
      //Narayana


//var array_id = [];
//var array_action1 = [];
//var array_action2 = [];
//var array_remarks = [];

var array_data;

var i=0;
debugger;
var rows_selected = userDataTable.column(0).checkboxes.selected();

if(rows_selected.length > 0){
    $('.textAreaclass').val('');
    debugger;
    if(session_roleid == '02'){
        forward_to_jc_one();
    }
    stalin(rows_selected);



}
else{
    alert("Please select Any Check Box")
}




 //console.log(array_action2);

      //   //Narayana

      // // Encode a set of form elements from all pages as an array of names and values
      // var params = userDataTable.$('input,select,textarea').serializeArray();

      // // Iterate over all form elements
      // $.each(params, function(){
      //    // If element doesn't exist in DOM
      //    if(!$.contains(document, form[this.name])){
      //       // Create a hidden element
      //       $(form).append(
      //          $('<input>')
      //             .attr('type', 'hidden1')
      //             .attr('name', this.name)
      //             .val(this.value)
      //       );
      //    }
      // });
   });

//             // Handle form submission event@stalin
//    $('#frm-example').on('submit', function(e){
//     e.preventDefault;
//     debugger;
//       var form = this; 

//        var rows_selected = userDataTable.column(0).checkboxes.selected();
//       // var tes = userDataTable.rows({selected: true}).data();
//       // var data = userDataTable.$('select,textarea').serialize();
//       // var data2 = userDataTable.$('input[type="checkbox"]').serializeArray();
    
//     if (rows_selected.length > 0) {


       
                
//                     //$(".forward-btn").removeAttr('disabled');
//                    // $(".revert_back_btn").removeAttr('disabled');



// // Encode a set of form elements from all pages as an array of names and values
//       var params = userDataTable.$('select,textarea').serializeArray();

    

//      // Iterate over all form elements
//       $.each(params, function(){
//          // If element doesn't exist in DOM
//          if(!$.contains(document, form[this.name])){
//             // Create a hidden element
//             if(this.checked){
//             $(form).append(
//                $('<input>')
//                   .attr('type', 'hidden1')
//                   .attr('name', this.name)
//                   .val(this.value)
//             );
//         }
//          }
//       });










//  debugger;
 
//             } else {
//                 $(".forward-btn").attr('disabled', "disabled");
//                 $(".revert_back_btn").attr('disabled', "disabled");
//                 //$(".archivebtn").removeAttr('disabled');
//             }
//    }); //form submit


           


          
        }


        function stalin(rows_selected){
                $('#billSelectionTable').find('input[type="checkbox"]:checked').each(function () {
       
       //rows_selected = userDataTable.column(0).checkboxes.selected();
        array_action1 = $(this).closest("tr").find("td:eq(4) select.p_code option:selected").val();
        array_action2 = $(this).closest("tr").find("td:eq(4) select.role_user_id option:selected").val();
        array_remarks = $(this).closest("tr").find("td:eq(5) textarea.textAreaclass").val();
        debugger;
        array_id = $(this).closest("tr").find("td:eq(5) input.bsid").val();

       });

     array_data = array_id+','+array_action1+','+array_action2+','+array_remarks;
     $('#hidden_data').val(array_data);
        }

$(document).on('change', 'input[type="checkbox"]', function() {      
    $('input[type="checkbox"]').not(this).prop('checked', false);  
    debugger;
    $(this).closest("tr").find("td:eq(5) textarea.textAreaclass").val("");    
});


        
        function cancel_confirmation_box(){
             $('#allotment_confirmation_alert').modal('hide');
              $('#distid').prop('disabled', false);
              $('#bill_year').prop('disabled', false);
              $('#bill_month').prop('disabled',  false);
             // $('#flexCheckChecked').removeattr('disabled', 'disabled');
              $('#menu').prop('disabled', false);
        }
         function allotment_fetch_data(){
            // var table = $('#billSelectionTable').DataTable();
            // table.destroy();
            //;
            var selectCountValue = $("#menu").val();
            var bill_year        =  $("#bill_year option:selected").text(); 
            var bill_month       = $("#bill_month option:selected").val();
            var district         = $("#distid option:selected").val();
            var yearmonth        = bill_year.concat(bill_month);
            var min              = -1;
            var max              = 1
            var random           = (Math.random() * (max - min) + min);
            let num              = random;
            let seedValue        = num.toString().substring(0,4);

           


           

             //let seedValue  = 0.33;


            if(district == undefined){
                alert("Already ALl Districts Selected");
                return false;
            }
            fetch_data(selectCountValue ,yearmonth,seedValue,district );
           // location.reload()
            //$('#button_action').attr('disabled', 'disabled');

         }
         function forwardConfirmationOpen(){
            $('#forward_confirmation_alert').modal('show');
         }

         function role_revert_back(dc_value,remarks,id){


              if(session_roleid == "02"){ //ADC
                var ids =   $("#ids").val();
                var p_bill_selection_id = ids;
                var role_type_id          =  "03"; 
                var role_type_name        = "JC"; 
                var dc_name = '';
                var remarks ="Forward To  JC";
            }
            else if(session_roleid == "03"){ //JC
                var role_type_id          =  "04"; 
                var role_type_name        = "DC";
                 var dc_name = dc_value;
                var p_bill_selection_id =   id;
            }
            else if(session_roleid == "04"){ //DC
                var role_type_id          =  "03"; 
                var role_type_name        = "JC";
                var dc_name = dc_value;
                 var p_bill_selection_id =   id;
            }
             else if(session_roleid == "05"){  //AC
               
                var role_type_id          =  "04"; 
                var role_type_name        = "DC";
                var dc_name = dc_value;
                var p_bill_selection_id =   id;
            }


            $.ajax({
                url: base+'/Allotment/RevertBackToBeforeRole',
                paging: "true",
                dataType: "json",
                type    : 'POST',
                data    :{
                    csrf    :   $('#csrf').val(),
                    bill_selection_id  : p_bill_selection_id ,
                     dc_name  : dc_name ,
                     remarks : remarks
               

                },
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                                              
                         if(data.message == 'true'){
                            
                              swal({
                                    title: "", 
                                    text: "Revert Back Successfully To "+role_type_name, 
                                    type:"success"
                                }).then(function(){ 
                                    location.reload();
                                }
                                );

                        }
                     
                    }
                },
                error: function (xhr, status, error) 
                {
                    var err = JSON.parse(xhr.responseText);     

                    if(err.code==413)
                    {
                        // $("#display_error").show();
                        // $('#display_error').html("101_611 Please contact Admin");
                        alert('Extra characters included')

                    }   
                    if(err.code== 403)
                        alert('csrf token invalid')

                    if(err.code==400)
                        alert('Bad request');
                },
            });
         }
        
         

         function role_forward(dc_value,remarks,id){

            

         // let p_bill_selection_id =   id;




        
          

            if(session_roleid == "02"){
                var ids =   $("#ids").val();
                var p_bill_selection_id = ids;
                var role_type_id          =  "03"; 
                var role_type_name        = "JC"; 
                var dc_name = '';
                var remarks ="Forward To  JC";
            }
            else if(session_roleid == "03"){
                var role_type_id          =  "04"; 
                var role_type_name        = "DC";
                 var dc_name = dc_value;
                var p_bill_selection_id =   id;
            }
            else if(session_roleid == "04"){
                var role_type_id          =  "04"; 
                var role_type_name        = "AC";
                var dc_name = dc_value;
                 var p_bill_selection_id =   id;
            }
             else if(session_roleid == "05"){
               
                var role_type_name        = "v";
            }

            $.ajax({
                url: siteurl+'/Allotment/ForwardToNextRole',
                paging: "true",
                dataType: "json",
                type    : 'POST',
                data    :{
                    csrf    :   $('#csrf').val(),
                    bill_selection_id  : p_bill_selection_id ,
                    dc_name  : dc_name ,
                    remarks : remarks
               

                },
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                       
                        if(data.message == 'true'){

                            if(role_type_name == 'v'){

                                 swal({
                                    title: "", 
                                    text: "Verified Successfully", 
                                    type:"success"
                                 }).then(function(){ 
                                    location.reload();
                                });

                            }
                            else{

                                 swal({
                                    title: "", 
                                    text: "Forwarded Successfully to "+role_type_name, 
                                    type:"success"
                                 }).then(function(){ 
                                    location.reload();
                                });

                            }


               
                            
                            // swal("Forwarded Successfully to "+role_type_name) ;
                            // setTimeout(function(){
                            //     window.location.reload();
                            //   }, 5000);
                        }
                     
                    }
                },
                error: function (xhr, status, error) 
                {
                    var err = JSON.parse(xhr.responseText);     

                    if(err.code==413)
                    {
                        // $("#display_error").show();
                        // $('#display_error').html("101_611 Please contact Admin");
                        alert('Extra characters included')

                    }   
                    if(err.code== 403)
                        alert('csrf token invalid')

                    if(err.code==400)
                        alert('Bad request');
                },
            });
         }


                // Handle form submission event
        $(".action-btn").on('click', function(e) {
            e.preventDefault;
           
            
            $("#action").val($(this).data('action'));

            let action_value = $("#action").val();
           

            if(session_roleid == "02"){

                 var dc_value ="";

            }
            else if(session_roleid == "03"){
                var dc_value = $(this).parents().parents().find(' #list-dcs option:selected').val();
            }
            else if(session_roleid == "04"){
               var dc_value = $(this).parents().parents().find(' #list-acs option:selected').val();
            }
             else if(session_roleid == "05"){ //Ac For revert back
               var dc_value = $(this).parents().parents().find(' #list-dcs-rb option:selected').val();
            }
            
           // var dc_value = $(this).parents().parents().find(' #list-dcs option:selected').val();

            // make the form submit
            var rows_selected = $('#billSelectionTable').DataTable().column(0).checkboxes.selected();



            //let form = "#frm-example";
            let rowIds = "";



            if (rows_selected.length == 0) {

                swal("Please select atleast one checkbox");
                return false;

            } else {

                let title = action_value[0].toUpperCase() +action_value.slice(1);
                $.each(rows_selected, function(index, rowId) {
                            // Create a hidden element
                            rowIds += `${rowId},`;

                        });
                        rowIds = rowIds.substring(0, rowIds.length - 1);

                        $("#ids").val(rowIds);
                       
                        if(action_value =='role_forward'){
                            role_forward(dc_value,"","");
                        }
                        else if(action_value =='role_revertback'){
                            role_revert_back(dc_value);
                        }

                       
                    

            }

        });
     $(function() {
        // $('#button_action').attr('disabled', 'disabled');
         $('#alloted_detail_btn').attr('disabled', 'disabled');
         $('#flexCheckChecked').click(function() {
             if ($(this).is(':checked')) {
                
                 $('#button_action').removeAttr('disabled');
                 $('#alloted_detail_btn').removeAttr('disabled');
                 
             } else {
                 $('#button_action').attr('disabled', 'disabled');
                 $('#alloted_detail_btn').attr('disabled', 'disabled');
             }
         });
     });

      $('#billSelectionTable').on('change', '#p_code', function(e) {

          var p_code_value = $(this).val();
          if(p_code_value == 'R'){

          $(this).closest("tr").find('#jc_role_user_id').show();
          $(this).closest("tr").find('#role_user_id').hide();

          }
          else{
             $(this).closest("tr").find('#jc_role_user_id').hide();
             $(this).closest("tr").find('#role_user_id').show();

          }

         
       

         });


      $('#billSelectionTable').on('change', '#p_ac_code', function(e) {

          var p_code_value = $(this).val();
          if(p_code_value == 'R'){

          $(this).closest("tr").find('#role_user_id_dc').show();

          }
          else{
              $(this).closest("tr").find('#role_user_id_dc').hide();

          }

         
       

         });


     $('#billSelectionTable').on('click', '.publish', function(e) { // publish button start
            e.preventDefault()

            //debugger;
          
            var id = $(this).data('id');

            if(session_roleid == "05"){
                var roles_id = $(this).closest("tr").find('#role_user_id_dc option:selected').val();
                var dc_value = roles_id ;
                var process_code = $(this).closest("tr").find('#p_ac_code option:selected').val();

            }
            else{
                var roles_id = $(this).closest("tr").find('#role_user_id option:selected').val();
                var dc_value = roles_id ;
                var process_code = $(this).closest("tr").find('#p_code option:selected').val();
            }
            
           

            swal("Write something here:", {
                content: "input",
                })
                .then((remarks) => { //then start
                //swal(`You typed: ${value}`);
                if(remarks == ""){
                    swal("Enter Remarks");
                    return false;
                }

                if(process_code == 'F'){
                    role_forward(dc_value,remarks,id)
                }
                else if(process_code == 'V'){

                    role_verified(dc_value,remarks,id)

                }
                 if(process_code == 'R'){
                    role_revert_back(dc_value,remarks,id)
                }

              //  role_forward(dc_value,remarks)

               
            });      // Then end    
         

        }); // publish button end


function role_verified(dc_value,remarks,id){
     $.ajax({ //ajax start
        url: siteurl+'/Allotment/VerifyTo',
        dataType: "json",
        type    : 'POST',
        data    :{
            csrf    :   $('#csrf').val(),
            bill_selection_id  : id ,
            remarks: remarks,
            dc_value :dc_value
        

        }, // in ,my case the absence of this was the cause of failure
    

                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                        
                        if(data.message == 'true'){
;

                swal({
                    title: "", 
                    text: data.text, 
                    type:"success"
                 }).then(function(){ 
                    location.reload();
                }
                );       
                        }
                     
                    }
                },
                error: function (xhr, status, error) 
                { //error start
                    var err = JSON.parse(xhr.responseText);     

                    if(err.code==413)
                    {
                        alert('Extra characters included')
                    }   
                    if(err.code== 403)
                        alert('csrf token invalid')

                    if(err.code==400)
                        alert('Bad request');
                }, // error end
      
      
                }); //ajax end
}




     function forward_to_jc_one(){
         $('#jc_two_confirmation_alert').modal('show');    
    }
      function forward_to_jc_two(){
         $('#jc_two_confirmation_alert').modal('show');
     }

      function forward_to_dc_one(){
         $('#dc_fwd_one').modal('show');    
    }

      function forward_to_dc_two(){
         $('#dc_fwd_two').modal('show');    
    }

     function forward_to_ac_one(){
         $('#ac_fwd_one').modal('show');    
    }

      function forward_to_ac_two(){
         $('#ac_fwd_two').modal('show');    
    }

     function verify_to_ac_one(){
         $('#ac_verify_one').modal('show');    
    }

      function verify_to_ac_two(){
         $('#ac_verify_two').modal('show');    
    }

    

     

     function revert_back_to_adc_one(){
         $('#adc_one_confirmation_alert').modal('show');     }
      function revert_back_to_adc_two(){
         $('#adc_two_confirmation_alert').modal('show');
     }



     function revert_back_to_dc_one(){
         $('#dc_rb_one').modal('show');     }
      function revert_back_to_dc_two(){
         $('#dc_rb_two').modal('show');
     }

     function revert_back_to_jc_one(){
         $('#jc_rb_one').modal('show');     }
      function revert_back_to_jc_two(){
         $('#jc_rb_two').modal('show');
     }




      function getRevertBacktoJC(selectObject) {


            ;
            var value = selectObject.value; 
          
            if(value == "R"){
              $('#p_code').closest('tr').find("#jc_role_user_id").show();
              
                $('#p_code').parent('tr').next().find("#role_user_id").hide();

            }
            else{

                $("#jc_role_user_id").hide();
                $("#role_user_id").show();

            } 
 
        }





// $(document).on('change', 'input[type="checkbox"]', function(e){
//     $('input[type="checkbox"]').not(this).prop('checked', false); 

// });


    