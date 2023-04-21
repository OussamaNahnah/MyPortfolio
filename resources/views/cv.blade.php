<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <title>Converted document</title> 
    <style>
      @font-face {
      font-family: "Comfortaa";
      src: url("fonts/Comfortaa.ttf");
      }
      @font-face {
      font-family: "Raleway";
      font-weight: bolder;
      src: url("fonts/Raleway.ttf");
      }

      body {
          font-family: "Comfortaa";
          
          color:#454545;
      }
      .name {
          font-family: "Raleway";
      }
      </style>
  </head>
<body>

<div>
<center><h1 class="name">{{$user->fullname}}</h1>

<p>
{{$user->email}} |

@foreach ($user->phone_numbers as $phone_number)
    {{ $phone_number->numberphone . ' ' }}
@endforeach


| {{$user->location}} 
</p>


<p>
@if ($user->principal_link()!=null)
{{$user->principal_link()}}
@endif


</p>
</center></div>
<hr>
<h3>Education</h3>
@foreach ($user->educations as $education)
<p>{{ $education->specialization }}|{{ $education->nameschool }} | {{ $education->startdate }}
@if($education->enddate!=null)
/{{ $education->enddate }}
@else
 / untill now
@endif  

</p>
@endforeach
 

<h3>Experience</h3>



@foreach ($user->experiences as $experience)
<p> {{ $experience->name }} |{{ $experience->titlejob }} |{{ $experience->location }}   |{{ $experience->startdate }}
@if($experience->enddate!=null)
/{{ $experience->enddate }} 
@else
 / untill now
@endif</p>
<ul>
@foreach ($experience->job_responsibilities as $job_responsibilitie)
<li>{{ $job_responsibilitie->responsibility }}</li>
@endforeach
</ul>
@endforeach 


<h3>Skills</h3>


@foreach ($user->skill_types as $skill_type)

<p>{{ $skill_type->name }}</p>
<p>
@foreach ($skill_type->skills as $skill)
{{ $skill->name .' | ' }}
@endforeach
</p>

@endforeach
<h3>Other</h3>
<p> Volunteer work in different organizations</p>
