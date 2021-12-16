@extends('layouts.main')

@section('content')
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home" aria-hidden="true"></i> Currencies</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center text-design2">Welcome to CURRENCIES</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">

            <a href="{{ route('upload') }}" >Upload courses to DB</a>

        </div>
    </div>

@endsection
