
@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')


<style>
      

      .card-h {
             /* max-width: 100%; */
  display: flex;
  flex-direction: row;
  background-color: #fff;
  border: 0;
  /* box-shadow: 0 7px 7px rgba(0, 0, 0, 0.18); */

      }

      .card.dark {
          color: #fff;
      }

      .card.card.bg-light-subtle .card-title {
          color: dimgrey;
      }

      .card-h img {
          max-width: 25%;
          margin: auto;
          padding: 0.5em;
          border-radius: 0.7em;
      }

      .card-body {
          display: flex;
          justify-content: space-between;
      }

      .text-section {
          max-width: 80%;
      }

      .cta-section {
          /* max-width: 40%; */
          display: flex;
          flex-direction: column;
          align-items: flex-end;
          justify-content: space-between;
      }

      .cta-section .btn {
          padding: 0.3em 0.5em;
          /* color: #696969; */
      }

      .card.bg-light-subtle .cta-section .btn {
          background-color: #898989;
          border-color: #898989;
      }

      @media screen and (max-width: 475px) {
          .card {
              font-size: 0.9em;
          }
      }
  </style>
<div class="main-content mt-5">
      <div class="page-content">
          <div class="container-fluid">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-header">
                          <div class="d-flex justify-content-between align-items-center">
                          <div>
                              <h5 class="card-title mb-0" data-anchor="data-anchor">
                                Announcement Detail
                              </h5>
                          </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-12">
                              <div class="card">
                                  <div class="row">
                                      <div class="card-body">
                                          <div class="card-h">
                                              <img src="{{ asset('event') . '/' . $Announcement->photo }}" class="card-img-top" alt="...">
                                              <div class="card-body">
                                                  <div class="text-section">
                                                    <div>
                                                      <h5 class="card-title text-black">{{$Announcement->Title}}</h5>
                                                      <p class="card-text mt-3">{!! $Announcement->description !!}</p>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div> 
                                </div>
                              </div>                            
                              <div class="d-flex justify-content-center mt-3">
                               </div>
                            </div>
                        </div>
                    </div>
@endsection