@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Двухфакторная проверка') }}</div>
                    <div class="card-body">
                     @if(session()->has('message') == 'The two factor code has been sent again')
                        <p class="alert alert-info">
                            Двухфакторный код отправлен повторно
                        </p>
                    @endif
                    <form method="POST" action="{{ route('verify.store') }}">
                        @csrf
                        <p class="text-muted">
                            Мы отправили Вам электронное письмо, содержащее двухфакторный код входа.
                            Если вы не получили его, нажмите <a href="{{ route('verify.resend') }}">здесь</a>.
                        </p>
                    
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            <input name="two_factor_code" type="text" 
                                class="form-control{{ $errors->has('two_factor_code') ? ' is-invalid' : '' }}" 
                                required autofocus placeholder="Двухфакторный код">
                            @if($errors->has('two_factor_code'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('two_factor_code') }}
                                </div>
                            @endif
                        </div>
                    
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary px-4">
                                    Отправить
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
