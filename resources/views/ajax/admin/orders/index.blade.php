@if (!$orders->isEmpty())
<div class="card">
    <div class="card-body p-0">
      <table class="table table-striped projects">
          <thead>
              <tr>
                   <th style="width: 5%">
                       Номер
                  </th>
                  <th style="width: 8%">
                      Код
                  </th>
                  <th style="width: 12.5%">
                     Заказчик
                  </th>
                  <th style="width: 10%">
                      Статус
                  </th>
                 <th style="width: 14%">
                     Способ оказания
                  </th>
                  <th style="width: 8%;">
                     Стоимость
                  </th>
                  <th style="width: 13%">
                      Дата создания
                  </th>
                   <th style="width: 13%">
                      Дата обновления
                  </th>
                  <th style="width: 8%;">
                      Действия
                  </th>
              </tr>
          </thead>
          <tbody>
              @foreach ($orders as $order)
              <tr>
                  <td style = "vertical-align:top;">
                  <a href = "">
                    {{ $order['id_order'] }}
                  </a>
                  </td>
                  <td style = "vertical-align:top;">
                  <a href="{{ route('myorderdetails',$order->code) }}"> 
                    {{ $order->code }}
                  </a>
                  </td>
                   <td style = "vertical-align:top;">
                  <a href = "">
                    {{ $order->login }}
                  </a>
                  </td>
                  <td style = "vertical-align:top;">
                    {{ $order->name_status }}
                  </td>
                   <td style = "vertical-align:top;">
                    {{ $order->name_sdm }}
                  </td>
                  <td style="vertical-align:top;">
                    {{ $order->total }} ₽
                   </td>
                    <td style="vertical-align:top;">
                    {{ $order->created }}
                   </td>
                    <td style="vertical-align:top;">
                    {{ $order->updated }}
                   </td>
                  <td style = "vertical-align:top;">
                      <a class="btn btn-info btn-sm" href="{{ route('orders.show',$order['id_order']) }}">
                          <i class="fas fa-pencil-alt">
                          </i> 
                      </a>
                    <form action = "{{ route('orders.destroy',$order['id_order']) }}" method = "POST" style = "display:inline-block;" enctype ="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <button type = "submit" class="btn btn-danger btn-sm delete-btn">
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
    <div class="empty-message__title-user">Заказы не найдены</div>
  </div>
</div>
@endif
<div class="container">
    <div class="d-flex justify-content-center mt-3">
    {{ $orders->withQueryString()->links() }}
    </div>
</div>