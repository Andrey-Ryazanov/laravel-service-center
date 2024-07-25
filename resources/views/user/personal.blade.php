@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container_card">
            <div class ="menu_board_profile">
                <a href =  "{{ route('profile-personal') }}">
                    <div id = "account" class = "menu_board-item">
                        <span class="security-icons">
                            <i class="fas fa-user-secret"></i>
                        </span>
                        Личные данные
                </div>
                </a>
                <a href =  "{{ route('profile-account') }}">
                    <div id = "account" class = "menu_board-item">
                        <span class = "security-icons">
                            <i class="fas fa-user-shield"></i>
                        </span>
                         Данные аккаунта
                </div>
                </a>
                <a href =  "{{ route('profile-security') }}">
                    <div id = "security" class = "menu_board-item">
                        <span class = "security-icons">
                            <i class="fas fa-shield-alt"></i>
                        </span>
                        Безопасность
                </div>
                </a>
            </div>
            <div id = "account" class="card">
                <div class="card-header"><h2>Личные данные</h2></div>
                    <div class="card-body">
                        <form class = "form-profile" method="POST" action="{{ route('update-personal') }}"> 
                        @csrf
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @elseif (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                            @endif
                            <div class = "edit-form">
                                <p class ="text">Фамилия</p>    
                                <input class = "form-control @error('surname') is-invalid @enderror" name = "surname" id = "surname" type="text" @if (isset($personal->surname)) value = "{{ $personal->surname }}" @endif required>
                                @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class = "edit-form">
                                <p class ="text">Имя</p>
                                <input class = "form-control @error('name') is-invalid @enderror" name = "name" id = "name" type ="name" @if (isset($personal->name)) value="{{ $personal->name }}" @endif required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class = "edit-form">
                                <p class ="text">Отчество</p>
                                <input class = "form-control @error('patronymic') is-invalid @enderror"  name = "patronymic" id = "patronymic" type ="patronymic" @if (isset($personal->patronymic)) value="{{ $personal->patronymic }}" @endif required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> 
                            <div class = "edit-form">
                                <p class ="text">Адрес</p>
                                <input class = "form-control @error('address') is-invalid @enderror"  name = "address" id = "address" type ="address" @if (isset($personal->address)) value="{{ $personal->address }}" @endif required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> 
                           <div class = "input-form">
                                <button type="submit" class="btn btn-primary">
                                    Редактировать
                                </button>
                            </div>
                        </form>
                </div>
            </div>
        </div>  
    </div>
</div>
</div>
@endsection