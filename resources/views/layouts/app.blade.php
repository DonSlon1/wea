{{-- resources/views/layouts/app.blade.php --}}
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Invoice Manager')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- CodeMirror CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/theme/monokai.min.css">
    <!-- CodeMirror Hint CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/hint/show-hint.min.css">
    <!-- Custom CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .select2-container .select2-selection--single {
            height: 38px; /* Match Bootstrap's input height */
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
        }
        /* Adjust CodeMirror height to match textarea size */
        .CodeMirror {
            height: auto;
            min-height: 200px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="container mt-4">
    {{-- Navigation Bar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('invoices.index') }}">Invoice Manager</a>
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
                            <li><a class="dropdown-item" href="{{ route('mail.create') }}">Send Email</a></li>
                            <li><a class="dropdown-item" href="{{ route('mail.sentEmails') }}">Sent Emails</a></li>
                            <li><a class="dropdown-item" href="{{ route('mail.statistics') }}">Statistics</a></li>
                        </ul>
                    </li>

                    {{-- Contacts Link --}}
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('contacts.*')) active @endif" href="{{ route('contacts.index') }}">Contacts</a>
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
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <div>
                {{ session('error') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Main Content --}}
    @yield('content')
</div>

{{-- Bootstrap 5 JS Bundle (includes Popper) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- jQuery (for Select2) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- Select2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- CodeMirror JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/htmlmixed/htmlmixed.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/css/css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/javascript/javascript.min.js"></script>
{{-- CodeMirror Addons for Autocomplete --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/hint/show-hint.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/hint/show-hint.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/hint/anyword-hint.min.js"></script>
{{-- Optional: Additional Addons for Better Autocomplete --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/hint/xml-hint.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/hint/html-hint.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/hint/javascript-hint.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
@stack('scripts')
</body>
</html>
