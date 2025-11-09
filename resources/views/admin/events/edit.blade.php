@extends('layouts.admin')
@section('content')
<div class="container">
   <div class="col-md-10">
      <div class="card card-primary card-outline mb-2" style="padding: 20px;">
         <div class="card-header">
            <div class="card-title">Edit Event</div>
         </div>
         <form action="{{ route('admin.events.update', $event->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.events.form')
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Cancel</a>
         </form>
      </div>
   </div>
</div>
@endsection