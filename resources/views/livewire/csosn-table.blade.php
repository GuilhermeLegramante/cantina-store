<div>
    @include('pages.datatable')

    @livewire('csosn-form-modal')
</div>
@push('scripts')
<script>
    window.livewire.on('showCsosnFormModal', () => {
        $('#csosn-form-modal').modal('show');
    });

    window.livewire.on('hideDemandFormModal', () => {
        $('#csosn-form-modal').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });
</script>
@endpush
