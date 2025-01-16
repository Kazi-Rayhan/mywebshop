@extends('voyager::master')
@section('content')
    <div class="container">

        <a href="" class="btn btn-primary">Add Retailer</a>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">QR Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Earn</th>
                    <th scope="col">Withdraw</th>
                    <th scope="col">Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($retailers as $retailer)
                    <tr>
                        <td scope="row">
                            <x-qr.image :size="75" :qr="Voyager::image($retailer->qr)" :url="route('shop.register.form', [
                                'refferal' => $retailer->user->id,
                            ])" />
                         
                        </td>
                        <td>{{ $retailer->user->name }}</td>
                        <td>{{ $retailer->user->email }}</td>
                        <td>{{ $retailer->user->phone }}</td>

                        <td>
                            <a href="" class="btn btn-sm btn-primary pull-left edit"><i class="voyager-edit"></i>
                                Edit</a>
                            <form method="post" action="{{ route('admin.retailer.delete-retailer', $retailer) }}"
                                class="d-none">

                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger pull-left delete"><i
                                        class="voyager-trash"></i> Delete</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
