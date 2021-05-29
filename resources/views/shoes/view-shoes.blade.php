<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    @if(Auth::user()->account_type == null)
    <!-- return nothing if == null means customer -->
    @else
    <!-- != null it means admin and returns a feature of adding shoes -->
    <x-slot name="header">
        <div class="container-fluid mb-3 clearfix">
            <a href="/shoes" class="float-left btn px-1 py-0 ">
                <i class="fas fa-chevron-circle-left text-success">
                </i>
                <small>
                    Add Shoes
                </small>
            </a>
        </div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- Button trigger modal to add new Design -->
            <button type="button" class="btn border border-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="fas fa-plus-square">
                </i>
                Add Design
            </button>
        </h2>

    </x-slot>



    <div class="container-fluid py-3">
        <!-- collapse features for adding shoes -->
        <div class="collapse  container col-lg-6 p-3 rounded" id="collapseExample">
            <!-- Modal for new part -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/parts" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" required />
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type=" submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!-- adding new designs -->
            <form action="/designs" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group clearfix">
                    <div class="form-group float-left clearfix col-12">
                        <label for="name">Part</label>
                        <br>
                        <!-- displaying data of Part model -->
                        <select id="selectPart" class="float-left col-sm-6 col-md-4" name="part" required>
                            <option value="">Select Part</option>
                            @foreach($selectParts as $selectPart)
                            <option value="{{$selectPart->id}}">
                                {{$selectPart->name}}
                            </option>
                            @endforeach
                        </select>
                        <small class="btn px-0 float-right">
                            <!-- trigger for modal add new part -->
                            <i class="fas fa-plus-square text-primary ml-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Add New Part</i>
                        </small>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" required />
                    <label for="name">Price</label>
                    <input type="number" name="price" class="form-control" required />
                    <input type="hidden" name="shoe_id" class="form-control" value={{$shoe->id}} />
                </div>
                <div class="form-group">
                    <label for=file">Choose file</label>
                    <input type="file" accept="image/*" name="file" class="form-control" id="shoes-choose-file" required />
                </div>
                <div class="container col-6">
                    <div id="shoes-img-preview"></div>
                </div>
                <div class="modal-footer">
                    <div class="btn btn-danger" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Cancel</div>
                    <button type=" submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        @endif
        <div class="container-fluid">
            <div class="card mb-3">
                <div class="row g-0 py-4">
                    <div class="col-md-12 ">
                        <div class="container col-md-6 position-relative float-left">
                            <img src="{{asset('images/shoes')}}/{{$shoe->image}}" alt="{{$shoe->name}}">
                            @if($design_order_lists != null)
                            <!-- if custom is empty -->
                            @foreach($design_order_lists as $selected_custom)
                            <!-- Display the value/s of customs parts -->
                            @php
                            $customs = $designs->where('id', $selected_custom);
                            @endphp
                            @foreach($customs as $custom)
                            <!-- Display all selected customized parts -->
                            <img src="{{asset('images/designs')}}/{{$custom->image}}" alt="{{$custom->image}}" class="position-absolute top-50 start-50 translate-middle">
                            @endforeach
                            @endforeach
                            @endif
                        </div>
                        <div class="card-body col-md-6 float-right">
                            <div class="p-1 d-md-flex">
                                <div class="card-body col-3">
                                    <img src="{{asset('images/brand')}}/{{$shoe->brand->image}}" alt=" {{$shoe->brand->name}}" class="col-12">
                                </div>
                                <div class="card-body col-9">
                                    <h1 class="card-title">Name: {{$shoe->name}}</h1>
                                    <p class="card-text">Price: {{number_format($shoe->price)}}</p>
                                    @if(Auth::user()->account_type != null)
                                    <p class="card-text"><small class="text-muted">Created: {{$shoe->created_at->diffForHumans()}}</small></p>
                                    <p class="card-text"><small class="text-muted">Last Update: {{$shoe->updated_at->diffForHumans()}}</small></p>
                                    @endif
                                </div>
                            </div>
                            <div class="container pt-3">
                                @if(Auth::user()->account_type == null)
                                <!-- Modal for Cart Review -->
                                <div class="modal fade bg-static" id="addToCart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Review Order</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container d-md-flex">
                                                    <div class="col-md-5">
                                                        <img src="{{asset('images/shoes')}}/{{$shoe->image}}" alt="{{$shoe->name}}">
                                                    </div>
                                                    <div class="col-md-5 p-4">
                                                        <h5 class="card-title">Name: {{$shoe->name}}</h5>
                                                        <p class="card-text">Price: {{number_format($shoe->price)}}</p>
                                                    </div>
                                                </div>
                                                <div class="container d-md-flex">
                                                    @if($design_order_lists == null)
                                                    <!-- if custom is empty -->
                                                    @else
                                                    <table class="table table-striped mt-3">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" colspan="4">
                                                                    <h3 class="card-title">Modified Parts</h3>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th scope="col">Name</th>
                                                                <th scope="col">Image</th>
                                                                <th scope="col">Price</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($design_order_lists as $selected_custom)
                                                            <!-- Display the value/s of customs parts -->

                                                            @php
                                                            $customs = $designs->where('id', $selected_custom * 1);
                                                            @endphp
                                                            @foreach($customs as $custom)

                                                            <tr>
                                                                <td>
                                                                    <form action="/remove_custom_part" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="remove_custom_design" value="{{$custom->part_id}}" />
                                                                        <button type="submit">
                                                                            <i class="fas fa-minus-circle text-danger"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
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

                                                            <!-- display sum for the selected designs -->
                                                            <tr>
                                                                <td>
                                                                    <b>Total</b>
                                                                </td>
                                                                <td colspan="5" class="text-end">
                                                                    @if($sum !=0)
                                                                    <b>
                                                                        Php {{number_format($sum,2)}}
                                                                    </b>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <b>Grand Total</b>
                                                                </td>
                                                                <td colspan="5" class="text-end">
                                                                    @if($sum !=0)
                                                                    <b><u>
                                                                            Php {{number_format($sum + $shoe->price,2)}}
                                                                        </u>
                                                                    </b>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @endif

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <form action="/orders" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="shoe_id" value="{{$shoe->id}}">
                                                    <button type=" submit" class="btn btn-primary">Submit</button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                @if($design_order_lists != null)
                                <!-- if custom is empty -->
                                <table class="table table-striped mt-3">
                                    <thead>
                                        <tr>
                                            <th scope="col" colspan="4">
                                                <h3 class="card-title">Modified Parts</h3>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($design_order_lists as $selected_custom)
                                        <!-- Display the value/s of customs parts -->

                                        @php
                                        $customs = $designs->where('id', $selected_custom * 1);
                                        @endphp
                                        @foreach($customs as $custom)

                                        <tr>
                                            <td>
                                                <form action="/remove_custom_part" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="remove_custom_design" value="{{$custom->part_id}}" />
                                                    <button type="submit">
                                                        <i class="fas fa-minus-circle text-danger"></i>
                                                    </button>
                                                </form>
                                            </td>
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

                                        <!-- display sum for the selected designs -->
                                        <tr>
                                            <td>
                                                <b>Total</b>
                                            </td>
                                            <td colspan="5" class="text-end">
                                                @if($sum !=0)
                                                <b>
                                                    Php {{number_format($sum,2)}}
                                                </b>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Grand Total</b>
                                            </td>
                                            <td colspan="5" class="text-end">
                                                @if($sum !=0)
                                                <b><u>
                                                        Php {{number_format($sum + $shoe->price,2)}}
                                                    </u>
                                                </b>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif

                                    </tbody>
                                </table>
                                <button class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#addToCart">
                                    <i class="fas fa-shopping-cart"></i>
                                    Proceed Order
                                </button>
                            </div>
                            @else
                            <h5 class="card-title">Design Parts</h5>
                            @foreach($shoeParts->unique('part_id') as $shoePart )
                            @php
                            $shoeDesigns = $designs->where('part_id', $shoePart->part_id)->where('shoe_id', $shoe->id);
                            @endphp
                            <a href="#{{$shoePart->part->id}}{{$shoePart->part->name}}" class="text-decoration-none">
                                <button type="button" class="btn mb-2">
                                    {{$shoePart->part->name}} <span class="badge bg-info text-dark">{{$shoeDesigns->count()}}</span>
                                </button>
                            </a>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid d-flex p-0 ">
                <div id="list-example" class="list-group col-md-3">
                    <div class="container-fluid bg-success sticky-top p-0">
                        @foreach($shoeParts->unique('part_id') as $shoePart )
                        <a class="list-group-item list-group-item-action" href="#{{$shoePart->part->id}}{{$shoePart->part->name}}"> {{$shoePart->part->name}} </a>
                        @endforeach
                    </div>
                </div>
                <div data-bs-offset="0" class="scrollspy-example p-4 clearfix border-start border-dark" tabindex="0">
                    @foreach($shoeParts->unique('part_id') as $shoePart )
                    <h4 id="{{$shoePart->part->id}}{{$shoePart->part->name}}">{{$shoePart->part->name}}</h4>
                    <div class="container-fluid clearfix border float-left p-4 d-md-flex justify-content-evenly mb-4">
                        @php
                        $shoeDesigns = $designs->where('part_id', $shoePart->part_id)->where('shoe_id', $shoe->id);
                        @endphp
                        @foreach($shoeDesigns as $shoeDesign)
                        <div class=" card my-2 col-sm-4 col-lg-3  border-0 ">
                            <div class="row g-0 col-md-12 col-sm-2 bg-light border rounded">
                                <img src="{{asset('images/designs')}}/{{$shoeDesign->image}}" alt="{{$shoeDesign->image}}" class="col-11 p-2 mt-5 ml-4">
                                <div class="card-body">
                                    <h5 class="card-title"> {{$shoeDesign->name}}</h5>
                                    <p class="card-text">Price: {{$shoeDesign->price}}</p>
                                    @if(Auth::user()->account_type == null)
                                    @else
                                    <p class="card-text">Updated: {{$shoeDesign->updated_at->diffForHumans()}}</p>
                                    @endif
                                </div>
                                <div class="text-center d-flex justify-content-evenly p-1">
                                    @if(Auth::user()->account_type == null)
                                    <form action="/custom" method="POST">
                                        @csrf
                                        <input type="hidden" name="add_custom_part" value="{{$shoeDesign->part->id}}" />
                                        <input type="hidden" name="add_custom_design" value="{{$shoeDesign->id}}" />
                                        <button class="btn border border-danger mb-1 btnDesign" id="{{$shoeDesign->id}}">
                                            <i class="far fa-hand-pointer"></i>
                                            Select {{$shoeDesign->id}}{{$shoeDesign->part->id}}
                                        </button>
                                    </form>

                                    @else
                                    <!-- Button trigger modal -->
                                    <button class="btn border border-warning mb-1" data-bs-toggle="modal" data-bs-target="#{{str_replace(" ", "",$shoeDesign->name).$shoeDesign->id}}">
                                        <i class="far fa-edit"></i>
                                        Edit
                                    </button>
                                    <form action="/designs/{{$shoeDesign->id}}" method="POST" class="">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn border border-danger mb-1">
                                            <i class="fas fa-trash-alt"></i>
                                            Delete
                                        </button>
                                    </form>
                                    @endif
                                </div>

                                <!--  Edit Design Modal -->
                                <div class="modal fade" id="{{str_replace(" ", "",$shoeDesign->name).$shoeDesign->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="{{str_replace(" ", "",$shoeDesign->name).$shoeDesign->id}}">Edit {{$shoeDesign->name}}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img src="{{asset('images/designs')}}/{{$shoeDesign->image}}" alt="{{$shoeDesign->name}}" width="150">
                                                <form action="/designs/{{$shoeDesign->id}}" method="POST" enctype="multipart/form-data" class="border border-secondary rounded p-2 mb-3">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group bg-warning p-2 rounded">
                                                        <label for="name">Part</label>
                                                        <br>
                                                        <select id="selectBrand" class="col-sm-6 col-md-4" name="updatePart" required>
                                                            <option value="{{$shoeDesign->part->id}}">{{$shoeDesign->part->name}}</option>
                                                            @foreach($selectParts as $selectPart)
                                                            <option value="{{$selectPart->id}}">
                                                                {{$selectPart->name}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="hidden" name="intactCurrentImage" class="form-control" value="{{$shoeDesign->image}}" />
                                                        <input type="text" name="updatename" class="form-control" value="{{$shoeDesign->name}}" required />
                                                    </div>


                                                    <div class="form-group">

                                                        <label for="name">Price</label>
                                                        <input type="number" name="updateprice" class="form-control" value="{{$shoeDesign->price}}" required />
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type=" submit" class="btn btn-primary">Submit</button>

                                                    </div>
                                                </form>
                                                <form action="/designs/{{$shoeDesign->id}}" method="POST" enctype="multipart/form-data" class="border border-secondary rounded p-2 mb-3">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for=file">Choose file</label>
                                                        <input type="hidden" name="currentName" class="form-control" value="{{$shoe->name}}" />
                                                        <input type="file" accept="image/*" name="file" class="form-control edit-file" id="{{str_replace(" ", "",$shoePart->name).$shoePart->id}}-choose-file" required value="{{$shoe->image}}" />
                                                    </div>

                                                    <div class="container col-6">
                                                        <div class='edit-file-preview' id="{{str_replace(" ", "",$shoePart->name).$shoePart->id}}-img-preview"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type=" submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    const test1 = document.querySelectorAll('.btnDesign');

    test1.forEach(function(btn) {
        btn.addEventListener('click', function() {
            console.log(btn.id);

        })
    })

    const shoesChooseFile = document.getElementById('shoes-choose-file');
    const shoesImgPreview = document.getElementById('shoes-img-preview');

    shoesChooseFile.addEventListener('change', function() {
        shoeGetImgData();
    });


    function shoeGetImgData() {
        const shoesfiles = shoesChooseFile.files[0];
        if (shoesfiles) {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(shoesfiles);
            fileReader.addEventListener('load', function() {
                shoesImgPreview.style.display = 'block';
                shoesImgPreview.innerHTML = `<img src= ${this.result} class="img-fluid p-4"/>`;
            });
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>