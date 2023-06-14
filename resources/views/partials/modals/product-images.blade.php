@if(isset($product['images']))
<div wire:ignore.self class="modal fade z-index-99999" id="modal-product-images" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <p><strong>Imagens</strong></p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach ($product['images'] as $image)
                    <div class="col-sm-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <a target="_blank" href="{{ Storage::disk('s3')->url($image['path']) }}"><img onerror="this.onerror=null; this.src='img/no-preview.jpg'" src="{{ Storage::disk('s3')->url($image['path']) }}" alt="Anexo" class="img-fluid mb-2">
                                </a>
                            </div>
                            <div class="card-footer">
                                <button wire:click.prevent="deleteFile({{ $image['id'] }}, {{ $image['productId'] }})" title="Excluir a imagem" class="btn btn-light btn-sm" wire:loading.attr="disabled">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
