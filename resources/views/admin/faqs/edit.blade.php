@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Edit FAQ</h2>
  <hr>
  <form action="/admin/faqs/{{ $faq_data->id }}" method="post">
    @method('put')
    @csrf
    <div class="form-group mb-3">
      <label class="form-label">FAQ Id</label>
      <input type="text" class="form-control" value="{{ $faq_data->id }}" readonly disabled>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Question</label>
      <input type="text" class="form-control" name="question" value="{{ $faq_data->question }}" required>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Answer</label>
      <input id="answer" type="hidden" name="answer" value="{!! $faq_data->answer !!}" required>
      <trix-editor input="answer"></trix-editor>
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-primary-native"><span class="fa-solid fa-circle-check"></span> Update FAQ</button>
    </div>
  </form>
</div>
@endsection