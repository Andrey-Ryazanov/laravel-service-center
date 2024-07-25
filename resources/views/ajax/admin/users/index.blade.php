@if (!$users->isEmpty())
<div class="card">
    <div class="card-body p-0">
      <table class="table table-striped projects">
            <thead>
              <tr>
                  <th style="width: 5%">
                      ID
                  </th>
                  <th style="width: 20%">
                      Логин
                  </th>
                  <th style="width: 25%">
                      Электронная почта
                  </th>
                  <th style="width: 20%">
                     Телефон
                  </th>
                  <th style="width: 20%">
                    Роль
                  </th>
                   <th style="width: 10%">
                    Действия
                  </th>
              </tr>
            </thead>
            <tbody class ="tbody">
                @foreach ($users as $user)
                <tr>
                  <td>
                    {{ $user['id_user'] }}
                  </td>
                  <td>
                    {{ $user['login'] }}
                  </td>
                  <td>
                    {{ $user['email'] }}
                  </td>
                  <td>
                    {{ $user['phone'] }}
                  </td>
                  <td>
                    @if ($user->hasAnyRole('user','moderator','admin','developer'))
                    {{ $user->roles->pluck('name')->first() }}
                    @endif
                  </td>
                  <td class="project-actions">
                      <a class="btn btn-info btn-sm" href="{{ route('usAbout.edit',$user['id_user']) }}">
                          <i class="fas fa-pencil-alt">
                          </i>   
                      </a>
                    <form action = "{{ route('usAbout.destroy',$user['id_user']) }}" method = "POST" style = "display:inline-block;">
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
  <div class="empty-message__user-image"></div>
  <div class="empty-message__text-wrapper">
    <div class="empty-message__title-user">Пользователи не найдены</div>
  </div>
</div>
@endif
<div class="container">
    <div class="d-flex justify-content-center mt-3">
    {{ $users->links() }}
    </div>
</div>
