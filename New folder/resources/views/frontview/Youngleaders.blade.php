<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Evolve Business Community -New are Leaders </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Evolve Business Community, the premier business networking platform for business growth in Ahmedabad. Evolve Business Community is the most successful and trusted business networking organisation in Ahmedabad." />
<meta name="keywords" content="Business Networking Organization, Business Networking Platform, Business Networking Platform in Ahmedabad, Business Networking Organization in Ahmedabad, Business Networking in Ahmedabad, Local Business Networking Platform in Ahmedabad, Local Business Networking Organization in Ahmedabad, Local Business Networking in Ahmedabad" />
<link rel="canonical" href="https://evolv.co.in//" />

<meta property="og:url" content="https://evolv.co.in//">
  <meta property="og:type" content="website">
  <meta property="og:title" content="Evolve Business Community | Business Networking Organization | Business Networking Platform in Ahmedabad">
  <meta property="og:description" content="Evolve Business Community, the premier business networking platform for business growth in Ahmedabad. Evolve Business Community is the most successful and trusted business networking organisation in Ahmedabad.">
<meta property="og:image" content="https://evolv.co.in//front/images/img/logo.png">
    <style>
        /* Reset default spacing */
        body {
            margin: 0;
            padding: 0;
            background-color: #000;
            font-family: Poppins, sans-serif;
        }

        /* Section wrapper */
        .image-section {
            width: 100%;
            overflow: hidden;
        }

        /* Full width image */
        .full-width-image {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Form Section */
        .form-section {
            background: url("{{ asset('front/images/img/body-bg.jpeg') }}") center center / cover no-repeat;
            /* padding: 60px 0; */
            padding-bottom: 20px;
        }

        .form-label {
            color: #fff;
            padding-left: 16px;
        }

        .form-section h2 {
            color: #b6ff5f;
        }

        .form-control,
        .form-select {
            background-color: #000 !important;
            border: 1px solid transparent !important;
            background-image: linear-gradient(#000, #000),
                linear-gradient(to right, #78c046, #26a9cd) !important;
            background-origin: border-box !important;
            background-clip: padding-box, border-box !important;
            /* border-color: linear-gradient(to right, #78c046, #26a9cd) !important; */
            color: #fff !important;
            border-radius: 30px !important;
            /* padding: 15px !important; */
        }

        .form-control::placeholder {
            color: #ffffff !important;
            opacity: 1;
            /* Important for Firefox */
        }

        .form-select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;

            /* Order matters: Arrow first (top), then Inner Black, then Border Gradient (bottom) */
            background-image:
                url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e"),
                linear-gradient(#000, #000),
                linear-gradient(to right, #78c046, #26a9cd) !important;

            /* Match the positions to the images above */
            background-position: right 15px center, center, center !important;
            background-repeat: no-repeat !important;

            /* Match the sizes: Arrow size first, then 'cover' or 'auto' for the rest */
            background-size: 16px 12px, auto, auto !important;

            /* Clip logic: Arrow and Inner Black stay in padding-box, Border Gradient fills border-box */
            background-clip: padding-box, padding-box, border-box !important;
            background-origin: padding-box, padding-box, border-box !important;

            padding-right: 45px !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #b6ff5f;
            box-shadow: none;
        }

        .btn-success {
            background: linear-gradient(to right, #78c046, #26a9cd) !important;
            border-radius: 30px !important;
            border: none;
            color: #000;
            font-weight: 600;
        }

        .btn-success:hover {
            background-color: #9be63a;
        }
       /* reuse your form-control gradient border style */
.fc-gradient {
  background-color: #000 !important;
  border: 1px solid transparent !important;
  background-image: linear-gradient(#000, #000),
    linear-gradient(to right, #78c046, #26a9cd) !important;
  background-origin: border-box !important;
  background-clip: padding-box, border-box !important;
  color: #fff !important;
  border-radius: 30px !important;
}

  .g-radio {
  position: relative;
  display: flex;
  align-items: center;
  gap: 10px;

  padding: 12px 16px;     /* like input padding */
  margin-bottom: 10px;
  cursor: pointer;
  user-select: none;
}

.g-radio input[type="radio"] {
  position: absolute;
  opacity: 0;
  width: 1px;
  height: 1px;
  pointer-events: none;
}

/* circle */
.g-radio .dot {
  width: 16px;
  height: 16px;
  border-radius: 999px;
  border: 2px solid rgba(255,255,255,.55);
  display: grid;
  place-items: center;
  flex: 0 0 auto;
}

.g-radio .dot::after {
  content: "";
  width: 8px;
  height: 8px;
  border-radius: 999px;
  background: #fff;
  transform: scale(0);
  transition: .15s ease;
}

.g-radio input[type="radio"]:checked + .dot::after {
  transform: scale(1);
}

.g-radio input[type="radio"]:checked ~ .txt {
  color: #b6ff5f;
}

/* focus like your form controls */
.g-radio input[type="radio"]:focus-visible + .dot {
  outline: 2px solid #26a9cd;
  outline-offset: 3px;
}

    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thank You!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#28a745'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#dc3545'
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#ffc107'
            });
        </script>
    @endif
    <!-- Image Section -->
    <section class="image-section">
        <img src="{{ asset('front/images/img/GRYD presentationpng.png') }}" alt="Coming Soon Design"
            class="img-fluid full-width-image">
    </section>

    <!-- GRYD Intent Form Section -->
    <section class="form-section">
        <div class="container">
            <h2 class="text-center mb-4">Membership Intention Form</h2>

            <form id="grydForm" method="POST" action="{{ route('YoungleadersAdd') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" name="mobile" inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="10" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email ID</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Profession</label>
                        <select class="form-select" name="profession" required>
                            <option value="">Select</option>
                            <option>Business</option>
                            <option>Freelancer</option>
                            <option>Employee</option>
                            <option>Professional</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Industry Type</label>
                        <select class="form-select" name="industry_type">
                            <option value="">Select</option>
                            <option>Product</option>
                            <option>Service</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Company / Brand Name</label>
                        <input type="text" class="form-control" name="company_name">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Business Category</label>
                        <select class="form-select" name="business_category_id">
                            <option value="">Select</option>
                            @foreach ($category as $data)
                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Company Type</label>
                        <select class="form-select" name="company_type">
                            <option value="">Select</option>
                            <option>Sole Proprietery</option>
                            <option>Partnership</option>
                            <option>LLP</option>
                            <option>Pvt Ltd</option>
                            <option>Limited</option>
                            <option>Trust</option>
                            <option>Other</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">City of Work</label>
                        <input type="text" class="form-control" name="city">
                    </div>
                    

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Are you part of any other community based organisation or run a community by yourself?
                        </label>

                        <select class="form-select" id="communityDropdown" name="community">
                            <option value="">Select</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                        <div class="mt-3 community-field" style="display: none;">
                            <label class="form-label">Community Name</label>
                            <input type="text" name="community_name" id="communityName" class="form-control"
                                placeholder="Community name. if many then , separated">
                        </div>
                    </div>
                  
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Company Brief</label>
                            <textarea class="form-control" name="joining_reason" rows="3" placeholder="Tell us brief about your company"></textarea>
                        </div>
                    </div>
                      <div class="row">  <h2 class="text-center mb-4">Vibe Check</h2></div>
                     <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Your weekends usually look like…</label>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                        <input type="radio"  name="vibe_1" value="Catching up with friends and talking ideas"><span class="dot"></span>
      <span class="txt">Catching up with friends and talking ideas</span></label></div>
       <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                        <input type="radio" name="vibe_1" value="Working on a side project, skill, or business"><span class="dot"></span>
      <span class="txt">Working on a side project, skill, or business</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                        <input type="radio" name="vibe_1" value=">A mix of chill and something productive"><span class="dot"></span>
      <span class="txt">A mix of chill and something productive</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                        <input type="radio" name="vibe_1" value="Mostly rest and personal time"><span class="dot"></span>
      <span class="txt">Mostly rest and personal time</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                        <input type="radio" name="vibe_1" value="No fixed pattern — I go with the flow"><span class="dot"></span>
      <span class="txt">No fixed pattern — I go with the flow</span></label>
                        </div>
                        </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">In a new group, you feel most comfortable when…</label>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                       <input type="radio"  name="vibe_2" value="Conversations are informal and equal"><span class="dot"></span>
      <span class="txt">Conversations are informal and equal</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                       <input type="radio"  name="vibe_2" value="People openly share what they’re building"><span class="dot"></span>
      <span class="txt">People openly share what they’re building</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                       <input type="radio"  name="vibe_2" value="There’s no pressure to impress anyone"><span class="dot"></span>
      <span class="txt">There’s no pressure to impress anyone</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                       <input type="radio"  name="vibe_2" value="I can first observe before engaging"><span class="dot"></span>
      <span class="txt">I can first observe before engaging</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                       <input type="radio"  name="vibe_2" value="I know exactly what I’ll gain from being there"><span class="dot"></span>
      <span class="txt">I know exactly what I’ll gain from being there</span></label></div>
                        
                    </div>
                    </div>
                      <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Which statement best describes you right now?</label>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                            <input type="radio"  name="vibe_3" value="I’m building or actively growing something"><span class="dot"></span>
      <span class="txt">I’m building or actively growing something</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                            <input type="radio"  name="vibe_3" value="I’m exploring ideas and testing directions"><span class="dot"></span>
      <span class="txt">I’m exploring ideas and testing directionss</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                            <input type="radio"  name="vibe_3" value="I’m working professionally and open to collaborations"><span class="dot"></span>
      <span class="txt">I’m working professionally and open to collaborations</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                            <input type="radio"  name="vibe_3" value="I’m learning and preparing for my next move"><span class="dot"></span>
      <span class="txt">I’m learning and preparing for my next move</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                            <input type="radio"  name="vibe_3" value="I prefer stability over experimentation"><span class="dot"></span>
      <span class="txt">I prefer stability over experimentation</span></label></div>
                         
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">When you attend a meet or event, you usually hope to…</label>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                        <input type="radio"  name="vibe_4" value="Meet people I can collaborate with"><span class="dot"></span>
      <span class="txt">Meet people I can collaborate with</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                        <input type="radio"  name="vibe_4" value="Get new perspectives or ideas"><span class="dot"></span>
      <span class="txt">Get new perspectives or ideas</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                        <input type="radio"  name="vibe_4" value="Have meaningful conversations, not just cards"><span class="dot"></span>
      <span class="txt">Have meaningful conversations, not just cards</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                        <input type="radio"  name="vibe_4" value="Learn something practical I can apply"><span class="dot"></span>
      <span class="txt">Learn something practical I can apply</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                        <input type="radio"  name="vibe_4" value="Just attend and see how it goes"><span class="dot"></span>
      <span class="txt">Just attend and see how it goes</span></label></div>
                         
                    </div>
                    </div>
                      <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Why do you want to be part of GRYD?</label>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                        <input type="radio"  name="vibe_5" value="To collaborate and grow with like-minded people"><span class="dot"></span>
      <span class="txt">To collaborate and grow with like-minded people</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                        <input type="radio"  name="vibe_5" value="To gain exposure and direction"><span class="dot"></span>
      <span class="txt">To gain exposure and direction</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                        <input type="radio"  name="vibe_5" value="To contribute skills and perspectives"><span class="dot"></span>
      <span class="txt">To contribute skills and perspectives</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                        <input type="radio"  name="vibe_5" value="To explore new opportunities organically"><span class="dot"></span>
      <span class="txt">To explore new opportunities organically</span></label></div>
                         <div class="g-radio-group">
      <label class="g-radio fc-gradient">
                        <input type="radio"  name="vibe_5" value="Just curious to see what it is"><span class="dot"></span>
      <span class="txt">Just curious to see what it is</span></label></div>
                        
                    </div>
                     <div class="col-md-6 mb-3">
                        <label class="form-label">Which of our first formative members referred you GRYD ?</label>
                        <select class="form-select" name="vibe_6">
                            <option value="">Select</option>
                            <option>Bansil Thakkar </option>
                            <option>Dt Rajeshwareeba Jadeja</option>
                            <option>Dr Jinal Thakkar</option>
                            <option>Kaumit Jani</option>
                            <option>Jeet Parikh</option>
                            <option>Nairuti Jambusaria</option>
                            <option>Parthiv Patel</option>
                            <option>Pooja Mehta</option>
                            <option>Shubham Surti</option>
                            <option>Utsav Shah</option>
                        </select>
                        
                    </div>
                    
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        Register Now
                    </button>
                </div>

            </form>
        </div>
    </section>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const communityDropdown = document.getElementById("communityDropdown");
            const communityField = document.querySelector(".community-field");
            const communityInput = document.getElementById("communityName");

            communityDropdown.addEventListener("change", function() {
                if (this.value === "yes") {
                    communityField.style.display = "block";
                    communityInput.focus();
                } else {
                    communityField.style.display = "none";
                    communityInput.value = "";
                }
            });
        });
    </script>
    <script>
        document.getElementById('communityYes').onclick = () =>
            document.getElementById('communityName').classList.remove('d-none');

        document.getElementById('communityNo').onclick = () =>
            document.getElementById('communityName').classList.add('d-none');
    </script>


</body>

</html>
