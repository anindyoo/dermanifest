@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Admin FAQs</h2>
  <hr>
  <div>
    @if(session()->has('success'))
      @include('partials/alert', [
        'status' => 'success',
        'message' => session('success'),
      ])
    @endif
  </div>
  <div>
    <a href="/admin/faqs/create" class="btn btn-primary-native mb-3"><span class="fa-solid fa-plus me-2"></span>Add FAQ</a>
  </div>
  <div class="table-wrapper table-responsive">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th>No.</th>
          <th>FAQ Id</th>
          <th>Question</th>
          <th>Answer</th>
          <th>Date Created</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($faqs_data as $faq)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $faq->id }}</td>
            <td>{{ $faq->question }}</td>
            <td>{!! $faq->answer !!}</td>
            <td>{{ $faq->created_at }}</td>
            <td>            
              <a href="/admin/faqs/{{ $faq->id }}/edit" class="btn btn-primary"><span><i class="fa-solid fa-pen-to-square me-1"></i></span> Update</a>
              <a href="" class="btn btn-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteFAQ-{{ $faq->id }}"><i class="fa-solid fa-xmark"></i> Delete</a>                  
            </td>
          </tr>
          @include('partials/modal', [
            'modal_id' => 'deleteFAQ-' . $faq->id,
            'modal_title' => 'Delete FAQ',
            'include_form' => 'true',
            'form_action' => '/admin/faqs/' . $faq->id,
            'form_method' => 'post', 
            'additional_form_method' => 'delete', 
            'modal_body' => '
            <input type="hidden" name="id" value="' . $faq->id . '" required>
            Are you sure to delete <strong>FAQ #' . $faq->id . '</strong>?',
            'modal_footer' => '
            <button type="button" class="btn btn-secondary-native-regular" data-bs-dismiss="modal"> Back</button>
            <button type="submit" class="btn btn-danger">Continue Delete FAQ</button>
            ',
          ])
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection