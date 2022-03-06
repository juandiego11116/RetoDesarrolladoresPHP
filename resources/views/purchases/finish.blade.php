@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Finish transaction</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <p class="mt-4 text-center text-gray-600 font-bold"> Your transaction is: {{$status}}</p>
                            <p class="mt-4 text-center text-gray-600 font-bold"> Number transaction is: {{$reference}}</p>
                            <p class="mt-4 text-center text-gray-600 font-bold"> Total to pay: {{$price}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
