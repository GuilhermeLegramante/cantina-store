@if(count($model) > 0)
<div class="col-md-{{ $columnSize }}">
    <div class="form-group">
        <label>{{ $label }}</label>
        <div class="input-group">
            @foreach ($model as $key => $item)
            <div class="mr-1" wire:click="removeTag({{ $key }})">
                <small class="cursor-pointer badge badge-primary mt-1">{{ $item }} <small><i class="fas fa-times"></i></small> </small>
            </div>
            @endforeach
        </div>
        {{-- <span class="input-group-append">
                    <button type="button" class="btn btn-primary" title="Pesquisar" wire:click="$emit('showMultipleLocaleModal')">
                        <i class="fas fa-search"></i>
                    </button>
                </span>  --}}
    </div>
</div>
@endif
