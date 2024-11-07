{{-- resources/views/layouts/app.blade.php --}}
    <!DOCTYPE html>
<html>
<head>
    <title>Email Sender</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS (optional for better styling) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Summernote (Rich Text Editor) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs4.min.css" integrity="sha512-rDHV59PgRefDUbMm2lSjvf0ZhXZy3wgROFyao0JxZPGho3oOuWejq/ELx0FOZJpgaE5QovVtRN65Y3rrb7JhdQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <style>
        /* Custom styles can be added here */
        body {
            background-color: #f8f9fa;
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: none;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="container mt-4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('invoices.index') }}">PDF Manager</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    {{-- Email Management Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if(request()->routeIs('mail.*')) active @endif" href="#" id="emailDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Email Management
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="emailDropdown">
                            <li><a class="dropdown-item" href="{{ route('mail.create') }}">Odeslat Email</a></li>
                            <li><a class="dropdown-item" href="{{ route('mail.sentEmails') }}">Odeslané Emaily</a></li>
                            <li><a class="dropdown-item" href="{{ route('mail.statistics') }}">Statistika</a></li>
                        </ul>
                    </li>

                    {{-- Contacts Dropdown --}}
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('contacts.*')) active @endif" href="{{ route('contacts.index') }}">Kontakty</a>
                    </li>

                    {{-- Invoices Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if(request()->routeIs('invoices.*')) active @endif" href="#" id="invoiceDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Invoices
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="invoiceDropdown">
                            <li><a class="dropdown-item" href="{{ route('invoices.create') }}">Create Invoice</a></li>
                            <li><a class="dropdown-item" href="{{ route('invoices.index') }}">All Invoices</a></li>
                        </ul>
                    </li>

                    {{-- PDF Templates Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if(request()->routeIs('pdf-templates.*')) active @endif" href="#" id="pdfTemplatesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            PDF Templates
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="pdfTemplatesDropdown">
                            <li><a class="dropdown-item" href="{{ route('pdf-templates.index') }}">PDF Templates</a></li>
                            <li><a class="dropdown-item" href="{{ route('pdf-templates.create') }}">Add Template</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Main Content --}}
    @yield('content')
</div>

{{-- jQuery (required for Select2 and other plugins) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Summernote JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote.min.js" integrity="sha512-07bR+AJ2enmNU5RDrZkqMfVq06mQHgFxcmWN/hNSNY4E5SgYNOmTVqo/HCzrSxBhWU8mx3WB3ZJOixA9cRnCdA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@stack('scripts')
</body>
</html>
