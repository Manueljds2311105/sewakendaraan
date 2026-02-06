// ===== FORMAT RUPIAH =====
function formatRupiah(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    input.value = new Intl.NumberFormat('id-ID').format(value);
}

// ===== CALCULATE TOTAL BIAYA SEWA =====
function hitungTotal() {
    const hargaInput = document.getElementById('harga_sewa');
    const lamaInput = document.getElementById('lama_sewa');
    const totalInput = document.getElementById('total_biaya');
    
    if(hargaInput && lamaInput && totalInput) {
        const harga = hargaInput.value.replace(/[^0-9]/g, '');
        const lama = lamaInput.value;
        
        if(harga && lama) {
            const total = parseInt(harga) * parseInt(lama);
            totalInput.value = new Intl.NumberFormat('id-ID').format(total);
            updateTanggalKembali();
        }
    }
}

// ===== UPDATE TANGGAL KEMBALI OTOMATIS =====
function updateTanggalKembali() {
    const tanggalSewaInput = document.getElementById('tanggal_sewa');
    const lamaSewaInput = document.getElementById('lama_sewa');
    const tanggalKembaliDisplay = document.getElementById('tanggal_kembali_display');
    
    if(tanggalSewaInput && lamaSewaInput && tanggalKembaliDisplay) {
        const tanggalSewa = new Date(tanggalSewaInput.value);
        const lamaSewa = parseInt(lamaSewaInput.value);
        
        if(!isNaN(tanggalSewa) && !isNaN(lamaSewa)) {
            tanggalSewa.setDate(tanggalSewa.getDate() + lamaSewa);
            const day = String(tanggalSewa.getDate()).padStart(2, '0');
            const month = String(tanggalSewa.getMonth() + 1).padStart(2, '0');
            const year = tanggalSewa.getFullYear();
            
            tanggalKembaliDisplay.textContent = `${day}/${month}/${year}`;
        }
    }
}

// ===== LOAD HARGA KENDARAAN =====
function loadHargaKendaraan(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const harga = selectedOption.getAttribute('data-harga');
    const hargaInput = document.getElementById('harga_sewa');
    
    if(hargaInput && harga) {
        hargaInput.value = new Intl.NumberFormat('id-ID').format(harga);
        hitungTotal();
    }
}

// ===== CALCULATE DENDA =====
function hitungDenda() {
    const tanggalRencanaInput = document.getElementById('tanggal_kembali_rencana');
    const tanggalAktualInput = document.getElementById('tanggal_kembali_aktual');
    const hargaSewaInput = document.getElementById('harga_sewa_perhari');
    const dendaDisplay = document.getElementById('denda_display');
    const dendaInput = document.getElementById('denda_value');
    
    if(tanggalRencanaInput && tanggalAktualInput && hargaSewaInput) {
        const tanggalRencana = new Date(tanggalRencanaInput.value);
        const tanggalAktual = new Date(tanggalAktualInput.value);
        const hargaSewa = parseFloat(hargaSewaInput.value);
        
        const diffTime = tanggalAktual - tanggalRencana;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        if(diffDays > 0) {
            const tarifDenda = hargaSewa * 0.1;
            const totalDenda = tarifDenda * diffDays;
            
            if(dendaDisplay) {
                dendaDisplay.innerHTML = `
                    <div class="alert alert-warning">
                        <strong>Terlambat ${diffDays} hari</strong><br>
                        Tarif Denda: Rp ${new Intl.NumberFormat('id-ID').format(tarifDenda)}/hari<br>
                        <strong>Total Denda: Rp ${new Intl.NumberFormat('id-ID').format(totalDenda)}</strong>
                    </div>
                `;
            }
            
            if(dendaInput) {
                dendaInput.value = totalDenda;
            }
        } else {
            if(dendaDisplay) {
                dendaDisplay.innerHTML = '<div class="alert alert-success">Tidak ada keterlambatan</div>';
            }
            if(dendaInput) {
                dendaInput.value = 0;
            }
        }
    }
}

