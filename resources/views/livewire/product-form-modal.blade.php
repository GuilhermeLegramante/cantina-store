<div>
    @include('partials.modals.form')

    @include('partials.modals.product-images')

    @livewire('manufacturer-select')

    @livewire('category-select')

    @livewire('measurement-unit-select')

    @livewire('cestncm-select')

    @livewire('cfop-select')

    @livewire('csosn-select')
</div>
@push('scripts')

<script>
    window.livewire.on('showManufacturerSelectModal', () => {
        $('#modal-select-manufacturer').modal('show');
        Livewire.emit('manufacturerSelectModal');
    });

    window.livewire.on('showCategorySelectModal', () => {
        $('#modal-select-category').modal('show');
        Livewire.emit('categorySelectModal');
    });

    window.livewire.on('showMeasurementUnitSelectModal', () => {
        $('#modal-select-measurementUnit').modal('show');
        Livewire.emit('measurementUnitSelectModal');
    });

    window.livewire.on('showCestncmSelectModal', () => {
        $('#modal-select-cestncm').modal('show');
        Livewire.emit('cestncmSelectModal');
    });

    window.livewire.on('showCfopSelectModal', () => {
        $('#modal-select-cfop').modal('show');
        Livewire.emit('cfopSelectModal');
    });

    window.livewire.on('showCsosnSelectModal', () => {
        $('#modal-select-csosn').modal('show');
        Livewire.emit('csosnSelectModal');
    });

    window.livewire.on('showProductImagesModal', () => {
        $('#modal-product-images').modal('show');
    });

    window.livewire.on('hideProductImagesModal', () => {
        $('#modal-product-images').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });

</script>


@endpush
