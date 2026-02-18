@extends('layouts.app')

@section('content')
    <h2>Upload Email List</h2>
    <form action="{{ route('emails.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" class="form-control mb-3" required>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
@endsection
