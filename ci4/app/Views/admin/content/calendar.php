<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2>Kalender Produksi & Deadline</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                    <li class="breadcrumb-item active">Kalender</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('admin/calendar/print') ?>" target="_blank" class="btn btn-admin btn-admin-primary">
                <i class="fas fa-print me-1"></i> Cetak Kalender
            </a>
            <a href="<?= base_url('admin/holiday') ?>" class="btn btn-admin btn-admin-primary">
                <i class="fas fa-calendar-times me-1"></i> Kelola Libur
            </a>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addEventModal">
                <i class="fas fa-plus"></i> Tambah Event
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-calendar-alt me-2"></i> Kalender</span>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary" onclick="changeMonth(-1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="btn btn-sm btn-primary" id="currentMonthYear">September 2026</span>
                    <button class="btn btn-sm btn-outline-primary" onclick="changeMonth(1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="calendar-container">
                    <div class="calendar-header">
                        <div class="calendar-day-name">Sen</div>
                        <div class="calendar-day-name">Sel</div>
                        <div class="calendar-day-name">Rab</div>
                        <div class="calendar-day-name">Kam</div>
                        <div class="calendar-day-name">Jum</div>
                        <div class="calendar-day-name">Sab</div>
                        <div class="calendar-day-name">Min</div>
                    </div>
                    <div class="calendar-body" id="calendarBody"></div>
                </div>
            </div>
        </div>
        
        <!-- Monthly Holiday List -->
        <div class="admin-card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-calendar-day me-2"></i> Libur Bulan <span id="holidayListMonthLabel"></span></span>
                <a href="<?= base_url('admin/holiday') ?>" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-cog"></i> Kelola Libur
                </a>
            </div>
            <div class="card-body" id="monthlyHolidayList">
                <p class="text-muted text-center mb-0">Memuat...</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i> Keterangan
            </div>
            <div class="card-body">
                <h6>Warna Event:</h6>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge" style="background: #1976d2;">Jadwal</span>
                    <span class="badge" style="background: #dc3545;">Deadline</span>
                    <span class="badge" style="background: #28a745;">Hari Libur</span>
                    <span class="badge" style="background: #ffc107; color: #333;">Pengumuman</span>
                    <span class="badge" style="background: #6f42c1;">Produksi</span>
                </div>
                <h6>Jenis Libur:</h6>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge" style="background: #dc3545;">Libur Nasional</span>
                    <span class="badge" style="background: #28a745;">Libur Custom</span>
                    <span class="badge" style="background: #1976d2;">Hari Pengganti</span>
                </div>
                <hr>
                <h6>Pengaturan Libur:</h6>
                <p class="mb-1">Sabtu: <span class="badge <?= (($settings['saturday_off'] ?? '0') == '1') ? 'bg-danger' : 'bg-success' ?>"><?= (($settings['saturday_off'] ?? '0') == '1') ? 'Libur' : 'Masuk' ?></span></p>
                <p class="mb-0">Minggu: <span class="badge <?= (($settings['sunday_off'] ?? '0') == '1') ? 'bg-danger' : 'bg-success' ?>"><?= (($settings['sunday_off'] ?? '0') == '1') ? 'Libur' : 'Masuk' ?></span></p>
                <div class="d-flex gap-2 mt-2">
                    <a href="<?= base_url('admin/settings') ?>" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-cog"></i> Ubah Pengaturan
                    </a>
                </div>
            </div>
        </div>
        
        <div class="admin-card">
            <div class="card-header">
                <i class="fas fa-list me-2"></i> Daftar Event
            </div>
            <div class="card-body">
                <div class="order-list">
                    <?php if (!empty($events)): ?>
                        <?php foreach ($events as $event): ?>
                            <div class="event-item">
                                <div class="event-color" style="background: <?= esc($event['color'] ?? '#1976d2') ?>"></div>
                                <div class="event-info">
                                    <h6><?= esc($event['title']) ?></h6>
                                    <small class="text-muted">
                                        <?= date('d M Y', strtotime($event['event_date'])) ?> - 
                                        <?= ucfirst($event['event_type']) ?>
                                    </small>
                                </div>
                                <a href="<?= base_url('admin/calendar/delete/' . $event['id']) ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Hapus event ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted text-center">Belum ada event</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Event -->
<div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/calendar/add') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="event_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Event</label>
                        <select name="event_type" class="form-select" id="eventType" onchange="updateColor()">
                            <option value="schedule" selected>Jadwal</option>
                            <option value="deadline">Deadline</option>
                            <option value="holiday">Hari Libur</option>
                            <option value="announcement">Pengumuman</option>
                            <option value="production">Produksi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Warna</label>
                        <input type="color" name="color" id="eventColor" class="form-control form-control-color" value="#1976d2">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const orders = <?= json_encode(array_filter($orders ?? [], function($o) { return !empty($o['deadline']); })) ?>;
