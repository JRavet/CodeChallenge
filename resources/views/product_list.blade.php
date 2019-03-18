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

            .mb20 {
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="title m-b-md">
                Available Products
            </div>
            <div class="row flex-center">
                <div class="col-xs-12 mb20">
                    <h3 id="orderDateHeader"> Order date: {{ $orderDate }} </h3>

                    Change order date:
                    <input name="orderDate" id="orderDatePicker" type="date" value="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}">
                </div>
            </div>
            <div id="productList">
                @include('product_list_partial', ['products' => $products])
            </div>
        </div>
    </body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
jQuery(document).ready(function() {

  function ajaxUpdateView()
  {
    $.ajax({
      dataType: 'json',
      url: '/ajaxReloadProductListPartial',
      data: {
        orderDate: $('#orderDatePicker').val()
      },
      method: 'GET',
      success: function(data) {
        $('#orderDateHeader').text('Order date: ' + data['orderDateHeaderText']);
        $('#productList').html(data['productListHtml']);
      }
    });
  }

  {{-- (Using a blade comment so it is not viewable by smart users) --}}
  {{-- When the user de-selects the input element, use ajax to update the view with the new data --}}
  $('#orderDatePicker').on('blur', function (e) {
    e.preventDefault();
    ajaxUpdateView();
  });

});
</script>
