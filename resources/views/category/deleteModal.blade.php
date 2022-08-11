<div class="modal fade" id="deleteModal{{ $categoryElem->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete data modal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="{{ route('category.destroy',$categoryElem->id) }}" method="POST" id="deleteForm">
            @csrf
            @method('DELETE') 
            <div class="modal-body">
                <input type="hidden" name="_method" value="DELETE">
                <p>Are you sure? You want to delete data ?</p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Yes! Delete data</button>
            </div>
        </form>
      </div>
    </div>
</div>