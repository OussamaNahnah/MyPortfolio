
# MyPortfolio 

[ **Myportfolio**  ](https://oussamanh.com) is a web application that allows users to create a professional portfolio and showcase their work experience, skills, and projects. Some of the key features of MyPortfolio include:

-   User authentication: Users can create a private account and verify their email address to access the application.
-   Admin panel: Admins can manage all the data and profiles from a dedicated admin panel ,but a simple user can manage their data only.
-   Portfolio display: Users can present their data in a visually appealing way and showcase their work in various formats such as images, videos, and documents.
-   Downloadable CV: Users can download their CV in PDF format.
-   REST API: **MyPortfolio**  provides a REST API with over 54 requests for developers who want to create their own front-end.

to see the live version  [click here ](https://oussamanh.com).



# Programming 
This website is built using several different technologies to ensure an efficient platform. Here are some of the key components:

- [ Laravel 10  ](https://laravel.com): This is the main framework that the website is built on. In this project, i utilized several classes , including controllers, models, blades, policies, resources, and validators. Additionally, i used all the types of relationships, one-to-one, one-to-many, and many-to-many, to ensure that data was stored and retrieved efficiently.

- [ Laravel JWT ](https://jwt-auth.readthedocs.io/en/develop/): i used Laravel JWT (JSON Web Tokens) to handle authentication and user sessions. JWT is a secure and efficient way of handling user authentication, and it allowed us to build a secure platform that could handle user accounts and sessions seamlessly.

- [Spatie Media Library ](https://spatie.be/docs/laravel-medialibrary/v10/introduction): i utilized the Spatie Media Library to manage  the images on the website.  It allows developers to easily upload, store, and manipulate media easily.
- [ FilamentPhp ](https://filamentphp.com) is a powerful admin panel package for Laravel that provides a simple and elegant interface for managing resources ,
In addition , i used two  plugins :
	> the first package is [Spatie Media Library ](https://filamentphp.com/docs/2.x/spatie-laravel-media-library-plugin/installation), which provides an easy-to-use interface for uploading, deleting, and retrieving images.
	> The second package you used is[ Filament Breezy ](https://filamentphp.com/plugins/breezy), which provides registration, email verification, and password reset functionality .

- [PDF Dom ](https://dompdf.github.io): i utilized the PDF Dom library to generate the PDF cv documents on the website.
# REST API queries :
[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/17735139-be9c8c48-ae11-4f8e-ad7b-3e81aae3b13d?action=collection%2Ffork&source=rip_markdown&collection-url=entityId%3D17735139-be9c8c48-ae11-4f8e-ad7b-3e81aae3b13d%26entityType%3Dcollection%26workspaceId%3D1465953d-50e4-4785-b3ba-61e2ad701cff)

# Schema

```mermaid
classDiagram
	User <|-- Profeessional Network
	User <|-- Education
	User <|-- Other Info
	User <|-- Phone Number
	User <|-- Experience
	User <|-- Skill Type
	User <|-- Project
	Experience <|-- Job Responsibility
	Project <|-- Skill
	Skill Type<|-- Skill
 
	User : +int id
	User : +varchar255 username
	User : +varchar255 fullname
	User : +text bio
	User : +varchar255 birthday
	User : +varchar255 email
	User : +timestamp email_verified_at
	User : +varchar255 password
	User : +varchar255 location
	User : +tinyint1 isadmin
	User : +varchar100 remember_token
	User : +timestamp created_at
	User : +timestamp updated_at
                                                                                    
      class Profeessional Network{
          +int id
          +varchar255 name
          +varchar255 link
          +varchar255 isprincipal
          +int user_id
          +timestamp created_at
	      +timestamp updated_at
           
      }
      class Education{
          +int id
          +varchar255 nameschool
          +varchar255 specialization
          +varchar255 startdate
          +varchar255 enddate
          +int user_id
          +timestamp created_at
	      +timestamp updated_at
      }
      class Other Info{
          +int id
          +varchar255 numberphone
          +int user_id
          +timestamp created_at
	      +timestamp updated_at
      }
	 class Phone Number{
          +int id
          +varchar255 description
          +int user_id
          +timestamp created_at
	      +timestamp updated_at
      }
      class Experience{
          +int id
          +varchar255 name
          +varchar255 titlejob
          +varchar255 location
          +varchar255 startdate
          +varchar255 enddate
          +int user_id
          +timestamp created_at
	      +timestamp updated_at
      }
           class Job Responsibility{
          +int id
          +varchar255 responsibility
          +varchar255 expirence_id
          +timestamp created_at
	      +timestamp updated_at
      }
        class Skill Type{
          +int id
          +varchar255 name
          +int user_id
          +timestamp created_at
	      +timestamp updated_at
      }
       class Skill{
          +int id
          +varchar255 name
          +int skill_type
          +timestamp created_at
	      +timestamp updated_at
      }
            class Project{
          +int id
          +varchar255 name
          +varchar255 description
          +varchar255 link
          +int user_id
          +timestamp created_at
	      +timestamp updated_at
      }
```

# Contact us:
- **email:** oussamanh7@gmail.com 
- **phone:** +213696900164
- **lindekin:** https://www.linkedin.com/in/oussamanahnah/
- **fb:** https://www.facebook.com/osma0k/

# Vedio && Screenshots
![](https://github.com/OussamaNahnah/MyPortfolio/blob/admin/screenshots/screen0.png)
![](https://github.com/OussamaNahnah/MyPortfolio/blob/admin/screenshots/screen1.png)
![](https://github.com/OussamaNahnah/MyPortfolio/blob/admin/screenshots/screen2.png)
![](https://github.com/OussamaNahnah/MyPortfolio/blob/admin/screenshots/screen3.png)
![](https://github.com/OussamaNahnah/MyPortfolio/blob/admin/screenshots/screen4.png)
![](https://github.com/OussamaNahnah/MyPortfolio/blob/admin/screenshots/screen5.png)
![](https://github.com/OussamaNahnah/MyPortfolio/blob/admin/screenshots/screen6.png)
![](https://github.com/OussamaNahnah/MyPortfolio/blob/admin/screenshots/screen7.png)
![](https://github.com/OussamaNahnah/MyPortfolio/blob/admin/screenshots/screen8.png)
![](https://github.com/OussamaNahnah/MyPortfolio/blob/admin/screenshots/screen9.png)
![](https://github.com/OussamaNahnah/MyPortfolio/blob/admin/screenshots/screen10.png)
![](https://github.com/OussamaNahnah/MyPortfolio/blob/admin/screenshots/screen11.png)
