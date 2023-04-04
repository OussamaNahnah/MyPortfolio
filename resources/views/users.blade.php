@extends('master')
@section('content')
@include('header')
 




<header class="bgimage"> Users</header>

<div class="container-fluid">
        <div class="row">
         
            @foreach($users as $user)
            <div class="col-sm-3 margin" >
            <img src="  {{$user->getFirstMediaUrl('image')}} " class="img-circle myimg" alt="cinque terre">
                <section>
                    <h1 class="center"> {{$user->id}}</h1>
                    <p class="center maxlength"> {{$user->fullname}} </p>
                       <center> <a href="{{route('user',[$user->id ])}}">Read More...</a></center>
                </section>
            </div> 
            @endforeach

        </div>

</div>


   @endsection