// ===== AUTO HIDE ALERTS =====
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
    
    const dateInputs = document.querySelectorAll('input[type="date"]');
    const today = new Date().toISOString().split('T')[0];
    dateInputs.forEach(input => {
        if(input.id === 'tanggal_sewa' || input.id === 'tanggal_kembali_aktual') {
            input.setAttribute('min', today);
        }
    });
});

// ===== PRINT FUNCTION =====
function printReport() {
    window.print();
}

function printDiv(divId) {
    var printContents = document.getElementById(divId).innerHTML;
    var originalContents = document.body.innerHTML;
    
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    window.location.reload();
}

// ===== EXPORT TO EXCEL - FIXED VERSION =====
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    
    if(!tableSelect) {
        alert('Table not found!');
        return;
    }
    
    // Clone table untuk manipulasi
    var tableClone = tableSelect.cloneNode(true);
    
    // Hapus badge/span yang tidak perlu, ambil text saja
    var badges = tableClone.querySelectorAll('.badge');
    badges.forEach(function(badge) {
        var text = badge.textContent;
        badge.replaceWith(document.createTextNode(text));
    });
    
    // Hapus tag <br> dan ganti dengan spasi
    var brs = tableClone.querySelectorAll('br');
    brs.forEach(function(br) {
        br.replaceWith(document.createTextNode(' '));
    });
    
    // Hapus tag <small>
    var smalls = tableClone.querySelectorAll('small');
    smalls.forEach(function(small) {
        var text = small.textContent;
        small.replaceWith(document.createTextNode(text));
    });
    
    // Hapus semua span
    var spans = tableClone.querySelectorAll('span');
    spans.forEach(function(span) {
        var text = span.textContent;
        span.replaceWith(document.createTextNode(text));
    });
    
    var tableHTML = tableClone.outerHTML.replace(/ /g, '%20');
    
    filename = filename ? filename + '.xls' : 'excel_data.xls';
    
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        downloadLink.download = filename;
        downloadLink.click();
    }
    
    document.body.removeChild(downloadLink);
}
EOF
cat script_fixed.js
Output

// ===== FORMAT RUPIAH =====
function formatRupiah(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    input.value = new Intl.NumberFormat('id-ID').format(value);
}

// ===== CALCULATE TOTAL BIAYA SEWA =====
function hitungTotal() {
    const hargaInput = document.getElementById('harga_sewa');
    const lamaInput = document.getElementById('lama_sewa');
    const totalInput = document.getElementById('total_biaya');
    
    if(hargaInput && lamaInput && totalInput) {
        const harga = hargaInput.value.replace(/[^0-9]/g, '');
        const lama = lamaInput.value;
        
        if(harga && lama) {
            const total = parseInt(harga) * parseInt(lama);
            totalInput.value = new Intl.NumberFormat('id-ID').format(total);
            updateTanggalKembali();
        }
    }
}

// ===== UPDATE TANGGAL KEMBALI OTOMATIS =====
function updateTanggalKembali() {
    const tanggalSewaInput = document.getElementById('tanggal_sewa');
    const lamaSewaInput = document.getElementById('lama_sewa');
    const tanggalKembaliDisplay = document.getElementById('tanggal_kembali_display');
    
    if(tanggalSewaInput && lamaSewaInput && tanggalKembaliDisplay) {
        const tanggalSewa = new Date(tanggalSewaInput.value);
        const lamaSewa = parseInt(lamaSewaInput.value);
        
        if(!isNaN(tanggalSewa) && !isNaN(lamaSewa)) {
            tanggalSewa.setDate(tanggalSewa.getDate() + lamaSewa);
            const day = String(tanggalSewa.getDate()).padStart(2, '0');
            const month = String(tanggalSewa.getMonth() + 1).padStart(2, '0');
            const year = tanggalSewa.getFullYear();
            
            tanggalKembaliDisplay.textContent = `${day}/${month}/${year}`;
        }
    }
}

