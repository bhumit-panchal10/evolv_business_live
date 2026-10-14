@extends('layouts.front')
@section('opTag')
@section('title', $seo->metaTitle)

<meta name="description" content="{{ $seo->metaDescription }}" />
<meta name="keywords" content="{{ $seo->metaKeyword }}" />
{!! $seo->head !!}
{!! $seo->body !!}


@endsection

@section('content')

<!-- This section classes require for whole page sliders -->
<div id="sequence" style="display:none;">
  <ul class="seq-canvas">
    </ul>
  </div>
  
  <!-- End Slider -->
  
  <!-- Main banner -->
  <div class="inner-page-main-banner about-us">
    <!-- Bootstrap -->
    <div class="container">
      <div class="row">
        <div class="col-xs-12">

          <!-- H2 heading -->
                <h2>Our Blogs</h2>
                <!-- H1 Heading -->
                <h1>We are Evolv</h1>
                <!-- Bredcum links -->
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                      <ul>
                            <li> <a href="{{route('FrontIndex')}}">Home » </a> </li>
                            <li> <a href="{{route('Frontblog')}}">Blogs </a> </li>
                          </ul>
                        </div>
                      </div>
            </div>
          </div>
        </div>
        <!-- End bootstrap -->
      </div>
      <!-- End Main banner -->
      
      
      <!-- Blog Section Start  -->
      
      
      <!-- Blog Section Start  -->
      <section class="blog">
    <div class="container">
        <div class="row">
            @foreach($Blog as $blog)
            <div class="col-sm-12 col-md-6 col-lg-4  blog-list">
              <img src="{{ asset('Blog/' . $blog->blogImage) }}" alt="" class="img-responsive">
              <div class="blog-list-content">
                <div class="title rainbow">
                    <!-- add url  -->
                       <a href="{{ route('Frontblog-detail', $blog->blog_slug) }}">
                            {{ $blog->blogTitle }}
                        </a>
                      </div>
                      <div class="blog-footer">
                      <span class="p-date"><i style="color:#78c046" class="fa fa-calendar"></i>
                          {{ \Carbon\Carbon::parse($blog->blogDate)->format('F j, Y') }}</span>
                          <span class="p-date"><i style="color:#78c046" class="fa fa-user"></i>
                          {{ $blog->Contact_person ?? 'Super'}} - {{ $blog->category_name ?? 'Evolv' }}
                          </span>

                     
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>          
                <!-- Pagination links -->
                <div class="row">
                  <div class="col-md-12">
                    {{ $Blog->links() }}
                  </div>
                </div>
              </div>
            </section>
           
<!-- Blog End  -->

@endsection

