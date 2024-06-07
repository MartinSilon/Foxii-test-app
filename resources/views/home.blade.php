@extends('components.head')
@section('body')

<section id="home" class="d-flex justify-content-center align-items-center">

    <div class="container-fluid">
        <div class="row text-center align-items-center">

            {{-- ---- WINDOW FOR CAR LIST ---- --}}
            <a href="{{route('cars.index')}}" class="col-md-6 cars-div d-flex flex-column justify-content-center">
                <h2 class="text-white text-uppercase m-0">Zoznam</h2>
                <h1 class="text-white text-uppercase m-0">vozidiel</h1>
            </a>

            {{-- ---- WINDOW FOR PART LIST ---- --}}
            <a href="{{route('parts.index')}}" class="col-md-6 parts-div d-flex flex-column justify-content-center">
                <h2 class="text-white text-uppercase m-0">Zoznam</h2>
                <h1 class="text-white text-uppercase m-0">dielov</h1>
            </a>

        </div>
    </div>

</section>

@endsection
