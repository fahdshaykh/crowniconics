@props(['name', 'label', 'oldValue', 'isRequired' => false])

@php
    $fieldName = $name ?? Str::lower($label);
    $fieldOldValue = old($name, $oldValue ?? '');
@endphp

<div class="form-group mt-3">
    <label for="{{ $fieldName }}" class="text-bold mb-2">{{ $label }} {!! $isRequired ? '<span class="text-danger">*</span>' : '' !!}</label>
    <textarea id="{{ $fieldName }}-editor" name="{{ $fieldName }}"
        class="form-control @error($fieldName) is-invalid @enderror" style="height: 200px;">{!! $fieldOldValue !!}</textarea>

    @error($fieldName)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
@push('styles')
<link rel="stylesheet" href="{{ asset('richtexteditor/rte_theme_default.css') }}" />
<style>
    @font-face {
        font-family: 'Canela Thin';
        src: url('{{ asset('fonts/my-custom-font/Canelacommercial-type-2310-YZCQDK-web/Canela-Thin-Web.woff2') }}') format('woff2');
        font-weight: normal;
        font-style: normal;
    }

     @font-face {
        font-family: 'Ballinger';
        src: url('{{ asset('fonts/my-custom-font/Ballinger-Font/Ballinger/WOFF/Ballinger-Medium.woff') }}') format('woff');
        font-weight: normal;
        font-style: normal;
    }
    @font-face {
        font-family: 'Ballinger Mono';
        src: url('{{ asset('fonts/my-custom-font/Ballinger-Font/Ballinger Mono/WOFF/BallingerMono-Medium.woff') }}') format('woff');
        font-weight: normal;
        font-style: normal;
    }
</style>
@endpush
@push('scripts')
    {{-- <link rel="stylesheet" href="{{ asset('richtexteditor/rte_theme_default.css') }}" /> --}}
    <script src="{{ asset('richtexteditor/rte.js') }}"></script>
    <script src="{{ asset('richtexteditor/plugins/all_plugins.js') }}"></script>
    <script>
        var config = {};

        config.editorResizeMode = "height";
        config.fontNameItems = "Arial,Arial Black,Comic Sans MS,Courier New,Tahoma,Georgia,Helvetica,Segoe UI,Sans-Serif,Impact,Times New Roman,Verdana,Canela Thin,Ballinger,Ballinger Mono";


        config.file_upload_handler = function(file, callback) {
            const uploadUrl = "{{ route('ckeditor.image.upload') }}?_token={{ csrf_token() }}";

            let formData = new FormData();
            formData.append('upload', file);

            let xhr = new XMLHttpRequest();
            xhr.open('POST', uploadUrl, true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    let response = JSON.parse(xhr.responseText);
                    if (response.uploaded && response.url) {
                        callback(response.url); // This is the correct key
                    } else {
                        callback(null, 'upload-failed');
                    }
                } else {
                    callback(null, 'upload-error');
                }
            };

            xhr.onerror = function() {
                callback(null, 'upload-error');
            };

            xhr.send(formData);
        };

        new RichTextEditor("#{{ $fieldName }}-editor", config);
    </script>
@endpush
