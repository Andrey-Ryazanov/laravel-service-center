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
                <div class="card-header"><h2>Данные аккаунта</h2></div>
                    <div class="card-body">
                        @foreach ($data as $user_info_auth)
                        <form class = "form-profile" method="POST" action="{{ route('update-profile') }}"> 
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
                                <p class ="text">Логин</p>    
                                <input class = "form-control @error('login') is-invalid @enderror" name = "login" id = "login" type="text" value = "{{ $user_info_auth->login }}">
                                @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class = "edit-form">
                                <p class ="text">Почта</p>
                                <input class = "form-control @error('email') is-invalid @enderror" name = "email" id = "email" type ="email" value="{{ $user_info_auth->email }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class = "edit-form">
                                <p class ="text">Телефон</p>
                                <input class = "form-control @error('phone') is-invalid @enderror"  name = "phone" id = "phone" type ="phone" value="{{ $user_info_auth->phone }}">
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
                        @endforeach
                </div>
            </div>
        </div>  
    </div>
</div>
</div>
@endsection