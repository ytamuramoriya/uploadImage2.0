@extends('layouts.app')

@section('content')
    @include('sweet::alert')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <a href="/arquivo/store">asd</a>
                        <form action="/arquivo/store" method="post" enctype="multipart/form-data">
                            @csrf
                            @php
                                $user_id = \Illuminate\Support\Facades\Auth::id();
                            @endphp
                            <input type="file" name="file">
                            <input type="hidden" name="entidade_id" value="{{$user_id}}">
                            <input type="hidden" name="user_id" value="{{$user_id}}">
                            <input type="hidden" name="nome_entidade" value="user">
                            <input type="submit" value="Enviar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
