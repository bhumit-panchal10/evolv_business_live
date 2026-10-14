
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

<div class="inner-page-main-banner services">
  <!-- Bootstrap -->
  <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <!-- H2 heading -->
                <h2>Gallery</h2>
                <!-- H1 Heading -->
                <h1>Photo Album</h1>
                <!-- Bredcum links -->
                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                    <ul>
                      <li><a href="{{ route('FrontIndex')}}">Home »</a></li>
                      <li><a href="{{ route('Frontphoto-album')}}">Photo Album</a></li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <!-- End bootstrap -->
    </div>
    <!-- End Main banner -->
    
   
    <section class="section-4 section-gap">
      <div class="container">
        <div class="row">
              @foreach ($photos as $photo)
              <div class="col-lg-4">
                  <figure class="figure">
                    <img src="{{ asset('Gallery/' . $photo->photo) }}">
                    <div>
                      <a href="{{ route('Frontphoto-gallery', $photo->photo_slug) }}"> 
                        <h3><span>{{$photo->name}}</span></h3>
                      </a>
                    </div>
                      
                  </figure>
              </div>
              @endforeach
          </div>
          <!-- Pagination Links -->
          <div class="row justify-content-center">
            <div class="col-md-12">
              {{ $photos->links() }}
            </div>
          </div>
        </div>
        </section>


@endsection

