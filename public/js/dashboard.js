// Dashboard JavaScript
// Data yang akan diisi dari Blade template
let dashboardConfig = {
    routes: {},
    initialData: {},
    csrfToken: '',
    pusherConfig: {}
};

// Diagram Batangan Pasien Per Bulan
let monthlyPatientChart = null;

function initMonthlyPatientChart() {
    const ctx = document.getElementById('monthlyPatientChart').getContext('2d');
    
    monthlyPatientChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Jumlah Pasien',
                data: [],
                backgroundColor: 'rgba(147, 51, 234, 0.8)',
                borderColor: 'rgb(147, 51, 234)',
                borderWidth: 1,
                borderRadius: 6,
                hoverBackgroundColor: 'rgba(147, 51, 234, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgb(147, 51, 234)',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            return `Pasien: ${context.parsed.y}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        stepSize: 1
                    }
                }
            }
        }
    });
    
    loadMonthlyPatientData();
}

function loadMonthlyPatientData() {
   fetch(dashboardConfig.routes.monthlyPatientData)
        .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();})
        .then(data => {
            if (data.success) {
                monthlyPatientChart.data.labels = data.labels;
                monthlyPatientChart.data.datasets[0].data = data.data;
                monthlyPatientChart.update();
                
                // Update year and total
                document.getElementById('current-year').textContent = data.year;
                document.getElementById('yearly-total').textContent = data.data.reduce((a, b) => a + b, 0);
            }
        })
        .catch(error => {
            console.error('Error loading monthly patient data:', error);
        });
}

// Diagram Lingkaran Tujuan Pasien
let destinationChart = null;

function initDestinationChart() {
    const ctx = document.getElementById('destinationChart').getContext('2d');
    
    destinationChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [
                    'rgba(239, 68, 68, 0.8)',  // Red for IGD
                    'rgba(236, 72, 153, 0.8)' // Pink for Ponek
                ],
                borderColor: [
                    'rgb(239, 68, 68)',
                    'rgb(236, 72, 153)'
                ],
                borderWidth: 2,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgb(147, 51, 234)',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
    
    loadDestinationData();
}

function loadDestinationData() {
    fetch(dashboardConfig.routes.patientDestinationData)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                destinationChart.data.labels = data.labels;
                destinationChart.data.datasets[0].data = data.data;
                destinationChart.update();
                
                // Update totals and percentages
                document.getElementById('destination-total').textContent = data.total;
                document.getElementById('igd-percentage').textContent = data.percentages.igd + '%';
                document.getElementById('ponek-percentage').textContent = data.percentages.ponek + '%';
            }
        })
        .catch(error => {
            console.error('Error loading destination data:', error);
        });
}

// Fallback polling jika Pusher gagal
let pollingInterval = null;
let lastScanCount = 0;
let lastPatientCount = 0;
let lastPointsCount = 0;

function startPolling() {
    console.log('Starting polling fallback...');
    pollingInterval = setInterval(() => {
        // Poll scan count
        fetch(dashboardConfig.routes.scanCount)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Polling scan response:', data);
                const counter = document.getElementById('scans-today');
                if (counter && data.scans_today !== undefined) {
                    const currentCount = parseInt(counter.textContent) || 0;
                    const newCount = data.scans_today;
                    
                    // Always update if different
                    if (newCount !== currentCount) {
                        counter.textContent = newCount;
                        counter.classList.add('pulse-animation');
                        setTimeout(() => counter.classList.remove('pulse-animation'), 1000);
                        
                        // Update persentase
                        const scanChange = document.getElementById('scan-change');
                        if (scanChange && data.scans_yesterday !== undefined) {
                            const yesterdayCount = data.scans_yesterday;
                            const percentageChange = yesterdayCount > 0 ? 
                                Math.round(((newCount - yesterdayCount) / yesterdayCount) * 100) : 0;
                            
                            const isPositive = percentageChange >= 0;
                            scanChange.className = `text-sm ${isPositive ? 'text-green-600' : 'text-red-600'} font-medium`;
                            scanChange.innerHTML = `${isPositive ? '↑' : '↓'} ${Math.abs(percentageChange)}%`;
                        }
                        
                        // Update lastScanCount for next comparison
                        lastScanCount = newCount;
                        console.log('Updated scan count from', currentCount, 'to', newCount);
                    }
                }
            })
            .catch(error => {
                console.error('Polling scan error:', error);
                console.log('URL:', dashboardConfig.routes.scanCount);
            });
            
        // Poll patient count
        fetch(dashboardConfig.routes.patientCount)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Polling patient response:', data);
                const counter = document.getElementById('total-patients');
                if (counter && data.total_patients !== undefined && data.total_patients !== lastPatientCount) {
                    const oldCount = parseInt(counter.textContent) || 0;
                    counter.textContent = data.total_patients;
                    counter.classList.add('pulse-animation');
                    setTimeout(() => counter.classList.remove('pulse-animation'), 1000);
                    
                    // Update new patients today
                    const newPatientsElement = document.getElementById('new-patients-today');
                    if (newPatientsElement && data.new_patients_today !== undefined) {
                        newPatientsElement.textContent = '+' + data.new_patients_today;
                    }
                    
                    lastPatientCount = data.total_patients;
                    console.log('Updated patient count from', oldCount, 'to', data.total_patients);
                }
            })
            .catch(error => {
                console.error('Polling patient error:', error);
                console.log('URL:', dashboardConfig.routes.patientCount);
            });
            
        // Poll points count
        fetch(dashboardConfig.routes.pointsCount)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Polling points response:', data);
                const counter = document.getElementById('total-points');
                if (counter && data.total_points !== undefined && data.total_points !== lastPointsCount) {
                    const oldCount = parseInt(counter.textContent.replace(/,/g, '')) || 0;
                    counter.textContent = data.total_points.toLocaleString('id-ID');
                    counter.classList.add('pulse-animation');
                    setTimeout(() => counter.classList.remove('pulse-animation'), 1000);
                    
                    // Update persentase poin
                    const pointsChange = document.getElementById('points-change');
                    if (pointsChange && data.points_yesterday !== undefined) {
                        const yesterdayCount = data.points_yesterday;
                        const todayCount = data.points_today;
                        const percentageChange = yesterdayCount > 0 ? 
                            Math.round(((todayCount - yesterdayCount) / yesterdayCount) * 100) : 0;
                        
                        const isPositive = percentageChange >= 0;
                        pointsChange.className = `text-sm ${isPositive ? 'text-green-600' : 'text-red-600'} font-medium`;
                        pointsChange.innerHTML = `${isPositive ? '↑' : '↓'} ${Math.abs(percentageChange)}%`;
                    }
                    
                    lastPointsCount = data.total_points;
                    console.log('Updated points count from', oldCount, 'to', data.total_points);
                }
            })
            .catch(error => {
                console.error('Polling points error:', error);
                console.log('URL:', dashboardConfig.routes.pointsCount);
            });
    }, 3000); // Poll setiap 3 detik
}

// Initialize Pusher
function initPusher() {
    // Coba Pusher dulu
    const script = document.createElement('script');
    script.src = 'https://js.pusher.com/7.0/pusher.min.js';
    script.onload = function() {
        try {
            const pusher = new Pusher(dashboardConfig.pusherConfig.key, {
                cluster: dashboardConfig.pusherConfig.cluster,
                forceTLS: true,
                enabledTransports: ['ws', 'wss', 'xhr_streaming', 'xhr_polling'],
                disableStats: true,
                activityTimeout: 30000
            });

            const channel = pusher.subscribe('scans');
            
            channel.bind('new-scan', function(data) {
                console.log('Menerima data scan baru via Pusher:', data);
                
                // Prevent duplicate processing
                const scanId = data.scan ? data.scan.id : null;
                if (scanId && window.lastProcessedScanId === scanId) {
                    console.log('Duplicate scan detected, skipping:', scanId);
                    return;
                }
                
                const counter = document.getElementById('scans-today');
                if (counter && data.scans_today !== undefined) {
                    const currentCount = parseInt(counter.textContent) || 0;
                    const newCount = data.scans_today;
                    
                    // Always update with exact count from server
                    counter.textContent = newCount;
                    counter.classList.add('pulse-animation');
                    setTimeout(() => counter.classList.remove('pulse-animation'), 1000);
                    
                    // Show increment badge
                    const badge = document.getElementById('new-scan-badge');
                    if (badge && data.increment) {
                        badge.textContent = `+${data.increment}`;
                        badge.classList.remove('hidden');
                        setTimeout(() => badge.classList.add('hidden'), 3000);
                    }
                }

                const scanChange = document.getElementById('scan-change');
                if (scanChange && data.scans_yesterday !== undefined) {
                    const yesterdayCount = data.scans_yesterday;
                    const todayCount = data.scans_today;
                    const percentageChange = yesterdayCount > 0 ? 
                        Math.round(((todayCount - yesterdayCount) / yesterdayCount) * 100) : 0;
                    
                    const isPositive = percentageChange >= 0;
                    scanChange.className = `text-sm ${isPositive ? 'text-green-600' : 'text-red-600'} font-medium`;
                    scanChange.innerHTML = `${isPositive ? '↑' : '↓'} ${Math.abs(percentageChange)}%`;
                }
                
                // Update recent activities - only if this scan has patient data
                if (data.recent_activities && data.recent_activities.length > 0) {
                    const activitiesContainer = document.getElementById('recent-activities-container');
                    if (activitiesContainer) {
                        let activitiesHtml = '';
                        data.recent_activities.forEach(activity => {
                            activitiesHtml += `
                                <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors fade-in">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 ${activity.color} rounded-full flex items-center justify-center">
                                            ${activity.icon}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900">${activity.title}</p>
                                        <p class="text-xs text-gray-500 truncate">${activity.subtitle}</p>
                                        <p class="text-xs text-gray-400 mt-1">${activity.time}</p>
                                    </div>
                                </div>
                            `;
                        });
                        activitiesContainer.innerHTML = activitiesHtml;
                    }
                }
                
                // Mark scan as processed
                if (scanId) {
                    window.lastProcessedScanId = scanId;
                }

                // Update daftar scan terbaru
                const recentScansList = document.getElementById('recent-scans-list');
                if (recentScansList && data.scan) {
                    const noDataMessage = recentScansList.querySelector('.text-center');
                    if (noDataMessage) {
                        recentScansList.removeChild(noDataMessage);
                    }
                    
                    const newScan = document.createElement('div');
                    newScan.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors fade-in';
                    newScan.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">${data.scan.driver_name || 'Driver Baru'}</p>
                                <p class="text-xs text-gray-500">
                                    ${data.scan.scan_time || new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})} • 
                                    Pasien Scan
                                </p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                            +${data.scan.points || 1} Poin
                        </span>
                    `;
                    
                    recentScansList.insertBefore(newScan, recentScansList.firstChild);
                    
                    if (recentScansList.children.length > 10) {
                        recentScansList.removeChild(recentScansList.lastChild);
                    }
                }
            });

            pusher.connection.bind('connected', function() {
                console.log('Pusher connected successfully!');
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                    pollingInterval = null;
                }
            });
            
            pusher.connection.bind('error', function(err) {
                console.error('Pusher connection error:', err);
                if (!pollingInterval) {
                    startPolling();
                }
            });
            
            pusher.connection.bind('disconnected', function() {
                console.log('Pusher disconnected, starting polling fallback');
                if (!pollingInterval) {
                    startPolling();
                }
            });
            
            // Timeout untuk Pusher
            setTimeout(() => {
                if (!pollingInterval) {
                    console.log('Pusher connection timeout, starting polling fallback');
                    startPolling();
                }
            }, 10000);
            
        } catch (error) {
            console.error('Error initializing Pusher:', error);
            startPolling();
        }
    };
    
    script.onerror = function() {
        console.error('Failed to load Pusher script, using polling fallback');
        startPolling();
    };
    
    document.head.appendChild(script);
}

// Reset points function
function confirmResetPoints() {
    Swal.fire({
        title: 'Reset Semua Data Sistem?',
        text: "Apakah Anda yakin ingin mereset SEMUA data sistem ke 0? Ini termasuk: poin driver, transaksi, data pasien, dan reward. Tindakan ini tidak dapat dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Reset Semua Data!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Tampilkan loading
            Swal.fire({
                title: 'Memproses...',
                text: 'Sedang mereset semua data sistem',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Kirim request reset
            fetch(dashboardConfig.routes.resetPoints, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': dashboardConfig.csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Semua data sistem berhasil direset ke 0',
                        icon: 'success',
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        // Reload halaman untuk menampilkan data terbaru
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Terjadi kesalahan saat mereset data',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat mereset data sistem',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            });
        }
    });
}

// Initialize dashboard
function initDashboard() {
    // Set initial data
    lastScanCount = dashboardConfig.initialData.scansToday;
    lastPatientCount = dashboardConfig.initialData.totalPatients;
    lastPointsCount = dashboardConfig.initialData.totalPoints;
    
    // Initialize charts
    initMonthlyPatientChart();
    initDestinationChart();
    
    // Initialize real-time updates
    initPusher();
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initDashboard();
});
