<div>
    @include('pages.datatable')

    @livewire('stock-form-modal')

    @livewire('store-form-modal')

    @livewire('product-form-modal')

</div>
@push('scripts')
<script>
    window.livewire.on('showStockFormModal', () => {
        $('#stock-form-modal').modal('show');
    });

    window.livewire.on('hideStockFormModal', () => {
        $('#stock-form-modal').modal('hide');
    });

    window.livewire.on('showStoreFormModal', () => {
        $('#store-form-modal').modal('show');
    });

    window.livewire.on('hideStoreFormModal', () => {
        $('#store-form-modal').modal('hide');
    });

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
