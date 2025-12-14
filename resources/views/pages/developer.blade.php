@extends('layouts.admin.app')

@section('title', 'Identitas Pengembang')

@section('content')
<div class="content-wrapper-full">
    <div class="container-full py-4">
        {{-- Header --}}
        <div class="page-header-primary">
            <div>
                <h1>
                    <span class="icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </span>
                    Identitas Pengembang
                </h1>
                <p>Profil dan keahlian pengembang sistem</p>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Profile & Skills -->
            <div class="col-lg-8">
                <div class="card-universal mb-4">
                    <div class="card-body-universal">
                        <!-- Profile Header -->
                        <div class="row align-items-center">
                            <!-- Photo Column -->
                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <div class="profile-container">
                                    <div class="profile-photo-main">
                                        <img src="{{ asset('assets-admin/img/developerfoto.jpeg') }}"
                                             alt="Foto Pengembang"
                                             class="profile-img"
                                             onerror="this.src='https://ui-avatars.com/api/?name=Ridho+Prasetyo&size=250&background=3b82f6&color=fff'">
                                        {{-- Status indicator dihapus sesuai permintaan --}}
                                    </div>
                                </div>
                            </div>

                            <!-- Info Column -->
                            <div class="col-md-8">
                                <div class="profile-info">
                                    <h1 class="profile-name">Ridho Prasetyo</h1>
                                    <p class="profile-title">Web Developer & Data Analyst</p>

                                    <div class="profile-details">
                                        <div class="detail-row">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="#3b82f6" class="me-2">
                                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/>
                                            </svg>
                                            <div>
                                                <span class="detail-label">Kampus</span>
                                                <span class="detail-value">Politeknik Caltex Riau </span>
                                            </div>
                                        </div>

                                        <div class="detail-row">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="#3b82f6" class="me-2">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                            <div>
                                                <span class="detail-label">Jurusan</span>
                                                <span class="detail-value">Sistem Informasi</span>
                                            </div>
                                        </div>

                                        <div class="detail-row">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="#3b82f6" class="me-2">
                                                <path d="M9 11.75C8.31 11.75 7.75 12.31 7.75 13 7.75 13.69 8.31 14.25 9 14.25 9.69 14.25 10.25 13.69 10.25 13 10.25 12.31 9.69 11.75 9 11.75zM15 11.75C14.31 11.75 13.75 12.31 13.75 13 13.75 13.69 14.31 14.25 15 14.25 15.69 14.25 16.25 13.69 16.25 13 16.25 12.31 15.69 11.75 15 11.75zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                                            </svg>
                                            <div>
                                                <span class="detail-label">NIM</span>
                                                <span class="detail-value">2457301122</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="status-container">
                                        <span class="status-badge active">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            </svg>
                                            Available for Projects
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tech Skills Section -->
                <div class="card-universal">
                    <div class="card-body-universal">
                        <h3 class="section-title mb-4">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="#3b82f6" class="me-2">
                                <path d="M9.4 16.6L4.8 12l4.6-4.6L8 6l-6 6 6 6 1.4-1.4zm5.2 0l4.6-4.6-4.6-4.6L16 6l6 6-6 6-1.4-1.4z"/>
                            </svg>
                            Keahlian Teknis
                        </h3>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="skill-card">
                                    <div class="skill-icon bg-primary">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                                            <path d="M20.5 11H19V7c0-1.1-.9-2-2-2h-4V3.5C13 2.12 11.88 1 10.5 1S8 2.12 8 3.5V5H4c-1.1 0-1.99.9-1.99 2v3.8H3.5c1.49 0 2.7 1.21 2.7 2.7s-1.21 2.7-2.7 2.7H2V20c0 1.1.9 2 2 2h3.8v-1.5c0-1.49 1.21-2.7 2.7-2.7 1.49 0 2.7 1.21 2.7 2.7V22H17c1.1 0 2-.9 2-2v-4h1.5c1.38 0 2.5-1.12 2.5-2.5S21.88 11 20.5 11z"/>
                                        </svg>
                                    </div>
                                    <div class="skill-info">
                                        <div class="skill-name">Rekayasa Perangkat Lunak</div>
                                        <div class="skill-level">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 90%"></div>
                                            </div>
                                            <span>90%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="skill-card">
                                    <div class="skill-icon bg-info">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                                        </svg>
                                    </div>
                                    <div class="skill-info">
                                        <div class="skill-name">Oracle APEX</div>
                                        <div class="skill-level">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 75%"></div>
                                            </div>
                                            <span>75%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="skill-card">
                                    <div class="skill-icon bg-success">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                                            <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                        </svg>
                                    </div>
                                    <div class="skill-info">
                                        <div class="skill-name">Star UML</div>
                                        <div class="skill-level">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 85%"></div>
                                            </div>
                                            <span>85%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="skill-card">
                                    <div class="skill-icon bg-danger">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                                            <path d="M24 12l-12-12-12 12 12 12 12-12zm-12 10.647l-10.647-10.647 10.647-10.647 10.647 10.647-10.647 10.647z"/>
                                        </svg>
                                    </div>
                                    <div class="skill-info">
                                        <div class="skill-name">Laravel</div>
                                        <div class="skill-level">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 95%"></div>
                                            </div>
                                            <span>95%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="skill-card">
                                    <div class="skill-icon bg-warning">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/>
                                        </svg>
                                    </div>
                                    <div class="skill-info">
                                        <div class="skill-name">MySQL</div>
                                        <div class="skill-level">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 90%"></div>
                                            </div>
                                            <span>90%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="skill-card">
                                    <div class="skill-icon bg-secondary">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                                            <path d="M9.4 16.6L4.8 12l4.6-4.6L8 6l-6 6 6 6 1.4-1.4zm5.2 0l4.6-4.6-4.6-4.6L16 6l6 6-6 6-1.4-1.4z"/>
                                        </svg>
                                    </div>
                                    <div class="skill-info">
                                        <div class="skill-name">PHP</div>
                                        <div class="skill-level">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 88%"></div>
                                            </div>
                                            <span>88%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Contact & Social Media -->
            <div class="col-lg-4">
                <div class="card-universal">
                    <div class="card-body-universal">
                        <h3 class="section-title mb-4">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="#3b82f6" class="me-2">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z"/>
                            </svg>
                            Kontak & Media Sosial
                        </h3>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <a href="https://wa.me/6289620830" target="_blank" class="contact-card whatsapp">
                                    <div class="contact-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M16.75 13.96c.25.13.41.2.46.3.06.11.04.61-.21 1.18-.2.56-1.24 1.1-1.7 1.12-.46.02-.47.36-2.96-.73-2.49-1.09-3.99-3.75-4.11-3.92-.12-.17-.96-1.38-.92-2.61.05-1.22.69-1.8.95-2.04.24-.26.51-.29.68-.26h.47c.15 0 .36-.06.55.45l.69 1.87c.06.13.1.28.01.44l-.27.41-.39.42c-.12.12-.26.25-.12.5.12.26.62 1.09 1.32 1.78.91.88 1.71 1.17 1.95 1.3.24.14.39.12.54-.04l.81-.94c.19-.25.35-.19.58-.11l1.67.88M12 2a10 10 0 0110 10 10 10 0 01-10 10c-1.97 0-3.8-.57-5.35-1.55L2 22l1.55-4.65A9.969 9.969 0 012 12 10 10 0 0112 2m0 2a8 8 0 00-8 8c0 1.72.54 3.31 1.46 4.61L4.5 19.5l2.89-.96A7.95 7.95 0 0012 20a8 8 0 008-8 8 8 0 00-8-8z"/>
                                        </svg>
                                    </div>
                                    <div class="contact-info">
                                        <div class="contact-title">WhatsApp</div>
                                        <div class="contact-detail">+62 896-2083-</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 mb-3">
                                <a href="https://www.linkedin.com/in/ridho-prasetyo-0497b2390/" target="_blank" class="contact-card linkedin">
                                    <div class="contact-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                    </div>
                                    <div class="contact-info">
                                        <div class="contact-title">LinkedIn</div>
                                        <div class="contact-detail">ridho-prasetyo</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 mb-3">
                                <a href="https://github.com/ridho140905" target="_blank" class="contact-card github">
                                    <div class="contact-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                        </svg>
                                    </div>
                                    <div class="contact-info">
                                        <div class="contact-title">GitHub</div>
                                        <div class="contact-detail">ridho-prasetyo</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 mb-3">
                                <a href="https://www.instagram.com/rdhprasetyo" target="_blank" class="contact-card instagram">
                                    <div class="contact-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                        </svg>
                                    </div>
                                    <div class="contact-info">
                                        <div class="contact-title">Instagram</div>
                                        <div class="contact-detail">@ridho.prasetyo</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-color: #3b82f6;
    --secondary-color: #64748b;
    --success-color: #10b981;
    --danger-color: #ef4444;
    --warning-color: #f59e0b;
    --info-color: #0ea5e9;
    --light-color: #f8fafc;
    --dark-color: #1e293b;
    --border-radius: 12px;
    --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Profile Container */
