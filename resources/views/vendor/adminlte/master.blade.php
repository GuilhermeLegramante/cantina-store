<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))</title>
    @if (!config('adminlte.enabled_laravel_mix'))
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    @include('adminlte::plugins', ['type' => 'css'])

    @yield('adminlte_css_pre')

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

    @yield('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @else
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @endif

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @yield('meta_tags')

    @if (config('adminlte.use_ico_only'))
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    @elseif(config('adminlte.use_full_favicon'))
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicons/android-icon-192x192.png') }}">
    <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif

    <style>
        .select2-results {
            max-height: 500px;
        }

    </style>

    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

    @livewireStyles

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />

</head>

<body id="body" class="@yield('classes_body')" @yield('body_data')>
    @yield('body')

    @if (!config('adminlte.enabled_laravel_mix'))
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    @include('adminlte::plugins', ['type' => 'js'])

    @yield('adminlte_js')
    @else
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @endif

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>

    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);
        FilePond.registerPlugin(FilePondPluginImagePreview);

        const labels_pt_BR = {
            // labelIdle: 'Drag & Drop your files or <span class="filepond--label-action"> Browse </span>'
            labelIdle: 'Arraste e solte os arquivos ou <span class="filepond--label-action"> Clique aqui </span>',
            // labelInvalidField: 'Field contains invalid files',
            labelInvalidField: 'Arquivos inválidos',
            // labelFileWaitingForSize: 'Waiting for size',
            labelFileWaitingForSize: 'Calculando o tamanho do arquivo',
            // labelFileSizeNotAvailable: 'Size not available',
            labelFileSizeNotAvailable: 'Tamanho do arquivo indisponível',
            // labelFileLoading: 'Loading',
            labelFileLoading: 'Carregando',
            // labelFileLoadError: 'Error during load',
            labelFileLoadError: 'Erro durante o carregamento',
            // labelFileProcessing: 'Uploading',
            labelFileProcessing: 'Enviando',
            // labelFileProcessingComplete: 'Upload complete',
            labelFileProcessingComplete: 'Envio finalizado',
            // labelFileProcessingAborted: 'Upload cancelled',
            labelFileProcessingAborted: 'Envio cancelado',
            // labelFileProcessingError: 'Error during upload',
            labelFileProcessingError: 'Erro durante o envio',
            // labelFileProcessingRevertError: 'Error during revert',
            labelFileProcessingRevertError: 'Erro ao reverter o envio',
            // labelFileRemoveError: 'Error during remove',
            labelFileRemoveError: 'Erro ao remover o arquivo',
            // labelTapToCancel: 'tap to cancel',
            labelTapToCancel: 'clique para cancelar',
            // labelTapToRetry: 'tap to retry',
            labelTapToRetry: 'clique para reenviar',
            // labelTapToUndo: 'tap to undo',
            labelTapToUndo: 'clique para desfazer',
            // labelButtonRemoveItem: 'Remove',
            labelButtonRemoveItem: 'Remover',
            // labelButtonAbortItemLoad: 'Abort',
            labelButtonAbortItemLoad: 'Abortar',
            // labelButtonRetryItemLoad: 'Retry',
            labelButtonRetryItemLoad: 'Reenviar',
            // labelButtonAbortItemProcessing: 'Cancel',
            labelButtonAbortItemProcessing: 'Cancelar',
            // labelButtonUndoItemProcessing: 'Undo',
            labelButtonUndoItemProcessing: 'Desfazer',
            // labelButtonRetryItemProcessing: 'Retry',
            labelButtonRetryItemProcessing: 'Reenviar',
            // labelButtonProcessItem: 'Upload',
            labelButtonProcessItem: 'Enviar',
            // labelMaxFileSizeExceeded: 'File is too large',
            labelMaxFileSizeExceeded: 'Arquivo é muito grande',
            // labelMaxFileSize: 'Maximum file size is {filesize}',
            labelMaxFileSize: 'O tamanho máximo permitido: {filesize}',
            // labelMaxTotalFileSizeExceeded: 'Maximum total size exceeded',
            labelMaxTotalFileSizeExceeded: 'Tamanho total dos arquivos excedido',
            // labelMaxTotalFileSize: 'Maximum total file size is {filesize}',
            labelMaxTotalFileSize: 'Tamanho total permitido: {filesize}',
            // labelFileTypeNotAllowed: 'File of invalid type',
            labelFileTypeNotAllowed: 'Tipo de arquivo inválido',
            // fileValidateTypeLabelExpectedTypes: 'Expects {allButLastType} or {lastType}',
            fileValidateTypeLabelExpectedTypes: 'Tipos de arquivo suportados são {allButLastType} ou {lastType}',
            // imageValidateSizeLabelFormatError: 'Image type not supported',
            imageValidateSizeLabelFormatError: 'Tipo de imagem inválida',
            // imageValidateSizeLabelImageSizeTooSmall: 'Image is too small',
            imageValidateSizeLabelImageSizeTooSmall: 'Imagem muito pequena',
            // imageValidateSizeLabelImageSizeTooBig: 'Image is too big',
            imageValidateSizeLabelImageSizeTooBig: 'Imagem muito grande',
            // imageValidateSizeLabelExpectedMinSize: 'Minimum size is {minWidth} × {minHeight}',
            imageValidateSizeLabelExpectedMinSize: 'Tamanho mínimo permitida: {minWidth} × {minHeight}',
            // imageValidateSizeLabelExpectedMaxSize: 'Maximum size is {maxWidth} × {maxHeight}',
            imageValidateSizeLabelExpectedMaxSize: 'Tamanho máximo permitido: {maxWidth} × {maxHeight}',
            // imageValidateSizeLabelImageResolutionTooLow: 'Resolution is too low',
            imageValidateSizeLabelImageResolutionTooLow: 'Resolução muito baixa',
            // imageValidateSizeLabelImageResolutionTooHigh: 'Resolution is too high',
            imageValidateSizeLabelImageResolutionTooHigh: 'Resolução muito alta',
            // imageValidateSizeLabelExpectedMinResolution: 'Minimum resolution is {minResolution}',
            imageValidateSizeLabelExpectedMinResolution: 'Resolução mínima permitida: {minResolution}',
            // imageValidateSizeLabelExpectedMaxResolution: 'Maximum resolution is {maxResolution}'
            imageValidateSizeLabelExpectedMaxResolution: 'Resolução máxima permitida: {maxResolution}'
        };
        FilePond.setOptions(labels_pt_BR);

    </script>

    @livewireScripts
    @livewireChartsScripts

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>

    @stack('scripts')

</body>

</html>
