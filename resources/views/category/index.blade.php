@extends('layout')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="float-left">
            <h3>Category</h3>
            <br>
        </div>
        <div class="float-right">
            <a class="btn btn-success" href="{{ route('category.create') }}"> Create New Category</a>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

@if ($message = Session::get('danger'))
    <div class="alert alert-danger">
        <p>{{ $message }}</p>
    </div>
@endif

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($category as $categoryElem)
    <tr>
        <td>{{ $categoryElem->id }}</td>
        <td>{{ $categoryElem->name }}</td>
        <td>{{ $categoryElem->description }}</td>
        <td>
                <a class="btn btn-info" href="{{ route('category.show',$categoryElem->id) }}">Show</a>
                <a class="btn btn-primary" href="{{ route('category.edit',$categoryElem->id) }}">Edit</a>
                <button type="button" class="btn btn-danger delete" data-toggle="modal" data-target="#deleteModal{{ $categoryElem->id }}">Delete</button>
        </td>
    </tr>

    {{-- DELETE MODAL --}}
    @include('category.deleteModal')

    @endforeach

</table>


{{-- {{ $category->links() }} --}}

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


@endsection