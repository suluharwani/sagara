<div role="main" class="main">
    <section class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8 text-start">
                    <span class="tob-sub-title text-color-primary d-block">OUR BLOG</span>
                    <h1 class="font-weight-bold">Blog</h1>
                    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb justify-content-start justify-content-md-end">
                        <li><a href="<?= base_url() ?>">Home</a></li>
                        <li class="active">Blog</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="blog-posts">
                    <?php if (isset($posts) && count($posts) > 0): ?>
                        <?php foreach ($posts as $post): ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="post-content">
                                        <h2 class="font-weight-bold text-5 mb-3">
                                            <a href="<?= base_url('blog/' . $post['slug']) ?>" class="text-dark">
                                                <?= esc($post['judul']) ?>
                                            </a>
                                        </h2>
                                        <div class="post-meta">
                                            <span class="text-muted">
                                                <i class="far fa-clock me-1"></i>
                                                <?= date('d M Y', strtotime($post['created_at'])) ?>
                                            </span>
                                        </div>
                                        <p class="mt-3">
                                            <?= substr(strip_tags($post['content']), 0, 150) ?>...
                                        </p>
                                        <a href="<?= base_url('blog/' . $post['slug']) ?>" class="btn btn-outline btn-primary btn-sm">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <hr class="solid my-5">
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <p class="mb-0">No blog posts available yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <aside class="sidebar col-lg-3">
                <div class="widget widget-search">
                    <h3 class="text-3 font-weight-bold">Search</h3>
                    <form action="<?= base_url('blog') ?>" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="Search...">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="widget widget-categories mt-4">
                    <h3 class="text-3 font-weight-bold">Categories</h3>
                    <ul class="list-unstyled">
                        <li><a href="#">Design</a></li>
                        <li><a href="#">Photos</a></li>
                        <li><a href="#">Lifestyle</a></li>
                        <li><a href="#">Technology</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</div>