<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <title>Converted document</title> 
  </head>
<body>

<h1>{{$user->fullname}}</h1>

<p>
{{$user->email}} |

@foreach ($user->phone_numbers as $phone_number)
    {{ $phone_number->numberphone . ' ' }}
@endforeach


| {{$user->location}} 
</p>


<p>
{{$user->principal_link()}}
</p>
<hr>
<h3>Education</h3>
@foreach ($user->educations as $education)
<p>{{ $education->specialization }}|{{ $education->nameschool }} | {{ $education->startdate }}/{{ $education->enddate }} </p>
@endforeach
 

<h3>Experience</h3>



@foreach ($user->experiences as $experience)
<p> {{ $experience->name }} |{{ $experience->titlejob }} |{{ $experience->location }}   |{{ $experience->startdate }}/{{ $experience->enddate }} </p>
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
