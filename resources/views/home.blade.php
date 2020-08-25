@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">{{ __('Dashboard') }}</div>
            <div class="card-body">
               @if (session('status'))
               <div class="alert alert-success" role="alert">
                  {{ session('status') }}
               </div>
               @endif
               {{ __('You are logged in!') }}
               <form method="POST" action="{{ url("import") }}" enctype="multipart/form-data">
               {{ csrf_field() }}
               <div class="input-group mb-3 mt-3 form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                  <div class="custom-file">
                     <input type="file" class="custom-file-input" id="file"  name="file" required>
                     <label class="custom-file-label" for="inputGroupFile02">Choose CSV file</label>
                  </div>
               </div>
               <div class="input-group-append">
                  <button id="submit" type="submit" class="btn btn-success" name="submit">Upload</button>
               </div>
               </form>
               @if ($errors->has('file'))
               <span class="help-block">
               <strong>{{ $errors->first('file') }}</strong>
               </span>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
@endsection