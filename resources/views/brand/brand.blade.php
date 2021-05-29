<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    @if(Auth::user()->account_type == null)
    <!-- return nothing -->
    @else
    <!-- return the add button -->
    <x-slot name="header">
        <div class="container-fluid mb-1 clearfix">
            <a href="/shoes" class="float-right btn px-1 py-0 ">
                <small>
                    Add Shoes
                </small>
                <i class="fas fa-chevron-circle-right text-success">
                </i>

            </a>
        </div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- Button trigger modal for adding brand -->
            <button type="button" class="btn border border-1" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fas fa-plus-square">
                </i>
                Add Brand
            </button>

        </h2>
        @if(session('message'))
        <div class="col-lg-12">
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
        </div>
        @endif
    </x-slot>

    <!-- Add Brand Modal  -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/brands" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for=file">Choose file</label>
                            <input type="file" accept="image/*" name="file" class="form-control" id="choose-file" />
                        </div>
                        <div class="container col-6">
                            <div id="img-preview"></div>
                        </div>
                        <div class="modal-footer">
                            <button type=" submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="container-fluid  b d-md-flex flex-wrap">
        @foreach($brands as $brand)
        <!-- fetch all brands -->
        <div class=" card my-2 col-md-4 p-0 bg-transparent border-0 ">
            <div class="card col-md-11">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{asset('images/brand')}}/{{$brand->image}}" alt="{{$brand->name}}" class="col-12 p-2">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title ">{{$brand->name}}</h5>
                            <h6 class="card-title ">shoes: {{$brand->shoes->count()}}</h6>
                            <button type="button" class="btn mb-2">
                                {{$brand->name}} <span class="badge bg-info text-dark"> {{$brand->shoes->count()}}</span>
                            </button><br>
                            @if(Auth::user()->account_type == null)
                            <!-- if == null it means 'customer' and return View feature -->
                            <a href="/shoes">
                                <div class="btn btn-primary">View</div>
                            </a>
                            @else
                            <!-- if != null it means  admin and returns the feature for edit and delete data  -->
                            <p class="card-text"><small class="text-muted">Created: {{$brand->created_at->diffForHumans()}}<br>Last Update: {{$brand->updated_at->diffForHumans()}}</small></p>
                            <button class="btn border border-warning mb-1" data-bs-toggle="modal" data-bs-target="#{{str_replace(" ", "",$brand->name).$brand->id}}">
                                <small>
                                    <i class="far fa-edit"></i>
                                    Edit
                                </small>
                            </button>
                            <form action="/brands/{{$brand->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn border border-danger mb-1">
                                    <small>
                                        <i class="fas fa-trash-alt"></i>
                                        Delete
                                    </small>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--  Edit Brand Modal -->
        <div class="modal fade" id="{{str_replace(" ", "",$brand->name).$brand->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="{{str_replace(" ", "",$brand->name).$brand->id}}">Edit {{$brand->name}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="{{asset('images/brand')}}/{{$brand->image}}" alt="{{$brand->name}}" width="150">
                        <form action="/brands/{{$brand->id}}" method="POST" enctype="multipart/form-data" class="border border-secondary rounded p-2 mb-3">
                            @csrf
                            @method('PUT')
                            <div class="form-group">

                                <label for="name">Name</label>
                                <input type="hidden" name="currentImage" class="form-control" value="{{$brand->image}}" />
                                <input type="text" name="name" class="form-control" value="{{$brand->name}}" required />
                            </div>
                            <div class="modal-footer">
                                <button type=" submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        <form action="/brands/{{$brand->id}}" method="POST" enctype="multipart/form-data" class="border border-secondary rounded p-2">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for=file">Choose file</label>
                                <input type="hidden" name="currentName" class="form-control" value="{{$brand->name}}" />
                                <input type="file" accept="image/*" name="file" class="form-control edit-file" id="{{str_replace(" ", "",$brand->name).$brand->id}}-choose-file" required />
                            </div>

                            <div class="container col-6">
                                <div class='edit-file-preview' id="{{str_replace(" ", "",$brand->name).$brand->id}}-img-preview"></div>
                            </div>
                            <div class="modal-footer">
                                <button type=" submit" class="btn btn-primary">Submit</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>


</x-app-layout>
<script>
    const chooseFile = document.getElementById('choose-file');
    // get the id of input type file
    const imgPreview = document.getElementById('img-preview');
    // get the id for previewing the file inserted in the input type


    chooseFile.addEventListener('change', function() {
        getImgData();
    });

    function getImgData() {
        const files = chooseFile.files[0];
        if (files) {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(files);
            fileReader.addEventListener('load', function() {
                imgPreview.style.display = 'block';
                imgPreview.innerHTML = `<img src= ${this.result} class="img-fluid p-4"/>`;
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