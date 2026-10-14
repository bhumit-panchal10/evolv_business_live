



    <script src="{{ asset ('front/js/jquery.countimator.min.js')}}"></script> <!-- Counter -->
    <script src="{{ asset ('front/js/jquery.sticky.min.js')}}"></script> <!-- Sticky Header -->
    <script src="{{ asset ('front/js/swiper.jquery.min.js')}}"></script>
    <script src="{{ asset ('front/js/isotope.pkgd.min.js')}}"></script> <!-- Isotope -->
    <script src="{{ asset ('front/js/jquery.tabslet.min.js')}}"></script> <!-- Tabs -->
    <script src="{{ asset ('front/js/tweetie.min.js')}}"></script> <!-- Tweets -->
    <script src="{{ asset ('front/js/jquery.scrollUp.min.js')}}"></script> <!-- Scroll up -->
    <script src="{{ asset ('front/https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY')}}"></script> <!-- Google map -->
    <script src="{{ asset ('front/js/imagesloaded.pkgd.min.js')}}"></script> <!-- Header slider scripts -->
    <script src="{{ asset ('front/js/hammer.min.js')}}"></script>
    <script src="{{ asset ('front/js/sequence.min.js')}}"></script>
    <script src="{{ asset ('front/js/venobox.min.js')}}"></script> <!-- Light box -->
    <script src="{{ asset ('front/js/jquery.mb.YTPlayer.min.js')}}"></script> <!-- Video background -->
    <script src="{{ asset ('front/js/template.js')}}"></script> <!-- Theme Options -->

    <script src="{{ asset ('front/js/retina.js')}}"></script> <!-- Retina js -->
    <script src="{{ asset ('front/js/retina.min.js')}}"></script>
    <!-- Retina js -->


        <!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
        <script src="{{ asset ('front/js/jquery-1.12.4.min.js')}}"></script>

   

 <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    
    
    
    <script>
        $(document).ready(function () {
            $('.owl-carousel2').owlCarousel({
                loop: true,
                margin: 20,
                nav: false,
                autoplay: true,
                autoplayTimeout: 2000,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 2
                    }
                }
            });

            $('.owl-carousel3').owlCarousel({
                loop: true,
                margin: 20,
                nav: false,
                autoplay: true,
                autoplayTimeout: 2000,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 5
                    }
                }
            });
        });
    </script>
    


    
    <script>
    // Fancybox Configuration
$('[data-fancybox="gallery"]').fancybox({
  buttons: [
    "slideShow",
    "thumbs",
    "zoom",
    "fullScreen",
    "share",
    "close"
  ],
  loop: false,
  protect: true
});

</script>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.js" integrity="sha512-j7/1CJweOskkQiS5RD9W8zhEG9D9vpgByNGxPIqkO5KrXrwyDAroM9aQ9w8J7oRqwxGyz429hPVk/zR6IOMtSA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
