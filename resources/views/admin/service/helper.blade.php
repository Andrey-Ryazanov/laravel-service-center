@foreach ($subcategories as $sub)
    <option @if ($sub->id_category == $current) selected @endif value = "{{$sub->id_category}}">{{ $sub->getFinalLevels($sub) }} {{ $sub->title }}</option>
        @if ($sub->subcategory->count() > 0) 
          @include('admin.service.helper', ['subcategories' => $sub->subcategory, 'current'=>$service->category_id ]) 
        @endif
@endforeach

