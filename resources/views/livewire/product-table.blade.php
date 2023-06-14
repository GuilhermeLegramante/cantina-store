<div>
    @include('pages.datatable')

    @livewire('product-form-modal')

    @livewire('manufacturer-form-modal')

    @livewire('category-form-modal')

    @livewire('measurement-unit-form-modal')

    @livewire('cestncm-form-modal')

</div>
@push('scripts')
<script>
    window.livewire.on('showProductFormModal', () => {
        $('#product-form-modal').modal('show');
    });

    window.livewire.on('hideDemandFormModal', () => {
        $('#product-form-modal').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });

    window.livewire.on('showManufacturerFormModal', () => {
        $('#manufacturer-form-modal').modal('show');
    })

    window.livewire.on('hideManufacturerFormModal', () => {
        $('manufacturer-form-modal').modal('hide');
    });

    window.livewire.on('showCategoryFormModal', () => {
        $('#category-form-modal').modal('show');
    })

    window.livewire.on('hideCategoryFormModal', () => {
        $('category-form-modal').modal('hide');
    });

    window.livewire.on('showMeasurementUnitFormModal', () => {
        $('#measurementUnit-form-modal').modal('show');
    })

    window.livewire.on('hideMeasurementUnitFormModal', () => {
        $('measurementUnit-form-modal').modal('hide');
    });

    window.livewire.on('showCestncmFormModal', () => {
        $('#cestncm-form-modal').modal('show');
    })

    window.livewire.on('hideCestncmFormModal', () => {
        $('cestncm-form-modal').modal('hide');
    });

</script>
@endpush
