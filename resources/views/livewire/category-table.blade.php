<div>
    @include('pages.datatable')

    @livewire('category-form-modal')
</div>
@push('scripts')
<script>
    window.livewire.on('showCategoryFormModal', () => {
        $('#category-form-modal').modal('show');
    });

    window.livewire.on('hideDemandFormModal', () => {
        $('#category-form-modal').modal('hide');
    });

    window.livewire.on('scrollTop', () => {
        $(window).scrollTop(0);
    });
</script>
@endpush
