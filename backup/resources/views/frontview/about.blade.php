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
    .bx .bx-img img {
    background-color: rgb(255, 255, 255);
    
    /*width: 80%;*/
    max-height:500px;
    margin: 0px auto;
    border: 10px solid rgb(255, 255, 255);
    border-radius: 150px;
    background-image: linear-gradient(to right bottom, rgb(120, 192, 70), rgb(38, 169, 205));
    z-index: -1;
    box-shadow: rgba(0, 0, 0, 0.2) -2px 2px 10px inset, rgba(0, 0, 0, 0.35) -2px 2px 12px;
    display: flex;
     align-items: center; 
    justify-content: center;
    flex-direction: column;
    overflow:hidden;
    object-fit:cover
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
                  
                    <!-- H1 Heading -->
                    <h1>About Us
                    </h1>
                    <!-- Bredcum links -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                        	<ul>
                            	<li> <a href="{{route('FrontIndex')}}">Home » </a> </li>
                                <li>About Us
                                </li>
                            </ul>
                          
                        </div>
                    </div>
                </div>
            </div>
		</div>
        <!-- End bootstrap -->
    </div>
    <!-- End Main banner -->


 
 
    <!-- Section Start  -->
    <?php
    $i=1;
    ?>
    @foreach($Ourteem as $member) 
        <?php if(($i%=2) == 1) { ?>
        <section class="section-gap2">
           <div class="container">
              <div class="row">
                 

                 <div class="col-lg-6">
                    <div class="bx">
                    <div class="bx-img">
                       <img class="img-fluid" src="{{ asset('overteem/' . $member->Overteem_photo) }}" alt="">
                    </div>
                    </div>
                 </div>

                 <div class="col-lg-6">
                    <div class="bx-content">
                       <div class="d-flex justify-content-between align-items-center">
                           <div class="head-txt">{{$member->Overteem_name}}</div>
                           </div>
                            <h4>{{$member->designation}}</h4>
                           <div class="bx-txt">
                           <p>
                               {{$member->description}}

                           </p>
                           </div>
                     </div>
                 </div>

               

              </div>
           </div>
        </section>
<?php }else{ ?>

        <section class="section-gap2">
           <div class="container">
              <div class="row flex-d-reverse">
                 <div class="col-lg-6">
                    <div class="bx-content">
                       <div class="d-flex justify-content-between align-items-center">
                          <div class="head-txt">{{$member->Overteem_name}}</div>
                           </div>
                           <h4>{{$member->designation}}</h4>
                           <div class="bx-txt">
                           <p>
                               {{$member->description}}
                           </p>
                           </div>
                     </div>
                 </div>


                 <div class="col-lg-6">
                    <div class="bx">
                    <div class="bx-img">
                       <img class="img-fluid" src="{{ asset('overteem/' . $member->Overteem_photo) }}" alt="">
                    </div>
                   
                    </div>
                 </div>



              </div>
           </div>
        </section>
<?php }
$i++;
?>
  @endforeach 
      
@endsection
