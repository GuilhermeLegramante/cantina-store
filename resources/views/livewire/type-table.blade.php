<div>
    @include('pages.datatable')

    @livewire('type-form-modal')
</div>
@push('scripts')
<script>
    window.livewire.on('showTypeFormModal', () => {
        $('#type-form-modal').modal('show');
    });

    window.livewire.on('hideTypeFormModal', () => {
        $('#type-form-modal').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });
</script>
@endpush