// ===== LOAD HARGA KENDARAAN =====
function loadHargaKendaraan(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const harga = selectedOption.getAttribute('data-harga');
    const hargaInput = document.getElementById('harga_sewa');
    
    if(hargaInput && harga) {
        hargaInput.value = new Intl.NumberFormat('id-ID').format(harga);
        hitungTotal();
    }
}

// ===== CALCULATE DENDA =====
function hitungDenda() {
    const tanggalRencanaInput = document.getElementById('tanggal_kembali_rencana');
    const tanggalAktualInput = document.getElementById('tanggal_kembali_aktual');
    const hargaSewaInput = document.getElementById('harga_sewa_perhari');
    const dendaDisplay = document.getElementById('denda_display');
    const dendaInput = document.getElementById('denda_value');
    
    if(tanggalRencanaInput && tanggalAktualInput && hargaSewaInput) {
        const tanggalRencana = new Date(tanggalRencanaInput.value);
        const tanggalAktual = new Date(tanggalAktualInput.value);
        const hargaSewa = parseFloat(hargaSewaInput.value);
        
        const diffTime = tanggalAktual - tanggalRencana;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        if(diffDays > 0) {
            const tarifDenda = hargaSewa * 0.1;
            const totalDenda = tarifDenda * diffDays;
            
            if(dendaDisplay) {
                dendaDisplay.innerHTML = `
                    <div class="alert alert-warning">
                        <strong>Terlambat ${diffDays} hari</strong><br>
                        Tarif Denda: Rp ${new Intl.NumberFormat('id-ID').format(tarifDenda)}/hari<br>
                        <strong>Total Denda: Rp ${new Intl.NumberFormat('id-ID').format(totalDenda)}</strong>
                    </div>
                `;
            }
            
            if(dendaInput) {
                dendaInput.value = totalDenda;
            }
        } else {
            if(dendaDisplay) {
                dendaDisplay.innerHTML = '<div class="alert alert-success">Tidak ada keterlambatan</div>';
            }
            if(dendaInput) {
                dendaInput.value = 0;
            }
        }
    }
}

// ===== AUTO HIDE ALERTS =====
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
    
    const dateInputs = document.querySelectorAll('input[type="date"]');
    const today = new Date().toISOString().split('T')[0];
    dateInputs.forEach(input => {
        if(input.id === 'tanggal_sewa' || input.id === 'tanggal_kembali_aktual') {
            input.setAttribute('min', today);
        }
    });
});

// ===== PRINT FUNCTION =====
function printReport() {
    window.print();
}

function printDiv(divId) {
    var printContents = document.getElementById(divId).innerHTML;
    var originalContents = document.body.innerHTML;
    
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    window.location.reload();
}

// ===== EXPORT TO EXCEL - FIXED VERSION =====
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    
    if(!tableSelect) {
        alert('Table not found!');
        return;
    }
    
    // Clone table untuk manipulasi
    var tableClone = tableSelect.cloneNode(true);
    
    // Hapus badge/span yang tidak perlu, ambil text saja
    var badges = tableClone.querySelectorAll('.badge');
    badges.forEach(function(badge) {
        var text = badge.textContent;
        badge.replaceWith(document.createTextNode(text));
    });
    
    // Hapus tag <br> dan ganti dengan spasi
    var brs = tableClone.querySelectorAll('br');
    brs.forEach(function(br) {
        br.replaceWith(document.createTextNode(' '));
    });
    
    // Hapus tag <small>
    var smalls = tableClone.querySelectorAll('small');
    smalls.forEach(function(small) {
        var text = small.textContent;
        small.replaceWith(document.createTextNode(text));
    });
    
    // Hapus semua span
    var spans = tableClone.querySelectorAll('span');
    spans.forEach(function(span) {
        var text = span.textContent;
        span.replaceWith(document.createTextNode(text));
    });
    
    var tableHTML = tableClone.outerHTML.replace(/ /g, '%20');
    
    filename = filename ? filename + '.xls' : 'excel_data.xls';
    
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        downloadLink.download = filename;
        downloadLink.click();
    }
    
    document.body.removeChild(downloadLink);
}