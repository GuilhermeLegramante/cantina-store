<button title="Selecionar o registro" data-dismiss="modal"
    wire:click="$emit('{{ $selectModal }}', '{{ $item->id }}')" class="btn btn-info btn-xs mr-1"><i
        class="fas fa-hand-pointer"></i></button>
