<div role="main" class="main">
				<div class="parallax py-5 appear-animation" data-appear-animation="fadeIn" data-plugin-parallax data-plugin-options="{'speed': 1.5, 'parallaxHeight': '115%'}" data-image-src="<?=base_url('assets/HTML')?>/img/parallax/parallax-10.jpg">
					<div class="spacer py-5 my-5"></div>
					<div class="spacer py-5 my-5"></div>
				</div>
				<section class="section section-content-pull-top-2 pull-top-level-3 z-index-1 py-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400">
					<div class="container pb-0">
						<div class="row text-center mb-5">
							<div class="col">
								<div class="overflow-hidden">
									<span class="d-block top-sub-title text-color-primary appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="600">GET TO KNOW US</span>
								</div>
								<div class="overflow-hidden mb-2">
									<h2 class="font-weight-bold mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="800">Digital Agency Based in New York</h2>
								</div>
								<div class="overflow-hidden mb-5">
									<p class="lead mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="1000">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit.</p>
								</div>
								<p class="text-2 px-lg-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1200">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque consequat sit amet diam a dignissim. Suspendisse nec suscipit purus, eget tincidunt magna. Suspendisse vulputate venenatis neque, a accumsan leo congue et.</p>
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
								<a class="btn btn-primary btn-rounded btn-v-3 btn-h-3 font-weight-bold text-0" data-bs-target="#collapseForm" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseForm" onClick="scrollAndFocus('#form', '#name', 30);">SEND MESSAGE</a>
							</div>
						</div>
					</div>
				</section>
				<div class="section bg-light-5 mt-negative-2 z-index-0 py-0">
					<div class="container">
						<div id="form" class="row">
							<div class="col">
								<div class="collapse pe-4" id="collapseForm">
							    	<form class="contact-form pt-5 mt-5" action="php/contact-form.php" method="POST">
							    		<div class="contact-form-success alert alert-success d-none">
							    			<strong>Success!</strong> Your message has been sent to us.
							    		</div>
							    		<div class="contact-form-error alert alert-danger d-none">
							    			<strong>Error!</strong> There was an error sending your message.
							    			<span class="mail-error-message d-block"></span>
							    		</div>
							    		<div class="form-row row mb-3">
							    			<div class="form-group col-lg-3">
							    				<input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control" name="name" id="name" placeholder="Name" required>
							    			</div>
							    			<div class="form-group col-lg-3">
							    				<input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control" name="email" id="email" placeholder="E-mail" required>
							    			</div>
							    			<div class="form-group col-lg-6">
							    				<input type="text" value="" data-msg-required="Please enter the subject." maxlength="100" class="form-control" name="subject" id="subject" placeholder="Subject" required>
							    			</div>
							    		</div>
							    		<div class="form-row row mb-3 mb-4">
							    			<div class="form-group col">
							    				<textarea maxlength="5000" data-msg-required="Please enter your message." rows="5" class="form-control" name="message" id="message" placeholder="Message" required></textarea>
							    			</div>
							    		</div>
							    		<div class="form-row row mb-3">
							    			<div class="form-group col">
							    				<div class="d-grid col-6 mx-auto">
							    					<input type="submit" value="SEND MESSAGE" class="btn btn-primary btn-rounded btn-4 font-weight-semibold text-0" data-loading-text="Loading...">
							    				</div>
							    			</div>
							    		</div>
							    	</form>
							    </div>
							</div>
						</div>
						<div class="row mx-0 appear-animation" data-appear-animation="fadeInUpShorter">
							<!-- Go to the bottom of the page to change settings and map location. -->
							<!-- <div id="googlemaps" class="google-map google-map-style-2 height-500"></div> -->
						</div>
					</div>
				</div>
			</div>