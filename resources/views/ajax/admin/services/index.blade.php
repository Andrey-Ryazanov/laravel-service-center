@if (!$services->isEmpty())
<div class="card">
    <div class="card-body p-0">
      <table class="table table-striped projects">
          <thead>
              <tr>
                  <th style="width: 5%">
                      ID
                  </th>
                  <th style="width: 30%">
                      Название
                  </th>
                  <th style="width: 55%">
                      Описание
                  </th>

                  <th style="width:20%;">
                      Действия
                  </th>
              </tr>
          </thead>
          <tbody>
              @foreach ($services as $service)
              <tr>
                  <td style="vertical-align:top;">
                    {{ $service->id_service }}
                  </td>
                  <td style="vertical-align:top;">
                    {{ $service->name_service }}
                  </td>
                  <td style="vertical-align:top;">
                    {{ $service->description_service }}
                  </td>
                  <td style="vertical-align:top;">
                      <a class="btn btn-info btn-sm" href="{{ route('service.edit',$service['id_service']) }}">
                          <i class="fas fa-pencil-alt">
                          </i> 
                      </a>
                    <form action = "{{ route('service.destroy',$service['id_service']) }}" method = "POST" style = "display:inline-block;">
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
    <!-- /.card-body -->
  </div>
  @else
<div class="empty-message">
  <div class="empty-message__cart-image"></div>
  <div class="empty-message__text-wrapper">
    <div class="empty-message__title-user">Услуги не найдены</div>
  </div>
</div>
@endif
<div class="container">
    <div class="d-flex justify-content-center mt-3">
    {{ $services->links() }}
    </div>
</div>