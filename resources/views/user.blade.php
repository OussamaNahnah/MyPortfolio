<!DOCTYPE html>
<html>

<head>
    <title>My portfolio</title>
    <meta charset="utf-8" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="/css/kube.min.css" />
    <link rel="stylesheet" href="/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/css/custom.min.css" />
    <link href='https://fonts.googleapis.com/css?family=Playfair+Display+SC:700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
    <link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <style>
        .intro h1:before {
            
            content: 'MY_CV';
        }

        .icon {
            padding-left: 10px;
        }

        //////////////avatar///////

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        pre {
            margin: 20px 0;
            padding: 20px;
            background: #fafafa;
        }

        .round {
            border-radius: 50%;
        }

        ////////
        .owl-carousel {
            position: relative;
        }

        .owl-next,
        .owl-prev {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            -webkit-transform: translateY(-50%);
        }

        .owl-next {
            right: 0;
            display: flex;
        }

        .owl-prev {
            left: 0;
            display: flex;
        }
    </style>


    <link rel="stylesheet" href="/css_carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="/css_carousel/owl.theme.default.min.css">
</head>

<body>
    <!-- Navigation -->
    <div class="main-nav">
        <div class="container">
            <header class="group top-nav">
                <div class="navigation-toggle" data-tools="navigation-toggle" data-target="#navbar-1">
                    <span class="logo">MY Portfolio</span>
                </div>
                <nav id="navbar-1" class="navbar item-nav">
                    <ul>
                        <li class="active"><a href="#about">About</a></li>
                        @if ($user->educations()->count() != 0)
                            <li><a href="#study">Studies</a></li>
                        @endif
                        @if ($user->experiences()->count() != 0)
                            <li><a href="#experiences">Experiences</a></li>
                        @endif
                        @if ($user->projects()->count() != 0)
                            <li><a href="#achievements">Projects</a></li>
                        @endif
                        @if ($user->skill_types()->count() != 0)
                            <li><a href="#skills">Skills</a></li>
                        @endif
                        @if ($user->other_infos()->count() != 0)
                            <li><a href="#other_info">OtherInfromation</a></li>
                        @endif
                        <li><a href="#contact">Contact</a></li>
                        
                        <li><a href="{{ route('cv', [$user->id])}}">Download CV</a></li> 
                        <li><a href="{{ route('admin') }}">Dashboard</a></li>
                        <li><a href="{{ route('index') }}">Back</a></li>
                    </ul>
                </nav>
            </header>
        </div>
    </div>

    <!-- Introduction -->
    <div class="intro section" id="about">
        <div class="container">
            <p>Hi, I’m {{ $user->fullname }}</p>
            <div class="units-row units-split wrap">
                <div class="unit-20">
                    @if ($user->getMedia('image')->count() != null)
                        <img src="{{ $user->getFirstMediaUrl('image') }}" alt="Avatar">
                    @else
                        <img width="60" height="60" avatar="{{ $user->fullname }}">
                    @endif

                </div>
                <div class="unit-80">
                    <h1>I live in<br><span id="typed"></span></h1>
                </div>
                @if ($user->bio != null)
                    <p>
                        {!! $user->bio!!}
                    </p>
                @endif
            </div>
        </div>
    </div>
    <!-- Studies -->
    @if ($user->educations()->count() != 0)

        <div class="study section second" id="study">
            <div class="container">
                <h1>Study</h1>
                @foreach ($user->educations as $education)
                    <ul class="skill-list list-flat">
                        <li>{{ $education->startdate }}/{{ $education->enddate }}</li>
                        <li>{{ $education->specialization }}</a>
                        <li>{{ $education->nameschool }}</li>
                    </ul>
                @endforeach
            </div>
        </div>

    @endif


    <!-- Work Experience -->
    @if ($user->experiences()->count() != 0)
        <div class="experiences section second" id="experiences">
            <div class="container">
                <h1>Work<br>Experiences</h1>
                @foreach ($user->experiences as $experience)
                    <ul class="award-list list-flat">
                        <li>{{ $experience->startdate }}/{{ $experience->enddate }}</li>
                        <li>{{ $experience->name }} |{{ $experience->location }}</li>
                        <li>{{ $experience->titlejob }}</li>
                        <li>
                            <ul>
                                @foreach ($experience->job_responsibilities as $job_responsibilitie)
                                    <li>{{ $job_responsibilitie->responsibility }}</li>
                                @endforeach
                            </ul>
                        </li>

                    </ul>
                @endforeach
            </div>
        </div>
    @endif
    @if ($user->projects->count() != 0)
        <!-- projets -->
        <div class="project section second" id="project">
            <div class="container">
                <h1>Projects</h1>
                @foreach ($user->projects as $project)
                    <ul class="award-list list-flat">
                        <li><a href="{{ $project->link }}">{{ $project->name }}</a></li>
                        <li>{{ $project->description }}</li>
                        <li>  @foreach ($project->skills as $skill)
                           {{ $skill->name .' '}}
                        @endforeach</li>

                    </ul>
                    <div class="owl-carousel">
                        @foreach ($project->getMedia('images') as $image)
                            <div>
                                <img onclick="window.open(this.src)" src="{{ $image->getUrl() }}"
                                    alt="Girl in a jacket" width="100" height="100">
                            </div>
                        @endforeach
                    </div>
                @endforeach

            </div>
        </div>
    @endif
    @if ($user->skill_types()->count() != 0)
        <!-- Technical Skills -->
        <div class="skills section second" id="skills">
            <div class="container">
                <h1>Technical<br>Skills</h1>

                @foreach ($user->skill_types as $skill_type)
                    <ul class="skill-list list-flat">
                        <li>{{ $skill_type->name }}</li>
                        <li>
                            @foreach ($skill_type->skills as $skill)
                                {{ $skill->name }}
                            @endforeach
                        </li>
                    </ul>
                @endforeach
            </div>
        </div>
    @endif


    @if ($user->other_infos()->count() != 0)
        <!-- Other Infromation  -->
        <div class="skills section second" id="other_info">
            <div class="container">
                <h1>Other<br>Intromations</h1>

                    <ul class="skill-list list-flat">
                        <li>{{ $user->other_infos->description}}</li>
                        </li>
                    </ul>
            </div>
        </div>
    @endif

    <!-- Contact -->
    <div class="skills section second" id="contact">
        <div class="container">
            <h1>Contact</h1>
            <ul class="skill-list list-flat">
                @if ($user->phone_numbers()->count() != 0)
                    <li>Phones</li>
                    <li>
                        @foreach ($user->phone_numbers as $phone_number)
                            {{ $phone_number->numberphone . ' ' }}
                        @endforeach
                    </li>
                @endif

            </ul>


            <ul class="skill-list list-flat">
                <li>Email</li>
                <li>
                    {{ $user->email }}
                </li>
            </ul>

        </div>
    </div>


    <!-- Quote -->
    <div class="quote">
        <div class="container text-centered">
            <h1>“I never dreamed about success. I worked for it.” </h1>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="units-row">
                <div class="unit-50">
                    <p>By Oussama Nahnah</p>
                </div>
                <div class="unit-50">
                    <ul class="social list-flat right">
                        @foreach ($user->professional_Networks as $professional_Network)
                            <li>
                                <a href="{{ $professional_Network->link }}">
                                    <div class="unit-20 icon">
                                        <div class="units-row units-split wrap">
                                            
