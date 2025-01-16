<x-dashboard.shop>
    
    <h3>{{ __('words.personal_trainers') }}</h3>
    
    <hr>
    <form action="{{route('shop.package.levels.assign_manager_store',$level)}}" method="post">
    @csrf


        @foreach ($personal_trainers as $trainer)
    
            <div class="form-check form-check-inline">
                <input  @if($level->users->contains($trainer->id))  checked @endif class="form-check-input" name="trainers[]" type="checkbox" id="trainer{{ $loop->iteration }}" value="{{$trainer->id}}">
                <label class="form-
                -label" for="trainer{{ $loop->iteration }}">{{ $trainer->fullName }}</label>
            </div>
        @endforeach
        <div class="row mt-4">
            <button class="btn btn-primary ml-3"> <i class="fa fa-plus-square" aria-hidden="true"></i>
                {{ __('words.save_btn') }}</button>

        </div>
    </form>

    @push('scripts')
    @endpush
</x-dashboard.shop>
