@extends('components.head')

@section('body')
    <section id="list">
        <div class="container w-75 pt-5">

            {{-- ---- HEADER OF CAR EDIT PAGE ---- --}}
            <div class="row">
                <div class="col-md-1 d-flex align-items-center justify-content-center">
                    <a href="{{ route('cars.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                        </svg>
                    </a>
                </div>
                <div class="col-md-11 text-center">
                    <h1 class="text-uppercase text-white">Vozidlo <span class="fw-bold">{{$car->name}}</span></h1>
                </div>
            </div>

            {{-- ---- BODY OF CAR EDIT PAGE ---- --}}
            <div class="bg-white px-5 rounded">
                <div class="row">
                    <div class="col-12 mt-3">

                        {{-- ---- ERROR MESSAGES ---- --}}
                        @include('components.errror-messages')

                        {{-- ---- EDIT CAR FORM ---- --}}
                        <form action="{{ route('cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="d-flex flex-column">

                                {{-- Vehicle Name --}}
                                <label for="name">Meno vozidla: <span class="text-danger">*</span></label>
                                <input id="name" class="rounded ps-2 mb-2" type="text" name="name" placeholder="Skoda Felicia 1994" value="{{ $car->name }}">

                                {{-- Registration Checkbox --}}
                                <select id="is_registered" name="is_registered" class="my-2 ps-2 py-1 w-25 rounded" onchange="updateLabelSelect()">
                                    <option value="1" {{ $car->is_registered == 1 ? 'selected' : '' }}>Registrované</option>
                                    <option value="0" {{ $car->is_registered == 0 ? 'selected' : '' }}>Neregistrované</option>
                                </select>

                                {{-- Registration Number --}}
                                <label id="registrationLabel" for="registration_number">Registračné číslo:</label>
                                <input id="registration_number" class="rounded ps-2 mb-3" type="number" name="registration_number" placeholder="199456" value="{{ $car->registration_number }}">

                                {{-- Submit Button --}}
                                <button class="btn btn-primary mt-3 py-1 w-25 rounded px-2 text-uppercase" type="submit">Upraviť</button>

                                {{-- Script for updating label --}}
                                <script>
                                    function updateLabelSelect() {
                                        var select = document.getElementById("is_registered");
                                        var label = document.getElementById("registrationLabel");

                                        var selectedOption = select.options[select.selectedIndex];

                                        if (selectedOption.value === "1") {
                                            label.innerHTML = 'Registračné číslo: <span class="text-danger">*</span>';
                                        } else {
                                            label.innerHTML = 'Registračné číslo: ';
                                        }
                                    }
                                    updateLabel();
                                </script>
                            </div>
                        </form>

                        {{-- Delete Button --}}
                        <form action="{{ route('cars.destroy', $car->id) }}" method="post" class="d-inline w-25">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger mt-3 text-uppercase" type="submit">Vymazať</button>
                        </form>
                    </div>
                </div>


                {{-- ---- PARTS CONNECTED WITH THE CAR ---- --}}
                <div class="row mt-5 pt-3">
                    <div class="col-md-12">

                        {{-- ---- HEADER ---- --}}
                        <label class="text-uppercase mb-4">Všetky diely pre <span class="fw-bold">{{ $car->name }}</span>:</label>

                        {{-- ---- PART LIST ---- --}}
                        <table class="table table-striped table-hover w-100 text-center">
                            <thead class="thead-dark">
                            <tr>
                                <th>Seriové č.</th>
                                <th>Meno</th>
                                <th>Pre vozidlo</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($parts as $part)
                                <tr>
                                    <td>{{ $part->serialNumber }}</td>
                                    <td>{{ $part->name }}</td>
                                    <td>{{ $car->name }}</td>
                                    <td>
                                        <form action="{{ route('parts.removeFromVehicle', $part->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-dark rounded px-2 py-1 text-uppercase fw-bold">Odpojiť od vozidla</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


                        {{-- ---- NO CONNECTED PART WITH THE CAR ---- --}}
                        @if($count == 0)
                            <p class="text-center mt-5">K vozidlu ešte neboli pridelené žiadne diely.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
