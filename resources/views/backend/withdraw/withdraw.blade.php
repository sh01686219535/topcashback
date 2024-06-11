@extends('backend.layouts.app')
@section('title')
    Pay Withdraw
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-head">
                        <form action="{{route('pay')}}" method="post">
                            @csrf
                            <input type="submit" value="Pay Withdraw" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
