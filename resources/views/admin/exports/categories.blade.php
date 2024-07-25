<table>
    <thead>
    <tr>
        <th style = "width: 40px; background: yellow"><b>ID</b></th>
        <th style = "width: 280px; background: yellow"><b>Название</b></th>
        <th style = "width: 200px; background: yellow"><b>Изображение</b></th>
        <th style = "width: 80px; background: yellow"><b>Родительский ID</b></th>
        <th style = "width: 240px; background: yellow"><b>Родительская категория</b></th>
        
    </tr>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>{{ $category->id_category }}</td>
            <td>{{ $category->title }}</td>
            <td>{{ $category->category_image }}</td>
            @if (!is_null($category->parent))
             <td>{{ $category->parent()->pluck('id_category')->first()}}</td>
             <td>{{ $category->parent()->pluck('title')->first() }}</td>
            @else
            <td>-</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>