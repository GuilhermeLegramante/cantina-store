<div>
    @include('pages.datatable')

    @livewire('manufacturer-form-modal')
</div>
@push('scripts')
<script>
    window.livewire.on('showManufacturerFormModal', () => {
        $('#manufacturer-form-modal').modal('show');
    });

    window.livewire.on('hideDemandFormModal', () => {
        $('#manufacturer-form-modal').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });
</script>
@endpush
