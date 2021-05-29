<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    @if(Auth::user()->account_type == null)
    @else
    @endif
    <div class="container pt-2">
        <table class="table caption-top text-center">
            <caption>List of Order</caption>
            <thead>
                <tr>
                    <th scope="col">Order #</th>
                    @if(Auth::user()->account_type == null)
                    @else
                    <th scope="col">Customer</th>
                    @endif
                    <th scope="col">Shoes</th>
                    <th scope="col">Date of Order</th>
                    <th scope="col">Status Modified</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    @if(Auth::user()->account_type == null)
                    @else
                    <td>{{$order->user->name}}</td>
                    @endif
                    <td>{{$order->shoe->name}}</td>
                    <td>{{$order->created_at->format('m-d-y')}}</td>
                    <td>{{$order->updated_at->diffForHumans()}}</td>
                    @if($order->status->id == 1)
                    <!-- 1 means pending -->
                    <td> <a href="/orders/{{$order->id}}" class="btn btn-warning">{{$order->status->name}}</a></td>
                    @elseif($order->status->id == 2)
                    <!-- 2 means received -->
                    <td> <a href="/orders/{{$order->id}}" class="btn btn-info">{{$order->status->name}}</a></td>
                    @else
                    <!-- 3 and else last means received -->
                    <td> <a href="/orders/{{$order->id}}" class="btn btn-success">{{$order->status->name}}</a></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>