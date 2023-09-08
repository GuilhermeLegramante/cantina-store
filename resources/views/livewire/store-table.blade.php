<div>
    @include('pages.datatable')

    @livewire('store-form-modal')
</div>
@push('scripts')
<script>
    window.livewire.on('showStoreFormModal', () => {
        $('#store-form-modal').modal('show');
    });

    window.livewire.on('hideStoreFormModal', () => {
        $('#store-form-modal').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });
</script>
@endpush
