<!-- START CSS -->
<!-- Tailwind is included -->
<link rel="stylesheet" href="{{ asset('assets-admin/css/main.css') }}?v=1628755089081">

<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets-admin/apple-touch-icon.png') }}"/>
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets-admin/favicon-32x32.png') }}"/>
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets-admin/favicon-16x16.png') }}"/>
<link rel="mask-icon" href="{{ asset('assets-admin/safari-pinned-tab.svg') }}" color="#00b4b6"/>

<meta name="description" content="Admin Dashboard">

<style>
    /* ====== STYLE UNIVERSAL UNTUK SEMUA HALAMAN ADMIN ====== */

    /* Container utama - FULL WIDTH */
    .container-full {
        max-width: 100% !important;
        width: 100% !important;
        padding-left: 20px;
        padding-right: 20px;
        margin: 0 auto;
    }

    /* Content wrapper full width dengan footer fix */
    .content-wrapper-full {
        min-height: calc(100vh - 120px);
        background-color: #f8f9fa;
        width: 100%;
        position: relative;
        padding-bottom: 60px;
    }

    /* Header card biru universal - FULL WIDTH */
    .page-header-primary {
        background: linear-gradient(135deg, #4a8ef3, #3b77e2);
        color: white;
        border-radius: 12px;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .page-header-primary h1 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: white;
    }

    .page-header-primary p {
        margin-bottom: 0;
        opacity: 0.9;
        color: white;
    }

    /* Tabel universal - FULL WIDTH */
    .universal-table {
        border-collapse: separate;
        border-spacing: 0 8px;
        width: 100%;
        margin-bottom: 0;
    }

    .universal-table thead {
        background-color: #f8f9fc;
        border-bottom: 2px solid #e9ecef;
    }

    .universal-table thead th {
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        color: #495057;
        border: none;
        padding: 1rem 1rem;
        font-weight: 600;
        vertical-align: middle;
        white-space: nowrap;
    }

    .universal-table tbody tr {
        background-color: #ffffff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.2s ease-in-out;
        border-radius: 8px;
    }

    .universal-table tbody tr:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transform: translateY(-1px);
    }

    .universal-table tbody td {
        padding: 1rem 1rem;
        vertical-align: middle;
        border: none;
        border-top: 1px solid #f8f9fa;
        white-space: nowrap;
    }

    /* Badge universal */
    .universal-badge {
        border-radius: 10px;
        font-size: 0.8rem;
        padding: 6px 10px;
        font-weight: 500;
        display: inline-block;
    }

    .badge-secondary { background-color: #adb5bd !important; color: white; }
    .badge-info { background-color: #0dcaf0 !important; color: #000; }
    .badge-warning { background-color: #ffc107 !important; color: #000; }
    .badge-success { background-color: #198754 !important; color: #fff; }
    .badge-primary { background-color: #0d6efd !important; color: #fff; }
    .badge-danger { background-color: #dc3545 !important; color: #fff; }

    /* Tombol universal untuk header */
    .btn-light-universal {
        background-color: #ffffff !important;
        color: #0d6efd !important;
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        transition: all 0.2s ease-in-out;
    }

    .btn-light-universal:hover {
        background-color: #f1f3f9 !important;
        transform: translateY(-1px);
        color: #0d6efd !important;
    }

    /* Card universal - FULL WIDTH */
    .card-universal {
        border-radius: 15px;
        overflow: hidden;
        background-color: #fff;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        width: 100%;
        margin-bottom: 2rem;
    }

    .card-body-universal {
        padding: 0;
        width: 100%;
    }

    /* Alert universal */
    .alert-universal {
        border-radius: 10px;
        font-weight: 500;
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
        width: 100%;
    }

    /* Table responsive universal - FULL WIDTH */
    .table-responsive-universal {
        border-radius: 15px;
        width: 100%;
    }

    /* Empty state universal */
    .empty-state-universal {
        color: #6c757d;
        text-align: center;
        padding: 2rem;
        font-style: italic;
    }

    /* Text styling */
    .text-muted-universal {
        color: #6c757d !important;
    }

    .fw-semibold-universal {
        font-weight: 600;
    }

    /* Footer styling */
    .universal-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
        padding: 1rem 0;
        margin-top: auto;
        position: relative;
        bottom: 0;
        width: 100%;
    }

    /* Layout untuk footer */
    html, body {
        height: 100%;
    }

    .admin-layout {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .admin-main-content {
        flex: 1;
        padding-bottom: 2rem;
    }

    /* Responsive design */
    @media (max-width: 1200px) {
        .container-full {
            padding-left: 15px;
            padding-right: 15px;
        }
    }

    @media (max-width: 768px) {
        .page-header-primary {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
            padding: 1rem;
        }

        .universal-table {
            font-size: 0.875rem;
        }

        .universal-table thead th,
        .universal-table tbody td {
            padding: 0.75rem 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .page-header-primary h1 {
            font-size: 1.5rem;
        }

        .container-full {
            padding-left: 10px;
            padding-right: 10px;
        }
    }

    /* Floating WhatsApp - Simple & Clean */
.floating-whatsapp {
    position: fixed;
    bottom: 25px;
    right: 25px;
    z-index: 1000;
}

.whatsapp-float {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    background-color: #25D366;
    border-radius: 50%;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
    text-decoration: none;
}

.whatsapp-float:hover {
    background-color: #128C7E;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    transform: translateY(-2px);
}

.whatsapp-icon {
    width: 30px;
    height: 30px;
}

/* Responsive */
@media (max-width: 768px) {
    .floating-whatsapp {
        bottom: 20px;
        right: 20px;
    }

    .whatsapp-float {
        width: 55px;
        height: 55px;
    }

    .whatsapp-icon {
        width: 28px;
        height: 28px;
    }
}
.navbar-item-button,
.desktop-logout-button {
    display: flex;
    align-items: center;
    background: none;
    border: none;
    color: #4a5568;
    cursor: pointer;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    text-decoration: none;
    width: 100%;
}
    /* Force full width for tables */
    .table-responsive-universal .universal-table {
        min-width: 100%;
    }

/* ===== PERBAIKAN TOMBOL AKSI ===== */
.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
    align-items: center;
    min-height: 40px;
}

.action-buttons form {
    display: flex !important;
    margin: 0 !important;
}

.btn-edit, .btn-delete {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    padding: 0;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.btn-edit {
    background-color: #ffc107;
    color: #000;
}

.btn-edit:hover {
    background-color: #e0a800;
    transform: translateY(-1px);
}

.btn-delete {
    background-color: #dc3545;
    color: #fff;
}

.btn-delete:hover {
    background-color: #c82333;
    transform: translateY(-1px);
}

/* Memastikan kolom aksi memiliki width yang konsisten */
.universal-table th.text-center:last-child,
.universal-table td.text-center:last-child {
    width: 120px;
    min-width: 120px;
    max-width: 120px;
}

/* Memastikan tombol tetap sejajar di semua kondisi */
.universal-table tbody td.text-center {
    vertical-align: middle !important;
}
</style>
<!-- END CSS -->
