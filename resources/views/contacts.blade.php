@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container2">
            <h1 class="contacts__page-title">{{ $title }}</h1>
            <div>
        		<p class="contact_text">По всем возникшим вопросам Вы можете обратиться к нам лично, связаться по телефону или написать на электронную почту</p>
        		<div class="contacts">
        			<div class="contacts_info">
        				<p class="contact_text"><strong>Телефон:</strong><a href="tel:{{ $contacts->phone }}"> {{ $contacts->phone }}</a> </p>
        			</div>
        		    <div class="contacts_info">
        				<p class="contact_text"><strong>Электронная почта:</strong><a href="mailto:{{ $contacts->email }}"> {{ $contacts->email }}</a></p>
        			</div>
        			<div class="contacts_info">
        				<p class="contact_text"><strong>Адрес:</strong> {{ $contacts->address }} </p>
        			</div>
        		</div>
        		<div class="contacts">
        			<p class="contact_text"><strong>Режим работы:</strong> {{ date('H:i', strtotime($contacts->start_working_hours)) }} – {{ date('H:i', strtotime($contacts->end_working_hours)) }}</p>
        		</div>
        	</div>
    		<div>
                <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A2be3405f9ad34178dc1e72f5c1755f96ba8f050d6b5971047906abb0a31f2c32&amp;width=1280&amp;height=720&amp;lang=ru_RU&amp;scroll=true"></script>
    		</div>
        </div>
    </div>         
</div>
@endsection
