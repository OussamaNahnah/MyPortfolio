@extends('master')
@section('content')
@include('header')
 




<header class="bgimage"> Tobic Programming</header>

<div class="container-fluid">
        <div class="row">
         
        
            <div class="col-sm-3 margin" >
            <img src="  {{$user->getFirstMediaUrl('image')}} " class="img-circle myimg" alt="cinque terre">
                <section>
                    <h1 class="center"> {{$user->id}}</h1>
                    <p class="center maxlength"> {{$user->fullname}} </p>
                       <center> <a href="{{route('user',[$user->id ])}}">Read More...</a></center>
                </section>
            </div> 
         

        </div>

</div>


   @endsection
