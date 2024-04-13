@foreach ($receiptDetails as $receiptDetail)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $receiptDetail->product_id }}</td>
    <td>{{ $receiptDetail->product_id }}</td>
    <td>{{ $receiptDetail->quantity }}</td>
    <td>{{ $receiptDetail->price }}</td>
    <td><a href="#" class="btn btn-secondary">Xóa</a></td>
</tr>
@endforeach