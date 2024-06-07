@extends('components.head')

@section('body')
    <section id="list">
        <div class="container w-75 pt-5">

            {{-- ---- HEADER OF CAR LIST ---- --}}
            <div class="row">
                <div class="col-md-1 d-flex align-items-center justify-content-center">
                    <a href="{{ route('home') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                        </svg>
                    </a>
                </div>
                <div class="col-md-11 text-center">
                    <h1 class="text-uppercase text-white">List vozidiel</h1>
                </div>
            </div>

            {{-- ---- BODY OF CAR LIST ---- --}}
            <div class="bg-white px-5 rounded">
                <div class="row">
                    <div class="col-12 mt-3">

                        {{-- ---- ERROR MESSAGES ---- --}}
                        @include('components.errror-messages')

                        {{-- ---- ADD CAR BUTTON ---- --}}
                        <button class="accordion-button collapsed rounded px-3 py-1 text-uppercase fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Pridať vozidlo do evidencie
                        </button>

                        {{-- ---- ADD CAR FORM ---- --}}
                        <div id="flush-collapseOne" class="accordion-collapse collapse pb-5" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body px-2 py-2">
                                <form action="{{ route('cars.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex flex-column">

                                        {{-- Vehicle Name --}}
                                        <label for="name">Meno vozidla: <span class="text-danger">*</span></label>
                                        <input id="name" class="form-control mb-2" type="text" name="name" placeholder="Skoda Felicia 1994" value="{{ old('name') }}">

                                        {{-- Registration Checkbox --}}
                                        <div class="form-check my-2">
                                            <input class="form-check-input" type="checkbox" id="is_registered" name="is_registered" value="1" {{ old('is_registered') ? 'checked' : '' }} onchange="updateLabel()">
                                            <label class="form-check-label" for="is_registered">Registrované</label>
                                        </div>

                                        {{-- Registration Number --}}
                                        <label id="registrationLabel" for="registration_number">Registračné číslo:</label>
                                        <input id="registration_number" class="form-control mb-3" type="number" name="registration_number" placeholder="199456" value="{{ old('registration_number') }}">

                                        {{-- Submit Button --}}
                                        <button class="btn btn-primary mt-3 w-25 text-uppercase" type="submit">Pridať</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ---- FILTERING ---- --}}
                <div class="row my-3 mt-4">
                    <div class="col-12">
                        <form action="{{ route('cars.index') }}" method="GET" class="d-flex gap-3">
                            <input type="text" name="search" class="form-control" placeholder="Registračné číslo, Meno" value="{{ request('search') }}">

                            <select name="registered" class="form-control">
                                <option value="1" {{ request('registered') == 1 ? 'selected' : '' }}>Registrované</option>
                                <option value="0" {{ request('registered') == 0 ? 'selected' : '' }}>Neregistrované</option>
                                <option value="" {{ request('registered') === '1' || request('registered') === '0' ? '' : 'selected' }}>-</option>
                            </select>

                            <input type="text" name="range" class="form-control" placeholder="Počet dielov: 1, 3, 5-10" value="{{ request('range') }}">

                            <button type="submit" class="btn btn-primary">Filtrovať</button>
                        </form>
                    </div>
                </div>

                {{-- ---- CAR LIST TABLE ---- --}}
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped table-hover text-center">
                            <thead class="thead-dark">
                            <tr class="head-row">
                                <th>Registračne č.</th>
                                <th>Meno</th>
                                <th>Registrované</th>
                                <th>Počet dielov</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cars as $car)
                                <tr>
                                    <td>{{ $car->registration_number ? $car->registration_number : 'Nevyplnené' }}</td>
                                    <td>{{ $car->name }}</td>
                                    <td>{{ $car->is_registered ? 'Ano' : 'Nie' }}</td>
                                    <td>{{ $car->parts_count }}</td>

                                    {{-- Edit and Delete buttons --}}
                                    <td>
                                        <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-outline-secondary btn-sm text-uppercase fw-bold">Upraviť</a>
                                        <form action="{{ route('cars.destroy', $car->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{-- ---- NO CAR FOUND ---- --}}
                        @if($count == 0)
                            <p class="text-center mt-5">Žiadne vozidla sa nenašli.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>


@endsection
