// Driver Management JavaScript
// Data yang akan diisi dari Blade template
let driverConfig = {
    routes: {},
    csrfToken: ''
};

// Modal functions
function openTukarPoinModal(driverId, availablePoints, driverName) {
    const modal = document.getElementById('tukarPoinModal');
    const driverIdInput = document.getElementById('tukarDriverId');
    const pointsInput = document.getElementById('points');
    const totalPoinTersedia = document.getElementById('totalPoinTersedia');
    const form = document.getElementById('formTukarPoin');
    
    if (modal && driverIdInput && pointsInput && totalPoinTersedia) {
        driverIdInput.value = driverId;
        pointsInput.max = availablePoints;
        pointsInput.value = '';
        totalPoinTersedia.textContent = availablePoints;
        
        // Reset nilai tukar
        document.getElementById('nilaiTukar').textContent = 'Rp 0';
        document.getElementById('nilaiTukarValue').value = '0';
        
        // Store driver name for confirmation
        form.dataset.driverName = driverName;
        
        modal.style.display = 'block';
    }
}

function closeTukarPoinModal() {
    const modal = document.getElementById('tukarPoinModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Delete confirmation
function confirmDelete(event, form) {
    event.preventDefault();
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data driver akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

// Initialize driver page
function initDriverPage() {
    // Tutup modal saat mengklik di luar konten modal
    window.onclick = function(event) {
        const modal = document.getElementById('tukarPoinModal');
        if (event.target == modal) {
            closeTukarPoinModal();
        }
    }

    // Hitung nilai tukar saat input berubah
    const pointsInput = document.getElementById('points');
    if (pointsInput) {
        pointsInput.addEventListener('input', function() {
            const points = parseInt(this.value) || 0;
            const totalPoints = parseInt(this.max) || 0;
            
            // Validasi poin tidak boleh melebihi poin tersedia
            if (points > totalPoints) {
                this.value = totalPoints;
                return;
            }
            
            // Hitung nilai tukar (1 poin = Rp 50.000)
            const nilaiTukar = points * 50000;
            console.log('Menghitung nilai tukar:', { points, nilaiTukar });
            const nilaiTukarElement = document.getElementById('nilaiTukar');
            if (nilaiTukarElement) {
                nilaiTukarElement.textContent = 'Rp ' + nilaiTukar.toLocaleString('id-ID');
                // Update nilai tukar di form submission handler
                document.getElementById('nilaiTukarValue').value = nilaiTukar;
            }
        });
    }
    
    // Handle form submission
    const formTukarPoin = document.getElementById('formTukarPoin');
    if (formTukarPoin) {
        formTukarPoin.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const points = parseInt(document.getElementById('points')?.value) || 0;
            const driverName = this.dataset.driverName || '';
            const nilaiTukar = points * 50000;
            
            if (points <= 0) {
                Swal.fire({
                    title: 'Error',
                    text: 'Jumlah poin harus lebih dari 0',
                    icon: 'error',
                    confirmButtonColor: '#4CAF50',
                });
                return;
            }
            
            Swal.fire({
                title: 'Konfirmasi Penukaran Poin',
                html: `Apakah Anda yakin ingin menukar <b>${points} poin</b> milik <b>${driverName}</b> senilai <b>Rp ${nilaiTukar.toLocaleString('id-ID')}</b>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4CAF50',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, tukar poin',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang memproses penukaran poin',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit form
                    this.submit();
                }
            });
        });
    }

    // Realtime update poin driver via Laravel Echo + Pusher
    if (window.Echo && typeof window.Echo.channel === 'function') {
        window.Echo.channel('driver-points')
            .listen('.DriverPointsUpdated', function (e) {
                var driverId = e.driver_id;
                var totalPoints = e.total_points; // total di database
                var remainingPoints = e.remaining_points; // sisa poin yang masih bisa ditukar

                var row = document.querySelector('tr[data-driver-id="' + driverId + '"]');
                if (!row) return;

                // Update tampilan poin ditukar dan sisa poin
                var redeemedSpan = row.querySelector('[data-role="points-redeemed"]');
                if (redeemedSpan) {
                    var redeemed = totalPoints - remainingPoints;
                    redeemedSpan.lastChild.nodeValue = ' ' + Number(redeemed).toLocaleString('id-ID');
                }

                var remainingSpan = row.querySelector('[data-role="remaining-points"]');
                if (remainingSpan) {
                    remainingSpan.lastChild.nodeValue = ' ' + Number(remainingPoints).toLocaleString('id-ID');
                }

                // Update tombol tukar poin
                var tukarButton = row.querySelector('[data-role="tukar-poin-button"]');
                if (tukarButton) {
                    var hasPoints = remainingPoints > 0;
                    tukarButton.disabled = !hasPoints;
                    tukarButton.classList.toggle('text-green-600', hasPoints);
                    tukarButton.classList.toggle('hover:text-green-800', hasPoints);
                    tukarButton.classList.toggle('text-gray-400', !hasPoints);
                    tukarButton.classList.toggle('cursor-not-allowed', !hasPoints);

                    if (hasPoints) {
                        tukarButton.setAttribute('title', 'Tukar Poin');
                        tukarButton.setAttribute('onclick', "openTukarPoinModal('" + driverId + "', " + remainingPoints + ", '" + (row.querySelector('td:nth-child(3) .text-sm')?.textContent || '') + "')");
                    } else {
                        tukarButton.setAttribute('title', 'Tidak ada poin yang bisa ditukarkan');
                        tukarButton.setAttribute('onclick', "alert('Tidak ada poin yang bisa ditukarkan')");
                    }
                }
            });
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initDriverPage();
});
