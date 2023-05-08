<script>
    	function get_district(roleid,divisioncode,zonecode,circleid,distcode,roleid_box,division_box,zone_box,circle_box,dist_box,dist_hidden)
	{

		if(roleid=='')
			roleid	=	$('#'+roleid_box).val();
		
		if(divisioncode=='')
			divisioncode	=	$('#'+division_box).val();


		if(zonecode=='')
			zonecode	=	$('#'+zone_box).val();
		
		if(circleid=='')
			circleid	=	$('#'+circle_box).val();


		form_data	=	[];
		var get_distcode	=	'N';


		if(((roleid==jc_roleid)&&(!(divisioncode==''))))		//JC
		{
			get_distcode	=	'Y';
			form_data.push({
				name: "divisioncode",
				value: divisioncode
        	});
		}
		else if(((roleid==dc_roleid)&&(!((divisioncode=='')&&(zonecode=='')))))	//DC
		{
			get_distcode	=	'Y';
			form_data.push({
				name: "divisioncode",
				value: divisioncode
        	});
			form_data.push({
				name: "zonecode",
				value: zonecode
        	});
		
		}
		else if(( ((roleid==ac_roleid)&&(!((divisioncode=='')&&(zonecode=='')&&(circleid=='')))) || ((roleid==cto_roletypecode)&&(!((divisioncode=='')&&(zonecode=='')&&(circleid==''))))))		//AC
		{
			get_distcode	=	'Y';
			form_data.push({
				name: "divisioncode",
				value: divisioncode
        	});
			form_data.push({
				name: "zonecode",
				value: zonecode
        	});
			form_data.push({
				name: "circlecode",
				value: circleid
        	});
		}

		if(get_distcode=='Y')
		{
			form_data.push({
				name: "roleid",
				value: roleid
        	});

			$.ajax({
				url: '<?php echo URLROOT; ?>Mybill/get_distcode_basedon_selection',
				paging: true,
				data:  form_data,
				dataType: "json",
				method: "POST",
				success: function(data, textStatus, jqXHR) 
				{
					if(jqXHR.status=='200')
					{
						$('#'+dist_box).val(data);
						$('#'+dist_hidden).val(data);
					}
				},
			});
		}
		else
		{
			$('#'+dist_box).val('');
			$('#'+dist_hidden).val('');
		}	
	}


	function get_division_data_basedon_roletype(roletype_selectboxid,division_selectboxid,roletypecode,divisioncode)
	{
	
		if(roletypecode	==	'')
			roletypecode	=	$('#'+roletype_selectboxid).val()

		

		$.ajax({
			url: '<?php echo URLROOT; ?>Mybill/get_divisiondata_basedon_roletype',
			paging: true,
			data:  {
				roletypecode	:	roletypecode
			},
			dataType: "json",
			method: "POST",
			success: function(data, textStatus, jqXHR) 
			{
				if(jqXHR.status=='200')
				{
					$("#"+division_selectboxid).empty();
					$("#"+division_selectboxid).append(" <option value=''>--- Select Division Name---</option> ");
					for (var i = 0; i < data.length; i++) 
					{
						if (divisioncode == data[i]['divisioncode'])
							$("#"+division_selectboxid).append("<option value='" + data[i]['divisioncode'] + "'selected>" + data[i]['divisionlname'] + "</option>");
						else
							$("#"+division_selectboxid).append("<option value='" + data[i]['divisioncode'] + "'>" + data[i]['divisionlname'] + "</option>");
					}
				}
			},

		});
	}

	function get_zone_data(roletypecode,divisioncode,zonecode,division_id,zone_id,roletype_selectboxid)
	{
		if(divisioncode	==	'')
			divisioncode	=	$('#'+division_id).val()
		if(roletypecode	==	'')
			roletypecode	=	$('#'+roletype_selectboxid).val()

		$.ajax({
			url: '<?php echo URLROOT; ?>Mybill/get_zonedata_basedon_division',
			paging: true,
			data:  {
				divisioncode	:	divisioncode,
				roletypecode	:	roletypecode
			},
			dataType: "json",
			method: "POST",
			success: function(data, textStatus, jqXHR) 
			{
				if(jqXHR.status=='200')
				{
					$("#"+zone_id).empty();
					$("#"+zone_id).append(" <option value=''>--- Select Zone Name---</option> ");
					for (var i = 0; i < data.length; i++) 
					{
						if (zonecode == data[i]['zonecode'])
							$("#"+zone_id).append("<option value='" + data[i]['zonecode'] + "'selected>" + data[i]['zonelname'] + "</option>");
						else
							$("#"+zone_id).append("<option value='" + data[i]['zonecode'] + "'>" + data[i]['zonelname'] + "</option>");
					}
				}
			},

		});
	}


	function get_circle_data(roletypecode,divisioncode,zonecode,circlecode,division_id,zone_id,circle_id,roletype_selectboxid)
	{
		if(roletypecode	==	'')
			roletypecode	=	$('#'+roletype_selectboxid).val()

		if(divisioncode	==	'')
			divisioncode	=	$('#'+division_id).val()

		if(zonecode	==	'')
			zonecode	=	$('#'+zone_id).val()
			
		$.ajax({
			url: '<?php echo URLROOT; ?>Mybill/get_circledata_basedon_division_zone',
			paging: true,
			data:  {
				roletypecode	:	roletypecode,
				divisioncode	:	divisioncode,
				zonecode		:	zonecode
			},
			dataType: "json",
			method: "POST",
			success: function(data, textStatus, jqXHR) 
			{
				if(jqXHR.status=='200')
				{
					$("#"+circle_id).empty();
					$("#"+circle_id).append(" <option value=''>--- Select Circle Name---</option> ");
					for (var i = 0; i < data.length; i++) 
					{
						if (circlecode == data[i]['circleid'])
							$("#"+circle_id).append("<option value='" + data[i]['circleid'] + "'selected>" + data[i]['circlename'] + "</option>");
						else
							$("#"+circle_id).append("<option value='" + data[i]['circleid'] + "'>" + data[i]['circlename'] + "</option>");
					}
				}
			},

		});
	}
    </script>