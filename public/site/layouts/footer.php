<div class="ftAreaWrap position-relative bg-gDark fontAlter">
	<aside class="ftConnectAside pt-3 pb-3 text-center">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-12">
					<nav class="ftcaNav mb-4 mb-lg-0">
						<ul class="list-unstyled d-flex flex-wrap mb-0 justify-content-center text-center">
							<li>
								<a href="about.html">Privacy Policy</a>
							</li>
							<li>
								<a href="services.html">Hyperlinking Policy</a>
							</li>
							<li>
								<a href="eventsList.html">Copyright Policy</a>
							</li>
							<li>
								<a href="eventsList.html">Help</a>
							</li>
							<li>
								<a href="eventsList.html">Terms and Conditions</a>
							</li>

						</ul>
					</nav>
				</div>

			</div>
		</div>
	</aside>

	<!-- pageFooter -->
	<footer id="pageFooter" class="text-center bg-dark pt-3 pb-3">
		<img src="<?php echo URLROOT; ?>public/site/images/nic.png" alt="nic_logo" width="100px" height="100px">
		<div class="container">
			<p><a href="javascript:void(0);">Designed By</a> - <a href="javascript:void(0);">NIC</a> &copy; 2023. <br class="d-md-none">All Rights Reserved</p>
		</div>
	</footer>
</div>
<!-- include jQuery library -->
<script src="<?php echo URLROOT; ?>public/site/js/jquery-3.4.1.min.js"></script>
<!-- include custom JavaScript -->
<script src="<?php echo URLROOT; ?>public/site/js/jqueryCustom.js"></script>
<!-- include plugins JavaScript -->
<script src="<?php echo URLROOT; ?>public/site/js/plugins.js"></script>
<!-- include fontAwesome -->

<script>

$(function() {
    $('marquee').mouseover(function() {
        $(this).attr('scrollamount',0);
    }).mouseout(function() {
         $(this).attr('scrollamount',5);
    });

});
</script>