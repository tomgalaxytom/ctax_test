

var siteurl = "http://10.163.2.160/projects/ctax_test/";



window.onload = function () {

   
    //
    fetch_data_auto_load("", "", "", "all", "auto", "all");
    //Column Hide /Show


    var valiator = $('#allotment_form').validate({ // Validate Form


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
            menu: "Enter Maximum Count",
            key: "Enter Menu key ",
            menu_url: "Enter Year / Month",
            cat_sub: "Select Cateory or Sub Category",
            cat_name: "Select Cateory Name",
        },
        highlight: function (element, errorClass) {
            $(element).removeClass(errorClass); //prevent class to be added to selects
        },
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) { // submit handler start
            
            event.preventDefault();
            var form_data = $('#allotment_form').serialize(); // All form data in a form_data variable.


            // $('#billSelectionTable').dataTable().fnDestroy();
            let selectCountValue1 = $('#menu').val();
            var selectCountValue = (selectCountValue1 == "") ? "" : selectCountValue1;

            var district = $("#distid option:selected").val();
            


            var bill_year = $("#bill_year option:selected").val();
            var bill_month = $("#bill_month option:selected").val();
            $.ajax({  //ajax start
                url: siteurl + '/Allotment/totalMaximumCountbasedConfigTable',
                paging: "true",
                dataType: "json",
                type: 'POST',
                data: {
                    csrf: $('#csrf').val(),
                    district: district,
                    selectCountValue: selectCountValue,
                    bill_year: bill_year,
                    bill_month: bill_month
                },
                success: function (data, textStatus, jqXHR) {
                    if (jqXHR.status == '200') {
                        
                        if (data.message == 'true') { //message if
                       

                            if(data.district !="all"){ //individual district start

                          

                            var trHTML = '';


                            // $.each(data.results, function(index) {

                            var bdcount = data.results[0].bdcount;
                            var bscount = data.results[0].bscount;
                            var bill_selection_count = data.results[0].bill_selection_count;
                            var distcode = data.results[0].distcode;
                            var districtname = data.results[0].districtname;
                            var scountvalue = data.scountvalue;
                            //var curmonth = data.curmonth;

                            

                            var curmonth = '202304';
                            var yymmfromdb = data.results[0].yyyymm;

                            if (curmonth != yymmfromdb) {

                                $('#current_month_bill_records').modal('show');
                                $('#current_month_bill_span').html(districtname);



                            }
                            else {
                                if (bdcount == 0) {
                                    //alert("There is no Bill Records for "+districtname +" District")
                                    $('#no_bill_records').modal('show');
                                    $('#no_bill_span').html(districtname);
                                }
                                else {
                                    var check = bill_selection_count * scountvalue;
                                    if (check > bdcount) {
                                        $('#enter_small').modal('show');
                                        $('#enter_small_span').html(scountvalue);


                                    }
                                    else {
                                        var trHTML = '';
                                        var finalcount = data.results[0].bill_selection_count * parseInt(data.scountvalue);
                                        trHTML += '<tr><td id="distename">' + data.results[0].districtname + '</td><td>' + data.results[0].bill_selection_count.toString() + '</td><td>' + data.scountvalue + '</td><td>' + finalcount + '</td></tr>';
                                        $('#records_table').html(trHTML);
                                        $('#totalmembers').html(finalcount);
                                        $('#districtname').html(data.results[0].districtname);
                                        $('#allotment_confirmation_alert').modal('show');

                                    }
                                    
                                }

                            }


                                  }//individual district end
                                  else{ // district all 

                                    var trHTML = '';

                                   // var finallyCount = "";
                                   
                                    var total = 0;

                                     $.each(data.results, function(index) {
                                        var scountvalue = 1;
                                        var finalcount = data.results[index].bill_selection_count * 1;
                                      //  var finalTextValue = finalcount+1;
                                        trHTML += '<tr><td id="distename">' + data.results[index].districtname + '</td><td>' + data.results[index].bill_selection_count.toString() + '</td><td>' + scountvalue + '</td><td>' + finalcount + '</td></tr>';
                                        $('#records_table').html(trHTML);

                                        
                                        total += finalcount;
                                        $('#totalmembers').html(total);
                                        $('#districtname').html("Total ");
                                        $('#allotment_confirmation_alert').modal('show');
                                  });
                                 

                                  $('#distid').prop('disabled', true);
                                  $('#bill_year').prop('disabled', true);
                                  $('#bill_month').prop('disabled', true);
                                  $('#flexCheckChecked').prop('disabled', true);
                                  $('#button_action').prop('disabled', true);
                                  $('#alloted_detail_btn').prop('disabled', true);

                                  } // district all 



                        } //message if
                        else {//message else
                            swal({
                                title: "",
                                text: "Records is not available current Month",
                                type: "success"
                            }).then(function () {
                                //location.reload();
                            }
                            );


                        } //message else

                    }
                },
                error: function (xhr, status, error) {
                    var err = JSON.parse(xhr.responseText);

                    if (err.code == 413) {
                        // $("#display_error").show();
                        // $('#display_error').html("101_611 Please contact Admin");
                        alert('Extra characters included')

                    }
                    if (err.code == 403)
                        alert('csrf token invalid')

                    if (err.code == 400)
                        alert('Bad request');
                },
            }); // Ajax End






        } // submit handler End
    }); // Validate Form End



    var district = $("#distid option:selected").val();



};
function countChecking(distcode) {
    alert(distcode);

}

