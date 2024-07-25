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
            <div id = "security" class="card">
                <div class="card-header"><h2>Безопасность</h2></div>
                    <div class="card-body">
                        @foreach ($data as $user_info_auth)
                        <div class = "input-form">
                            <div class = "security__container">
                                <span class="input-group-text">
                                    <i class='fas fa-key'></i>
                                </span>
                                <div class = "security__elem">
                                    <p class = "security__password">Пароль</p>
                                </div>
                                <a href = "{{ route('change-password') }}"> 
                                    <button id = "change_password" type="submit" class="btn btn-primary">
                                        Изменить
                                    </button>
                                </a>
                            </div> 
                        </div> 
                        @if (auth()->user()->two_factor_enabled)
                        <form method = "POST" action = "{{ url('two-factor/disable') }}">
                        @csrf
                        <div class = "input-form">
                            <div class = "security__container">
                                <span class = "input-group-text"><i class="fas fa-lock"></i></span>
                                <div class = "security__elem" >
                                    <p class = "security__header">Двухфакторная аутентификация </p>    
                                    <p class = "security__text twofactor__enable">включена</p>  
                                </div>
                                <button type="submit" class="btn btn-danger">
                                  Выключить
                                </button>
                            </div>
                        </div> 
                        </form>
                        @else
                        <form method = "POST" action = "{{ url('two-factor/enable') }}">
                        @csrf
                            <div class = "input-form">
                            <div class = "security__container">
                                <span class = "input-group-text"><i class="fas fa-lock-open"></i></span>
                                <div class = "security__elem" >
                                    <p class = "security__header">Двухфакторная аутентификация </p>    
                                    <p class = "security__text twofactor__disable">выключена</p>  
                                </div>
                                <button type="submit" class="btn btn-primary">
                                  Включить
                                </button>
                            </div>
                        </div> 
                        </form>
                              @endif
                        @endforeach
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>
@endsection