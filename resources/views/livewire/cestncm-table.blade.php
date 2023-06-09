<div>
    @include('pages.datatable')

    @livewire('cestncm-form-modal')
</div>
@push('scripts')
<script>
    window.livewire.on('showCestncmFormModal', () => {
        $('#cestncm-form-modal').modal('show');
    });

    window.livewire.on('hideDemandFormModal', () => {
        $('#cestncm-form-modal').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });
</script>
@endpush
