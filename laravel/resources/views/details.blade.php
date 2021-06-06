@extends('layout')


@section('content')
    <div class="container px-4 px-lg-5">
        {{-- <div class="row gx-4 gx-lg-5 justify-content-center"> --}}
            
            <moviedetail-component id="{{$id}}"></moviedetail-component>

            
        {{-- </div> --}}
    </div>
@endsection


<style>
    .masthead{
        padding-top: 11rem !important;
        /* padding-bottom: 0 !important; */
    }

    #mainNav{
  background-color: #100f17 !important;
}
</style>