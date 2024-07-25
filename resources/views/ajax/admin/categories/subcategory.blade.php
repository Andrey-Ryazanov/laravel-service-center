@if (!$subcategories->isEmpty())
<div class="card">
    <div class="card-body p-0">
      <table class="table table-striped projects">
          <thead>
                         <tr>
                   <th style="width: 5%">
                      ID
                  </th>
                  <th style="width: 20%">
                      Название
                  </th>
                  <th style="width: 20%;">
                      Изображение
                  </th>
                  <th style="width: 20%">
                      Родительская категория
                  </th>
                  <th style="width: 10%;">
                      Действия
                  </th>
              </tr>
          </thead>
          <tbody>
            @foreach ($subcategories as $sub)
            <tr>
                  <td style="vertical-align:top;">
                  <a href = "{{ url('/administration/subcategory/'.$sub->title) }}">
                    {{ $sub['id_category'] }}
                  </a>
                  </td>
                  <td style = "text-align:left; vertical-align:top;">
                  <a href = "{{ url('/administration/subcategory/'.$sub->title) }}">
                    {{ $sub['title'] }}
                  </a>
                  </td>
                  <td style="vertical-align:top;">
                  @if ($sub['category_image'])
                    <img class ="service_image" src="{{ asset('uploads/categories/'.$sub['category_image']) }}"/>
                    @else Отсутствует
                  @endif
                  </td>
                  @if ($sub->parent)
                  <td style="vertical-align:top;">
                        <a href = "{{ url('/administration/subcategory/'.$sub->parent->title) }}">
                          {{  $sub->parent->title }}              
                        </a><br>
                  </td>
                  @else
                    <td style="vertical-align:top;">
                      Отстутствует
                    </td>
                  @endif
                  <td style="vertical-align:top;">
                      <a class="btn btn-info btn-sm" href="{{ route('category.edit',$sub['id_category']) }}">
                          <i class="fas fa-pencil-alt">
                          </i> 
                      </a>
                    <form action = "{{ route('category.destroy',$sub['id_category']) }}" method = "POST" style = "display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type = "sudmit" class="btn btn-danger btn-sm delete-btn">
                          <i class="fas fa-trash">
                          </i>
                       </button>
                    </form>
                  </td>
              </tr>    
            @endforeach
          </tbody>
      </table>
    </div>
</div>
@else
<div class="empty-message">
  <div class="empty-message__cart-image"></div>
  <div class="empty-message__text-wrapper">
    <div class="empty-message__title-user">Категории не найдены</div>
  </div>
</div>
@endif
<div class="container">
    <div class="d-flex justify-content-center mt-3">
    {{ $subcategories->links() }}
    </div>
</div>