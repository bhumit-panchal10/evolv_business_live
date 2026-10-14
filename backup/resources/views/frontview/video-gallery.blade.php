
@extends('layouts.front')
@section('opTag')
@section('title', $seo->metaTitle)

<meta name="description" content="{{ $seo->metaDescription }}" />
<meta name="keywords" content="{{ $seo->metaKeyword }}" />
{!! $seo->head !!}
{!! $seo->body !!}

@endsection

@section('content')
    <!-- Main banner -->
    <div class="inner-page-main-banner services">
        <!-- Bootstrap -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <!-- H2 heading -->
                    <h2>Gallery</h2>
                    <!-- H1 Heading -->
                    <h1>Video Gallery</h1>
                    <!-- Bredcum links -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                            <ul>
                                <li> <a href="{{route('FrontIndex')}}">Home » </a> </li>
                                <li>Video Gallery</li>
                            </ul>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End bootstrap -->
    </div>
    <!-- End Main banner -->
 

    
    <!-- This section classes require for whole page sliders -->
    <div id="sequence" style="display:none;">
        <ul class="seq-canvas">
        </ul>
    </div>

    <!-- End Slider -->
    <section class="section-gap">
        <main class="main">
            <div class="container">
                <div class="row">
                    @foreach($videos as $vid)
                    <?php 
                                $ytarray=explode("/", $vid->vidoeurl);
                                $ytendstring=end($ytarray);
                                $ytendarray=explode("?v=", $ytendstring);
                                $ytendstring=end($ytendarray);
                                $ytendarray=explode("&", $ytendstring);
                                $ytcode=$ytendarray[0];
                            ?>
                        <div class="col-lg-4">
                        <div class="yt-video">
                        <iframe width="100%" height="315"
                         src="https://www.youtube.com/embed/<?= $ytcode ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                        </iframe>
                        <div class="blog-footer">
                          <span class="p-date"><i style="color:#78c046" class="fa fa-calendar"></i>  {{ \Carbon\Carbon::parse($vid->date)->format('F j, Y') }}
                          </span>
                          <!-- <span class="p-date"><i style="color:#78c046" class="fa fa-user"></i>
                          Ravi Patel
                          </span>-->
                      </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {{ $videos->links() }}
                    </div>
                </div>
            </div>
        </main>
    </section>
        </div>
      </main>
</section>


    


@endsection
