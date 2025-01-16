<x-dashboard.shop>
    @push('styles')
    <style>
        .table td{
            vertical-align: middle
        }
    </style>
    @endpush
    
    <h3><span class="text-primary opacity-25"><i class="fas fa-list" aria-hidden="true"></i></span> My Groups
    </h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-lg">
                    <form action="" method="POST">
                        <div class="row">
                            @csrf
                            <div class="col-12">
                                <x-form.input type="text" name="Name" label="Name" value="{{ old('name') }}" />
                            </div>
                            <button class="btn btn-primary ml-3"> <i class="fa fa-plus-square"
                                    aria-hidden="true"></i>Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="card">
              
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
                            <td>Rookie</td>
                            <td>
                               <a class="btn btn-danger btn-sm mt-1" href=""><i class="fas fa-backspace"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Standard</td>
                            <td>
                               <a class="btn btn-danger btn-sm mt-1" href=""><i class="fas fa-backspace"></i></a>
                            </td>
                        </tr>
      
                    </tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>

</x-dashboard.shop>
