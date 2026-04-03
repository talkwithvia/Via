@extends('adminlte::page')
@section('meta_tags')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.jpg') }}" type="image/x-icon">
@stop

{{-- Extend and customize the browser title --}}
@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle')
        | @yield('subtitle')
    @endif
@stop

{{-- Extend and customize the page content header --}}
@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted text-capitalize">
            @yield('content_header_title')

            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
    @yield('content_body')
@stop

{{-- Create a common footer --}}
@section('footer')
    <div class="float-right">
        copyright &copy;
        <b>
            <script>
                document.write(new Date().getFullYear())
            </script>
        </b>

    </div>

    <strong>
        <a href="{{ config('app.company_url', '#') }}">
            {{ config('app.company_name', 'My company') }}
        </a>
    </strong>
@stop
@push('css')
    <style type="text/css">
        .file-upload-area {
            transition: all 0.3s ease;
            border: 2px dashed #dee2e6;
        }

        .file-upload-area:hover {
            border-color: #0d6efd;
            background-color: #f8f9fa;
        }

        .border-dashed {
            border-style: dashed !important;
        }

        thead th {
            vertical-align: middle;
            font-size: 14px;
        }

        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px) !important;
            border-radius: .25rem !important;
            padding: .375rem .75rem !important;
            border: 1px solid #ced4da !important;
            background-color: #fff !important;
            background-image: none !important;
            box-shadow: none !important;
            color: #495057 !important;
            width: 100% !important;
        }

        .select {
            width: 100% !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" />
@endpush

@push('js')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <!-- JSZip (required for Excel export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- pdfmake (required for PDF export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function() {
            $('.chosen-select').chosen({
                width: '100%',
                allow_single_deselect: true,
                no_results_text: "No results found!"
            });

            $('.datepicker').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
        $(document).ready(function() {
            $('.select').select2();
        });
        const csrf = '{{ csrf_token() }}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf
            }
        });

        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        @if (Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif

        @if (Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif

        // open modal
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            $('#delete-form').attr('action', $(this).data('url'));
            $('#delete-item-name').text($(this).data('name') || '');
            $('#confirmDeleteModal').modal('show');
        });
        $('#delete-form').on('submit', function() {
            $('#confirm-delete-btn').prop('disabled', true).text('Deleting...');
        });
        $(document).ready(function() {
            var formSub = $('#status-form');
            $('#status-confirm-btn').on('click', function() {
                formSub.submit();
            })
            formSub = $('#delete-form');
            $('#confirm-delete-btn').on('click', function() {
                formSub.submit();
            })
        })

        // status change modal
        $(document).on('click', '.btn-status-change', function(e) {
            e.preventDefault();
            $('#status-form').attr('action', $(this).data('url'));
            $('#status-item-name').text($(this).data('name') || '');
            $('#status-item-action').text($(this).data('action') || '');
            const method = $(this).data('method') || 'POST';
            $('#status-form-method').val(method);
            $('#statusConfirmModal').modal('show');
        });
        // avoid double submit on status form (non-AJAX)
        $('#status-form').on('submit', function() {
            var $btn = $('#status-confirm-btn');
            var txt = $btn.text();
            $btn.prop('disabled', true).text(txt + '...');
            // form will submit normally (server handles redirect/flash)
        });

        function resetForm(form) {
            const protectedValues = {};

            form.querySelectorAll('.no-reset').forEach(el => {
                protectedValues[el.name] = el.value;
            });

            form.reset();
            $(form).find('.select').each(function() {
                $(this).val(null).trigger('change');
            });

            form.querySelectorAll('.no-reset').forEach(el => {
                el.value = protectedValues[el.name];
                if ($(el).hasClass('select')) {
                    $(el).trigger('change');
                }
            });
        }
    </script>
@endpush
