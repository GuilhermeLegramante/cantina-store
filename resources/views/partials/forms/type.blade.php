<div class="row">
    @include('partials.inputs.text', [
    'columnSize' => 12,
    'label' => 'Descrição*',
    'model' => 'name',
    ])
</div>
<div class="row">
    @include('partials.inputs.select', [
    'columnSize' => 3,
    'disabled' => $isEdition,
    'label' => 'Bloqueado para Edição*',
    'model' => 'isLocked',
    'options' => [['value' => 1, 'description' => 'SIM'], ['value' => 0, 'description' => 'NÃO']],
    ])
</div>
<p><small>*campos obrigatórios</small></p>
