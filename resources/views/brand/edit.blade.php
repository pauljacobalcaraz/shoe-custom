<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">



    <div class="container col-8">
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
    </div>
    </form>
    </div>
</x-app-layout>