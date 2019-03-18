<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Available Products</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .striped {
                background-color: #dddddd;
            }

            .borderSpace15 {
                padding: 15px;
            }

            .fs14 {
                font-size: 1.166em;
                /* approx 14 pixels, but scalable */
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="title m-b-md">
                Available Products
            </div>
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
        </div>
    </body>
</html>
