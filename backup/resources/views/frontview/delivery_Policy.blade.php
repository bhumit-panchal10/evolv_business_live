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
                        <h2 class="mb-5">Shipping and Delivery Policy</h2>



                        <p>Groath spectrum pvt ltd is business networking platform. We are providing service to our registered members. It's noting like goods or product to deliver end user.
                            For any issues in utilizing our services you may contact our helpdesk on 99748 97311 or info@getdemo.in
                        </p>
                        
                        

                        
                    </div>
                </div>
            </div>
        </section>

@endsection