.profile-container {
    padding: 10px;
}

.profile-photo-main {
    position: relative;
    width: 280px;
    height: 280px;
    margin: 0 auto;
}

.profile-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 20px;
    border: 5px solid white;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

/* Profile Info */
.profile-info {
    padding-left: 20px;
}

.profile-name {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 5px;
    line-height: 1.2;
}

.profile-title {
    font-size: 1.1rem;
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 25px;
}

.profile-details {
    margin-bottom: 20px;
}

.detail-row {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
    padding: 10px;
    background: #f8fafc;
    border-radius: 8px;
    transition: background 0.2s ease;
}

.detail-row:hover {
    background: #f1f5f9;
}

.detail-label {
    display: block;
    font-size: 0.85rem;
    color: var(--secondary-color);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}

.detail-value {
    display: block;
    font-size: 1rem;
    color: var(--dark-color);
    font-weight: 600;
}

.status-container {
    margin-top: 15px;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 600;
}

.status-badge.active {
    background: linear-gradient(135deg, var(--success-color), #34d399);
    color: white;
    box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);
}

/* Section Title */
.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark-color);
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e2e8f0;
}

/* Skill Cards */
.skill-card {
    display: flex;
    align-items: center;
    padding: 15px;
    background: white;
    border-radius: var(--border-radius);
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    height: 100%;
}

