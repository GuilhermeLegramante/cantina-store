<div>
    <ul wire:ignore.self class="nav nav-tabs" role="tablist">
        <li wire:click='setActiveTab(1)' class="nav-item">
            <a class="nav-link {{ ($activeTab == 1) ? 'active' : '' }}" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true"><strong>DADOS GERAIS</strong></a>
        </li>
        <li wire:click='setActiveTab(2)' class="nav-item">
            <a class="nav-link {{ ($activeTab == 2) ? 'active' : '' }}" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false"><strong>DETALHES</strong></a>
        </li>
        <li wire:click='setActiveTab(3)' class="nav-item">
            <a class="nav-link {{ ($activeTab == 3) ? 'active' : '' }}" data-toggle="pill" href="#custom-content-below-messages" role="tab" aria-controls="custom-content-below-messages" aria-selected="false"><strong>INFORMAÇÕES ADICIONAIS</strong></a>
        </li>
    </ul>
    <div wire:ignore.self class="tab-content p-4" id="custom-content-below-tabContent">
        <div class="tab-pane fade {{ ($activeTab == 1) ? 'active show' : '' }}" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
            <div class="row">
                @include('partials.inputs.text', [
                'columnSize' => 6,
                'label' => 'Código de Barras',
                'model' => 'barcode',
                ])
                @include('partials.inputs.text', [
                'columnSize' => 6,
                'label' => 'Código',
                'model' => 'code',
                ])
            </div>
            <div class="row">
                @include('partials.inputs.select-modal', [
                'columnSize' => 12,
                'label' => 'Fabricante',
                'method' => 'showManufacturerSelectModal',
                'model' => 'manufacturerId',
                'description' => $manufacturerDescription,
                //'disabled' => $isEdition,
                'modelId' => $manufacturerId,
                'cleanFields' => 'manufacturerId,manufacturerDescription',
                ])
            </div>
            <div class="row">
                @include('partials.inputs.select-modal', [
                'columnSize' => 12,
                'label' => 'Categoria',
                'method' => 'showCategorySelectModal',
                'model' => 'categoryId',
                'description' => $categoryDescription,
                //'disabled' => $isEdition,
                'modelId' => $categoryId,
                'cleanFields' => 'categoryId,categoryDescription',
                ])
            </div>
            <div class="row">
                @include('partials.inputs.text', [
                'columnSize' => 12,
                'label' => 'Descrição*',
                'model' => 'description',
                ])
            </div>
        </div>
        <div class="tab-pane fade {{ ($activeTab == 2) ? 'active show' : '' }}" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">

            <div wire:ignore x-data x-init="() => {
                const post = FilePond.create($refs.input);
                post.setOptions({
                allowMultiple: true,
                server: {
                process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                @this.upload('images', file, load, error, progress);
                },
                revert: (filename, load) => {
                @this.removeUpload('images', filename, load)
                },
                }
                });
            }">
                <input type=" file" x-ref="input" />

            </div>

            @if(count($storedFiles) > 0)
            @if(isset($product['images']))
            <div class="row mt-4">
                <div class="col-sm-12">
                    <label>Imagens do Produto</label>
                </div>
            </div>
            <div class="row mt-2 text-center">
                @foreach ($product['images'] as $image)
                <div class="col-sm-3">
                    <img src="{{ Storage::disk('s3')->url($image['path']) }}" class="img-fluid mb-2" alt="black sample">
                    <br>
                    <button wire:click.prevent="deleteFile({{ $image['id'] }})" title="Excluir a imagem" class="btn btn-light btn-sm" wire:loading.attr="disabled">
                        <i class="fas fa-times"></i>
                    </button> </div>
                @endforeach
            </div>
            @endif
            @endif
            <div class="row mt-4">
                @include('partials.inputs.text', [
                'columnSize' => 12,
                'label' => 'Incluir Tag',
                'model' => 'tag',
                ])
            </div>
            <div class="row">
                @include('partials.inputs.badge-list', [
                'columnSize' => 12,
                'label' => 'Tags adicionadas',
                'model' => $tags,
                ])
            </div>
        </div>
        <div class="tab-pane fade {{ ($activeTab == 3) ? 'active show' : '' }}" id="custom-content-below-messages" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">

            <div class="row">
                @include('partials.inputs.text', [
                'columnSize' => 12,
                'label' => 'Preço de Custo',
                'model' => 'costPrice',
                'monetaryValue' => true,
                ])
            </div>
            <div class="row">
                @include('partials.inputs.number', [
                'columnSize' => 6,
                'label' => 'Peso ou Volume',
                'model' => 'weight',
                ])
                @include('partials.inputs.select-modal', [
                'columnSize' => 6,
                'label' => 'Unidade de Medida',
                'method' => 'showMeasurementUnitSelectModal',
                'model' => 'measurementUnitId',
                'description' => $measurementUnitDescription,
                //'disabled' => $isEdition,
                'modelId' => $measurementUnitId,
                'cleanFields' => 'measurementUnitId,measurementUnitDescription',
                ])
            </div>
            <div class="row">
                @include('partials.inputs.select-modal', [
                'columnSize' => 12,
                'label' => 'Código CEST/NCM',
                'method' => 'showCestncmSelectModal',
                'model' => 'cestncmId',
                'description' => $cestncmDescription,
                //'disabled' => $isEdition,
                'modelId' => $cestncmId,
                'cleanFields' => 'cestncmId,cestncmDescription',
                ])
            </div>
            <div class="row">
                @include('partials.inputs.select-modal', [
                'columnSize' => 6,
                'label' => 'CFOP',
                'method' => 'showCfopSelectModal',
                'model' => 'cfopId',
                'description' => $cfopDescription,
                //'disabled' => $isEdition,
                'modelId' => $cfopId,
                'cleanFields' => 'cfopId,cfopDescription',
                ])
                @include('partials.inputs.select-modal', [
                'columnSize' => 6,
                'label' => 'CSOSN',
                'method' => 'showCsosnSelectModal',
                'model' => 'csosnId',
                'description' => $csosnDescription,
                //'disabled' => $isEdition,
                'modelId' => $csosnId,
                'cleanFields' => 'csosnId,csosnDescription',
                ])
            </div>

        </div>
    </div>
    <p class="mt-3"><small>*campos obrigatórios</small></p>
</div>
