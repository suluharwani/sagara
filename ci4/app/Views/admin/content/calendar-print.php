<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Cetak Kalender - Sagara Jersey</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #fff; color: #333; }
        
        .print-header {
            text-align: center;
            padding: 20px;
            border-bottom: 3px solid #1976d2;
            margin-bottom: 20px;
        }
        .print-header h1 { color: #1976d2; font-size: 1.8rem; margin-bottom: 5px; }
        .print-header p { color: #6c757d; }
        
        .calendar-container { padding: 20px; }
        .calendar-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 3px;
            margin-bottom: 10px;
        }
        .calendar-day-name {
            text-align: center;
            font-weight: 600;
            padding: 10px;
            background: #1976d2;
            color: #fff;
            font-size: 0.85rem;
        }
        .calendar-body {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 3px;
        }
        .calendar-day {
            min-height: 80px;
            border: 1px solid #dee2e6;
            padding: 6px;
            background: #fff;
        }
        .calendar-day.today {
            background: #e3f2fd;
            border-color: #1976d2;
        }
        .calendar-day.weekend-off {
            background: #ffebee;
            border-color: #dc3545;
        }
        .calendar-day.holiday {
            background: #ffebee;
            border-color: #dc3545;
        }
        .calendar-day.replacement {
            background: #e3f2fd;
            border-color: #1976d2;
        }
        .calendar-day.other-month {
            background: #f8f9fa;
            color: #adb5bd;
        }
        .calendar-day .day-number {
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 4px;
        }
        .calendar-day .day-events {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .calendar-day .event {
            font-size: 0.6rem;
            padding: 1px 4px;
            border-radius: 2px;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .legend {
            padding: 20px;
            border-top: 1px solid #dee2e6;
            margin-top: 20px;
        }
        .legend h6 { margin-bottom: 10px; }
        .legend-item {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-right: 15px;
            margin-bottom: 5px;
        }
        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 3px;
        }
        
        .no-print {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }
        .no-print .btn {
            padding: 10px 20px;
            font-size: 1rem;
        }
        
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
            .calendar-container { padding: 10px; }
        }
    </style>
</head>
<body>

<div class="no-print">
    <button class="btn btn-primary" onclick="window.print()">
        <i class="fas fa-print"></i> Cetak
    </button>
    <button class="btn btn-secondary" onclick="window.close()">
        <i class="fas fa-times"></i> Tutup
    </button>
</div>

<div class="print-header">
    <h1><i class="fas fa-calendar-alt"></i> Kalender Sagara Jersey</h1>
    <p><?= date('d M Y') ?> | Percetakan Kaos & Jersey Custom</p>
</div>

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

<div class="legend">
    <h6>Keterangan Warna:</h6>
    <div class="legend-item"><div class="legend-color" style="background: #1976d2;"></div> Jadwal/Deadline</div>
    <div class="legend-item"><div class="legend-color" style="background: #dc3545;"></div> Libur Nasional/Custom</div>
    <div class="legend-item"><div class="legend-color" style="background: #28a745;"></div> Hari Libur Custom</div>
    <div class="legend-item"><div class="legend-color" style="background: #1976d2;"></div> Hari Pengganti</div>
    <div class="legend-item"><div class="legend-color" style="background: #ffc107;"></div> Pengumuman</div>
    <div class="legend-item"><div class="legend-color" style="background: #6f42c1;"></div> Produksi</div>
</div>

<script>
const orders = <?= json_encode(array_filter($orders ?? [], function($o) { return !empty($o['deadline']); })) ?>;
const events = <?= json_encode($events ?? []) ?>;
const holidays = <?= json_encode($holidays ?? []) ?>;
const settings = <?= json_encode($settings ?? []) ?>;

const today = new Date();
const year = today.getFullYear();
const month = today.getMonth();

const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                   'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

const firstDay = new Date(year, month, 1).getDay();
const adjustedFirstDay = firstDay === 0 ? 6 : firstDay - 1;
const daysInMonth = new Date(year, month + 1, 0).getDate();

const saturdayOff = settings.saturday_off === '1';
const sundayOff = settings.sunday_off === '1';

const calendarBody = document.getElementById('calendarBody');

for (let i = 0; i < adjustedFirstDay; i++) {
    const emptyDay = document.createElement('div');
    emptyDay.className = 'calendar-day other-month';
    calendarBody.appendChild(emptyDay);
}

for (let day = 1; day <= daysInMonth; day++) {
    const dayEl = document.createElement('div');
    dayEl.className = 'calendar-day';
    
    const currentDayDate = new Date(year, month, day);
    const isToday = currentDayDate.toDateString() === today.toDateString();
    if (isToday) dayEl.classList.add('today');
    
    const dayOfWeek = currentDayDate.getDay();
    
    if ((sundayOff && dayOfWeek === 0) || (saturdayOff && dayOfWeek === 6)) {
        dayEl.classList.add('weekend-off');
    }
    
    holidays.forEach(holiday => {
        const hDate = new Date(holiday.holiday_date);
        if (hDate.getFullYear() === year && hDate.getMonth() === month && hDate.getDate() === day) {
            if (holiday.type === 'replacement') {
                dayEl.classList.add('replacement');
            } else {
                dayEl.classList.add('holiday');
            }
        }
    });
    
    const dayNumber = document.createElement('div');
    dayNumber.className = 'day-number';
    dayNumber.textContent = day;
    dayEl.appendChild(dayNumber);
    
    const dayEvents = document.createElement('div');
    dayEvents.className = 'day-events';
    
    orders.forEach(order => {
        const deadline = new Date(order.deadline);
        if (deadline.getFullYear() === year && deadline.getMonth() === month && deadline.getDate() === day) {
            const event = document.createElement('div');
            event.className = 'event';
            event.style.background = deadline < today ? '#dc3545' : '#1976d2';
            event.textContent = order.nama_tim || 'Order';
            dayEvents.appendChild(event);
        }
    });
    
    events.forEach(evt => {
        const evtDate = new Date(evt.event_date);
        if (evtDate.getFullYear() === year && evtDate.getMonth() === month && evtDate.getDate() === day) {
            const event = document.createElement('div');
            event.className = 'event';
            event.style.background = evt.color || '#1976d2';
            event.textContent = evt.title;
            dayEvents.appendChild(event);
        }
    });
    
    holidays.forEach(holiday => {
        const hDate = new Date(holiday.holiday_date);
        if (hDate.getFullYear() === year && hDate.getMonth() === month && hDate.getDate() === day) {
            const event = document.createElement('div');
            event.className = 'event';
            event.style.background = holiday.color || '#dc3545';
            event.textContent = holiday.title;
            dayEvents.appendChild(event);
        }
    });
    
    dayEl.appendChild(dayEvents);
    calendarBody.appendChild(dayEl);
}
</script>

</body>
</html>