.skill-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--box-shadow);
    border-color: var(--primary-color);
}

.skill-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0;
}

.skill-icon.bg-primary { background-color: var(--primary-color); }
.skill-icon.bg-success { background-color: var(--success-color); }
.skill-icon.bg-danger { background-color: var(--danger-color); }
.skill-icon.bg-warning { background-color: var(--warning-color); }
.skill-icon.bg-info { background-color: var(--info-color); }
.skill-icon.bg-secondary { background-color: var(--secondary-color); }

.skill-info {
    flex-grow: 1;
}

.skill-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 8px;
}

.skill-level {
    display: flex;
    align-items: center;
    gap: 10px;
}

.progress-bar {
    flex-grow: 1;
    height: 6px;
    background: #e2e8f0;
    border-radius: 3px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    border-radius: 3px;
}

.skill-card:nth-child(1) .progress-fill { background: var(--primary-color); }
.skill-card:nth-child(2) .progress-fill { background: var(--info-color); }
.skill-card:nth-child(3) .progress-fill { background: var(--success-color); }
.skill-card:nth-child(4) .progress-fill { background: var(--danger-color); }
.skill-card:nth-child(5) .progress-fill { background: var(--warning-color); }
.skill-card:nth-child(6) .progress-fill { background: var(--secondary-color); }

.skill-level span {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--secondary-color);
    min-width: 35px;
}

/* Contact Cards */
.contact-card {
    display: flex;
    align-items: center;
    padding: 15px;
    border-radius: var(--border-radius);
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
    height: 100%;
    background: white;
}

.contact-card:hover {
    transform: translateY(-3px);
    text-decoration: none;
    box-shadow: var(--box-shadow);
}

.contact-card.whatsapp:hover { border-color: #25d366; }
.contact-card.linkedin:hover { border-color: #0077b5; }
.contact-card.github:hover { border-color: #24292e; }
.contact-card.instagram:hover { border-color: #e1306c; }

.contact-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0;
}

.contact-card.whatsapp .contact-icon {
    background-color: rgba(37, 211, 102, 0.1);
    color: #25d366;
}

.contact-card.linkedin .contact-icon {
    background-color: rgba(0, 119, 181, 0.1);
    color: #0077b5;
}

.contact-card.github .contact-icon {
    background-color: rgba(36, 41, 46, 0.1);
    color: #24292e;
}

.contact-card.instagram .contact-icon {
    background-color: rgba(225, 48, 108, 0.1);
    color: #e1306c;
}

.contact-info {
    flex-grow: 1;
}

.contact-title {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 4px;
}

.contact-detail {
    font-size: 0.95rem;
    color: var(--secondary-color);
}

/* Responsive */
@media (max-width: 768px) {
    .profile-photo-main {
        width: 220px;
        height: 220px;
    }

    .profile-info {
        padding-left: 0;
        margin-top: 20px;
        text-align: center;
    }

    .profile-name {
        font-size: 1.8rem;
    }

    .detail-row {
        justify-content: center;
        text-align: left;
    }

    .section-title {
        justify-content: center;
    }
}

/* Animation */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.profile-img {
    animation: fadeIn 0.5s ease-in;
}

.skill-card, .contact-card {
    animation: fadeIn 0.6s ease forwards;
    opacity: 0;
}

.skill-card:nth-child(1) { animation-delay: 0.1s; }
.skill-card:nth-child(2) { animation-delay: 0.2s; }
.skill-card:nth-child(3) { animation-delay: 0.3s; }
.skill-card:nth-child(4) { animation-delay: 0.4s; }
.skill-card:nth-child(5) { animation-delay: 0.5s; }
.skill-card:nth-child(6) { animation-delay: 0.6s; }

.contact-card:nth-child(1) { animation-delay: 0.1s; }
.contact-card:nth-child(2) { animation-delay: 0.2s; }
.contact-card:nth-child(3) { animation-delay: 0.3s; }
.contact-card:nth-child(4) { animation-delay: 0.4s; }
</style>
@endsection
