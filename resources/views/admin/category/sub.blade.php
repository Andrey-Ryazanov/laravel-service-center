@foreach ($subcategories as $sub)
        @if ($sub->id_category != $current)
            <option @if ($sub->id_category == $parent) selected @endif value = "{{$sub->id_category}}">{{ $sub->getFinalLevels($sub) }} {{ $sub->title }}</option>
            @if (count($sub->subcategory))
                @include('admin.category.sub', ['subcategories' => $sub->subcategory, 'current'=>$current, 'parent'=>$parent])
            @endif
        @endif
@endforeach