const events = <?= json_encode($events ?? []) ?>;
const holidays = <?= json_encode($holidays ?? []) ?>;
const settings = <?= json_encode($settings ?? []) ?>;

let currentDate = new Date();
let activePopup = null;

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    document.getElementById('currentMonthYear').textContent = monthNames[month] + ' ' + year;
    
    const firstDay = new Date(year, month, 1).getDay();
    const adjustedFirstDay = firstDay === 0 ? 6 : firstDay - 1;
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const today = new Date();
    
    const saturdayOff = settings.saturday_off === '1';
    const sundayOff = settings.sunday_off === '1';
    
    const calendarBody = document.getElementById('calendarBody');
    calendarBody.innerHTML = '';
    
    // Empty cells for days before first day of month
    for (let i = 0; i < adjustedFirstDay; i++) {
        const emptyDay = document.createElement('div');
        emptyDay.className = 'calendar-day other-month';
        calendarBody.appendChild(emptyDay);
    }
    
    // Day cells
    for (let day = 1; day <= daysInMonth; day++) {
        const dayEl = document.createElement('div');
        dayEl.className = 'calendar-day';
        dayEl.setAttribute('data-day', day);
        
        const currentDayDate = new Date(year, month, day);
        const isToday = currentDayDate.toDateString() === today.toDateString();
        if (isToday) dayEl.classList.add('today');
        
        const dayOfWeek = currentDayDate.getDay();
        
        // Check for weekend off
        if ((sundayOff && dayOfWeek === 0) || (saturdayOff && dayOfWeek === 6)) {
            dayEl.classList.add('weekend-off');
        }
        
        // Check for holidays
        const dayHolidays = holidays.filter(h => {
            const hDate = new Date(h.holiday_date);
            return hDate.getFullYear() === year && hDate.getMonth() === month && hDate.getDate() === day;
        });
        
        if (dayHolidays.length > 0) {
            dayHolidays.forEach(h => {
                if (h.type === 'replacement') {
                    dayEl.classList.add('replacement');
                } else {
                    dayEl.classList.add('holiday');
                }
            });
        }
        
        // Day number
        const dayNumber = document.createElement('div');
        dayNumber.className = 'day-number';
        dayNumber.textContent = day;
        dayEl.appendChild(dayNumber);
        
        // Holiday indicator dot
        if (dayHolidays.length > 0) {
            const indicator = document.createElement('div');
            indicator.className = 'holiday-indicator';
            const hasCustom = dayHolidays.some(h => h.type === 'custom');
            const hasReplacement = dayHolidays.some(h => h.type === 'replacement');
            if (hasCustom) indicator.classList.add('custom');
            if (hasReplacement) indicator.classList.add('replacement');
            dayEl.appendChild(indicator);
        }
        
        // Event dots container
        const dayEvents = document.createElement('div');
        dayEvents.className = 'day-events';
        
        // Collect all events for this day
        const dayEventList = [];
        
        // Add orders
        orders.forEach(order => {
            const deadline = new Date(order.deadline);
            if (deadline.getFullYear() === year && deadline.getMonth() === month && deadline.getDate() === day) {
                dayEventList.push({
                    type: 'order',
                    title: order.nama_tim || 'Order',
                    color: deadline < today ? '#dc3545' : '#1976d2',
                    data: order
                });
            }
        });
        
        // Add events
        events.forEach(evt => {
            const evtDate = new Date(evt.event_date);
            if (evtDate.getFullYear() === year && evtDate.getMonth() === month && evtDate.getDate() === day) {
                dayEventList.push({
                    type: 'event',
                    title: evt.title,
                    color: evt.color || '#1976d2',
                    data: evt
                });
            }
        });
        
        // Add holidays
        dayHolidays.forEach(h => {
            dayEventList.push({
                type: 'holiday',
                title: h.title,
                color: h.color || '#dc3545',
                data: h
            });
        });
        
        // Show max 4 dots, then "+" if more
        const maxDots = 4;
        dayEventList.slice(0, maxDots).forEach(evt => {
            const dot = document.createElement('div');
            dot.className = 'event-dot';
            dot.style.background = evt.color;
            dayEvents.appendChild(dot);
        });
        
        if (dayEventList.length > maxDots) {
            const more = document.createElement('div');
            more.className = 'event-more';
            more.textContent = '+' + (dayEventList.length - maxDots) + ' lagi';
            dayEvents.appendChild(more);
        }
        
        dayEl.appendChild(dayEvents);
        
        // Click handler to show popup
        dayEl.addEventListener('click', function(e) {
            if (dayEl.classList.contains('other-month')) return;
            showDayPopup(e, day, year, month, dayEventList, dayHolidays, dayOfWeek);
        });
        
        calendarBody.appendChild(dayEl);
    }
}

