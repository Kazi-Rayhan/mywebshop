<x-dashboard.shop>
@push('styles')
    <style>



    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    @endpush
    
    <h3><span class="text-primary opacity-25"><i class="fas fa-list" aria-hidden="true"></i></span> Create Service
    </h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-lg">
                    <form action="{{route('shop.category.store')}}" method="POST">
                    <div class="row">

                            @csrf
                            <div class="col-12">
                                <x-form.input type="text" name="name" label="Name" value="{{old('name')}}"/>
                            </div>
                            <div class="col-12">
                                <x-form.input type="text" name="slug" label="Slug" value="{{old('slug')}}"/>
                            </div>


                            <div class="col-12">
                            <label for="exampleFormControlTextarea1">Details</label>
                            <textarea class="form-control" id="" rows="3"></textarea>
                            </div>
                            <div class="col-6 pt-2">
                            <label for="resource">Resource</label>
                            <select id="resource" class="form-control">
                                <option selected>Choose resource...</option>
                                <option>Chair</option>
                                <option>Body message bed</option>
                            </select>
                            </div>
                            <div class="col-6 pt-2">
                            <label for="manager">Number of manager</label>
                                <select class="form-control" id="manager" name="manager" multiple>
                                    <option value="HTML">Sayed Khan</option>
                                    <option value="Jquery">Jayed Khan</option>
                                    <option value="CSS">Ahmed Tamim</option>


                                </select>
                            </div>

                            <div class="col-6 pt-2">
                            <label for="store">Stores</label>
                            <select id="store" class="form-control">
                                <option selected>Choose store...</option>
                                <option>Barisal</option>
                                <option>Patuakhali</option>
                                <option>Barguna</option>

                            </select>
                            </div>
                            <div class="col-6 pt-2">
                                <x-form.input type="text" name="needed_time" label="Needed times" value="{{old('name')}}"/>
                            </div>
                            <div class="col-6 pt-2">
                                <x-form.input type="number" name="free_form" label="Free form" value="{{old('name')}}"/>
                            </div>
                            <div class="col-6 pt-2">
                                <x-form.input type="number" name="free_to" label="Free to" value="{{old('name')}}"/>
                            </div>
                            <div class="col-12 pt-4">
                            <label for="" >Status</label>

                            </div>

                            <div class="form-check form-check-inline ml-5">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                <label class="form-check-label" for="inlineRadio1">Active</label>
                            </div>
                            <div class="form-check form-check-inline ml-5">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                <label class="form-check-label" for="inlineRadio2">Deactive</label>
                             </div>

                            <div class="col-12 pt-4">
                            <label for="" >Available Time</label>

                            </div>
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input ml-1" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label ml-5" for="flexCheckDefault">
                                      Saturday
                                    </label>
                                </div>
                                <div class="row mt-2 mt-2 ml-2">
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control" >
                                    </div>
                                    <div class="m-2">
                                        <span>To</span>
                                    </div>
                          
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" >
                                    <label class="form-check-label ml-4" for="flexCheckDefault">
                                      Sunday
                                    </label>
                                </div>
                                <div class="row mt-2">
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control" >
                                    </div>
                                    <div class="m-2">
                                        <span>To</span>
                                    </div>
                          
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label ml-4" for="flexCheckDefault">
                                    Monday
                                    </label>
                                </div>
                                <div class="row mt-2">
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control" >
                                    </div>
                                    <div class="m-2">
                                        <span>To</span>
                                    </div>
                          
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control" >
                                    </div>
                                 </div>
                            </div>
                            <div class="col-4 mt-1">
                                <div class="form-check">
                                    <input class="form-check-input ml-1" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label ml-5" for="flexCheckDefault">
                                    Tuesday
                                    </label>
                                </div>
                                <div class="row mt-2 mt-2 ml-2">
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control" >
                                    </div>
                                    <div class="m-2">
                                        <span>To</span>
                                    </div>
                          
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label ml-4" for="flexCheckDefault">
                                    Wednesday
                                    </label>
                                </div>
                                <div class="row mt-2">
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control" >
                                    </div>
                                    <div class="m-2">
                                        <span>To</span>
                                    </div>
                          
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label ml-4" for="flexCheckDefault">
                                    Thursday
                                    </label>
                                </div>
                                <div class="row mt-2">
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control" >
                                    </div>
                                    <div class="m-2">
                                        <span>To</span>
                                    </div>
                          
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control" >
                                    </div>
                                 </div>
                            </div>
                            <div class="col-12 mt-1">
                                <div class="form-check">
                                    <input class="form-check-input ml-1" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label ml-5" for="flexCheckDefault">
                                    Friday
                                    </label>
                                </div>
                                <div class="row mt-2 ml-2">
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control" >
                                    </div>
                                    <div class="m-2">
                                        <span>To</span>
                                    </div>
                          
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control" >
                                    </div>
                                </div>
                            </div>
                
   
                        <div class="col-12 pt-2">
                            <button class="btn btn-primary"> <i class="fa fa-plus-square" aria-hidden="true"></i> Save</button>
                            </div>
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
                    <form action="{{route('shop.category.store')}}" method="POST">
                    <div class="row">

                            @csrf
                            <div class="col-12 pt-2">
                            <label for="" >Price</label>

                            </div>
                            <table class="table mx-3">
                                <tbody>

                                    <tr>
                                        <td>Rookie</td>
                                        <td>
                                            <div class="col-12">
                                            <input type="email" class="form-control"  placeholder="Enter Rookie price">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Standard</td>
                                        <td>
                                            <div class="col-12">
                                            <input type="email" class="form-control"  placeholder="Enter Standard price">
                                            </div>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>


                                <div class="col-12 pt-2">
                                    <button class="btn btn-primary"> <i class="fa fa-plus-square" aria-hidden="true"></i> Save</button>
                                    </div>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script>
 $(document).ready(function(){

var multipleCancelButton = new Choices('#manager', {
removeItemButton: true,
maxItemCount:5,
searchResultLimit:5,
renderChoiceLimit:5
});


});

</script>

@endpush
</x-dashboard.shop>
