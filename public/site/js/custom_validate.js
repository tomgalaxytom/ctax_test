$('.only_numbers').on('keypress', function(event) 
{
    if ( (event.charCode >= 48 && event.charCode <= 57) )
        return true; // let it happen, don't do anything
    else 
        return false; 
});


function fn_captilise_each_word(txtbox_name)
{
    var value=$("#"+txtbox_name).val();
     text=value.toLowerCase().split(' ').map(s => s.charAt(0).toUpperCase() + s.substring(1)).join(' '); 
     document.getElementById(txtbox_name).value = text;
     return true;
     
}


$('.name').on('keypress', function(event) 
{
       
    if (( event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32 ) ) 
        return true;
    else 
        return false; 
});

  // Allow Alphabets and Numbers   
  $('.alpha_numeric').on('keypress', function(event) 
  {
      if (( event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 32 ) )
          return true; // let it happen, don't do anything
      else 
          return false; 
  });



  function ValidateEmail() 
  {
    var email = document.getElementById("email").value;
    var lblError = document.getElementById("lblError");
    lblError.innerHTML = "";
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (!expr.test(email)) {
        lblError.innerHTML = "Invalid email address.";
    }
}


//   $('#email').on('keypress', function() {
//     var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test(this.value);
//     if(!re) {
//        alert('hi');
//     } else {
//         alert('himm');
//     }
// })


