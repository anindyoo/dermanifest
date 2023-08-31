@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Add FAQ</h2>
  <hr>
  @if(session()->has('danger'))
  <div class="home-alert">
    @include('partials/alert', [
      'status' => 'danger',
      'message' => session('danger'),
    ])
  </div>
  @endif
  <form action="/admin/faqs" method="post">
    @csrf
    <div class="form-group mb-3">
      <label class="form-label">Question</label>
      <input type="text" class="form-control @error('question') is-invalid @enderror" name="question" value="{{ old('question') }}" required>
      @error('question')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Answer</label>
      <input id="answer" type="hidden" name="answer" value="{{ old('answer') }}" required>
      <trix-editor input="answer"></trix-editor>
      @error('answer')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-primary-native"><span class="fa-solid fa-circle-check"></span> Add FAQ</button>
    </div>
  </form>
</div>
@endsection