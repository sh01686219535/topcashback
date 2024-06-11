@extends('backend.layouts.app')
@section('title')
Location
@endsection
@section('content')
<form method="POST" action="{{ route('shop.setAddress') }}">
    @csrf
    @if(isset($latitude) && isset($longitude))
    <p>Latitude: {{ $latitude }}</p>
    <p>Longitude: {{ $longitude }}</p>
@endif
    <label for="address">Shop Address:</label>
    <input type="text" name="address" id="address" required>

    <label for="postcode">Postcode:</label>
    <input type="text" name="postcode" id="postcode" required>

    <button type="submit">Set Shop Address</button>
</form>

@endsection
