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



                        <p>Joining Evolv opens the door to a suite of benefits that empower your growth, enhance your visibility, and foster a collaborative spirit among women entrepreneurs. Here’s what you can expect as an Evolv member.
                            For any issues in utilizing our services you may contact our helpdesk on +91-9913134961 or support@evolv.co.in
                        </p>
                        
                        

                        
                    </div>
                </div>
            </div>
        </section>

@endsection
