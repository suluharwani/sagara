<div role="main" class="main">
				<section class="page-header">
					<div class="container">
						<div class="row align-items-center">
							<div class="col-md-8 text-start">
								<span class="tob-sub-title text-color-primary d-block">OUR BLOG</span>
								<h1 class="font-weight-bold">Default - Left Sidebar</h1>
								<p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
							</div>
							<div class="col-md-4">
								<ul class="breadcrumb justify-content-start justify-content-md-end">
									<li><a href="#">Home</a></li>
									<li class="active">Blog</li>
								</ul>
							</div>
						</div>
					</div>
				</section>

				<div class="container">
					<div class="row">
						<aside class="sidebar col-md-4 col-lg-3 order-2 order-md-1">
							<div class="accordion accordion-default accordion-toggle accordion-style-1" role="tablist">

								<div class="card">
									<div id="toggleSidebarSearch" class="accordion-body accordion-body-show-border-top collapse show p-0" role="tabpanel" aria-labelledby="sidebarSearchForm">
										<div class="card-body pt-4">
											<form id="sidebarSearchForm" class="sidebar-search" action="page-search-results.html" method="get">
												<div class="input-group">
													<input type="text" class="form-control line-height-1 bg-light-5" name="s" id="s" placeholder="Search..." required="">
													<span class="input-group-btn">
														<button class="btn btn-light" type="submit"><i class="fas fa-search text-color-primary"></i></button>
													</span>
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-header accordion-header" role="tab" id="categories">
										<h3 class="text-3 mb-0">
											<a href="#" data-bs-toggle="collapse" data-bs-target="#toggleCategories" aria-expanded="false" aria-controls="toggleCategories">CATEGORIES</a>
										</h3>
									</div>
									<div id="toggleCategories" class="accordion-body collapse show p-0" aria-labelledby="categories">
										<div class="card-body">
											<ul class="list list-unstyled">
												<li class="mb-2">
													<a href="#" class="font-weight-semibold"><i class="fas fa-angle-right ms-1 me-1"></i> Design</a>
												</li>
												<li class="mb-2">
													<a href="#" class="font-weight-semibold text-color-primary"><i class="fas fa-angle-right ms-1 me-1" id="photos" data-bs-toggle="collapse" data-bs-target="#submenuPhotos" aria-expanded="true" aria-controls="submenuPhotos" role="list" onclick="return false;"></i> Photos (3)</a>
													<ul class="list list-unstyled collapse show" id="submenuPhotos" aria-labelledby="photos">
														<li>
															<a href="#">Animals</a>
														</li>
														<li>
															<a href="#">Business (4)</a>
														</li>
														<li>
															<a href="#">Sports</a>
														</li>
													</ul>
												</li>
												<li class="mb-2">
													<a href="#" class="font-weight-semibold"><i class="fas fa-angle-right ms-1 me-1"></i> Videos</a>
												</li>
												<li class="mb-2">
													<a href="#" class="font-weight-semibold"><i class="fas fa-angle-right ms-1 me-1"></i> Lifestyle</a>
												</li>
												<li class="mb-2">
													<a href="#" class="font-weight-semibold"><i class="fas fa-angle-right ms-1 me-1"></i> Technology</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-header accordion-header" role="tab" id="tags">
										<h3 class="text-3 mb-0">
											<a href="#" data-bs-toggle="collapse" data-bs-target="#toggleTags" aria-expanded="false" aria-controls="toggleTags">TAGS</a>
										</h3>
									</div>
									<div id="toggleTags" class="accordion-body collapse show p-0" role="tabpanel" aria-labelledby="tags">
										<div class="card-body">
											<ul class="list-inline">
												<li class="list-inline-item"><a href="#" class="badge bg-dark badge-sm badge-pill rounded-pill px-3 py-2 mb-2">NEWS</a></li>
												<li class="list-inline-item"><a href="#" class="badge bg-dark badge-sm badge-pill rounded-pill px-3 py-2 mb-2">JOBS</a></li>
												<li class="list-inline-item"><a href="#" class="badge bg-dark badge-sm badge-pill rounded-pill px-3 py-2 mb-2">POST</a></li>
												<li class="list-inline-item"><a href="#" class="badge bg-dark badge-sm badge-pill rounded-pill px-3 py-2 mb-2">PHOTOS</a></li>
												<li class="list-inline-item"><a href="#" class="badge bg-dark badge-sm badge-pill rounded-pill px-3 py-2 mb-2">INNOVATION</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</aside>
						<div class="col-md-8 col-lg-9 order-1 order-md-2 mb-5 mb-md-0">
							<article class="blog-post">
								<header class="blog-post-header mb-4">
									<a href="blog-single-post.html">
										<img src="img/blog/posts/post-1-masonry.jpg" class="img-fluid" alt="" />
									</a>
									<i class="post-format-icon lnr lnr-picture bg-primary text-color-light text-7 p-3"></i>
								</header>
								<h2 class="text-5">
									<a href="blog-single-post.html" class="link-color-dark">
										This is a standard post with preview image
									</a>
								</h2>
								<div class="d-flex mb-3">
									<span class="post-date text-color-primary pe-3">MARCH 5, 2021</span>
									<span class="post-likes d-flex align-items-center border border-top-0 border-bottom-0 px-3"><i class="lnr lnr-heart text-3 me-1" aria-label="3 users like this post"></i> 3</span>
									<a href="blog-single-post.html#comments">
										<span class="post-comments d-flex align-items-center px-3"><i class="lnr lnr-bubble text-3 me-1" aria-label="6 users comment this post"></i> 6</span>
									</a>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam finibus vestibulum lacus non sodales. Aenean pretium augue tellus, dapibus molestie sapien vestibulum venenatis. Curabitur eulr...</p>
								<a href="blog-single-post.html" class="text-color-primary font-weight-bold learn-more">READ MORE <i class="fas fa-angle-right text-2" aria-label="Read more"></i></a>
							</article>
							<hr class="my-5">
							<article class="blog-post">
								<header class="blog-post-header mb-4">
									<div class="owl-carousel owl-theme dots-style-2 nav-style-2" data-plugin-options="{'autoplay': true, 'items': 1, 'dots': true, 'nav': false, 'animateIn': 'animate__fadeIn', 'animateOut': 'animate__fadeOut'}">
										<div>
											<a href="blog-single-post.html">
												<img src="img/blog/posts/post-2-2-masonry.jpg" class="img-fluid" alt="" />
											</a>
										</div>
										<div>
											<a href="blog-single-post.html">
												<img src="img/blog/posts/post-2-3-masonry.jpg" class="img-fluid" alt="" />
											</a>
										</div>
										<div>
											<a href="blog-single-post.html">
												<img src="img/blog/posts/post-2-masonry.jpg" class="img-fluid" alt="" />
											</a>
										</div>
									</div>
									<i class="post-format-icon lnr lnr-picture bg-primary text-color-light text-7 p-3"></i>
								</header>
								<h2 class="text-5">
									<a href="blog-single-post.html" class="link-color-dark">
										This is a standard slider gallery post
									</a>
								</h2>
								<div class="d-flex mb-3">
									<span class="post-date text-color-primary pe-3">MARCH 4, 2021</span>
									<span class="post-likes d-flex align-items-center border border-top-0 border-bottom-0 px-3"><i class="lnr lnr-heart text-3 me-1" aria-label="4 users like this post"></i> 4</span>
									<a href="blog-single-post.html#comments">
										<span class="post-comments d-flex align-items-center px-3"><i class="lnr lnr-bubble text-3 me-1" aria-label="2 users comment this post"></i> 2</span>
									</a>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam finibus vestibulum lacus non sodales. Aenean pretium augue tellus, dapibus molestie sapien vestibulum venenatis. Curabitur eulr...</p>
								<a href="blog-single-post.html" class="text-color-primary font-weight-bold learn-more">READ MORE <i class="fas fa-angle-right text-2" aria-label="Read more"></i></a>
							</article>
							<hr class="my-5">
							<article class="blog-post">
								<header class="blog-post-header mb-4">
									<div class="lightbox" data-plugin-options="{'delegate': 'a', 'type': 'image', 'gallery': {'enabled': true}, 'mainClass': 'mfp-with-zoom', 'zoom': {'enabled': true, 'duration': 300}}">
										<div class="row mx-0">
											<div class="col-6 col-md-4 p-0">
												<a href="img/blog/posts/post-3-square.jpg">
													<span class="image-frame image-frame-style-1 image-frame-effect-1">
														<span class="image-frame-wrapper">
															<img src="img/blog/posts/post-3-square.jpg" class="img-fluid" alt="">
															<span class="image-frame-inner-border"></span>
															<span class="image-frame-action">
																<span class="image-frame-action-icon">
																	<i class="lnr lnr-magnifier text-color-light"></i>
																</span>
															</span>
														</span>
													</span>
												</a>
											</div>
											<div class="col-6 col-md-4 p-0">
												<a href="img/blog/posts/post-4-square.jpg">
													<span class="image-frame image-frame-style-1 image-frame-effect-1">
														<span class="image-frame-wrapper">
															<img src="img/blog/posts/post-4-square.jpg" class="img-fluid" alt="">
															<span class="image-frame-inner-border"></span>
															<span class="image-frame-action">
																<span class="image-frame-action-icon">
																	<i class="lnr lnr-magnifier text-color-light"></i>
																</span>
															</span>
														</span>
													</span>
												</a>
											</div>
											<div class="col-6 col-md-4 p-0">
												<a href="img/blog/posts/post-9-square.jpg">
													<span class="image-frame image-frame-style-1 image-frame-effect-1">
														<span class="image-frame-wrapper">
															<img src="img/blog/posts/post-9-square.jpg" class="img-fluid" alt="">
															<span class="image-frame-inner-border"></span>
															<span class="image-frame-action">
																<span class="image-frame-action-icon">
																	<i class="lnr lnr-magnifier text-color-light"></i>
																</span>
															</span>
														</span>
													</span>
												</a>
											</div>
											<div class="col-6 col-md-4 p-0">
												<a href="img/blog/posts/post-6-square.jpg">
													<span class="image-frame image-frame-style-1 image-frame-effect-1">
														<span class="image-frame-wrapper">
															<img src="img/blog/posts/post-6-square.jpg" class="img-fluid" alt="">
															<span class="image-frame-inner-border"></span>
															<span class="image-frame-action">
																<span class="image-frame-action-icon">
																	<i class="lnr lnr-magnifier text-color-light"></i>
																</span>
															</span>
														</span>
													</span>
												</a>
											</div>
											<div class="col-6 col-md-4 p-0">
												<a href="img/blog/posts/post-7-square.jpg">
													<span class="image-frame image-frame-style-1 image-frame-effect-1">
														<span class="image-frame-wrapper">
															<img src="img/blog/posts/post-7-square.jpg" class="img-fluid" alt="">
															<span class="image-frame-inner-border"></span>
															<span class="image-frame-action">
																<span class="image-frame-action-icon">
																	<i class="lnr lnr-magnifier text-color-light"></i>
																</span>
															</span>
														</span>
													</span>
												</a>
											</div>
											<div class="col-6 col-md-4 p-0">
												<a href="img/blog/posts/post-8-square.jpg">
													<span class="image-frame image-frame-style-1 image-frame-effect-1">
														<span class="image-frame-wrapper">
															<img src="img/blog/posts/post-8-square.jpg" class="img-fluid" alt="">
															<span class="image-frame-inner-border"></span>
															<span class="image-frame-action">
																<span class="image-frame-action-icon">
																	<i class="lnr lnr-magnifier text-color-light"></i>
																</span>
															</span>
														</span>
													</span>
												</a>
											</div>
										</div>
									</div>
								</header>
								<h2 class="text-5">
									<a href="blog-single-post.html" class="link-color-dark">
										This is a standard image gallery thumbs post
									</a>
								</h2>
								<div class="d-flex mb-3">
									<span class="post-date text-color-primary pe-3">MARCH 3, 2021</span>
									<span class="post-likes d-flex align-items-center border border-top-0 border-bottom-0 px-3"><i class="lnr lnr-heart text-3 me-1" aria-label="7 users like this post"></i> 7</span>
									<a href="blog-single-post.html#comments">
										<span class="post-comments d-flex align-items-center px-3"><i class="lnr lnr-bubble text-3 me-1" aria-label="8 users comment this post"></i> 8</span>
									</a>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam finibus vestibulum lacus non sodales. Aenean pretium augue tellus, dapibus molestie sapien vestibulum venenatis. Curabitur eulr...</p>
								<a href="blog-single-post.html" class="text-color-primary font-weight-bold learn-more">READ MORE <i class="fas fa-angle-right text-2" aria-label="Read more"></i></a>
							</article>
							<hr class="my-5">
							<article class="blog-post">
								<header class="blog-post-header mb-4">
									<div class="ratio ratio-16x9">
										<iframe class="embed-responsive-item" src="https://player.vimeo.com/video/45830194?color=ffffff&title=0&byline=0&portrait=0&badge=0" width="640" height="360" allowfullscreen></iframe>
									</div>
								</header>
								<h2 class="text-5">
									<a href="blog-single-post.html" class="link-color-dark">
										This is a standard embedded video post
									</a>
								</h2>
								<div class="d-flex mb-3">
									<span class="post-date text-color-primary pe-3">MARCH 2, 2021</span>
									<span class="post-likes d-flex align-items-center border border-top-0 border-bottom-0 px-3"><i class="lnr lnr-heart text-3 me-1" aria-label="3 users like this post"></i> 3</span>
									<a href="blog-single-post.html#comments">
										<span class="post-comments d-flex align-items-center px-3"><i class="lnr lnr-bubble text-3 me-1" aria-label="5 users comment this post"></i> 5</span>
									</a>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam finibus vestibulum lacus non sodales. Aenean pretium augue tellus, dapibus molestie sapien vestibulum venenatis. Curabitur eulr...</p>
								<a href="blog-single-post.html" class="text-color-primary font-weight-bold learn-more">READ MORE <i class="fas fa-angle-right text-2" aria-label="Read more"></i></a>
							</article>
							<hr class="my-5">
							<article class="blog-post">
								<header class="blog-post-header mb-4">
									<div class="ratio ratio-16x9">
										<video class="embed-responsive-item" autoplay="" muted="" loop="" controls="">
											<source src="video/office.mp4" type="video/mp4">
										</video>
									</div>
								</header>
								<h2 class="text-5">
									<a href="blog-single-post.html" class="link-color-dark">
										This is a standard HTML5 video post
									</a>
								</h2>
								<div class="d-flex mb-3">
									<span class="post-date text-color-primary pe-3">MARCH 1, 2021</span>
									<span class="post-likes d-flex align-items-center border border-top-0 border-bottom-0 px-3"><i class="lnr lnr-heart text-3 me-1" aria-label="2 users like this post"></i> 2</span>
									<a href="blog-single-post.html#comments">
										<span class="post-comments d-flex align-items-center px-3"><i class="lnr lnr-bubble text-3 me-1" aria-label="3 users comment this post"></i> 3</span>
									</a>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam finibus vestibulum lacus non sodales. Aenean pretium augue tellus, dapibus molestie sapien vestibulum venenatis. Curabitur eulr...</p>
								<a href="blog-single-post.html" class="text-color-primary font-weight-bold learn-more">READ MORE <i class="fas fa-angle-right text-2" aria-label="Read more"></i></a>
							</article>
							<hr class="my-5">
							<article class="blog-post">
								<header class="blog-post-header bg-light-5 p-5 mb-4">
									<blockquote class="blockquote blockquote-style-1 blockquote-primary">
										<p class="mb-4 font-tertiary font-italic">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla gravida ipsum a est iaculis, sit amet ullamcorper odio egestas.</p>
									</blockquote>
								</header>
								<h2 class="text-5">
									<a href="blog-single-post.html" class="link-color-dark">
										This is a standard blockquote post
									</a>
								</h2>
								<div class="d-flex mb-3">
									<span class="post-date text-color-primary pe-3">FEBRUARY 26, 2021</span>
									<span class="post-likes d-flex align-items-center border border-top-0 border-bottom-0 px-3"><i class="lnr lnr-heart text-3 me-1" aria-label="1 users like this post"></i> 1</span>
									<a href="blog-single-post.html#comments">
										<span class="post-comments d-flex align-items-center px-3"><i class="lnr lnr-bubble text-3 me-1" aria-label="2 users comment this post"></i> 2</span>
									</a>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam finibus vestibulum lacus non sodales. Aenean pretium augue tellus, dapibus molestie sapien vestibulum venenatis. Curabitur eulr...</p>
								<a href="blog-single-post.html" class="text-color-primary font-weight-bold learn-more">READ MORE <i class="fas fa-angle-right text-2" aria-label="Read more"></i></a>
							</article>
							<hr class="my-5">
							<article class="blog-post">
								<header class="blog-post-header mb-4">
									<a href="http://www.themeforest.net/" class="d-block btn btn-primary btn-outline border-0 rounded-0 font-weight-bold text-center text-6 py-5" target="_blank">EZY ON THEMEFOREST</a>
								</header>
								<h2 class="text-5">
									<a href="blog-single-post.html" class="link-color-dark">
										This is a standard link post
									</a>
								</h2>
								<div class="d-flex mb-3">
									<span class="post-date text-color-primary pe-3">FEBRUARY 25, 2021</span>
									<span class="post-likes d-flex align-items-center border border-top-0 border-bottom-0 px-3"><i class="lnr lnr-heart text-3 me-1" aria-label="1 users like this post"></i> 1</span>
									<a href="blog-single-post.html#comments">
										<span class="post-comments d-flex align-items-center px-3"><i class="lnr lnr-bubble text-3 me-1" aria-label="5 users comment this post"></i> 5</span>
									</a>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam finibus vestibulum lacus non sodales. Aenean pretium augue tellus, dapibus molestie sapien vestibulum venenatis. Curabitur eulr...</p>
								<a href="blog-single-post.html" class="text-color-primary font-weight-bold learn-more">READ MORE <i class="fas fa-angle-right text-2" aria-label="Read more"></i></a>
							</article>
							<hr class="my-5">
							<article class="blog-post">
								<header class="blog-post-header mb-4">
									<div class="embed-responsive embed-soundcloud">
										<iframe class="embed-responsive-item" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/341546259&amp;color=%23ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;show_teaser=true&amp;visual=true"></iframe>
									</div>
								</header>
								<h2 class="text-5">
									<a href="blog-single-post.html" class="link-color-dark">
										This is a standard audio post
									</a>
								</h2>
								<div class="d-flex mb-3">
									<span class="post-date text-color-primary pe-3">FEBRUARY 24, 2021</span>
									<span class="post-likes d-flex align-items-center border border-top-0 border-bottom-0 px-3"><i class="lnr lnr-heart text-3 me-1" aria-label="1 users like this post"></i> 1</span>
									<a href="blog-single-post.html#comments">
										<span class="post-comments d-flex align-items-center px-3"><i class="lnr lnr-bubble text-3 me-1" aria-label="3 users comment this post"></i> 3</span>
									</a>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam finibus vestibulum lacus non sodales. Aenean pretium augue tellus, dapibus molestie sapien vestibulum venenatis. Curabitur eulr...</p>
								<a href="blog-single-post.html" class="text-color-primary font-weight-bold learn-more">READ MORE <i class="fas fa-angle-right text-2" aria-label="Read more"></i></a>
							</article>
							<hr class="mt-5 mb-4">
							<div class="row align-items-center justify-content-between">
								<div class="col-auto mb-3 mb-sm-0">
									<span>Showing 1-9 of 60 results</span>
								</div>
								<div class="col-auto">
									<nav aria-label="Page navigation example">
									  	<ul class="pagination mb-0">
									    	<li class="page-item">
									      		<a class="page-link prev" href="#" aria-label="Previous">
										        	<span><i class="fas fa-angle-left" aria-label="Previous"></i></span>
										      	</a>
									    	</li>
										    <li class="page-item active"><a class="page-link" href="#">1</a></li>
										    <li class="page-item"><a class="page-link" href="#">2</a></li>
										    <li class="page-item"><a class="page-link" href="#">3</a></li>
										    <li class="page-item">...</li>
										    <li class="page-item"><a class="page-link" href="#">15</a></li>
										    <li class="page-item">
										      	<a class="page-link next" href="#" aria-label="Next">
										        	<span><i class="fas fa-angle-right" aria-label="Next"></i></span>
										      	</a>
										    </li>
									  	</ul>
									</nav>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>