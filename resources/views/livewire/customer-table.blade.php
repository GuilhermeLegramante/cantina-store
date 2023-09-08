<div>
    @include('pages.datatable')

    @livewire('customer-form-modal')
</div>
@push('scripts')
<script>
    window.livewire.on('showCustomerFormModal', () => {
        $('#customer-form-modal').modal('show');
    });

    window.livewire.on('hideCustomerFormModal', () => {
        $('#customer-form-modal').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });
</script>
@endpush
