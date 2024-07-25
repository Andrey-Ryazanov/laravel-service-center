<table>
    <thead>
    <tr>
        <th style = "width: 40px; background: yellow"><b>ID</b></th>
        <th style = "width: 280px; background: yellow"><b>Название</b></th>
        <th style = "width: 800px; background: yellow"><b>Описание</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($services as $service) 
        <tr>
            <td>{{ $service->id_service}}</td>
            <td>{{ $service->name_service }}</td>
            <td style="word-wrap: break-word; max-width: 800px;">{{ $service->description_service }}</td>
        </tr>
    @endforeach
    </tbody>
</table>