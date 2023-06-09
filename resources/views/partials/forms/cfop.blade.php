<div class="row">
    @include('partials.inputs.text', [
    'columnSize' => 12,
    'label' => 'Código*',
    'model' => 'code',
    ])
</div>
<div class="row">
    @include('partials.inputs.text', [
    'columnSize' => 12,
    'label' => 'Descrição*',
    'model' => 'description',
    ])
</div>
<p><small>*campos obrigatórios</small></p>
