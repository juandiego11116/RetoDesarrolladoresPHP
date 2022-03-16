@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Edit Products</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                    <strong>¡Check fields!</strong>
                                    @foreach ($errors->all() as $error)
                                        <span class="badge badge-danger">{{ $error }}</span>
                                    @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            {!! Form::model($product, ['method' => 'PATCH','route' => ['products.update', $product->id]]) !!}
                               <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="photo">Photo</label>
                                            {!! Form::text('photo', null, array('class'=>'form-control')) !!}
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            {!! Form::text('name', null, array('class'=>'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            {!! Form::text('price', null, array('class'=>'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="stock_number">Stock Number</label>
                                            {!! Form::text('stock_number', null, array('class'=>'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <select type="text" name="id_category" class="form-control">
                                                <option></option>
                                                @foreach($categories as $category)
                                                    <option>{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-floating">
                                            <label for="description">Description</label>
                                            {!! Form::textarea('description', null, array('class'=>'form-control')) !!}
                                        </div>
                                    </div>
                                   <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
                                           <label for="visible">Visible</label>
                                           <select type="text" name="visible" class="form-control">
                                               <option></option>
                                               <option>Yes</option>
                                               <option>No</option>
                                           </select>
                                       </div>
                                   </div>
                                   <div class="col-xs-12 col-sm-12 col-md-12">
                                       <button type="submit" class="btn btn-primary">Save</button>
                                   </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