$('#email').on('keypress', function (event) {
    var regex = new RegExp("^[a-zA-Z0-9!#$%&'*+-/=?^_`{|}~@]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) 
    {
       event.preventDefault();
       return false;
    }
});


function change_button_as_update(form_name,action_name,button_action,error,card_name,closebtn)
{
    if(error)
        $('#'+error).hide();
   
    if(card_name)
        $('#'+card_name).show();
    if(closebtn)
        $('#'+closebtn).html('Close'); 

    $('#'+form_name).show();
    $('#'+form_name)[0].reset();
    $('#'+action_name).val('update');
    $('#'+button_action).val('Update'); 
   
    document.getElementById(button_action).style.backgroundColor = '#0262af';
}

function change_button_as_insert(form_name,action_name,button_action,error,closebtn)
{
    if(error)
        $('#'+error).hide();
    $('#'+form_name)[0].reset();
    $('#'+action_name).val('insert');
    $('#'+button_action).val('Save');
    document.getElementById(button_action).style.backgroundColor ='#05ac95';
    document.getElementById(button_action).style.color = "#FFFFFF";
   ;

    if(closebtn)
    $('#'+closebtn).html('Clear');
    
}

function passing_alert_value(alert_header,alert_body,alert_name,alert_header_id,alert_body_id,alert_type)
{  
    if(alert_type=='confirmation_alert')
    {
        $('#process_button').hide();
        $('#ok_button').show();
        $('#cancel_button').hide();
        $('#button_close').hide();
       
    }
    if(alert_type=='delete_alert')
    {
        const element = document.getElementById("process_button");
        element.classList.remove("btn-success");
        $('#ok_button').hide();
        $('#cancel_button').hide();
        $('#process_button').show();
        $('#process_button').html('Delete')
        $('#cancel_button').show();
            // Add a class (quote) to the element
        element.classList.add("btn-danger");
        
    }
    if(alert_type=='forward_alert')
    {
        
        const element = document.getElementById("process_button");
        element.classList.remove("btn-danger");
       
        $('#ok_button').hide();
        $('#cancel_button').hide();
        $('#process_button').show();
        $('#process_button').html('Ok');
        $('#cancel_button').show();
        element.classList.add("btn-success");
       
    }
    if(alert_type=='confirmation_alert_with_function')
    {
        const element = document.getElementById("process_button");
        element.classList.remove("btn-danger");

        $('#ok_button').hide();
        $('#cancel_button').hide();
        $('#process_button').show();
        $('#process_button').html('Ok');
        $('#cancel_button').hide();
        $('#button_close').hide();
        element.classList.add("btn-success");
       
    }
    $("#"+alert_header_id).html(alert_header);
    $("#"+alert_body_id).html(alert_body);
    $('#'+alert_name).modal('show');
   
}


function view_datepicker(value,yearrange,maxdate_greater_futuredate,mindate,maxdate,page)
{
 
    if(page == 'bill')
    {
        yearrange='';
        if(mindate)
        mindate =   new Date(mindate);
        
        if(maxdate)
        maxdate =   new Date(maxdate);
        
        const date = new Date();
        defalutdate=("-"+date.getFullYear() + "y-m-d");
    }
    else if(page == 'bill_history')
    {
        // yearrange='2022:2023';
        const date = new Date();
        var maxdate= new Date(date.getFullYear(), date.getMonth() - 1, 0);
        var mindate= new Date(date.getFullYear(), date.getMonth() - 13, 1);
    

        if('to_date' == value)
        {
            var from_date = $('#from_date').val();

            if(from_date)
            {
                const data = from_date.split("/");
                var f_date = data[0];
                var f_month=data[1];
                var f_year   =  data[2] ;
                // date_val = f_month + '/' + f_date + '/' + f_year;
                date_val = f_date + '/' +f_month + '/' +f_year;
    
                mindate =   date_val;
    
            }
            else
            {
                
                var mindate= new Date(date.getFullYear(), date.getMonth() - 4, 1);
            }
             var maxdate= new Date(date.getFullYear(), date.getMonth() - 1, 0);

           
        }
        
        mindate_value =   convert_dateformat(mindate);
        var min_year = mindate_value.split("-");


        maxdate_value =   convert_dateformat(maxdate);
        var max_year = maxdate_value.split("-");

        yearrange   =   min_year[0] + ":" +max_year[0];

        defalutdate=("-"+date.getFullYear() + "y-m-d");
        
    }
    else if(page == 'settings')
    {
        const date = new Date();

        var mindate= new Date(date.getFullYear(), date.getMonth() -2, 1);
        var maxdate= new Date(date.getFullYear(), date.getMonth() +5, 0);
        mindate_value =   convert_dateformat(mindate);
        var min_year = mindate_value.split("-");


        maxdate_value =   convert_dateformat(maxdate);
        var max_year = maxdate_value.split("-");

        yearrange   =   min_year[0] + ":" +max_year[0];

        
        defalutdate=("-"+date.getFullYear() + "y-m-d");
    }

    else
    {
       

        const st_end_year = yearrange.split(":");
        
      
        defalutdate=("-"+st_end_year[1] + "y-m-d");

        // const d = new Date();
        // let date = d.getDate();
        // let month = d.getMonth();
        // let year = d.getFullYear();


        // if(maxdate_greater_futuredate == 'N')
        // {
        //     if(st_end_year[1] == 0)
        //         maxdate='0';
        //     else
        //     {
        //         year -=Math.abs(st_end_year[1]);
        //         maxdate=new Date(year,month, date)
        //     }

        //     mindate = new Date(year - st_end_year[0],month, date)   ;
        // }
        // if(maxdate_greater_futuredate == 'Y')
        //     maxdate='+1y';
    
    }
   

    // const d = new Date();
    // let date = d.getDate();
    // let month = d.getMonth();
    // let year = d.getFullYear();


    
    // mindate = new Date(2001, 0, 1);
    // maxdate = '+15Y',


        

        $( "#"+value ).datepicker({
            dateFormat: 'dd/mm/yy',//check change
            yearRange:yearrange,
            changeYear:true,
            autoclose: true,
            maxDate :  maxdate,
            minDate  : mindate,
            changeMonth: true,
            // yearRange: "-70:-18",
            defaultDate:defalutdate,  // Relative year/month/day

            showButtonPanel: true,
            beforeShow: function( input ) 
            {
                setTimeout(function() {
                    var buttonPane = $( input )
                        .datepicker( "widget" )
                        .find( ".ui-datepicker-buttonpane" );
                    $( "<button>", {
                        text: "Clear",
                        click: function() {
                            $.datepicker._clearDate( input );
                        }
                    }).appendTo( buttonPane ).addClass("ui-datepicker-clear ui-state-default ui-priority-primary ui-corner-all");
                }, 1 );
            },
               
            onSelect: function (dateString, txtDate) 
            {	

                $("#"+value).datepicker('setDate',dateString);
                if(page == 'bill_history')
                {
                    get_the_bill_history_data();
                }    
                $("#"+value).valid();

                  
                if($('#'+value).val()=='')
                {
                    $('#'+value).focus();
                }
                else
                {
                    $('#'+value).datepicker("hide");
                    $('#'+value).datepicker( "destroy" );
                }
            },
            // onClose: function( selectedDate ) 
            // {
            //     if(from_date)
            //     {  
            //         $( "#to_date" ).datepicker( "option", "minDate", selectedDate );
            //     }
            // }

        //     onClose: function( selectedDate, inst ) {
        //         var maxDate = new Date(Date.parse(selectedDate));
        //         maxDate.setDate(maxDate.getDate() - 1);            
        //        $( "#"+value ).datepicker( "option", "maxDate", maxDate);
        //    }
        })
        if(!(page == 'bill_history'))
        {
            $( "#"+value ).focus();
        }
       
       
    
}

function convert_dateto_dd_mm_yy_format_with_slash(datevalue) 
{
    const data = datevalue.split("-");
    year = data[0];
    date=data[1];
    month   =  data[2] ;
    date_val = month + '/' + date + '/' + year;
    return date_val;
    // var date = new Date(str),
    //     mnth = ("0" + (date.getMonth() + 1)).slice(-2),
    //     day = ("0" + date.getDate()).slice(-2);
    // // return [date.getFullYear(), mnth, day].join("-");
    // return [day, mnth, date.getFullYear()].join("/");
}


function convert_dateto_yy_mm_dd_format_with_hyphen(datevalue) 
{
    const data = datevalue.split("/");
    year = data[2];
    date=data[0];
    month   =  data[1] ;
    date_val = year + '-' + month + '-' + date;
    return date_val;
    // var date = new Date(str),
    //     mnth = ("0" + (date.getMonth() + 1)).slice(-2),
    //     day = ("0" + date.getDate()).slice(-2);
    // // return [date.getFullYear(), mnth, day].join("-");
    // return [day, mnth, date.getFullYear()].join("/");
}


// function format_datarange_for_daterangebox(datevalue) {
//     var date_val = convertto_dd_mm_yy_format(new Date(datevalue));

//     return date_val;
// }


function convert_dateformat(str) 
{
    var date = new Date(str),
      mnth = ("0" + (date.getMonth() + 1)).slice(-2),
      day = ("0" + date.getDate()).slice(-2);
    return [date.getFullYear(), mnth, day].join("-");
  }


function convert_dateto_dd_mm_yy_format_with_slash_fordatetime(datevalue) 
{

    var data = datevalue.split(" ");
    datevalue   =   data[0];
    var data = datevalue.split("-");
    year = data[0];
    date=data[1];
    month   =  data[2] ;
    date_val = month + '/' + date + '/' + year;
    return date_val;

}



