
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/logo_withouttext.png') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? 'Gadget Genius' }}</title>
    <meta name="description" content="@include('description')">


  <!-- Font Awesome -->
  <link rel="stylesheet" href="/admin/plugins/fontawesome-free/css/all.min.css">


  <!-- Theme style -->
  <link rel="stylesheet" href="/admin/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
       (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
       m[i].l=1*new Date();
       for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
       k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
       (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
    
       ym(93647571, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
       });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/93647571" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    
    <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-TN36T67');</script>
    <!-- End Google Tag Manager -->

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- jQuery -->
    <script src="/admin/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{asset("vendor/cookie-consent/css/cookie-consent.css")}}" rel="stylesheet" type="text/css">
    
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TN36T67"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
            <div class="container">

              <!--  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> -->

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img class = "logo" src = "/img/new_logo.png">
                    </a>
                    </ul>
                    
                    <!--Search side of Navbar-->
                   <!-- <div class="navbar-nav ms-auto">
                    <div class="d1">
                        <form class ="searching">
                            <input type="text" placeholder="Искать здесь...">
                            <button type="submit"></button>
                        </form>
                    </div>
                    </div> -->

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        <a class="nav-item navbar-brand navbar-brand-add" href = "{{ url('/catalog') }}">
                            Каталог
                        </a>
                        <a class="nav-item navbar-brand navbar-brand-add" href = "{{ url('/contacts') }}">
                            Контакты
                       </a> 
                        @guest
                            <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img src ="/img/user.png" class = "imgUser">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @if (Route::has('login'))
                                <li class="dropdown-item">
                                    <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Вход</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="dropdown-item">
                                    <a class="nav-link" href="{{ route('register') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Регистрация</a>
                                </li>
                            @endif
                            </ul>
                            </li>
                        @else

                            <li class="nav-item dropdown notification">
                                <a id="navbarDropdown" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src ="/img/notification.png" class = "imgUser">
                                </a>
                               <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <div class="modal__body" style = "display:none;">
                                        <div class="modal__tabs">
                                            <div class="modal-wrapper">
                                                <div class="modal-header">
                                                    <span class="modal-header-title"></span>
                                                </div>
                                                 <div class="modal_service_cart">
                                                    <div class="modal-service">
                                                        <div class="modal_service__img-container">
                                                            <img class="service__img">
                                                        </div>
                                                        <div class="modal_service_info">
                                                            <div class="modal_service__text-container">
                                                                <div class="modal-service__text">
                                                                    <div class="modal-service__name"></div>
                                                                    <div class="service__delete">
                                                                        <div class="service__price"></div>
                                                                        <button class="service__delete_btn"></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    </div> 
                                </div>  
                            </li>
                            
                            <li class="nav-item dropdown">
                                @if (Auth::user()->hasPermissionTo('иметь доступ к главной административной панели'))
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src ="/img/admin.png" class = "imgUser">
                                </a>
                                @else
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src ="/img/user.png" class = "imgUser">
                                </a>
                                @endif
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if (Auth::user()->hasPermissionTo('иметь доступ к главной административной панели'))
                                    <a href="{{ url('/administration') }}" class="dropdown-item"><i class="fa fa-user-circle" aria-hidden="true"></i> 
                                        Администрирование
                                    </a>
                                    @endif
                                    <a href="{{ route('profile-account') }}" class="dropdown-item"><i class="fa fa-user-circle-o" aria-hidden="true"></i> 
                                        Профиль
                                    </a>
                                    <a href="{{ route('myorders') }}" class="dropdown-item"><i class="fa fa-shopping-bag" aria-hidden="true"></i> 
                                       Заказы
                                    </a>
                                    <a id = "cart" href="{{ route('mycart') }}" class="dropdown-item"><i class="fa fa-shopping-cart" aria-hidden="true"></i> 
                                        Корзина
                                    </a>
                                   
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i>
                                        Выйти
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 mt-8">
            @yield('content')
        </main>

        @if (auth()->user())
         <!--   <div id="js-chatik-container" >
				<div id = "viewchat" class="chat-btn chat-btn_load"  data-role="chat-button">
					<div class="chat-btn__image"></div>
					<div class="chat-btn__notification hidden" data-role="chat-notification"></div>
				</div>
				<div id = "chat" class="chat-container chat-container_active" data-role="chat-container" data-user-id="5ec35bc1-e08a-4ab2-97ad-91af9b4288ca" style="bottom: 24px;">
					<div class="chat-header">
						<div class="chat-header__label">Чат CH</div>
						<div id = "closechat" class="chat-header__button-cross" data-role="chat-button-close"></div>
					</div>
					<div id="appchat" data-v-app="">
                        <div class="chat">
                            <div class="chat-wrapper">
                            <div class="chat-messages">
                                <div class="chat-messages__list"><div>
                                    <div>
                                        <div class="greeting">
                                            <div>
                                                <img src="/img/user.png" style ="width:40px; height:40px;">
                                            </div>
                                            <div class="greeting__content">
                                                <div class="greeting__text">Здравствуйте, Вас приветствует техническая служба поддержки CH.</div>
                                                <div class="greeting__actions">
                                                    <div name = "callModer" class="greeting__action-item">
                                                        <div class="greeting__action-link">
                                                           Связаться с оператором
                                                        </div>
                                                   </div>   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat-messages-placeholder">Никому не сообщайте свои персональные данные</div>
                                </div>
                                <div class="dropzone-wrapper">
                                    <div class="chat-add-message-block" id="chat-add-message-block">
                                        <label class="attach-file-button v-popper--has-tooltip" for="input-file">
                                            <input accept="image/*,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword,text/plain,application/pdf" type="file" multiple="" id="input-file" hidden="">
                                        </label>
                                    <div class="chat-add-message-block__input" id="chat-add-message-block-input" data-placeholder="Введите сообщение..." contenteditable="true"></div>
                                        <button class="chat-send-message" type="button" disabled=""></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
        </div>
        </div> -->
        @endif
    </div>

    <script>
         /*   function openChat() {
                    document.getElementById("chat").style.display = "block";
                    document.getElementById("viewchat").style.display = "none";
            }
            document.getElementById("viewchat").addEventListener("click", openChat);

            function closeChat() {
                document.getElementById("chat").style.display = "none";
                document.getElementById("viewchat").style.display = "table";
            }
            document.getElementById("closechat").addEventListener("click", closeChat);
            */
        </script>

    <!-- AdminLTE App -->
    <script src="/admin/dist/js/adminlte.js"></script>
    @stack('scripts');
</body>

</html>
