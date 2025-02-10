<link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/datatables/datatables.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/summernote/summernote-image-list.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/summernote/summernote-lite.min.css" />
<style>
        #clock {
            font-size: 2em;
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
    </style>

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
                        <div id="clock"></div>
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
        // Get today's date
// Get today's date
const today = new Date();

// Set startDate to the first day of the current month
const startDate = new Date(today.getFullYear(), today.getMonth(), 2).toISOString().split('T')[0];

// Set endDate to today's date
const endDate = today.toISOString().split('T')[0];

// Assign the values to the input fields
document.getElementById('startDate').value = startDate;
document.getElementById('endDate').value = endDate;


function updateClock() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const timeString = `${hours}:${minutes}:${seconds}`;

    document.getElementById('clock').textContent = timeString;
}

// Update the clock every second
setInterval(updateClock, 1000);

// Initialize the clock immediately
updateClock();


    </script>

<script type="text/javascript" src="<?= base_url('assets') ?>/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/summernote/summernote-lite.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/summernote/summernote-image-list.min.js"></script>
<script src="<?= base_url('assets/template/dist') ?>/assets/extensions/apexcharts/apexcharts.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/js/dashboardData.js"></script>