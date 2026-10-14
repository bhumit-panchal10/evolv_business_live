@extends('layouts.front')
@section('title', 'Success')
@section('content')

<style>
	.error-content h3 {
		text-transform: uppercase;
		font-size: 42px;
		font-weight: 800;
		font-family: "Muli", sans-serif;
		margin-top: 10px;
		margin-bottom: 10px;
	}

	.btn-primary {
		background: #000000;
		color: #ffffff;
	}

	.error-content h3 {
		text-transform: uppercase;
		font-size: 42px;
		font-weight: 800;
		font-family: "Muli", sans-serif;
		margin-top: 10px;
		margin-bottom: 10px;
		color: black;
	}

	.btn {
		border: none;
		line-height: initial;
		text-transform: uppercase;
		border-radius: 30px;
		padding: 18px 60px 17px 25px;
		position: relative;
		-webkit-box-shadow: 0px 5px 28.5px 1.5px rgba(254, 35, 9, 0.2) !important;
		box-shadow: 0px 5px 28.5px 1.5px rgba(254, 35, 9, 0.2) !important;
		-webkit-transition: 0.5s;
		transition: 0.5s;
		font-size: 14px;
		font-weight: 700;
	}

	.btn-primary i {
		position: absolute;
		right: 7px;
		top: 50%;
		-webkit-transform: translateY(-50%);
		transform: translateY(-50%);
		text-align: center;
		display: inline-block;
		height: 38px;
		width: 38px;
		line-height: 38px;
		color: #000000;
		border-radius: 50%;
		background-color: #ffffff;
		-webkit-transition: 0.5s;
		transition: 0.5s;
	}
</style>
<!-- Start Error Area -->
<section class="mt-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="error-content text-center">
					<img width="400" src="{{ asset('assets/images/Qr_thankyou.png')}}" alt="error">
					<h3>Thank You</h3>
					<p>Your payment successfully. &#128522;</p>
					<a href="{{route('FrontIndex')}}" class="btn btn-primary">Go Back Home <i
							class="fas fa-chevron-right"></i></a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End Error Area -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
	integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
	crossorigin="anonymous"></script>

@endsection
