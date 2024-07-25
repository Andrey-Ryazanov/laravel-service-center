@foreach ($subcategories as $sub)
    <option value = "{{$sub->id_category}}">{{ $sub->getFinalLevels($sub) }} {{ $sub->title }}</option>
        @if ($sub->subcategory->count() > 0) 
            @include('admin.service.sub', ['subcategories' => $sub->subcategory ])
        @endif
@endforeach