function showDayPopup(e, day, year, month, dayEventList, dayHolidays, dayOfWeek) {
    // Remove existing popup
    if (activePopup) {
        activePopup.remove();
        activePopup = null;
    }
    
    // Day names
    const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    
    const popup = document.createElement('div');
    popup.className = 'calendar-popup';
    
    // Header
    const header = document.createElement('div');
    header.className = 'calendar-popup-header';
    header.innerHTML = `
        <div>
            <div class="calendar-popup-date">${day} ${monthNames[month]} ${year}</div>
            <div class="calendar-popup-day">${dayNames[dayOfWeek]}</div>
        </div>
    `;
    popup.appendChild(header);
    
    // Content
    if (dayEventList.length === 0) {
        const noEvent = document.createElement('div');
        noEvent.className = 'text-muted text-center py-2';
        noEvent.style.fontSize = '0.85rem';
        noEvent.textContent = 'Tidak ada event atau libur';
        popup.appendChild(noEvent);
    } else {
        dayEventList.forEach(evt => {
            const item = document.createElement('div');
            item.className = 'calendar-popup-item';
            
            const colorBar = document.createElement('div');
            colorBar.className = 'calendar-popup-color';
            colorBar.style.background = evt.color;
            item.appendChild(colorBar);
            
            const info = document.createElement('div');
            info.className = 'calendar-popup-info';
            
            const title = document.createElement('h6');
            title.textContent = evt.title;
            info.appendChild(title);
            
            const typeSpan = document.createElement('span');
            typeSpan.className = 'calendar-popup-type ' + (evt.type === 'holiday' ? evt.data.type : evt.type);
            
            if (evt.type === 'holiday') {
                typeSpan.textContent = evt.data.type === 'national' ? 'Libur Nasional' : 
                                     evt.data.type === 'custom' ? 'Cuti Bersama' : 'Hari Pengganti';
            } else if (evt.type === 'order') {
                typeSpan.textContent = 'Deadline Order';
            } else {
                typeSpan.textContent = 'Event';
            }
            
            info.appendChild(typeSpan);
            item.appendChild(info);
            popup.appendChild(item);
        });
    }
    
    // Position popup
    const rect = e.target.closest('.calendar-day').getBoundingClientRect();
    const popupWidth = 260;
    let left = rect.right + 10;
    
    // Check if popup goes off screen
    if (left + popupWidth > window.innerWidth) {
        left = rect.left - popupWidth - 10;
    }
    if (left < 10) {
        left = 10;
    }
    
    popup.style.left = left + 'px';
    popup.style.top = rect.top + 'px';
    
    document.body.appendChild(popup);
    
    // Trigger animation
    requestAnimationFrame(() => {
        popup.classList.add('show');
    });
    
    activePopup = popup;
    
    // Close popup when clicking outside
    setTimeout(() => {
        document.addEventListener('click', closePopupOutside);
    }, 100);
}

function closePopupOutside(e) {
    if (activePopup && !activePopup.contains(e.target) && !e.target.closest('.calendar-day')) {
        activePopup.remove();
        activePopup = null;
        document.removeEventListener('click', closePopupOutside);
    }
}

function changeMonth(delta) {
    currentDate.setMonth(currentDate.getMonth() + delta);
    renderCalendar();
    renderMonthlyHolidayList();
}

