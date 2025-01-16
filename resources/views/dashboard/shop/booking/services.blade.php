<x-dashboard.shop>
    @push('styles')
    <style>
        .table td{
            vertical-align: middle
        }
    </style>
    @endpush
    
    <h3><span class="text-primary opacity-25"><i class="fas fa-list" aria-hidden="true"></i></span> My bookings
    </h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success float-right" href="{{route('shop.booking.services.create')}}"><i class="fas fa-plus"></i> Add new service </a>
                </div>
                <div class="card-body shadow-lg">

                    <table class="table">
                        <thead>
                        <tr>
                            
                            <th>Name</th>
                     
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                  
                        <tr>
                            <td><a href="{{route('booking.group.create')}}">Hairdresser cut</a></td>
                   
                            <td>
                            
                                <a class="btn btn-info btn-sm mt-1" href=""><i class="fas fa-edit"></i></a>
              
                            </td>
                        </tr>
      
                    </tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>

</x-dashboard.shop>
