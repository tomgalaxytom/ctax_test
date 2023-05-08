<?php
require_once('./public/site/layouts/header.php');
include('./././public/dash/layout/alert.php'); 
session_destroy();
?>
<style>
	.error {
		color: red;
		
	}
	.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  transition: 0.3s;
  border-radius: 10px;
}
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

</style>
<script>

	function decryptString($string) {
		var Utf8 = CryptoJS.enc.Utf8;
		const $secret_key = '8/AaeB65F17A1c7f3F17A1c7NwewQ4f3';
		const $secret_iv = 'WSa6qfh7RUGyph5j';
		const key = CryptoJS.SHA256($secret_key).toString(CryptoJS.enc.Hex).substring(0, 32);
		let iv = CryptoJS.SHA256($secret_iv).toString(CryptoJS.enc.Hex).substring(0, 16);
		const decrypt = CryptoJS.AES.decrypt($string, Utf8.parse(key), {
			iv: Utf8.parse(iv)
		}).toString(Utf8);
		return decrypt;
	}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js" integrity="sha512-E8QSvWZ0eCLGk4km3hxSsNmGWbLtSCSUcewDQPQWZF6pEU8GlT8a5fF32wOl1i8ftdMhssTrF/OhyGWwonTcXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>


<main>

	<section class="login_section py-8 py-md-15 fontAlter">
		<div class="container">
			<!-- <div class="card">
	  <div class="card-body" > -->
			<div class="row justify-content-center">
				<div class="col-12 col-md-6 col-xl-4">
					<ul class="nav nav-tabs tabset justify-content-center mb-10" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link tablink active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
						</li>
						<li class="nav-item">
							<a class="nav-link tablink" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Registration</a>
						</li>
					</ul>
					<div class="tab-content" id="loginTabContent">
						<div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
							<form id="login_form" method="post">
								<div class="alert alert-danger alert-dismissible" id="error_login" style="display:none;" name="error">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
								</div>
								<input type="hidden" id="ecv" value="ecv">
								<div class="form-group">
									<label for="email">Mobile Number<span class="text-danger">*</span></label>
									<input type="text" name="username" id="username" class="form-control only_numbers" maxlength="10">
								</div>
								<div class="form-group">
									<label for="pass">Password <span class="text-danger">*</span></label>
									<input type="password" name="password" id="password" class="form-control">
								</div>
								<button type="submit" id="login" class="btn btnTheme fwMedium w-100 d-block text-capitalize position-relative border-0 p-0" data-hover="Login">
									<span class="d-block btnText">Login</span>
								</button>
							</form>
						</div>

						<div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
							<form id="register_form" method="post">
								<div class="alert alert-danger alert-dismissible" id="error_register" style="display:none;" name="error">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
								</div>
								<div class="form-group">
									<label for="email">District<span class="text-danger">*</span></label>
									<select class="form-control" aria-label="Default select example" id="distcode" name="distcode">
										<option selected value=''>Select District</option>
										<?php $Basemodel = new Basemodel;
										$Basemodel->tablename = "mybillmyright.mst_district";
										$id = 'distename';
										$data = ($Basemodel->getMultipleData(NULL, $id));
										foreach ($data as $value) { ?>
											<option value="<?= htmlspecialchars($value->distcode); ?>"><?= htmlspecialchars($value->distename); ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label for="email">Email<span class="text-danger">*</span></label>
									<input type="email" id="email" name="email" class="form-control">
								</div>
								<div class="form-group">
									<label for="mobilenumber">Mobile Number<span class="text-danger">*</span></label>
									<input type="text" id="mobilenumber" name="mobilenumber" class="form-control only_numbers" maxlength="10">
								</div>
								<div class="form-group">
									<label for="Name">Name<span class="text-danger">*</span></label>
									<input type="name" id="name" name="name" class="form-control name">
								</div>
								<div class="form-group">
									<label for="pwd">Password <span class="text-danger">*</span></label>
									<input type="password" id="pwd" name="pwd" class="form-control">
								</div>
								<div class="form-group">
									<label for="pwd">Confirm Password <span class="text-danger">*</span></label>
									<input type="password" id="cnf_pwd" name="cnf_pwd" class="form-control">
								</div>
								<button type="submit" class="btn btnTheme fwMedium w-100 d-block text-capitalize position-relative border-0 mt-5 p-0" data-hover="Register">
									<span class="d-block btnText">Register</span>
								</button>
							</form>
						</div>
					</div>
			</div>
  <!-- </div>
		</div> -->
		</div>
		
	</section>
</main>
<script src="<?php echo URLROOT; ?>public/site/js/custom_validate.js"></script>


<script>


	$('#login_form').validate({

		// Specify validation rules
		rules: {

			username: {
				required: true,
			},
			password: {
				required: true
			}
		},
		// Specify validation error messages
		messages: {

			password: {
				required: "Please provide a password"
			},
			username: "Please enter a User name",

		},

		highlight: function(element, errorClass) {
			$(element).removeClass(errorClass); //prevent class to be added to selects
		},
		errorPlacement: function(error, element) {
			if (element.parent('.input-group').length) {
				error.insertAfter(element.parent());
			} else {
				error.insertAfter(element);
			}
		},
		submitHandler: function(form) {
			var password = $('#password').val();
			var md5_password = CryptoJS.MD5(password).toString();

			var form_data = [];

			form_data.push({
				name: "username",
				value: btoa($('#username').val())
			});

			form_data.push({
				name: "password",
				value: btoa(md5_password)
			});

			form_data.push({
				name: "page",
				value: 'citizen_login'
			});
			$('#error_login').hide();

			$.ajax({
				url: "<?php echo URLROOT; ?>User/validate_login",
				method: "POST",
				data: form_data,
				dataType: "json",
				// headers: {
				// 	"Authorization": "Basic " + btoa($('#username').val() + ":" + btoa($('#password').val()))
				// },
				
				success: function(data, textStatus, jqXHR) 
				{
				
					if (jqXHR.status == '200') 
					{

						// var response = decryptString(data.data);
						window.location.href = '<?php echo URLROOT; ?>Mybill/citizen_dashboard';

						// decode_json = JSON.parse(response);
						// var form_data = [];

						// form_data.push({
						// 	name: "userid",
						// 	value: decode_json.userid
						// });
						// $.ajax({
						// 	url: "<?php echo URLROOT; ?>get-user",
						// 	type: 'POST',
						// 	dataType: "json",
						// 	data: form_data,
						// 	success: function(data, textStatus, jqXHR) 
						// 	{

						// 		if (data.status == 'success') {
						// 			var get_user = decryptString(data.data);
						// 			alert(get_user);


						// 		}
						// 	}

						// }).fail(function($xhr) {

						// 	debugger;
						// 	alert('fail');

						// });

					}
				}
			}).fail(function($xhr) 
			{
				$('#error_login').show();
				$('#error_login').html('Invalid Login');
				
			});
		}

	});



	var valiator = $('#register_form').validate({
		// Specify validation rules
		rules: {
			distcode: {
				required: true
			},
			email: {
				required: true
			},
			mobilenumber: {
				required: true
			},
		
			name: {
				required: true
			},
			pwd: {
				required: true
			},
			cnf_pwd: {
				required: true,
				equalTo: "#pwd"
			}
		},
		// Specify validation error messages
		messages: {

			distcode: {
				required: "Select District name"
			},
			email: {
				required: "Enter a valid Email address"
			},
			mobilenumber: {
				required: "Enter a valid Mobile Number"
			},
			cnf_pwd: {
				required: "Enter Password again",
				equalTo	:  "Confirm password must match with new password"
			},
			name: {
				required: "Enter Username"
			},
			pwd: {
				required: "Enter a Password"
			}

		},
		submitHandler: function(form) {
			event.preventDefault();
			// var form_data = $('#register_form').serializeArray();

			form_data = [];

			form_data.push({
				name: "mobilenumber",
				value: btoa($('#mobilenumber').val())
			});
			form_data.push({
				name: "name",
				value: $('#name').val()
			});
			form_data.push({
				name: "email",
				value: btoa($('#email').val())
			});
			form_data.push({
				name: "pwd",
				value: CryptoJS.MD5($('#pwd').val())
			});
			form_data.push({
				name: "distcode",
				value: $('#distcode').val()
			});
			form_data.push({
				name: "deviceid",
				value: 'W'
			});
		
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

			if (!(mailformat.test($('#email').val()))) 
			{
				$("#error_register").show();
				$('#error_register').html('Invalid Email Address.');
			} 
			else
			{
				$("#error_register").hide();
				$.ajax({
					url: '<?php echo URLROOT; ?>User/register',
					method: "POST",
					data: form_data,
					dataType: "json",
					success: function(data, textStatus, jqXHR) 
					{
						if (jqXHR.status == '200') 
						{
							$('#confirmation_alert').modal({
                                        backdrop: 'static',
                                        keyboard: false
                                        })
							document.getElementById("process_button").onclick = function() 
							{
								registration_sucess();
							};

                       		passing_alert_value('Confirmation', 'Registration Done Successfully.Login now', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert_with_function');
						}
					},
					error: function(xhr, status, error) 
					{
						var err = JSON.parse(xhr.responseText);
						if (err.code == 406) 
						{
							$("#error_register").show();
							$('#error_register').html('Already Registered.');
						}

					}

				});
			}
			

		}
	});

	function registration_sucess()
	{
		$('#confirmation_alert').hide();
		window.location.href = '<?php echo URLROOT; ?>User/login';
	} 
</script>

<?php
require_once('./public/site/layouts/footer.php');
?>