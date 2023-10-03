<div>
    @include('partials.modals.form')

    @livewire('manufacturer-select')

    @livewire('category-select')

    @livewire('measurement-unit-select')

    @livewire('cestncm-select')

    @livewire('cfop-select')

    @livewire('csosn-select')

    @livewire('manufacturer-form-modal')

    @livewire('category-form-modal')

    @livewire('measurement-unit-form-modal')

    @livewire('cestncm-form-modal')

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

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });

</script>


@endpush