function renderMonthlyHolidayList() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    document.getElementById('holidayListMonthLabel').textContent = monthNames[month] + ' ' + year;
    
    const container = document.getElementById('monthlyHolidayList');
    
    // Get holidays for this month
    const monthHolidays = holidays.filter(h => {
        const hDate = new Date(h.holiday_date);
        return hDate.getFullYear() === year && hDate.getMonth() === month;
    });
    
    // Get orders with deadlines for this month
    const monthOrders = orders.filter(o => {
        if (!o.deadline) return false;
        const dDate = new Date(o.deadline);
        return dDate.getFullYear() === year && dDate.getMonth() === month;
    });
    
    // Get weekend off days
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const weekendDays = [];
    const saturdayOff = settings.saturday_off === '1';
    const sundayOff = settings.sunday_off === '1';
    
    for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(year, month, day);
        const dayOfWeek = date.getDay();
        if ((sundayOff && dayOfWeek === 0) || (saturdayOff && dayOfWeek === 6)) {
            weekendDays.push(day);
        }
    }
    
    if (monthHolidays.length === 0 && weekendDays.length === 0 && monthOrders.length === 0) {
        container.innerHTML = '<p class="text-muted text-center mb-0">Tidak ada libur atau deadline pada bulan ini</p>';
        return;
    }
    
    let html = '<div class="holiday-month-list">';
    
    // Weekend off section
    if (weekendDays.length > 0) {
        html += '<div class="holiday-section mb-3">';
        html += '<h6 class="text-warning mb-2"><i class="fas fa-calendar-week me-1"></i> Akhir Pekan</h6>';
        html += '<div class="holiday-list-group">';
        
        const saturdayWeekends = weekendDays.filter(d => new Date(year, month, d).getDay() === 6);
        const sundayWeekends = weekendDays.filter(d => new Date(year, month, d).getDay() === 0);
        
        if (saturdayOff && saturdayWeekends.length > 0) {
            html += `<div class="holiday-item-sm">`;
            html += `<span class="badge bg-warning text-dark">Sabtu</span>`;
            html += `<span class="holiday-days">${saturdayWeekends.join(', ')}</span>`;
            html += `</div>`;
        }
        if (sundayOff && sundayWeekends.length > 0) {
            html += `<div class="holiday-item-sm">`;
            html += `<span class="badge bg-warning text-dark">Minggu</span>`;
            html += `<span class="holiday-days">${sundayWeekends.join(', ')}</span>`;
            html += `</div>`;
        }
        html += '</div></div>';
    }
    
    // National holidays section
    const nationalHolidays = monthHolidays.filter(h => h.type === 'national');
    if (nationalHolidays.length > 0) {
        html += '<div class="holiday-section mb-3">';
        html += '<h6 class="text-danger mb-2"><i class="fas fa-flag me-1"></i> Libur Nasional</h6>';
        html += '<div class="holiday-list-group">';
        
        nationalHolidays.forEach(h => {
            const day = new Date(h.holiday_date).getDate();
            html += `<div class="holiday-item-sm national">`;
            html += `<span class="holiday-date">${day}</span>`;
            html += `<span class="holiday-title">${h.title}</span>`;
            html += `</div>`;
        });
        html += '</div></div>';
    }
    
    // Custom holidays section
    const customHolidays = monthHolidays.filter(h => h.type === 'custom');
    if (customHolidays.length > 0) {
        html += '<div class="holiday-section mb-3">';
        html += '<h6 class="text-success mb-2"><i class="fas fa-calendar-plus me-1"></i> Cuti Bersama</h6>';
        html += '<div class="holiday-list-group">';
        
        customHolidays.forEach(h => {
            const day = new Date(h.holiday_date).getDate();
            html += `<div class="holiday-item-sm custom">`;
            html += `<span class="holiday-date">${day}</span>`;
            html += `<span class="holiday-title">${h.title}</span>`;
            html += `</div>`;
        });
        html += '</div></div>';
    }
    
    // Replacement holidays section
    const replacementHolidays = monthHolidays.filter(h => h.type === 'replacement');
    if (replacementHolidays.length > 0) {
        html += '<div class="holiday-section mb-3">';
        html += '<h6 class="text-info mb-2"><i class="fas fa-exchange-alt me-1"></i> Hari Pengganti</h6>';
        html += '<div class="holiday-list-group">';
        
        replacementHolidays.forEach(h => {
            const day = new Date(h.holiday_date).getDate();
            html += `<div class="holiday-item-sm replacement">`;
            html += `<span class="holiday-date">${day}</span>`;
            html += `<span class="holiday-title">${h.title}</span>`;
            html += `</div>`;
        });
        html += '</div></div>';
    }
    
    // Deadline Orders section
    if (monthOrders.length > 0) {
        html += '<div class="holiday-section mb-3">';
        html += '<h6 class="text-primary mb-2"><i class="fas fa-shipping-fast me-1"></i> Deadline Order</h6>';
        html += '<div class="holiday-list-group">';
        
        monthOrders.forEach(o => {
            const dDate = new Date(o.deadline);
            const day = dDate.getDate();
            const today = new Date();
            const isOverdue = dDate < today;
            html += `<div class="holiday-item-sm order ${isOverdue ? 'overdue' : ''}">`;
            html += `<span class="holiday-date" style="background: ${isOverdue ? '#dc3545' : '#1976d2'}; color: #fff;">${day}</span>`;
            html += `<span class="holiday-title">${o.nama_tim || 'Order'}</span>`;
            html += `<small class="text-muted ms-auto">${dDate.toLocaleDateString('id-ID', {day:'numeric', month:'short'})}</small>`;
            html += `</div>`;
        });
        html += '</div></div>';
    }
    
    html += '</div>';
    container.innerHTML = html;
}

function updateColor() {
    const type = document.getElementById('eventType').value;
    const colorMap = {
        'schedule': '#1976d2',
        'deadline': '#dc3545',
        'holiday': '#28a745',
        'announcement': '#ffc107',
        'production': '#6f42c1'
    };
    document.getElementById('eventColor').value = colorMap[type] || '#1976d2';
}

// Close popup on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && activePopup) {
        activePopup.remove();
        activePopup = null;
    }
});

renderCalendar();
renderMonthlyHolidayList();
</script>