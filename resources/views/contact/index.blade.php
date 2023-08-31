@extends('layouts.main')

@section('container')
<section class="contact-faq container container-contact-faq">
  @if(session()->has('success'))
  <div class="home-alert">
    @include('partials/alert', [
      'status' => 'success',
      'message' => session('success'),
    ])
  </div>
  @elseif(session()->has('danger'))
  <div class="home-alert">
    @include('partials/alert', [
      'status' => 'danger',
      'message' => session('danger'),
    ])
  </div>
  @endif
  <div id="contact" class="row contact-row mt-4">
    <div class="col-12">
      <h1>Contact Us</h1>
      <p>Feel free to contact us and tell your opinion, critics, & suggestion via our email (<strong>dermanifest@gmail.com</strong>) or by the form below (<strong>login is required</strong>).</p>
      <div class="contact-form">
        <form action="/contact" method="post">
          @csrf
          <div class="mb-3">
            <label for="email-contact" class="form-label"><h5 class="m-0 fw-bold">Email</h5></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email-contact" value="{{ old('email') }}" required>    
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror        
          </div>
          <div class="mb-3">
            <label for="phone-contact" class="form-label"><h5 class="m-0 fw-bold">Phone Number</h5></label>
            <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone-contact" value="{{ old('phone') }}" required> 
            @error('phone')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror            
          </div>
          <div class="mb-3">
            <label for="subject-contact" class="form-label"><h5 class="m-0 fw-bold">Subject</h5></label>
            <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" id="subject-contact" value="{{ old('subject') }}" required>    
            @error('subject')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror         
          </div>
          <div class="mb-3">
            <label for="message-contact" class="form-label"><h5 class="m-0 fw-bold">Message</h5></label>
            <textarea class="form-control" id="message-contact" rows="3" name="message" value="{{ old('message') }}" required></textarea>
            @error('subject')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror 
          </div>
          <div class="d-flex">
            <button type="submit" class="btn btn-primary-native w-100" @if (!Auth::check()) disabled @endif>Submit @if (!Auth::check()) (Login is Required) @endif</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div id="faq" class="row faq-row mt-5 mb-5">
    <div class="col-12">
      <h1>Frequently Asked Questions (FAQs)</h1>
      <div class="accordion mt-4" id="faqAccordion">
        @foreach ($faqs_data as $faq)
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $faq->id }}" aria-expanded="false" aria-controls="collapse-{{ $faq->id }}"><strong>{{ $faq->question }}</strong></button>
          </h2>
          <div id="collapse-{{ $faq->id }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">{!! $faq->answer !!}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endsection