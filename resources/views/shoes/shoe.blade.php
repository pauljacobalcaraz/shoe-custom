<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    @if(Auth::user()->account_type == null)
    @else
    <x-slot name="header">
        <div class="container-fluid mb-3 clearfix">
            <a href="/brands" class="float-left btn px-1 py-0 ">
                <i class="fas fa-chevron-circle-left text-success">
                </i>
                <small>
                    Add Brands
                </small>
            </a>
            <a href="" class="float-right btn px-1 py-0 ">
                <small>
                    Add Parts
                </small>
                <i class="fas fa-chevron-circle-right text-success">
                </i>
            </a>
        </div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- Button trigger modal -->
            <button type="button" class="btn border border-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="fas fa-plus-square">
                </i>
                Add Shoes
            </button>
        </h2>
        @if(session('message'))
        <div class="col-lg-12">
            <div class="alert alert-warning" role="alert">{{ session('message') }}</div>
        </div>
        @endif
    </x-slot>
    <div class="collapse  container col-lg-6 p-3 rounded" id="collapseExample">
        <form action="/shoes" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group clearfix">
                <div class="form-group float-left clearfix col-12">
                    <label for="name">Brand</label>
                    <br>
                    <select id="selectBrand" class="float-left col-sm-6 col-md-4" name="brand">
                        <option value="none">Select Brand</option>
                        @foreach($brands as $brand)
                        <option value="{{$brand->id}}">{{$brand->name}}
                        </option>
                        @endforeach
                    </select>
                    <small class="btn px-0 float-right">
                        <i class="fas fa-plus-square text-primary ml-1" data-bs-toggle="modal" data-bs-dismiss="#addModal" data-bs-target="#addBrand">
                            Add New Brand</i>
                    </small>
                </div>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required />
                <label for="name">Price</label>
                <input type="number" name="price" class="form-control" required />
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



    <div class="container-fluid clearfix">
        @foreach($shoes as $shoe)
        <div class=" card my-2 col-sm-4 col-lg-3 bg-transparent border-0 float-left">
            <div class="row g-0 col-md-11 col-sm-2 bg-light border rounded">
                <img src="{{asset('images/shoes')}}/{{$shoe->image}}" alt="{{$shoe->name}}" class="col-11 p-2 mt-5 ml-4">
                <div class="card-body">
                    <h5 class="card-title"> {{$shoe->name}}</h5>
                    <p class="card-text">Brand: {{$shoe->brand->name}}</p>
                    <p class="card-text">Price: {{$shoe->price}}</p>
                    <p class="card-text">Updated: {{$shoe->updated_at->diffForHumans()}}</p>
                </div>
                @if(Auth::user()->account_type == null)
                <a href="/shoes/{{$shoe->id}}" class="p-2 text-center btn-primary"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
                @else
                <div class=" text-center d-flex justify-content-evenly p-1">
                    <!-- Button trigger modal -->
                    <button class="btn border border-warning mb-1" data-bs-toggle="modal" data-bs-target="#{{str_replace(" ", "",$shoe->name).$shoe->id}}">
                        <i class="far fa-edit"></i>
                        Edit
                    </button>
                    <form action="/shoes/{{$shoe->id}}" method="POST" class="">
                        @csrf
                        @method('DELETE')
                        <button class="btn border border-danger mb-1">
                            <i class="fas fa-trash-alt"></i>
                            Delete
                        </button>
                    </form>
                </div>
                <a href="/shoes/{{$shoe->id}}" class="p-2 text-center btn-primary"><i class="far fa-eye"></i> View</a>
                @endif

                <!--  Edit Shoes Modal -->
                <div class="modal fade" id="{{str_replace(" ", "",$shoe->name).$shoe->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="{{str_replace(" ", "",$shoe->name).$shoe->id}}">Edit {{$shoe->name}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="{{asset('images/shoes')}}/{{$shoe->image}}" alt="{{$shoe->name}}" width="150">
                                <form action="/shoes/{{$shoe->id}}" method="POST" enctype="multipart/form-data" class="border border-secondary rounded p-2 mb-3">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group bg-warning p-2 rounded">
                                        <label for="name">Brand</label>
                                        <br>
                                        <select id="selectBrand" class="col-sm-6 col-md-4" name="updateBrand" required>
                                            <option value="{{$shoe->brand_id}}">Select Brands</option>
                                            @foreach($brands as $brand)
                                            <option value="{{$brand->id}}">{{$brand->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="hidden" name="intactCurrentImage" class="form-control" value="{{$shoe->image}}" />
                                        <input type="text" name="updatename" class="form-control" value="{{$shoe->name}}" required />
                                    </div>


                                    <div class="form-group">

                                        <label for="name">Price</label>
                                        <input type="number" name="updateprice" class="form-control" value="{{$shoe->price}}" required />
                                    </div>
                                    <div class="modal-footer">
                                        <button type=" submit" class="btn btn-primary">Submit</button>

                                    </div>
                                </form>
                                <form action="/shoes/{{$shoe->id}}" method="POST" enctype="multipart/form-data" class="border border-secondary rounded p-2 mb-3">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for=file">Choose file</label>
                                        <input type="file" accept="image/*" name="file" class="form-control edit-file" id="{{str_replace(" ", "",$shoe->name).$shoe->id}}-choose-file" required value="{{$shoe->image}}" />
                                    </div>

                                    <div class="container col-6">
                                        <div class='edit-file-preview' id="{{str_replace(" ", "",$shoe->name).$shoe->id}}-img-preview"></div>
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

        @endforeach

    </div>


</x-app-layout>


<!-- Modal for Adding New Brands -->
<div class="modal fade bg-static" id="addBrand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select Brand</h5>
            </div>
            <div class="modal-body clearfix">
                <form action="/brands" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for=file">Choose file</label>
                        <input type="file" accept="image/*" name="file" class="form-control" id="brand-choose-file" required />
                    </div>
                    <div class="container col-6">
                        <div id="brand-img-preview"></div>
                    </div>
                    <div class="modal-footer">
                        <button type=" submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    //Shoes
    const shoesChooseFile = document.getElementById('shoes-choose-file');
    const shoesImgPreview = document.getElementById('shoes-img-preview');

    shoesChooseFile.addEventListener('change', function() {
        shoeGetImgData();
    });

    // const brandfiles = shoesChooseFile.files[0];

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

    //Brand
    const brandChooseFile = document.getElementById('brand-choose-file');
    const brandImgPreview = document.getElementById('brand-img-preview');

    brandChooseFile.addEventListener('change', function() {
        brandGetImgData();
    })


    function brandGetImgData() {
        const brandfiles = brandChooseFile.files[0];
        if (brandfiles) {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(brandfiles);
            fileReader.addEventListener('load', function() {
                brandImgPreview.style.display = 'block';
                brandImgPreview.innerHTML = `<img src= ${this.result} class="img-fluid p-4"/>`;
            });
        }
    }


    const editChooseFiles = document.querySelectorAll('.edit-file');
    const editImgPreview = document.querySelectorAll('.edit-file-preview');

    editChooseFiles.forEach(function(input) {

        input.addEventListener('change', function() {
            geteditImgData();
        });

        function geteditImgData() {
            const files = input.files[0];
            // alert();
            if (files) {
                const fileReader = new FileReader();
                fileReader.readAsDataURL(files);
                editImgPreview.forEach(function(preview) {
                    fileReader.addEventListener('load', function() {
                        preview.style.display = 'block';
                        preview.innerHTML = `<img src= ${this.result} class="img-fluid p-4"/>`;
                    });
                });
            }
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>