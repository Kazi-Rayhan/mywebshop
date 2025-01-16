<x-dashboard.shop>
    
    <h3><span class="text-primary opacity-25"><i class="fas fa-list" aria-hidden="true"></i></span> Create Resource
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
                 
                            <div class="col-12 pt-2">
                                <x-form.input type="text" name="quantity" label="Available seat" value="{{old('quantity')}}"/>
                            </div>
                            <div class="col-12 pt-4">
                            <label for="" >Available Time</label>
                        
                            </div>
                    

                        <div class="col-12 mb-2 ml-2">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" onclick="availableDays()" id="mycheck">
                        <label class="form-check-label" for="flexCheckDefault">
                            Available 24 hours
                        </label>
                        </div>
               
                        </div>
                          
                          <div class="row" id="weeks">
                          <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input ml-1" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label ml-5" for="flexCheckDefault">
                                      Saturday
                                    </label>
                                </div>
                                <div class="row mt-2 mt-2 ml-2">
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control check" >
                                    </div>
                                    <div class="m-2 check">
                                        <span>To</span>
                                    </div>
                          
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control check" >
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
                                        <input type="time" id="inputPassword6" class="form-control check" >
                                    </div>
                                    <div class="m-2 check">
                                        <span>To</span>
                                    </div>
                          
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control check" >
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
                                        <input type="time" id="inputPassword6" class="form-control check" >
                                    </div>
                                    <div class="m-2 check">
                                        <span>To</span>
                                    </div>
                          
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control check" >
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
                                        <input type="time" id="inputPassword6" class="form-control check" >
                                    </div>
                                    <div class="m-2 check">
                                        <span>To</span>
                                    </div>
                          
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control check" >
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
                                        <input type="time" id="inputPassword6" class="form-control check" >
                                    </div>
                                    <div class="m-2 check">
                                        <span>To</span>
                                    </div>
                          
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control check" >
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
                                        <input type="time" id="inputPassword6" class="form-control check" >
                                    </div>
                                    <div class="m-2 check">
                                        <span>To</span>
                                    </div>
                          
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control check" >
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
                                        <input type="time" id="inputPassword6" class="form-control check" >
                                    </div>
                                    <div class="m-2 check">
                                        <span>To</span>
                                    </div>
                          
                                    <div class="">
                                        <input type="time" id="inputPassword6" class="form-control check" >
                                    </div>
                                </div>
                            </div>
                          </div>

                         
                           
                           
                             
                   
                           <div class="col-12">
                           <button class="btn btn-primary ml-3 mt-2"> <i class="fa fa-plus-square" aria-hidden="true"></i> Save</button>
                           </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script>

function availableDays() {
    const x =document.getElementsByClassName('check');
    const mycheck =document.getElementById("mycheck");
    let i;
    if(mycheck.checked==true){

        for (i = 0; i < x.length; i++) {
        x[i].style.display = 'none';
    }
    }else{
        for (i = 0; i < x.length; i++) {
        x[i].style.display = 'inline';
    }
   
    
}
}
</script>

@endpush
</x-dashboard.shop>
