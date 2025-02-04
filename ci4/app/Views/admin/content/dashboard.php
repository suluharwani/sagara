<link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/datatables/datatables.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/summernote/summernote-image-list.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/summernote/summernote-lite.min.css" />


<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon purple mb-2">
                                    <i class="iconly-boldShow"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">ORDER</h6>
                                <h6 class="font-extrabold mb-0" id="total_order"></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon blue mb-2">
                                    <i class="iconly-boldProfile"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">ORDER SELESAI</h6>
                                <h6 class="font-extrabold mb-0" id="completed_orders"></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon green mb-2">
                                    <i class="iconly-boldAdd-User"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">ORDER PROGRESS</h6>
                                <h6 class="font-extrabold mb-0" id="progress_orders"></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon red mb-2">
                                    <i class="iconly-boldBookmark"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">PRODUK</h6>
                                <h6 class="font-extrabold mb-0" >Total :<span id="total_product"></span></h6>
                                <h6 class="font-extrabold mb-0" >Proses :<span id="totalProductProgress"></span></h6>
                                <h6 class="font-extrabold mb-0" >Finish :<span id="totalProductSelesai"></span></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="row">

                <div class="col-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Production Progress</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tabel_serverside" class="table table-bordered display text-left"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width: 5%; text-align: center;">NO</th>
                                            <th style="width: 5%; text-align: center;">TEAM</th>
                                            <th style="width: 5%; text-align: center;">KODE</th>
                                            <th style="width: 5%; text-align: center;">CUSTOMER</th>
                                            <th style="width: 5%; text-align: center;">DEADLINE</th>
                                            <th style="width: 5%; text-align: center;">QTY</th>
                                            <th style="width: 5%; text-align: center;">STATUS</th>
                                            <th style="width: 20%; text-align: center;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="text-center">
                                            <th style="width: 5%; text-align: center;">NO</th>
                                            <th style="width: 5%; text-align: center;">TEAM</th>
                                            <th style="width: 5%; text-align: center;">KODE</th>
                                            <th style="width: 5%; text-align: center;">CUSTOMER</th>
                                            <th style="width: 5%; text-align: center;">DEADLINE</th>
                                            <th style="width: 5%; text-align: center;">QTY</th>
                                            <th style="width: 5%; text-align: center;">STATUS</th>
                                            <th style="width: 20%; text-align: center;">ACTION</th>
                                        </tr>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Profile Visit</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-12">

                    <div class="d-flex align-items-center">
                    <div class="col-md-12">
                    <div class="input-group">
                    <input type="date" id="startDate" class="form-control" />
                    <input type="date" id="endDate" class="form-control" />
                    <button class="btn btn-success btn-sm" id="changeDateRangeBtn">Cari</button>
                </div>
            </div>

                    </div>
                </div>
            </div>
            <div class="card">
                    <div class="card-header">
                        <h4>Total Revenue</h4>
                    </div>
                    <div class="card-body">
                        <div class="card-content pb-4">
                            <span id="total_revenue">Rp 0</span> <!-- Default value -->
                        </div>
                    </div>
                </div>
            <div class="card">
                <div class="card-header">
                    <h4>Progress</h4>
                </div>
                <div class="card-body">
                    <div id="chart-progress"></div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
        // Set default date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('startDate').value = today;
        document.getElementById('endDate').value = today;
    </script>
<script type="text/javascript" src="<?= base_url('assets') ?>/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/summernote/summernote-lite.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/summernote/summernote-image-list.min.js"></script>
<script src="<?= base_url('assets/template/dist') ?>/assets/extensions/apexcharts/apexcharts.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/js/dashboardData.js"></script>