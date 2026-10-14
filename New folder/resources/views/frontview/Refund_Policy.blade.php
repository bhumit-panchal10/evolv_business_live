@extends('layouts.front')
@section('opTag')
@section('title', $seo->metaTitle)

<meta name="description" content="{{ $seo->metaDescription }}" />
<meta name="keywords" content="{{ $seo->metaKeyword }}" />
{!! $seo->head !!}
{!! $seo->body !!}


@endsection

@section('content')
<style>
      .priv-head p {
            color: #000;
            font-size: 16px;
        }

        .priv-head p strong {
            color: #78c046;
            font-size: 20px;
        }
</style>
<section class="blog-single section section-gap">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 priv-head">
                        <h2 class="mb-5">Cancellation and Refund Policy</h2>



                        <p>No cancellation no refund no return no exchange applicable at Evolve Business Community.</p>
                        
                        

                        
                    </div>
                </div>
            </div>
        </section>

@endsection