function reset_menuform() {
    valiator.resetForm();
    $('#action').val('insert');
    $('#button_action').val('Save');
    document.getElementById('button_action').style.backgroundColor = '#56a1e3';
    document.getElementById('button_action').style.color = "#FFFFFF";

}

function reset_enableform() {
    $('#enable_confirmation_alert').modal('show');

    //$("#menu").prop('disabled', true);
    //$('#enableButton').hide();

}

function enable_select_count_text_box() {

    $("#menu").prop('disabled', false);
    $('#enableButton').hide();

}




function enable_cat(value) {
    if ($('#cat_sub').val() == '') {
        passing_alert_value('Alert', 'Please select category/subcategory option', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
        $("#cat_name").attr("disabled", "disabled");

    }
    else {
        if ($('#cat_sub').val() == 1) {
            $("#cat_name").attr("disabled", "disabled");
            $("#cat_name").val('');
        }
        else
            $("#cat_name").removeAttr("disabled");
    }

}

function fun_close() {
    valiator.resetForm();

}


// $('#allcb').change(function(){
//     if($(this).prop('checked')){
//         $('tbody tr td input[type="checkbox"]').each(function(){
//             $(this).prop('checked', true);
//         });
//     }else{
//         $('tbody tr td input[type="checkbox"]').each(function(){
//             $(this).prop('checked', false);
//         });
//     }
// });
function fetch_data(selectCountValue, yearmonth, seedValue, district) {
    //  $("#datatables").html(`<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>`);


    fetch_data_auto_load(selectCountValue, yearmonth, seedValue, district, actionfunc = 'form-submit', 'all');
    if (session_roleid == '02') {
        var dt = $('#billSelectionTable').DataTable();
        dt.columns([0,4, 5, 6]).visible(false);
        // location.reload();
    }
    else {
        var dt = $('#billSelectionTable').DataTable();
        dt.columns([4, 5, 6, 7]).visible(true);
    }








}
//$(".forward-btn").attr('disabled', "disabled");
//$(".revert_back_btn").attr('disabled', "disabled");

$('#bill_status').on('change', function (e) {

    var bill_status = $(this).val();
    //if(bill_status =='all'){
    // fetch_data_auto_load(selectCountValue, yearmonth, seedValue, district, actionfunc = 'form-submit');
    fetch_data_auto_load("", "", "", "all", "auto", bill_status);
    //}
    // else if(bill_status =='F'){
    //     fetch_data_auto_load("", "", "", "all", "auto",);
    // }
    // else{
    //     fetch_data_auto_load("", "", "", "all", "auto");
    // }



});


function fetch_data_auto_load(selectCountValue, yearmonth, seedValue, district, actionfunc, bill_status) {
    
    
    var formData = {
        select_count_value: selectCountValue,
        yearmonth: yearmonth,
        seedValue: seedValue,
        district: district,
        act: actionfunc,
        bill_status: bill_status,
    };
    if (district != 'all' && actionfunc == 'form-submit') {
        $('#dataTableBody').show();
        displayDatatable(formData);
        location.reload();
    }
    else if(district = 'all' && actionfunc == 'form-submit'){

        $('#dataTableBody').show();
        displayDatatable(formData);
       // location.reload();
      // $('#distid').hide();
       
       $('#distid').prop('disabled', true);

    }
   else {
        
        emptyTableChecking(formData, formData.district);

    }
}

function emptyTableChecking(formData, district) {
    $.ajax({
        url: siteurl + '/Allotment/EmptyTableCheckingToServer',
        paging: "true",
        dataType: "json",
        type: 'POST',
        data: {
            csrf: $('#csrf').val(),
            district: district
        },
        success: function (data, textStatus, jqXHR) {
            if (jqXHR.status == '200') {
                
                
                if (data.message == 'true' && data.count > 0) {

                    



                    displayDatatable(formData);
                    $('#dataTableBody').show();
                    
                   // location.reload();
                }
                else {
                    $('#dataTableBody').hide();
                }

            }
        },
        error: function (xhr, status, error) {
            var err = JSON.parse(xhr.responseText);

            if (err.code == 413) {
                // $("#display_error").show();
                // $('#display_error').html("101_611 Please contact Admin");
                alert('Extra characters included')

            }
            if (err.code == 403)
                alert('csrf token invalid')

            if (err.code == 400)
                alert('Bad request');
        },
    });
}

function displayDatatable(formData) {  //DisplayDatatable if start
    //@stalin

    var baseurl = siteurl + '/Allotment/FetchingAllotmentDataAuto';
    var userDataTable = $('#billSelectionTable').DataTable({ //Datatable Start
        "fnInitComplete": function (oSettings) {
            if (oSettings.aiDisplayMaster.length <= 0) {
                $("#dataTableBody").hide();
            }
        },
        "rowCallback": function (row, data, index) {
            if (index % 2 == 0) {
                $(row).removeClass('myodd myeven');
                $(row).addClass('myodd');
            } else {
                $(row).removeClass('myodd myeven');
                $(row).addClass('myeven');
            }
        },
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'paging': true,
        'pageLength': 5,
        //      scrollY:        "300px",
        // scrollX:        true,
        // scrollCollapse: true,



        'lengthMenu': [[5, 10, 20, -1], [5, 10, 20, "All"]],
        'iDisplayLength': -1,
        'ajax': {
            'url': baseurl,
            data: formData,
        },
        // autoWidth: false,

        'destroy': true,

        responsive: true,
        //     responsive: {
        //     details: {
        //         type: 'column'
        //     }
        // },



        'columns': [
            { "data": "bill_selection_id", "name": "bill_selection_id" },
            // { "data": "distename","name": "distename"},
            { "data": "billnumber", "name": "billnumber" },
            // { "data": "billamount","name": "billamount"},
            { "data": "action", "name": "action" },
           { "data": "order_by_column", "name": "order_by_column" },
            { "data": "remarks", "name": "remarks" },
            { "data": "status", "name": "status" },
            { "data": "username", "name": "username" },
            { "data": "mobilenumber", "name": "mobilenumber" },
            { "data": "invoicecopy", "name": "invoicecopy" },

        ],


        'columnDefs': [
            {

                responsivePriority: 1,

                targets: 0,


                // className: 'dtr-control',
                orderable: false,
                // 'checkboxes': {
                //     'selectRow': true
                // }
            },

            {

                responsivePriority: 2,

                targets: -5,



            },
            {

                width: 95,

                targets: 4,



            },




        ],
        //  order: [ 0, 'asc' ],
        "ordering": false,
        'select': {
            'style': 'multi'
        },

    }); // DataTable End

    if (session_roleid == '02') {


        var dt = $('#billSelectionTable').DataTable();
        //hide the first column
        dt.columns([0,2, 4, 5]).visible(false);

        // location.reload();



    }
    else {

        jQuery('.dt-checkboxes-select-all').closest('tr').find('[type=checkbox]').hide();


        var dt = $('#billSelectionTable').DataTable();
        //hide the first column
        //dt.columns([0]).visible(false);
        //dt.columns([4,5,6,7]).visible(true);

    }




    //$('.dt-checkboxes').attr('name', 'test');

    // $('#billSelectionTable .dt-checkboxes').eq(0).attr('name', 'yourNewname1');




    $('#frm-example').on('submit', function (e) { // 28 Form submit start 



        // Prevent actual form submission
        e.preventDefault();
        if (session_roleid == '02') { //ADC

            forward_to_jc_one();
        } //ADC END
        else { // Not ADC


            
          
       

           

            // $('#dc_confirmation_alert').modal('show');
            // Serialize form data
            var data = userDataTable.$('input,select,textarea,checkbox').serializeArray();


            // Submit form data via Ajax
            $.ajax({ //Ajax Start 
                url: siteurl + '/Allotment/getResultsEachRows',
                dataType: "json",
                type: 'POST',
                data: data,
                success: function (data) {

                   

                  

                    if (data.message == "true") {

                       
                        //  if(data.process_code == 'F'){


                        if (session_roleid == '03') { //jc


                            $('#dc_confirmation_alert').modal('show');
                        }
                        else if (session_roleid == '04') { //dc
                            //   $('#ac_success_message').modal('show');
                            $('#dc_confirmation_alert').modal('show');
                        }
                        else if (session_roleid == '05') { //ac
                            //   $('#ac_success_message').modal('show');
                            $('#dc_confirmation_alert').modal('show');
                        }


                    }
                    else {
                        if (session_roleid == '05') {

                            $('#select_any_checkbox_remarks').modal('show');  
                       
                        }
                        else{
                            $('#select_any_checkbox').modal('show');
                        }
                       

                    }

                }
            });  //Ajax End



        }// Not ADC


    }); //Form Submit End



} //DisplayDatatable if End


function ajax_function_call() {
    $('#ac_success_message').modal('show');
}



function cancel_confirmation_box() {
    $('#allotment_confirmation_alert').modal('hide');
    $('#distid').prop('disabled', false);
    $('#records_table tbody').empty();

    $('#bill_year').prop('disabled', false);
    $('#bill_month').prop('disabled', false);
    // $('#flexCheckChecked').removeattr('disabled', 'disabled');
    $('#menu').prop('disabled', false);
}
function allotment_fetch_data() {
    // var table = $('#billSelectionTable').DataTable();
    // table.destroy();
    //;
    
    var selectCountValue = ($("#menu").val()=="")?"":$("#menu").val();
    var bill_year = $("#bill_year option:selected").text();
    var bill_month = $("#bill_month option:selected").val();
    var district = $("#distid option:selected").val();
    var districtText = $("#distid option:selected").text();
    var yearmonth = bill_year.concat(bill_month);
    var min = -1;
    var max = 1
    var random = (Math.random() * (max - min) + min);
    let num = random;
    let seedValue = num.toString().substring(0, 4);
    var distename = $("#distid option:selected").text();

    // if(districtText == distename  ){
    //     location.reload();
    // }






    //let seedValue  = 0.33;


    if (district == undefined) {
        alert("Already ALl Districts Selected");
        return false;
    }
    fetch_data(selectCountValue, yearmonth, seedValue, district);
    // location.reload()
    //$('#button_action').attr('disabled', 'disabled');

}
function forwardConfirmationOpen() {
    $('#forward_confirmation_alert').modal('show');
}

function role_revert_back(dc_value, remarks, id) {


    if (session_roleid == "02") { //ADC
        var ids = $("#ids").val();
        var p_bill_selection_id = ids;
        var role_type_id = "03";
        var role_type_name = "JC";
        var dc_name = '';
        var remarks = "Forward To  JC";
    }
    else if (session_roleid == "03") { //JC
        var role_type_id = "04";
        var role_type_name = "DC";
        var dc_name = dc_value;
        var p_bill_selection_id = id;
    }
    else if (session_roleid == "04") { //DC
        var role_type_id = "03";
        var role_type_name = "JC";
        var dc_name = dc_value;
        var p_bill_selection_id = id;
    }
    else if (session_roleid == "05") {  //AC

        var role_type_id = "04";
        var role_type_name = "DC";
        var dc_name = dc_value;
        var p_bill_selection_id = id;
    }


    $.ajax({
        url: base + '/Allotment/RevertBackToBeforeRole',
        paging: "true",
        dataType: "json",
        type: 'POST',
        data: {
            csrf: $('#csrf').val(),
            bill_selection_id: p_bill_selection_id,
            dc_name: dc_name,
            remarks: remarks


        },
        success: function (data, textStatus, jqXHR) {
            if (jqXHR.status == '200') {

                if (data.message == 'true') {

                    swal({
                        title: "",
                        text: "Revert Back Successfully To " + role_type_name,
                        type: "success"
                    }).then(function () {
                        location.reload();
                    }
                    );

                }

            }
        },
        error: function (xhr, status, error) {
            var err = JSON.parse(xhr.responseText);

            if (err.code == 413) {
                // $("#display_error").show();
                // $('#display_error').html("101_611 Please contact Admin");
                alert('Extra characters included')

            }
            if (err.code == 403)
                alert('csrf token invalid')

            if (err.code == 400)
                alert('Bad request');
        },
    });
}



function role_forward(dc_value, remarks, id) {



    // let p_bill_selection_id =   id;







    if (session_roleid == "02") {
        var ids = $("#ids").val();
        var p_bill_selection_id = ids;
        var role_type_id = "03";
        var role_type_name = "JC";
        var dc_name = '';
        var remarks = "";
    }
    else if (session_roleid == "03") {
        var role_type_id = "04";
        var role_type_name = "DC";
        var dc_name = dc_value;
        var p_bill_selection_id = id;
    }
    else if (session_roleid == "04") {
        var role_type_id = "04";
        var role_type_name = "AC";
        var dc_name = dc_value;
        var p_bill_selection_id = id;
    }
    else if (session_roleid == "05") {

        var role_type_name = "v";
    }

    $.ajax({
        url: siteurl + '/Allotment/ForwardToNextRole',
        paging: "true",
        dataType: "json",
        type: 'POST',
        data: {
            csrf: $('#csrf').val(),
            bill_selection_id: p_bill_selection_id,
            dc_name: dc_name,
            remarks: remarks


        },
        success: function (data, textStatus, jqXHR) {
            if (jqXHR.status == '200') {

                if (data.message == 'true') {

                    if (role_type_name == 'v') {

                        swal({
                            title: "",
                            text: "Verified Successfully",
                            type: "success"
                        }).then(function () {
                            location.reload();
                        });

                    }
                    else {

                        //  swal({
                        //     title: "", 
                        //     text: "Forwarded Successfully to "+role_type_name, 
                        //     type:"success"
                        //  }).then(function(){ 
                        //     location.reload();
                        // });
                        $('#jc_success_message').modal('show');

                    }




                    // swal("Forwarded Successfully to "+role_type_name) ;
                    // setTimeout(function(){
                    //     window.location.reload();
                    //   }, 5000);
                }

            }
        },
        error: function (xhr, status, error) {
            var err = JSON.parse(xhr.responseText);

            if (err.code == 413) {
                // $("#display_error").show();
                // $('#display_error').html("101_611 Please contact Admin");
                alert('Extra characters included')

            }
            if (err.code == 403)
                alert('csrf token invalid')

            if (err.code == 400)
                alert('Bad request');
        },
    });
}


// Handle form submission event
$(".action-btn").on('click', function (e) {
    e.preventDefault;

    

    $("#action").val($(this).data('action'));

    let action_value = $("#action").val();


    if (session_roleid == "02") {

        var dc_value = "";

        var oTable = $('#billSelectionTable').DataTable();

            
           

            $.ajax({
                type: "POST",
                url: siteurl + '/Allotment/getAdcResultsEachRows',       
                data: oTable.$('input').serialize(),
                dataType: "json",
                success: function(response){
                    let rowIds = "";
                    $.each(response.message.bsid, function (index, rowId) {

                        // Create a hidden element
                        rowIds += `${rowId},`;
            
                    });
                    rowIds = rowIds.substring(0, rowIds.length - 1);
            
                    $("#ids").val(rowIds);

                    if (action_value == 'role_forward') {
                        role_forward(dc_value, "", "");
                    }
                    else if (action_value == 'role_revertback') {
                        role_revert_back(dc_value);
                    }
                   
                   //alert(response);
                }
            });






    }
    else if (session_roleid == "03") {
        var dc_value = $(this).parents().parents().find(' #list-dcs option:selected').val();
    }
    else if (session_roleid == "04") {
        var dc_value = $(this).parents().parents().find(' #list-acs option:selected').val();
    }
    else if (session_roleid == "05") { //Ac For revert back
        var dc_value = $(this).parents().parents().find(' #list-dcs-rb option:selected').val();
    }

    // var dc_value = $(this).parents().parents().find(' #list-dcs option:selected').val();

    // make the form submit
    var rows_selected = $('#billSelectionTable').DataTable().column(0).checkboxes.selected();



    //let form = "#frm-example";
    // let rowIds = "";



    // if (rows_selected.length == 0) {

    //     swal("Please select atleast one checkbox");
    //     return false;

    // } else {

    //     let title = action_value[0].toUpperCase() + action_value.slice(1);
    //     $.each(rows_selected, function (index, rowId) {
    //         // Create a hidden element
    //         rowIds += `${rowId},`;

    //     });
    //     rowIds = rowIds.substring(0, rowIds.length - 1);

    //     $("#ids").val(rowIds);

    //     if (action_value == 'role_forward') {
    //         role_forward(dc_value, "", "");
    //     }
    //     else if (action_value == 'role_revertback') {
    //         role_revert_back(dc_value);
    //     }




    // }

});
$(function () {
    // $('#button_action').attr('disabled', 'disabled');
    $('#alloted_detail_btn').attr('disabled', 'disabled');
    $('#flexCheckChecked').click(function () {
        if ($(this).is(':checked')) {

            $('#button_action').removeAttr('disabled');
            $('#alloted_detail_btn').removeAttr('disabled');

        } else {
            $('#button_action').attr('disabled', 'disabled');
            $('#alloted_detail_btn').attr('disabled', 'disabled');
        }
    });
});

$('#billSelectionTable').on('change', '#processcode', function (e) {


    var p_code_value = $(this).val();

    if (session_roleid == "04") {

        if (p_code_value == 'R') {

            $(this).closest("tr").find('#roleuserid').hide();
            $(this).closest("tr").find('#listjc').show();

        }
        else {





            $(this).closest("tr").find('#roleuserid').show();
            $(this).closest("tr").find('#listjc').hide();

        }

    }

    else if (session_roleid == "05") {

        if (p_code_value == 'V') {

            $(this).closest("tr").find('#roleuserid').hide();

        }
        else {





            $(this).closest("tr").find('#roleuserid').show();

        }

    }




});


$('#distid').on('change', function (e) {


    var dist_id = $(this).val();
    if (dist_id == 'all') {
        $('.msdiv').hide();
    }
    else {
        $('.msdiv').show();
    }


});


$('#billSelectionTable').on('change', '#p_ac_code', function (e) {

    var p_code_value = $(this).val();
    if (p_code_value == 'R') {

        $(this).closest("tr").find('#role_user_id_dc').show();

    }
    else {
        $(this).closest("tr").find('#role_user_id_dc').hide();

    }




});


$('#billSelectionTable').on('click', '.publish', function (e) { // publish button start
    e.preventDefault()

    //

    var id = $(this).data('id');

    if (session_roleid == "05") {
        var roles_id = $(this).closest("tr").find('#role_user_id_dc option:selected').val();
        var dc_value = roles_id;
        var process_code = $(this).closest("tr").find('#p_ac_code option:selected').val();

    }
    else {
        var roles_id = $(this).closest("tr").find('#role_user_id option:selected').val();
        var dc_value = roles_id;
        var process_code = $(this).closest("tr").find('#p_code option:selected').val();
    }



    swal("Write something here:", {
        content: "input",
    })
        .then((remarks) => { //then start
            //swal(`You typed: ${value}`);
            if (remarks == "") {
                swal("Enter Remarks");
                return false;
            }

            if (process_code == 'F') {
                role_forward(dc_value, remarks, id)
            }
            else if (process_code == 'V') {

                role_verified(dc_value, remarks, id)

            }
            if (process_code == 'R') {
                role_revert_back(dc_value, remarks, id)
            }

            //  role_forward(dc_value,remarks)


        });      // Then end    


}); // publish button end





function role_verified(dc_value, remarks, id) {
    $.ajax({ //ajax start
        url: siteurl + '/Allotment/VerifyTo',
        dataType: "json",
        type: 'POST',
        data: {
            csrf: $('#csrf').val(),
            bill_selection_id: id,
            remarks: remarks,
            dc_value: dc_value


        }, // in ,my case the absence of this was the cause of failure


        success: function (data, textStatus, jqXHR) {
            if (jqXHR.status == '200') {

                if (data.message == 'true') {
                    ;

                    swal({
                        title: "",
                        text: data.text,
                        type: "success"
                    }).then(function () {
                        location.reload();
                    }
                    );
                }

            }
        },
        error: function (xhr, status, error) { //error start
            var err = JSON.parse(xhr.responseText);

            if (err.code == 413) {
                alert('Extra characters included')
            }
            if (err.code == 403)
                alert('csrf token invalid')

            if (err.code == 400)
                alert('Bad request');
        }, // error end


    }); //ajax end
}




function forward_to_jc_one() {
    $('#jc_two_confirmation_alert').modal('show');
}
function forward_to_jc_two() {
    $('#jc_two_confirmation_alert').modal('show');
}

function forward_to_dc_one() {
    $('#dc_fwd_one').modal('show');
}

function forward_to_dc_two() {
    $('#dc_fwd_two').modal('show');
}

function forward_to_ac_one() {
    $('#ac_fwd_one').modal('show');
}

function forward_to_ac_two() {
    $('#ac_fwd_two').modal('show');
}

function verify_to_ac_one() {
    $('#ac_verify_one').modal('show');
}

function verify_to_ac_two() {
    $('#ac_verify_two').modal('show');
}
function reload_function() {
    location.reload();
}
function dc_confirmation() {
    $('#ac_success_message').modal('show');
}






function revert_back_to_adc_one() {
    $('#adc_one_confirmation_alert').modal('show');
}
function revert_back_to_adc_two() {
    $('#adc_two_confirmation_alert').modal('show');
}



function revert_back_to_dc_one() {
    $('#dc_rb_one').modal('show');
}
function revert_back_to_dc_two() {
    $('#dc_rb_two').modal('show');
}

function revert_back_to_jc_one() {
    $('#jc_rb_one').modal('show');
}
function revert_back_to_jc_two() {
    $('#jc_rb_two').modal('show');
}




function getRevertBacktoJC(selectObject) {



    var value = selectObject.value;

    if (value == "R") {
        $('#p_code').closest('tr').find("#jc_role_user_id").show();

        $('#p_code').parent('tr').next().find("#role_user_id").hide();

    }
    else {

        $("#jc_role_user_id").hide();
        $("#role_user_id").show();

    }

}







// $(document).on('change', 'input[type="checkbox"]', function(e){
//     $('input[type="checkbox"]').not(this).prop('checked', false); 

// });


