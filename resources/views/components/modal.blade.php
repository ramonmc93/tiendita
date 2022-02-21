@props(['tamanioModal' => 'modal-lg'])

<!-- Modal -->
<div 
class="modal fade"
{{ $attributes->merge(['id']) }}
tabindex="-1" 
aria-labelledby="tituloModal" 
aria-hidden="true">
    <div class="modal-dialog {{$tamanioModal}} modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="tituloModal">{{$tituloModal}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              @yield('contenido-modal')
            </div>
            <div class="modal-footer">
              <button 
              type="button" 
              class="btn btn-secondary btnCancelar" 
              data-bs-dismiss="modal">Cerrar</button>
              <button 
              type="button" 
              class="btn btn-primary btnGuardarActualizar">Guardar</button>
            </div>
        </div>
    </div>
</div>