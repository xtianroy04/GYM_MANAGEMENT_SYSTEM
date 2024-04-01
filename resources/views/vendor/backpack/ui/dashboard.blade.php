@extends(backpack_view('blank'))

@section('content')
<div class="row d-flex justify-content-center">
    @foreach ($progressWidgets as $widget)
        <div class="col-md-3">
            <div class="{{ $widget['class'] }}">
                <div class="card-body">
                    @if(isset($widget['ribbon']) && isset($widget['ribbon']['position']) && isset($widget['ribbon']['icon']))
                        <div class="ribbon-wrapper ribbon-{{ $widget['ribbon']['position'] }}">
                            <div class="ribbon bg-primary text-lg">
                                <i class="{{ $widget['ribbon']['icon'] }}"></i>
                            </div>
                        </div>
                    @endif

                    <h5 class="card-title">{{ $widget['description'] }}</h5>
                    <p class="card-text">{{ $widget['value'] }}</p>
                    <p class="card-text">{{ $widget['hint'] }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="container-fluid bg-dark text-white py-3">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="text-center">
                <h3 id="liveDateTime"></h3>
            </div>
        </div>
    </div>
</div>




<div class="col-lg-12 mt-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Gym Chart</h5>
        </div>
        <div class="card-body">
            <canvas id="userChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.58/dist/themes/light.css"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/js/index.js')}}"></script>
<script>
    var ctx = document.getElementById('userChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Total Payments',
                data: {!! json_encode($paymentData) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
