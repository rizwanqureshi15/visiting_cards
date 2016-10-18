@extends('layouts.app')

@section('content')

<section class="lightSection">

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="page-title">
          <h2>FAQs</h2>
        </div>
      </div>
    </div>
  </div>

</section>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-12 title">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <?php $i = 0; ?>
          @foreach($faqs as $faq)
            <?php $i++; ?>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="heading{{ $i }}">
                <h4 class="panel-title">
                  <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $i }}" aria-expanded="true" aria-controls="collapse{{ $i }}">
                    <h3 class="faq-heading">
                     {{ $faq->question }}
                    </h3>
                  </a>
                </h4>
              </div>
              <div id="collapse{{ $i }}" class="panel-collapse collapse @if($i==1) {{ 'in' }} @endif" role="tabpanel" aria-labelledby="heading{{ $i }}">
                <div class="panel-body answer-space">
                  <sup><i class="fa fa-quote-left left-quote" aria-hidden="true"></i></sup>
                    {{ $faq->answer }}
                  <sub class="subscript"><i class="fa fa-quote-right right-quote" aria-hidden="true"></i></sub>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      <div class="col-md-12 text-center" >
        {{ $faqs->links() }}
      </div>
    </div>
  </div>
</div>
@endsection