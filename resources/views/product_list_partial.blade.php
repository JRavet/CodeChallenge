<div class="row flex-center">
    <div class="col-xs-10">
        <table class="table">
            <thead>
                <th> Product Name </th>
                <th> Quantity Available </th>
                <th> Ship Date </th>
            </thead>
            <tbody>
                @php $counter = 0; @endphp

                @foreach ($products as $product)

                    @if ($counter % 2 == 0)
                        @php $rowClass = "striped"; @endphp
                    @else
                        @php $rowClass = ""; @endphp
                    @endif

                    <tr class="{{$rowClass}}">
                        <td class="fs14 borderSpace15"> {{ $product->productName }} </td>
                        <td> {{ $product->inventoryQuantity }} </td>
                        <td class="borderSpace15"> {{ $product->ship_by_date_display }} </td>
                    </tr>

                    @php $counter++; @endphp

                @endforeach
            </tbody>
        </table>
    </div>
</div>