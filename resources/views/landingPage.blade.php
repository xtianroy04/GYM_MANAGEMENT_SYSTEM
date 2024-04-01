<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gym Management System</title>

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="{{ asset('assets/css/landingpage.css') }}">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Catamaran:wght@600;700;800;900&family=Rubik:wght@400;500;800&display=swap"
    rel="stylesheet">

</head>

<body id="top">

  <!-- 
    - #HEADER
  -->

  <header class="header" data-header>
    <div class="container">

      <a href="#" class="logo">
        <ion-icon name="barbell-sharp" aria-hidden="true"></ion-icon>

        <span class="span">FitHub</span>
      </a>

      <nav class="navbar" data-navbar>

        <button class="nav-close-btn" aria-label="close menu" data-nav-toggler>
          <ion-icon name="close-sharp" aria-hidden="true"></ion-icon>
        </button>

        <ul class="navbar-list">

          <li>
            <a href="{{ route('backpack.auth.login') }}" class="navbar-link login active">Admin Login</a>
          </li>

          {{-- <li>
            <a href="{{ route('backpack.auth.register') }}" class="register" data-nav-link>Register</a>
          </li> --}}


        </ul>

      </nav>

      <a href="{{ route('search') }}" class="btn btn-secondary">Check In Now</a>

      <button class="nav-open-btn" aria-label="open menu" data-nav-toggler>
        <span class="line"></span>
        <span class="line"></span>
        <span class="line"></span>
      </button>

    </div>
  </header>





  <main>
    <article>

      <!-- 
        - #HERO
      -->

      <section class="section hero bg-dark has-after has-bg-image" id="home" aria-label="hero" data-section
        style="background-image: url('{{ asset('./assets/bg.gif')}}'); background-size: cover; background-position: center;">
        <div class="container">

          <div class="hero-content">

            <p class="hero-subtitle">
              <strong class="strong">The Best</strong>Fitness Club
            </p>

            <h1 class="h1 hero-title">Work Hard To Get Better Life</h1>

            {{-- <p class="section-text">
              Duis mollis felis quis libero dictum vehicula. Duis dictum lorem mi, a faucibus nisi eleifend eu.
            </p> --}}

            <a href="{{ route('search') }}" class="btn btn-primary">Check In Now</a>

          </div>

          <div class="hero-banner">

            <img src="{{ asset('./assets/images/landingPageimages/1.png')}}" width="660" height="753" alt="hero banner" class="w-100">  

            <img src="{{ asset('./assets/images/landingPageimages/heart-rate.svg')}}" width="255" height="270" alt="heart rate"
              class="abs-img abs-img-1">
            <img src="{{ asset('./assets/images/landingPageimages/calories.svg')}}" width="348" height="224" alt="calories" class="abs-img abs-img-2">

          </div>

        </div>
      </section>




    </article>
  </main>


  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>