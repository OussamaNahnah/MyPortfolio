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
          font-size: 14px;
          color:#454545;
      }
      .name {
          font-family: "Raleway";
          font-size: 40px;
         
      }
      a{
        color:#454545;
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


<p ><a href="{{$user->principal_link()}}">
@if ($user->principal_link()!=null)
{{$user->principal_link()}}
@endif

    </a>
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






@if ($user->projects->count() != 0)
      
<h3>Projects</h3>
@foreach ($user->projects as $project)

<p><a href="{{ $project->link }}">{{ $project->name }}</a></p>
{{ $project->description }}</br>
<p>Used skills:
 @foreach ($project->skills as $skill)
{{ $skill->name .' '}}
@endforeach

    </p>


@endforeach

    @endif


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
