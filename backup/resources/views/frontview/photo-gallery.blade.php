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
    .pagination {
  justify-content: center;
  margin-top: 30px;
}
</style>

<!-- This section classes require for whole page sliders -->
<div id="sequence" style="display:none;">
    <ul class="seq-canvas">
        </ul>
    </div>
    <!-- End Slider -->
    
    <!-- Main banner -->
    <div class="inner-page-main-banner services">
        <!-- Bootstrap -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    
                    <!-- H2 heading -->
                    <h2>Gallery</h2>
                    <!-- H1 Heading -->
                    <h1>{{$slug_to_id->name}}</h1>
                    <!-- Breadcrumb links -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                            <ul>
                                <li> <a href="{{ route('FrontIndex') }}">Home » </a> </li>
                                <li><a href="{{ route('Frontphoto-album')}}">Photo Gallery</a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End bootstrap -->
</div>
<!-- End Main banner -->

<section class="section-gap">
    <main class="main">
        <div class="container">
            <div class="row">
                @foreach($photosgallery as $photo)
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-image">
                            <a href="{{ asset('GalleryDetail/' . $photo->photo) }}" data-fancybox="gallery" data-caption="">
                                <img class="img-fluid" src="{{ asset('GalleryDetail/' . $photo->photo) }}" alt="Image Gallery">
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Pagination -->
            <div class="center">
                {{ $photosgallery->links() }}
            </div>
            <!-- End Pagination -->
        </div>
    </main>
</section>





@endsection

   