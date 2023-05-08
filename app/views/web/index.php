<?php
require_once('./public/site/layouts/header.php');
session_destroy();
?>

<main>
<div id="homeCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#homeCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#homeCarousel" data-slide-to="1"></li>
    <li data-target="#homeCarousel" data-slide-to="2"></li>
  </ol>
  
  <!-- Slides -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="<?php echo URLROOT; ?>public/site/images/img01.png" class="d-block w-100" />
    
    </div>
    <div class="carousel-item">
      <img src="<?php echo URLROOT; ?>public/site/images/img02.png" class="d-block w-100" />
      
    </div>
    <div class="carousel-item">
      <img src="<?php echo URLROOT; ?>public/site/images/img03.png" class="d-block w-100" />
     
    </div>
  </div>
  
  <!-- Controls -->
  <a class="carousel-control-prev" href="#homeCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only"></span>
  </a>
  <a class="carousel-control-next" href="#homeCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only"></span>
  </a>
</div>


	<section class="upcomeventsBlock position-relative pt-7 pb-3 pt-md-9 pb-md-6">

		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-6">
					<div class="pr-lg-8">
						<header class="headingHead mb-6 mb-lg-8 mb-xl-12">
							<div class="row align-items-end">
								<div class="col-12 col-sm-6 col-md-7">
									<h2 class="mb-sm-0 fwSemiBold h2Small">Latest News</h2>
								</div>

							</div>
						</header>
						<article class="cdColumnWidget bg-white shadow px-6 pb-5 mb-6" style=" border-radius: 25px;">

							<div class="row">
								<marquee width="90%" direction="up" height="60%">
									<ul class="list-unstyled cdDocsList mb-0">
										<li>
											<h3 class="font-weight-normal cdTitle mb-1">
												<a href="#">Test</a>
											</h3>
											<time datetime="2011-01-12" class="d-block">January 20, 2023</time>
										</li>
										<li>
											<h3 class="font-weight-normal cdTitle mb-1">
												<a href="#">Test</a>
											</h3>
											<time datetime="2011-01-12" class="d-block">January 20, 2023</time>
										</li>
									
										<li>
											<h3 class="font-weight-normal cdTitle mb-1">
												<a href="#">Test</a>
											</h3>
											<time datetime="2011-01-12" class="d-block">January 20, 2023</time>
										</li>
										<li>
											<h3 class="font-weight-normal cdTitle mb-1">
												<a href="#">Test</a>
											</h3>
											<time datetime="2011-01-12" class="d-block">January 20, 2023</time>
										</li>
									</ul>
								</marquee>
							</div>
						</article>
					</div>
				</div>
				<aside class="col-12 col-lg-6 uecColBg position-static">
					<div class="pl-lg-5">
						<header class="headingHead mb-6 mb-lg-8 mb-xl-12">
							<h2 class="mb-0 fwSemiBold h2Small">Price List</h2>
						</header>
						<section class="ItemfullBlock">
				<div class="container">
					<div class="row">
						<div class="col-12 col-md-6 col-lg-4 col-xl-6">
							<article class="npbColumn shadow bg-white mb-6 mb-xl-12">
								<div class="imgHolder position-relative">
									<a>
										<img src="<?php echo URLROOT; ?>public/site/images/img11.jpg" class="img-fluid w-100 d-block" alt="image description">
									</a>
									<time datetime="2011-01-12" class="npbTimeTag font-weight-bold fontAlter position-absolute text-white px-2 py-1">23 Jan 2023</time>
								</div>
								<div class="npbDescriptionWrap px-5 pt-8 pb-5">
									
									<h3 class="fwSemiBold mb-5">
										<a href="#">January Gift Lists</a>
									</h3>
									<address>
													<ul class="list-unstyled ueScheduleList">
														<li>
														<i class="fa-solid fa-clock"></i><span class="sr-only">icon</span></i>
															9:30am - 1:00pm
														</li>
														<li>
															<i class="icomoon-location icn position-absolute"><span class="sr-only">icon</span></i>
															Chennai
														</li>
													</ul>
												</address>
								</div>
							</article>
						</div>
						<div class="col-12 col-md-6 col-lg-4 col-xl-6">
							<article class="npbColumn shadow bg-white mb-6 mb-xl-12">
								<div class="imgHolder position-relative">
								<a>
										<img src="<?php echo URLROOT; ?>public/site/images/img11.jpg" class="img-fluid w-100 d-block" alt="image description">
									</a>
									<time datetime="2011-01-12" class="npbTimeTag font-weight-bold fontAlter position-absolute text-white px-2 py-1">23 Jan 2023</time>
								</div>
								<div class="npbDescriptionWrap px-5 pt-8 pb-5">
									
									<h3 class="fwSemiBold mb-5">
										<a href="#">January Gift Lists</a>
									</h3>
									<address>
													<ul class="list-unstyled ueScheduleList">
														<li>
															<i class="icomoon-clock icn position-absolute"><span class="sr-only">icon</span></i>
															9:30am - 1:00pm
														</li>
														<li>
															<i class="icomoon-location icn position-absolute"><span class="sr-only">icon</span></i>
															Chennai
														</li>
													</ul>
												</address>
								</div>
							</article>
						</div>
					
					
					</div>
				
				</div>
			</section>
						
					</div>
				</aside>
			</div>
		</div>
	</section>

</main>
<?php
require_once('./public/site/layouts/footer.php');
?>
