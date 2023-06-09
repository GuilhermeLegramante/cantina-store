<div class="row">
    @include('partials.inputs.text', [
    'columnSize' => 12,
    'label' => 'CEST*',
    'model' => 'cest',
    ])
</div>
<div class="row">
    @include('partials.inputs.text', [
    'columnSize' => 12,
    'label' => 'NCM*',
    'model' => 'ncm',
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
