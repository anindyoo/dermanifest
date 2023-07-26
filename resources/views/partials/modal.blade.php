<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $modal_title }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      @if(isset($include_form))
      <form action={{ $form_action }} method="{{ $form_method }}">
        @if (isset($additional_form_method))
          @if($additional_form_method == 'put') 
            @method('put') 
          @elseif($additional_form_method == 'delete') 
            @method('delete')
          @endif        
        @endif
        @csrf        
      @endif
      <div class="modal-body">
        {!! $modal_body !!}
      </div>
      <div class="modal-footer">
        {!! $modal_footer !!}        
      </div>
      @if(isset($include_form))
      </form>
      @endif
    </div>
  </div>
</div>