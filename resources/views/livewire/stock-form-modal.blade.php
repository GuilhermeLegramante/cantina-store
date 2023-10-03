<div>
    @include('partials.modals.form')

    @livewire('store-select')

    @livewire('product-select')

</div>
@push('scripts')
<script>
    window.livewire.on('hideStockFormModal', () => {
        $('#stock-form-modal').modal('hide');
    });

    window.livewire.on('showStoreSelectModal', () => {
        $('#modal-select-store').modal('show');
        Livewire.emit('storeSelectModal');
    });

    window.livewire.on('showProductSelectModal', () => {
        $('#modal-select-product').modal('show');
        Livewire.emit('productSelectModal');
    });

</script>
@endpush
