<div>
    @include('partials.modals.form')
</div>
@push('scripts')
<script>
    window.livewire.on('hideManufacturerFormModal', () => {
        $('#manufacturer-form-modal').modal('hide');
    });

</script>
@endpush
