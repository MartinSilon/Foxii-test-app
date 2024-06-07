@extends('components.head')

@section('body')
    <section id="list">
        <div class="container w-75 pt-5">

            {{-- ---- HEADER OF PART EDIT PAGE ---- --}}
            <div class="row">
                <div class="col-md-1 d-flex align-items-center justify-content-center">
                    <a href="{{ route('parts.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                        </svg>
                    </a>
                </div>
                <div class="col-md-11 text-center">
                    <h1 class="text-uppercase text-white">Úprava dielu <span class="fw-bold">{{$part->name}}</span></h1>
                </div>
            </div>

            {{-- ---- BODY OF PART EDIT PAGE ---- --}}
            <div class="bg-white px-5 rounded">
                <div class="row">
                    <div class="col-12 mt-3">

                        {{-- ---- ERROR MESSAGES ---- --}}
                        @include('components.errror-messages')

                        {{-- ---- EDIT PART FORM ---- --}}
                        <form action="{{ route('parts.update', $part->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="d-flex flex-column">

                                {{-- Part Name --}}
                                <label for="name">Meno dielu: <span class="text-danger">*</span></label>
                                <input class="form-control mb-2" type="text" name="name" placeholder="Silenblok MEYLE" value="{{ $part->name }}" required>

                                {{-- Serial Number --}}
                                <label for="serialNumber">Sériové číslo: <span class="text-danger">*</span></label>
                                <input class="form-control mb-2" type="number" name="serialNumber" placeholder="100511" value="{{ $part->serialNumber }}" required>

                                {{-- Car Selection --}}
                                <label for="car_id">Pre auto:</label>
                                <select name="car_id" class="form-select mb-2">
                                    <option value="">Žiadne</option>
                                    @foreach($cars as $car)
                                        <option value="{{ $car->id }}" {{ $part->car_id == $car->id ? 'selected' : '' }}>
                                            {{ $car->name }} ({{ $car->registration_number ? 'registračné č. ' . $car->registration_number : 'bez registračného č.' }})
                                        </option>
                                    @endforeach
                                </select>

                                {{-- Submit Buttons --}}
                                <button class="btn btn-primary w-50 mt-3 text-uppercase" type="submit">Upraviť</button>
                            </div>
                        </form>


                        <form action="{{ route('parts.destroy', $part->id) }}" method="post" class="d-inline w-25">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger mt-3 text-uppercase" type="submit">Vymazať</button>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

