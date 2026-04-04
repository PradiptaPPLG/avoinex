<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>


<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Total Bookings</div>
                <div class="stat-value"><?php echo e(number_format($totalBookings)); ?></div>
            </div>
            <div class="stat-icon" style="background: rgba(0,102,204,0.10); color: #0066CC;">
                <i class="bi bi-ticket-perforated-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Confirmed</div>
                <div class="stat-value" style="color: #0DAF7A;"><?php echo e(number_format($confirmedBookings)); ?></div>
            </div>
            <div class="stat-icon" style="background: rgba(13,175,122,0.10); color: #0DAF7A;">
                <i class="bi bi-check-circle-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Cancelled</div>
                <div class="stat-value" style="color: #EF4444;"><?php echo e(number_format($cancelledBookings)); ?></div>
            </div>
            <div class="stat-icon" style="background: rgba(239,68,68,0.10); color: #EF4444;">
                <i class="bi bi-x-circle-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value" style="font-size:24px;">Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></div>
            </div>
            <div class="stat-icon" style="background: rgba(0,194,168,0.12); color: #00C2A8;">
                <i class="bi bi-cash-stack"></i>
            </div>
        </div>
    </div>
</div>


<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-graph-up-arrow text-primary"></i>
                <h5 class="mb-0">Revenue Trend (6 Bulan Terakhir)</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="260"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-pie-chart-fill text-info"></i>
                <h5 class="mb-0">Status Booking</h5>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <div style="max-width: 260px; width: 100%;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row g-3 mb-4">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-bar-chart-fill text-success"></i>
                <h5 class="mb-0">Booking per Bulan</h5>
            </div>
            <div class="card-body">
                <canvas id="bookingChart" height="250"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-geo-alt-fill text-danger"></i>
                <h5 class="mb-0">Top 5 Rute Populer</h5>
            </div>
            <div class="card-body">
                <canvas id="routeChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>


<div class="row g-3">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-calendar-check text-primary"></i>
                <h5 class="mb-0">Today's Flights</h5>
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-5">
                <div style="font-size: 72px; font-weight: 800; color: var(--primary); line-height: 1;">
                    <?php echo e($flightsToday); ?>

                </div>
                <div class="text-muted mt-2" style="font-size: 13px; font-weight: 500;">Scheduled departures today</div>
                <div class="mt-3 d-flex align-items-center gap-1" style="font-size: 12px; color: var(--success); font-weight: 600;">
                    <i class="bi bi-circle-fill" style="font-size: 7px;"></i> Live tracking active
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-lightning-charge-fill text-warning"></i>
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <a href="<?php echo e(route('admin.bookings.index')); ?>" class="text-decoration-none">
                            <div style="border: 1.5px solid var(--border); border-radius: 10px; padding: 18px; transition: all 0.2s; background: var(--surface-2);" onmouseover="this.style.borderColor='var(--primary)';this.style.background='var(--primary-light)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--surface-2)'">
                                <i class="bi bi-ticket-perforated-fill" style="font-size: 22px; color: var(--primary);"></i>
                                <div style="font-size: 14px; font-weight: 700; color: var(--text-primary); margin-top: 10px;">View Bookings</div>
                                <div style="font-size: 12px; color: var(--text-muted); margin-top: 3px;">Manage all reservations</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="<?php echo e(route('admin.flights.create')); ?>" class="text-decoration-none">
                            <div style="border: 1.5px solid var(--border); border-radius: 10px; padding: 18px; transition: all 0.2s; background: var(--surface-2);" onmouseover="this.style.borderColor='var(--success)';this.style.background='rgba(13,175,122,0.06)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--surface-2)'">
                                <i class="bi bi-plus-circle-fill" style="font-size: 22px; color: var(--success);"></i>
                                <div style="font-size: 14px; font-weight: 700; color: var(--text-primary); margin-top: 10px;">New Flight</div>
                                <div style="font-size: 12px; color: var(--text-muted); margin-top: 3px;">Create flight instance</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="<?php echo e(route('admin.schedules.create')); ?>" class="text-decoration-none">
                            <div style="border: 1.5px solid var(--border); border-radius: 10px; padding: 18px; transition: all 0.2s; background: var(--surface-2);" onmouseover="this.style.borderColor='var(--info)';this.style.background='rgba(59,130,246,0.06)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--surface-2)'">
                                <i class="bi bi-calendar-plus-fill" style="font-size: 22px; color: var(--info);"></i>
                                <div style="font-size: 14px; font-weight: 700; color: var(--text-primary); margin-top: 10px;">Add Schedule</div>
                                <div style="font-size: 12px; color: var(--text-muted); margin-top: 3px;">Set up flight schedule</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="<?php echo e(route('admin.aircraft.create')); ?>" class="text-decoration-none">
                            <div style="border: 1.5px solid var(--border); border-radius: 10px; padding: 18px; transition: all 0.2s; background: var(--surface-2);" onmouseover="this.style.borderColor='var(--warning)';this.style.background='rgba(245,158,11,0.06)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--surface-2)'">
                                <i class="bi bi-airplane-fill" style="font-size: 22px; color: var(--warning);"></i>
                                <div style="font-size: 14px; font-weight: 700; color: var(--text-primary); margin-top: 10px;">Add Aircraft</div>
                                <div style="font-size: 12px; color: var(--text-muted); margin-top: 3px;">Register new aircraft</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Common chart options
    var gridColor = 'rgba(0,0,0,0.04)';
    var fontFamily = "'Plus Jakarta Sans', sans-serif";

    // ======= REVENUE TREND CHART =======
    var revenueCtx = document.getElementById('revenueChart').getContext('2d');
    var revenueGradient = revenueCtx.createLinearGradient(0, 0, 0, 260);
    revenueGradient.addColorStop(0, 'rgba(0, 102, 204, 0.15)');
    revenueGradient.addColorStop(1, 'rgba(0, 102, 204, 0)');

    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($revenueMonths); ?>,
            datasets: [{
                label: 'Revenue (Rp)',
                data: <?php echo json_encode($revenueData); ?>,
                borderColor: '#0066CC',
                backgroundColor: revenueGradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#0066CC',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#0066CC',
                pointHoverBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0D1B2A',
                    titleFont: { family: fontFamily, weight: '600' },
                    bodyFont: { family: fontFamily },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(ctx) {
                            return 'Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { family: fontFamily, size: 11, weight: '600' }, color: '#8FA0B5' }
                },
                y: {
                    grid: { color: gridColor },
                    border: { display: false },
                    ticks: {
                        font: { family: fontFamily, size: 11 },
                        color: '#8FA0B5',
                        callback: function(v) {
                            if (v >= 1000000) return 'Rp ' + (v / 1000000).toFixed(1) + 'M';
                            if (v >= 1000) return 'Rp ' + (v / 1000).toFixed(0) + 'K';
                            return 'Rp ' + v;
                        }
                    }
                }
            }
        }
    });

    // ======= STATUS DISTRIBUTION CHART =======
    var statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Confirmed', 'Pending', 'Cancelled'],
            datasets: [{
                data: [
                    <?php echo e($statusDistribution['confirmed']); ?>,
                    <?php echo e($statusDistribution['pending']); ?>,
                    <?php echo e($statusDistribution['cancelled']); ?>

                ],
                backgroundColor: ['#0DAF7A', '#F59E0B', '#EF4444'],
                borderColor: '#ffffff',
                borderWidth: 3,
                hoverBorderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { family: fontFamily, size: 12, weight: '600' },
                        color: '#5A6B82',
                        padding: 16,
                        usePointStyle: true,
                        pointStyleWidth: 12
                    }
                },
                tooltip: {
                    backgroundColor: '#0D1B2A',
                    titleFont: { family: fontFamily, weight: '600' },
                    bodyFont: { family: fontFamily },
                    padding: 12,
                    cornerRadius: 8
                }
            }
        }
    });

    // ======= BOOKINGS PER MONTH BAR CHART =======
    var bookingCtx = document.getElementById('bookingChart').getContext('2d');
    new Chart(bookingCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($bookingMonths); ?>,
            datasets: [
                {
                    label: 'Confirmed',
                    data: <?php echo json_encode($bookingConfirmedData); ?>,
                    backgroundColor: 'rgba(13, 175, 122, 0.8)',
                    borderRadius: 6,
                    borderSkipped: false,
                    barPercentage: 0.6
                },
                {
                    label: 'Cancelled',
                    data: <?php echo json_encode($bookingCancelledData); ?>,
                    backgroundColor: 'rgba(239, 68, 68, 0.7)',
                    borderRadius: 6,
                    borderSkipped: false,
                    barPercentage: 0.6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        font: { family: fontFamily, size: 11, weight: '600' },
                        color: '#5A6B82',
                        usePointStyle: true,
                        pointStyleWidth: 10,
                        padding: 16
                    }
                },
                tooltip: {
                    backgroundColor: '#0D1B2A',
                    titleFont: { family: fontFamily, weight: '600' },
                    bodyFont: { family: fontFamily },
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { family: fontFamily, size: 11, weight: '600' }, color: '#8FA0B5' },
                    stacked: true
                },
                y: {
                    grid: { color: gridColor },
                    border: { display: false },
                    ticks: {
                        font: { family: fontFamily, size: 11 },
                        color: '#8FA0B5',
                        stepSize: 1
                    },
                    stacked: true
                }
            }
        }
    });

    // ======= TOP ROUTES HORIZONTAL BAR CHART =======
    var routeCtx = document.getElementById('routeChart').getContext('2d');
    var routeColors = ['#0066CC', '#3B82F6', '#00C2A8', '#F59E0B', '#8338EC'];
    new Chart(routeCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($topRouteLabels); ?>,
            datasets: [{
                label: 'Total Bookings',
                data: <?php echo json_encode($topRouteValues); ?>,
                backgroundColor: routeColors.map(function(c) { return c + 'CC'; }),
                borderColor: routeColors,
                borderWidth: 1,
                borderRadius: 8,
                barPercentage: 0.65,
                borderSkipped: false
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0D1B2A',
                    titleFont: { family: fontFamily, weight: '600' },
                    bodyFont: { family: fontFamily },
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                x: {
                    grid: { color: gridColor },
                    border: { display: false },
                    ticks: {
                        font: { family: fontFamily, size: 11 },
                        color: '#8FA0B5',
                        stepSize: 1
                    }
                },
                y: {
                    grid: { display: false },
                    ticks: {
                        font: { family: fontFamily, size: 12, weight: '600' },
                        color: '#0D1B2A'
                    }
                }
            }
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>