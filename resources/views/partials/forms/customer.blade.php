<div class="row">
    @include('partials.inputs.text', [
    'columnSize' => 12,
    'label' => 'Documento (CPF ou CNPJ)*',
    'model' => 'document',
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
