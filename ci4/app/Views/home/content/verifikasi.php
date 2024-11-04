<div role="main" class="main">
				<div class="parallax py-5 appear-animation" data-appear-animation="fadeIn" data-plugin-parallax data-plugin-options="{'speed': 1.5, 'parallaxHeight': '115%'}" data-image-src="<?=base_url('assets/HTML')?>/img/parallax/parallax-10.jpg">
					<div class="spacer py-5 my-5"></div>
					<div class="spacer py-5 my-5"></div>
				</div>
				<section class="section section-content-pull-top-2 pull-top-level-3 z-index-1 py-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400">
					<div class="container pb-0">
						<div class="row text-center mb-5">
							<div class="col">
								<!-- <div class="overflow-hidden"> -->
					<?php if (isset($_SESSION['message'])){
                        echo '<div class="alert alert-info" role="alert">';
                        echo $_SESSION['message'];
                        echo '</div>';
                     }?>
									<!-- <span class="d-block top-sub-title text-color-primary appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="600">GET TO KNOW US</span> -->
						<!-- 		</div>
								<div class="overflow-hidden mb-2">
									<h2 class="font-weight-bold mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="800">Digital Agency Based in New York</h2>
								</div>
								<div class="overflow-hidden mb-5">
									<p class="lead mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="1000">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit.</p>
								</div>
								<p class="text-2 px-lg-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1200">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque consequat sit amet diam a dignissim. Suspendisse nec suscipit purus, eget tincidunt magna. Suspendisse vulputate venenatis neque, a accumsan leo congue et.</p> -->
							</div>
						</div>
						<div class="row justify-content-center">
							<div class="col-md-5 col-lg-4 p-md-4 p-lg-5 mb-5 mb-md-4 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="1600">
								<div class="icon-box icon-box-style-6">
									<div class="icon-box-icon mb-3">
										<i class="lnr lnr-apartment text-color-primary"></i>
									</div>
									<div class="icon-box-info">
										<div class="icon-box-info-title">
											<h3 class="font-weight-bold text-4 mb-0">Address</h3>
										</div>
										<span>1234 Street Name, City Name, USA</span>
									</div>
								</div>
							</div>
							<div class="vertical-divider border border-top-0 border-end-0 border-bottom-0 p-0 d-none d-md-block appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1400"></div>
							<div class="col-md-5 col-lg-4 p-md-4 p-lg-5 mb-5 mb-md-4 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="1600">
								<div class="icon-box icon-box-style-6">
									<div class="icon-box-icon mb-3">
										<i class="lnr lnr-phone-handset text-color-primary"></i>
									</div>
									<div class="icon-box-info">
										<div class="icon-box-info-title">
											<h3 class="font-weight-bold text-4 mb-0">Phone Number</h3>
										</div>
										<span class="d-block">
											<a href="tel:+1234567890">(123) 456-7890</a> - <a href="tel:+1234567890">(123) 456-7890</a>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="container no-pull-top">
						<div class="row text-center">
							<div class="col appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1800" data-plugin-options="{'accY': 100}">
								<a class="btn btn-primary btn-rounded btn-v-3 btn-h-3 font-weight-bold text-0" role="button" aria-expanded="false" aria-controls="collapseForm" onClick="window.location.reload();">Kirim Ulang</a>
								<a class="btn btn-primary btn-rounded btn-v-3 btn-h-3 font-weight-bold text-0" role="button" aria-expanded="false" aria-controls="collapseForm" href="<?=base_url('client')?>">Halaman Login</a>
							</div>
						</div>
					</div>
				</section>

			</div>