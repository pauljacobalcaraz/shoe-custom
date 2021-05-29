<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <div class="container d-md-flex">
        <div class="container-fluid mt-2">
            <div class="container-fluid">
                Customized
            </div>
            <div class="container-fluid p-0 position-relative rounded">
                <img src="{{asset('images/shoes')}}/{{$order->shoe->image}}" alt="{{$order->shoe->image}}">
                @foreach($design_order as $customize)

                @php
                $customs = $designs->where('id', $customize->design_id)
                @endphp
                <!-- need to quer y the orders and display -->
                @foreach($customs as $custom)
                @php
                $sum += $custom->price
                @endphp
                <img src="{{asset('images/designs')}}/{{$custom->image}}" alt="{{$custom->image}}" class="position-absolute top-50 start-50 translate-middle">
                @endforeach
                @endforeach
            </div>

        </div>
        <div class="container-fluid bg-light mt-2">
            <div class="container-fluid">
                Original
            </div>
            <img src="{{asset('images/shoes')}}/{{$order->shoe->image}}" alt="{{$order->shoe->image}}">
        </div>
        <div class="container-fluid p-2 mt-2 col-lg-2">
            <h4>{{$order->shoe->name}}</h4>
            <p>Php {{number_format($order->shoe->price)}}</p>

            <p>Status: {{$order->status->name}}</p>
            <p>Order Date: {{$order->created_at->format('m-d-y')}}</p>
            @if(Auth::user()->account_type == null)

            @if($order->status->id == 3)
            <!-- the status 3 means done -->
            <p class="badge text-dark">Your Shoes was already done! Hope you like it.</p>
            <p class="badge text-dark">To order new, click <a href="/shoes">here</a>
            </p>
            @else
            <form action="/orders/{{$order->id}}" method="POST" class="">
                @csrf
                @method('DELETE')
                <button class="btn border border-danger mb-1">
                    <i class="fas fa-trash-alt"></i>
                    Cancel
                </button>
            </form>
            @endif
            @else
            <div class="container-fluid d-flex justify-content-between p-0">
                @if($order->status->id ==1 )
                <!-- 2 is for recieved -->
                <form action="/orders/{{$order->id}}" method="POST" class="">
                    @csrf
                    @method('PUT')
                    <button class="btn-info btn" name="received" value="2">Received</button>
                </form>
                @endif
                @if($order->status->id ==2)
                <form action="/orders/{{$order->id}}" method="POST" class="">
                    @csrf
                    @method('PUT')
                    <button class="btn-success btn" name="done" value="3">Done</button>
                    @endif
                </form>
            </div>
            @endif
        </div>


    </div>


    <div class="container">

        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th scope="col" colspan="4">
                        <p class="card-title">Customized Parts(Breakdown)</p>
                    </th>
                </tr>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($design_order as $customize)

                @php
                $customs = $designs->where('id', $customize->design_id)
                @endphp
                <!-- need to quer y the orders and display -->
                @foreach($customs as $custom)
                @php
                $sum += $custom->price
                @endphp
                <tr>
                    <td>
                        {{$custom->name}}
                    </td>
                    <td>
                        <img src="{{asset('images/designs')}}/{{$custom->image}}" alt="{{$custom->image}}" width="70">
                    </td>
                    <td>
                        {{number_format($custom->price)}}
                    </td>
                </tr>
                @endforeach
                @endforeach
                <div class="container p-0 py-2  d-flex justify-content-between mt-5 bg-light">
                    <h3>
                        <b>
                            Grand total
                        </b>
                    </h3>
                    <h3>
                        <b>
                            {{number_format($sum + $order->shoe->price)}}
                        </b>
                    </h3>
                </div>


                <!-- display sum for the selected designs -->


            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <b>
                            Custom Total
                        </b>
                    </td>

                    <td>
                        <b>
                            Php {{number_format($sum)}}
                        </b>
                    </td>
                </tr>
            </tfoot>
        </table>

    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>