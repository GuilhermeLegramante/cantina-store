<div>
    @include('pages.datatable')

    @livewire('cfop-form-modal')
</div>
@push('scripts')
<script>
    window.livewire.on('showCfopFormModal', () => {
        $('#cfop-form-modal').modal('show');
    });

    window.livewire.on('hideDemandFormModal', () => {
        $('#cfop-form-modal').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });
</script>
@endpush
