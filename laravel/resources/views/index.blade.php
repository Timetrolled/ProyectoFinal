@extends('layout')

@section('content')
    <!-- Page Header-->
    <header class="masthead">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="site-heading">
                        <h1 id="infiniFilmText">InfiniFilm</h1>
                        <span class="subheading">Descubre en el loop</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content-->
    <div class="container px-4 px-lg-5">
        {{-- <div class="row gx-4 gx-lg-5 justify-content-center"> --}}
            
            <movies-component></movies-component>

            
        {{-- </div> --}}
    </div>

    <a id="myBtn" class="btn-outline-dark mr-md-3 mb-2 mb-md-0" href="#app"><img width="50px" src="https://img.icons8.com/carbon-copy/344/up.png"></a>

   
@stop

@section('javascript')
    <script src="{{ mix('js/buttonScript.js') }}" defer></script>
@endsection