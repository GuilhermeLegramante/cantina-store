<div>
    @include('pages.datatable')

    @livewire('measurement-unit-form-modal')
</div>
@push('scripts')
<script>
    window.livewire.on('showMeasurementUnitFormModal', () => {
        $('#measurementUnit-form-modal').modal('show');
    });

    window.livewire.on('hideDemandFormModal', () => {
        $('#measurementUnit-form-modal').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });

</script>
@endpush
