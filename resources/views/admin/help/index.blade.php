@extends('admin.layouts.app')
@section('title', 'Help & Guide')
@section('page-title', 'Help & Guide')

@push('styles')
<style>
    .accordion-button:not(.collapsed) {
        background-color: var(--primary-light);
        color: var(--primary-dark);
        font-weight: 600;
        box-shadow: inset 0 -1px 0 rgba(0,0,0,.125);
    }
    .accordion-item {
        border: 1px solid var(--border);
        margin-bottom: 12px;
        border-radius: var(--radius) !important;
        overflow: hidden;
        background: var(--surface);
    }
    .accordion-button:focus {
        box-shadow: 0 0 0 3px rgba(0,102,204,0.12);
    }
    .accordion-body {
        color: var(--text-primary);
        font-size: 14.5px;
        line-height: 1.6;
    }
    .accordion-body ul, .accordion-body ol {
        margin-bottom: 0;
        padding-left: 20px;
    }
    .accordion-body li {
        margin-bottom: 8px;
    }
    .accordion-body p {
        margin-bottom: 12px;
    }
    
    .example-box {
        background: rgba(0, 102, 204, 0.04);
        border-left: 4px solid var(--primary);
        padding: 12px 16px;
        border-radius: 6px;
        margin-top: 10px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 13.5px;
        color: var(--primary-dark);
        font-weight: 500;
    }
    .example-box code {
        background: rgba(0, 102, 204, 0.12);
        padding: 3px 6px;
        border-radius: 4px;
        color: var(--primary-dark);
        font-weight: 700;
        font-size: 13px;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="quick-nav">
        <!-- Quick Navigation -->
        <h6 class="text-muted fw-bold text-uppercase mb-2" style="font-size: 11px; letter-spacing: 0.05em;">
            <i class="bi bi-list-stars me-1"></i> {{ $lang === 'id' ? 'Navigasi Cepat' : 'Quick Navigation' }}
        </h6>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill border-0 bg-white shadow-sm" onclick="openAccordion('collapseOne')">{{ $lang === 'id' ? 'Sistem' : 'Overview' }}</button>
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill border-0 bg-white shadow-sm" onclick="openAccordion('collapseTwo')">Workflow</button>
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill border-0 bg-white shadow-sm" onclick="openAccordion('collapseThree')">{{ $lang === 'id' ? 'Formulir' : 'Forms' }}</button>
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill border-0 bg-white shadow-sm" onclick="openAccordion('collapseFour')">{{ $lang === 'id' ? 'Zonasi Kursi' : 'Seats' }}</button>
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill border-0 bg-white shadow-sm" onclick="openAccordion('collapseFive')">{{ $lang === 'id' ? 'Istilah' : 'Glossary' }}</button>
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill border-0 bg-white shadow-sm" onclick="openAccordion('collapseSix')">Sidebar</button>
            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill border-0 bg-white shadow-sm" onclick="openAccordion('collapseSeven')">Troubleshooting</button>
        </div>
    </div>

    <div class="btn-group align-self-start" role="group" aria-label="Language Switcher">
        <a href="{{ route('admin.help', ['lang' => 'en']) }}" class="btn {{ $lang === 'en' ? 'btn-primary' : 'btn-outline-primary' }}">English</a>
        <a href="{{ route('admin.help', ['lang' => 'id']) }}" class="btn {{ $lang === 'id' ? 'btn-primary' : 'btn-outline-primary' }}">Indonesia</a>
    </div>
</div>

<div class="accordion" id="helpAccordion">
    <!-- System Overview -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <i class="bi bi-info-circle me-2"></i> {{ $lang === 'id' ? 'Gambaran Sistem' : 'System Overview' }}
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#helpAccordion">
            <div class="accordion-body">
                @if($lang === 'id')
                    <p>Platform pemesanan tiket pesawat (Avoinex) ini memungkinkan administrator untuk mengelola seluruh aspek penerbangan, mulai dari maskapai, armada pesawat, rute jadwal, hingga pengelolaan tiket pelanggan.</p>
                    <p>Sistem ini dirancang untuk memberikan kontrol penuh atas semua data penerbangan yang ditampilkan kepada konsumen di halaman utama pencarian dan pemesanan.</p>
                @else
                    <p>This airline booking platform (Avoinex) allows administrators to manage all aspects of flights, from airlines, aircraft fleets, route schedules, to managing customer bookings.</p>
                    <p>The system is designed to provide full control over all flight data displayed to consumers on the main search and booking pages.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Admin Workflow -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <i class="bi bi-diagram-3 me-2"></i> {{ $lang === 'id' ? 'Alur Kerja Administrator (Workflow)' : 'Admin Workflow' }}
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#helpAccordion">
            <div class="accordion-body">
                @if($lang === 'id')
                    <p>Ikuti urutan pembuatan data yang benar ini agar jadwal penerbangan bisa muncul dan dicari di halaman utama konsumen:</p>
                    <ol>
                        <li><strong>Airlines (Maskapai):</strong> Buat data maskapai terlebih dahulu. Maskapai dibutuhkan untuk menentukan operator pesawat.</li>
                        <li><strong>Aircraft (Pesawat):</strong> Tambahkan pesawat, tentukan konfigurasi zonasi kursinya secara tepat, lalu hubungkan ke maskapai.</li>
                        <li><strong>Airports (Bandara):</strong> Pastikan bandara asal (Origin) dan bandara tujuan (Destination) Anda sudah terdaftar dan berstatus aktif (Active = Yes).</li>
                        <li><strong>Schedules (Jadwal Basis):</strong> Buat rencana rute dasar dengan jadwal perkiraan keberangkatan dan kedatangan berulang.</li>
                        <li><strong>Flight Instances (Penerbangan Aktual):</strong> Aktifkan jadwal dasar dengan membuat instansi penerbangan aktual pada tanggal/hari spesifik agar tersedia untuk dipesan.</li>
                    </ol>
                @else
                    <p>Follow this strictly defined data creation order so flights correctly appear and are searchable on the homepage:</p>
                    <ol>
                        <li><strong>Airlines:</strong> Create airline data first. The airline acts as the operator for the aircraft.</li>
                        <li><strong>Aircraft:</strong> Add an aircraft, accurately define its passenger seat zones configuration, and assign it to an airline.</li>
                        <li><strong>Airports:</strong> Ensure both the Origin and Destination airports are registered in the system and set to Active status.</li>
                        <li><strong>Schedules:</strong> Create a basic recurring route plan outlining estimated departure and arrival times.</li>
                        <li><strong>Flight Instances:</strong> Activate the basic schedule by creating an actual flight instance for a specific date, making it finally available for booking.</li>
                    </ol>
                @endif
            </div>
        </div>
    </div>

    <!-- Form Input Guide -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <i class="bi bi-pencil-square me-2"></i> {{ $lang === 'id' ? 'Panduan Pengisian Form' : 'Form Input Guide' }}
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#helpAccordion">
            <div class="accordion-body">
                @if($lang === 'id')
                    <p>Agar sistem berfungsi dengan baik dan tampilan bersih, pastikan format input mematuhi ekspektasi standar industri penerbangan:</p>
                    <ul>
                        <li>
                            <strong>Kode Penerbangan (Flight Code):</strong> 2 huruf kode IATA diikuti dengan 3-4 angka.
                            <div class="example-box">Contoh: <code>GA513</code>, <code>JT612</code>, <code>QZ701</code></div>
                        </li>
                        <li>
                            <strong>Registrasi Pesawat (Registration Number):</strong> Format huruf/angka standar registrasi pesawat internasional.
                            <div class="example-box">Contoh: <code>PK-GEA</code>, <code>N123AA</code>, <code>9V-SMC</code></div>
                        </li>
                        <li>
                            <strong>Kode Bandara (Airport IATA Code):</strong> Wajib tepat 3 huruf kode bandara internasional resmi.
                            <div class="example-box">Contoh: <code>CGK</code> (Soekarno-Hatta), <code>DPS</code> (Ngurah Rai), <code>SIN</code> (Changi)</div>
                        </li>
                    </ul>
                @else
                    <p>For the system to function correctly and remain presentable, ensure input formats strictly follow aviation industry standards:</p>
                    <ul>
                        <li>
                            <strong>Flight Code:</strong> A 2-letter IATA airline code followed by 3-4 digits.
                            <div class="example-box">Example: <code>GA513</code>, <code>JT612</code>, <code>QZ701</code></div>
                        </li>
                        <li>
                            <strong>Aircraft Registration Number:</strong> Standard alphanumeric format for international aircraft registration.
                            <div class="example-box">Example: <code>PK-GEA</code>, <code>N123AA</code>, <code>9V-SMC</code></div>
                        </li>
                        <li>
                            <strong>Airport IATA Code:</strong> Must be exactly 3 letters representing the official international airport code.
                            <div class="example-box">Example: <code>CGK</code> (Soekarno-Hatta), <code>DPS</code> (Ngurah Rai), <code>SIN</code> (Changi)</div>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <!-- Seat System Explanation -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingFour">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                <i class="bi bi-grid-3x3 me-2"></i> {{ $lang === 'id' ? 'Penjelasan Sistem Zonasi Kursi' : 'Seat System Explanation' }}
            </button>
        </h2>
        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#helpAccordion">
            <div class="accordion-body">
                @if($lang === 'id')
                    <p>Kursi penumpang terbagi menjadi tiga kelas/zona utama, masing-masing dengan nilai dan kenyamanan yang berbeda:</p>
                    <ul>
                        <li><strong>Business Class (Kelas Bisnis):</strong> Kursi premium di baris depan pesawat. Menawarkan ruang yang jauh lebih luas dan fasilitas ekstra.</li>
                        <li><strong>Preferred Zone (Ruang Kaki Ekstra):</strong> Kursi khusus yang biasanya terletak di dekat pintu darurat (Exit row) atau di bagian depan kabin ekonomi. Menawarkan jarak antar kursi (legroom) lebih besar daripada ekonomi biasa.</li>
                        <li><strong>Economy (Ekonomi Standar):</strong> Kursi dasar untuk mayoritas kabin bagian tengah dan belakang pesawat.</li>
                    </ul>
                    <div class="alert alert-warning mt-3 mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i> <strong>Sangat Penting:</strong> Saat mengkonfigurasi baris kursi pada formulir Pesawat (Aircraft), dilarang tumpang tindih urutan baris. Rentang baris antara rentang Bisnis, rentang Preferred, dan jumlah total Ekonomi tak boleh bertabrakan.
                    </div>
                @else
                    <p>Passenger seats are divided into three main classes/zones, each offering distinct value and comfort levels:</p>
                    <ul>
                        <li><strong>Business Class:</strong> Premium seating in the front rows of the aircraft. Offers vastly superior space and extra amenities.</li>
                        <li><strong>Preferred Zone (Extra Legroom):</strong> Special seats usually located at emergency exit rows or the front of the economy cabin. Offers significantly more legroom compared to standard economy.</li>
                        <li><strong>Economy (Standard Economy):</strong> The baseline seating populating the majority of the middle and rear cabin.</li>
                    </ul>
                    <div class="alert alert-warning mt-3 mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i> <strong>Extremely Important:</strong> When configuring seat rows in the Aircraft creation/edit form, row index overlapping is prohibited. The ranges for Business, Preferred, and Economy rows must be strictly mutually exclusive and continuous.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Terminology / Glossary -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingFive">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                <i class="bi bi-journal-text me-2"></i> {{ $lang === 'id' ? 'Daftar Istilah (Glosarium)' : 'Terminology / Glossary' }}
            </button>
        </h2>
        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#helpAccordion">
            <div class="accordion-body">
                @if($lang === 'id')
                    <ul>
                        <li><strong>Legroom:</strong> Jarak/ruang kaki antara punggung kursi dengan kursi persis di depannya.</li>
                        <li><strong>Preferred Zone:</strong> Zona kursi khusus yang memiliki tarif biaya tambahan di atas ekonomi biasa karena posisinya yang strategis (misalnya di dekat jendela, pintu keluar, atau bagian depan kabin).</li>
                        <li><strong>Seat Configuration:</strong> Pola pengaturan kolom kursi melintasi badan pesawat (misal: 3-3 untuk lorong tunggal, atau 3-4-3 untuk pesawat badan lebar/wide-body).</li>
                        <li><strong>Boarding:</strong> Proses saat penumpang memasuki kabin pesawat.</li>
                        <li><strong>Cabin Layout:</strong> Cetak biru fisik bagian dalam pesawat termasuk kelas kursi, letak toilet, dan dapur pesawat (galley).</li>
                    </ul>
                @else
                    <ul>
                        <li><strong>Legroom:</strong> The physical space available for your legs between your seat and the seat immediately in front of it.</li>
                        <li><strong>Preferred Zone:</strong> Highly sought-after seats demanding an added fee over standard economy due to strategic locations (e.g., exit rows, bulkhead, or front cab sections).</li>
                        <li><strong>Seat Configuration:</strong> The cross-cabin column layout arrangement (e.g., 3-3 layout for a single-aisle narrow-body, or 3-4-3 for a wide-body jumbo).</li>
                        <li><strong>Boarding:</strong> The formal process of passengers embarking and entering the aircraft cabin.</li>
                        <li><strong>Cabin Layout:</strong> The internal physical blueprint of the aircraft including class seating borders, lavatories, and galleys.</li>
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar Explanation -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingSix">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                <i class="bi bi-layout-sidebar me-2"></i> {{ $lang === 'id' ? 'Fungsi Menu Panel' : 'Sidebar Menu Explanation' }}
            </button>
        </h2>
        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#helpAccordion">
            <div class="accordion-body">
                @if($lang === 'id')
                    <ul>
                        <li><strong>Dashboard:</strong> Menampilkan ringkasan metrik statistik tingkat tinggi dan performa penjualan tiket terkini.</li>
                        <li><strong>Aircraft (Pesawat):</strong> Modul untuk melakukan inventarisasi pesawat terbang dan presisi zonasi duduk kabin.</li>
                        <li><strong>Schedules (Jadwal Basis):</strong> Mengelola struktur jadwal rute reguler (Origin, Destinasi, Durasi, Harga).</li>
                        <li><strong>Flight Instances (Jadwal Riil):</strong> Menginisiasi ketersediaan terbang tiket jadwal pada jam dan tanggal sungguhan.</li>
                        <li><strong>Bookings (Pemesanan):</strong> Rekaman basis data riwayat pembelian dari nasabah yang telah berhasil melalui portal bayar (Checkout).</li>
                        <li><strong>Data Master (Airports/Manufacturers/Countries/Airlines):</strong> Entitas referensi krusial yang diperlukan oleh seluruh kerangka modul penjadwalan.</li>
                    </ul>
                @else
                    <ul>
                        <li><strong>Dashboard:</strong> Displays high-level statistical health metrics and recent ticket sales performance.</li>
                        <li><strong>Aircraft:</strong> Module targeting flying fleet inventory and granular cabin seating assignments.</li>
                        <li><strong>Schedules (Base Route Plan):</strong> Administering regular route structures (Origin, Destination, Base Duration, Price Index).</li>
                        <li><strong>Flight Instances (Actualized Dates):</strong> Trigger schedules to become active purchasable flight events occurring on genuine real dates and times.</li>
                        <li><strong>Bookings (Orders):</strong> Relational historic records capturing confirmed customer checkouts/tickets paid through the portal gateway.</li>
                        <li><strong>Master Data (Airports/Manufacturers/Countries/Airlines):</strong> Crucial referencing entities essentially forming the skeleton depended on by every single scheduling module.</li>
                    </ul>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Troubleshooting -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingSeven">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                <i class="bi bi-wrench-adjustable me-2"></i> {{ $lang === 'id' ? 'Pemecahan Masalah (Troubleshooting)' : 'Troubleshooting Issues' }}
            </button>
        </h2>
        <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#helpAccordion">
            <div class="accordion-body">
                @if($lang === 'id')
                    <p>Temukan solusi dari isu-isu teknis penggunaan panel sistem yang paling umum terjadi:</p>
                    <ul>
                        <li>
                            <strong>Masalah: Penerbangan Tidak Muncul di Beranda Pencarian Pencari Tiket.</strong>
                            <br><em>Sebab Umum:</em> 
                            Anda belum men-generate "Flight Instance" dengan tanggal aktual tersebut. Selain itu, pastikan status Flight aktif (Aktif = Ya), dan bandara Origin dan Tujuan diset ke 'Active'.
                        </li>
                        <li>
                            <strong>Masalah: Ticket Booking (Pesanan) Ditolak atau Error di Form Pemesanan.</strong>
                            <br><em>Sebab Umum:</em>
                            Jika pesawat terlalu cepat terisi habis terjual atau jumlah reservasi penumpang telah melanggar/melebihi limit kapasitas maksimal armada spesifik bersangkutan.
                        </li>
                        <li>
                            <strong>Masalah: Peta Kabin Seat Kosong atau Hancur Saat Pemilihan Kursi.</strong>
                            <br><em>Sebab Umum:</em>
                            Hal ini mutlak akibat parameter "Row" (Baris) di form profil Aircraft tidak terisi linear atau terdapat tumpang tindih hitungan antara sel Bisnis ke sel Ekonomi.
                        </li>
                    </ul>
                @else
                    <p>Find diagnostic solutions for the most frequent technical roadblocks traversing the administrative control panel:</p>
                    <ul>
                        <li>
                            <strong>Issue: Flight Simply Won't Appear Upon Homepage Traversal Searches.</strong>
                            <br><em>Likely Cause:</em>
                            You solely outlined a 'Schedule' but neglected to instantiate a real physical "Flight Instance" linking to the specified customer date inquiry. Additionally, review that both referenced origin/destination Airport nodes stay strictly toggled as "Active".
                        </li>
                        <li>
                            <strong>Issue: Booking Pipeline Crashed / Fails to Allocate Ticket.</strong>
                            <br><em>Likely Cause:</em>
                            The reserved seats count globally breached max aircraft capacity arrays allocated inside the particular assigned aircraft parameters.
                        </li>
                        <li>
                            <strong>Issue: Cabin Seat Mapping Grid Rendering Empty or Distorted during Selection.</strong>
                            <br><em>Likely Cause:</em>
                            This entirely origins from erroneous "Row" mapping logic when initially committing Aircraft profiling data. Validate that your numbered tiers for Business, Preferred, and Economy span strictly linearly absent of mathematical skipping/colliding integers.
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </div>
    
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // 1. LocalStorage Language Retention
        const urlParams = new URLSearchParams(window.location.search);
        const currentLangParam = urlParams.get('lang');
        
        if (currentLangParam) {
            // Save current selection to localStorage
            localStorage.setItem('admin_help_lang', currentLangParam);
        } else {
            // Check if there's a saved language, and if it's not the default 'en', redirect
            const savedLang = localStorage.getItem('admin_help_lang');
            // If the server gave us 'en' (default) but the user previously picked 'id'
            if (savedLang && savedLang === 'id' && '{{ $lang }}' !== 'id') {
                window.location.replace("{{ route('admin.help') }}?lang=" + savedLang);
            }
        }
    });

    // 2. Quick Navigation Accordion Open logic
    function openAccordion(id) {
        let el = document.getElementById(id);
        if (el) {
            // Check if collapsible instance already exists, or create one
            let bsCollapse = bootstrap.Collapse.getInstance(el);
            if (!bsCollapse) {
                bsCollapse = new bootstrap.Collapse(el, {toggle: false});
            }
            
            // Open the accordion
            bsCollapse.show();
            
            // Scroll to it smoothly
            setTimeout(() => {
                el.parentElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 300); // Give it a bit of time to transition the height
        }
    }
</script>
@endpush
