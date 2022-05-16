@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Reports</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">


                        <div>
                            <form action="{{route('reports.import.product')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div id="div_file" class="form-group">
                                    <label for="name">Import Update Products</label>
                                    <input type="file" id="file" name="file" class="form-control">
                                    <button type="submit" class="btn btn-primary">Load</button>
                                </div>
                            </form>
                        </div>
                        <div>
                            <form action="{{route('reports.export')}}" method="GET" enctype="multipart/form-data">
                                @csrf

                                <div>
                                    <label for="name">Export All Products</label>
                                    <button type="submit" class="btn btn-primary" style="display: block">download</button>
                                </div>
                            </form>
                        </div>
                        <div>
                            <form action="{{route('reports.sale')}}" method="GET" enctype="multipart/form-data">
                                @csrf

                                <div>
                                    <label for="name">Export Sales</label>
                                    <button type="submit" class="btn btn-primary" style="display: block">download</button>
                                </div>
                            </form>
                        </div>

                        </div>
                    </div>
                </div>
            </div>


    </section>
@endsection
<script>
    window.addEventListener("load", function(){
        document.getElementById("text").addEventListener("keyup",function (){
            fetch(`users.search?text=${ document.getElementById("text").value}`,{
                method:'get'
            })
                .then(response =>response.text())
                .then(html =>{

                    document.getElementById('result').innerHTML += html

                })

        })
    })
</script>