@if ($professional_Network->getMedia('icon')->count() != null)
<img src="{{ $professional_Network->getFirstMediaUrl('icon') }}"
                                                alt="Avatar">
@else
<img width="60" height="60" avatar="{{ $professional_Network->name }}">
@endif
                                            
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <?php $arry = explode(' ', $user->location); ?>
    <!-- Javascript -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/typed.min.js"></script>
    <script src="/js/kube.min.js"></script>
    <script src="/js/site.js"></script>
    <script>
        function newTyped() {}
        $(function() {
            $("#typed").typed({
                // Change to edit type effect

                strings: @json($arry),

                typeSpeed: 90,
                backDelay: 700,
                contentType: "html",
                loop: !0,
                resetCallback: function() {
                    newTyped()
                }
            }), $(".reset").click(function() {
                $("#typed").typed("reset")
            })
        });
    </script>
    <!-- avatar Javascript -->
    <script>
        /*
         * LetterAvatar
         * 
         * Artur Heinze
         * Create Letter avatar based on Initials
         * based on https://gist.github.com/leecrossley/6027780
         */
        (function(w, d) {


            function LetterAvatar(name, size) {

                name = name || '';
                size = size || 60;

                var colours = [
                        "#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9",
                        "#8e44ad", "#2c3e50",
                        "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b",
                        "#bdc3c7", "#7f8c8d"
                    ],

                    nameSplit = String(name).toUpperCase().split(' '),
                    initials, charIndex, colourIndex, canvas, context, dataURI;


                if (nameSplit.length == 1) {
                    initials = nameSplit[0] ? nameSplit[0].charAt(0) : '?';
                } else {
                    initials = nameSplit[0].charAt(0) + nameSplit[1].charAt(0);
                }

                if (w.devicePixelRatio) {
                    size = (size * w.devicePixelRatio);
                }

                charIndex = (initials == '?' ? 72 : initials.charCodeAt(0)) - 64;
                colourIndex = charIndex % 20;
                canvas = d.createElement('canvas');
                canvas.width = size;
                canvas.height = size;
                context = canvas.getContext("2d");

                context.fillStyle = colours[colourIndex - 1];
                context.fillRect(0, 0, canvas.width, canvas.height);
                context.font = Math.round(canvas.width / 2) + "px Arial";
                context.textAlign = "center";
                context.fillStyle = "#FFF";
                context.fillText(initials, size / 2, size / 1.5);

                dataURI = canvas.toDataURL();
                canvas = null;

                return dataURI;
            }

            LetterAvatar.transform = function() {

                Array.prototype.forEach.call(d.querySelectorAll('img[avatar]'), function(img, name) {
                    name = img.getAttribute('avatar');
                    img.src = LetterAvatar(name, img.getAttribute('width'));
                    img.removeAttribute('avatar');
                    img.setAttribute('alt', name);
                });
            };


            // AMD support
            if (typeof define === 'function' && define.amd) {

                define(function() {
                    return LetterAvatar;
                });

                // CommonJS and Node.js module support.
            } else if (typeof exports !== 'undefined') {

                // Support Node.js specific `module.exports` (which can be a function)
                if (typeof module != 'undefined' && module.exports) {
                    exports = module.exports = LetterAvatar;
                }

                // But always support CommonJS module 1.1.1 spec (`exports` cannot be a function)
                exports.LetterAvatar = LetterAvatar;

            } else {

                window.LetterAvatar = LetterAvatar;

                d.addEventListener('DOMContentLoaded', function(event) {
                    LetterAvatar.transform();
                });
            }

        })(window, document);
    </script>

    <script src="/js_carousel/owl.carousel.min.js"></script>

    <script>
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            loop: false,
            nav: true,
            dots: false,
            margin: 10,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                960: {
                    items: 5
                },
                1200: {
                    items: 6
                }
            }
        });
    </script>

</body>

</html>
