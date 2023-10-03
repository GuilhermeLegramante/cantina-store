<div>
    @include('pages.datatable')

    @livewire('product-form-modal')

</div>
@push('scripts')
<script>
    window.livewire.on('showProductFormModal', () => {
        $('#product-form-modal').modal('show');
    });

    window.livewire.on('hideProductFormModal', () => {
        $('#product-form-modal').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });

</script>
@endpush
