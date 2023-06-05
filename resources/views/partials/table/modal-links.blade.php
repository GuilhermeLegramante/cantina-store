@if (count($data) > 0)
    <div class="row mb-2">
        <div class="col-12 text-center">
            <a wire:click="load('-30')" data-toggle="tooltip" title="VER MENOS"
                class="chevron-bnt-col btn btn-outline-info btn-sm">
                <i class="fas fa-chevron-up"></i>
            </a>
            <a wire:click="load('30')" data-toggle="tooltip" title="VER MAIS"
                class="chevron-bnt-col btn btn-outline-info btn-sm">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </div>
@endif
<div class="modal-footer">
    <h3><strong>{{ count($data) }} registros</strong></h3>
</div>
