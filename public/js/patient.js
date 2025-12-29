// Patient Management JavaScript
// Data yang akan diisi dari Blade template
let patientConfig = {
    routes: {
        monthlyPatientData: '/dashboard/monthly-patient-data',
        patientDestinationData: '/dashboard/patient-destination-data'
    }
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
    fetch(patientConfig.routes.monthlyPatientData)
        .then(response => response.json())
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
    fetch(patientConfig.routes.patientDestinationData)
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

// Initialize patient page
function initPatientPage() {
    initMonthlyPatientChart();
    initDestinationChart();
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initPatientPage();
});
