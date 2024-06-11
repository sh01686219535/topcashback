@extends('backend.layouts.app')
@section('title')
    Assign Permission
@endsection
@section('content')

    <!-- Hoverable Table rows -->
    <div class="contasiner customer-container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-2">
                    <div class="card-head mx-5 my-3 customer-card">
                        <a href="{{route('add-assign-permission')}}" class="btn btn-primary" ><i class="fa-solid fa-plus"></i> Create Assign Permission </a>
                        <div class="search">
                            <a class="btn btn-primary pdf" href="{{route('pdf.subCategory')}}">PDF</a>
                            <form action="" method="post" class="search-form">
                                @csrf
                                <input type="search" id="search" name="order_serch" placeholder="Search"
                                       class="form-control order-search">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-header text-center">Assign Permission Table</h3>
                        <table class="table table-hover table-borderd">
                            <thead>
                            <tr>
                                <th>SI</th>
                                <th>Role Name</th>
                                <th>Permission Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i = 1 @endphp

                            @forelse ($role as $item)
                                <tr>
                                    <td>{{$i++}}</td>

                                    <td> {{ $item->role_name }}</td>
                                    <td> @foreach($item->permissions as $permission)
                                            <button class="btn btn-sm btn-success"><span style="font-size:10px;"> {{$permission->permission_name}} </span></button>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('showEdit-assign-permission',$item->id) }}" title="Edit" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                        <a href="{{ route('delete-assign-permission',$item->id) }}" title="Delete" class="btn btn-danger" id="delete"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $role->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
