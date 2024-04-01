<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gym Management System</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="antialiased" >
    
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{route('landingPage')}}"><img width="80px" src="{{ asset('./assets/logo.png')}}" alt=""></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('backpack.auth.login')}}">Admin Login</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="container">
                <h1 class="text-center" id="scanText">Scan QR Codes</h1>
                <div class="section">
                    <div id="my-qr-reader">
                    </div>
                </div>
            </div>
            <!-- Search Form -->
            <div class="input-group mt-5">
                <form id="searchForm" action="{{ route('search') }}" method="GET" class="w-100">
                    <input type="text" name="query" id="queryInput" class="form-control mb-3" placeholder="Enter a code" aria-label="Search" autocomplete="off">
                    <button type="submit" class="btn btn-outline-success w-100">Check-In</button>
                </form>
            </div>    
          
            
            <!-- Success Message -->
            @if (!empty($successMessage))
            <div id="successMessage" class="alert alert-warning" role="alert">
                @foreach ($members as $i)
                    <div class="d-flex justify-content-center">
                        @if ($i->image)
                            <img src="{{ asset('assets/images/' . $i->image) }}" alt="Member Image" class="rounded-circle" width="200px">
                        @else
                            <img src="{{ asset('assets/icon.png') }}" alt="Default Image" class="rounded-circle" width="200px">
                        @endif
                    </div>
                @endforeach
                <h2 class="mb-4 text-center">Member Info</h2>
                <table class="table">
                    <tbody>
                        {!! $successMessage !!}
                    </tbody>
                    
                    
                </table>
                <button type="button" class="btn btn-danger d-block mx-auto mt-4" onclick="closeSuccessMessage()">Close<span id="countdown"></span></button>
            </div>
            <script>
                let countdownSeconds = 10; 
            
                function closeSuccessMessage() {
                    document.getElementById('successMessage').style.display = 'none';
                    setTimeout(function() {
                        window.location.href = "{{ route('search') }}";
                    }, 1000);
                }
            
                function updateCountdown() {
                    document.getElementById('countdown').innerText = ` (${countdownSeconds}s)`;
                    countdownSeconds--;
                    if (countdownSeconds >= 0) {
                        setTimeout(updateCountdown, 1000); 
                    } else {
                        closeSuccessMessage();
                    }
                }
            
                function showSuccessMessage() {
                    document.getElementById('successMessage').style.display = 'block';
                    if (countdownSeconds <= 0) {
                        document.getElementById('my-qr-reader').style.display = 'block'; 
                    } else {
                        document.getElementById('my-qr-reader').style.display = 'none';
                        document.getElementById('scanText').style.display = 'none';
                    }
                    updateCountdown();
                }
            
                showSuccessMessage();
            </script>
            @else
            <div class="alert alert-warning mt-4">  
                <p class="text-center">Please check in.</p>
                <div class="text-center">
                    <img width="320px" class="img-fluid" src="{{ asset('./assets/gym2.gif') }}" alt="Waiting GIF">
                </div>
            </div>
            @endif
            <!-- End Success Message -->
        </div>
    </div>
</div>
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="{{ asset('assets/js/script.js')}}"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</body>
</html>
