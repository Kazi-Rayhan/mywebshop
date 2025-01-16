<h3>{{ __('words.ticket_create_title') }}</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-lg">
                    <form action="{{ route('retailer.tickets.store') }}" method="POST" enctype='multipart/form-data'>
                        @csrf
                        <div class="col-12">
                            <x-form.input type="text" name="subject" label="{{ __('words.ticket_subject') }}" value="{{ old('subject')}}" />
                        </div>
                        <div class="col-12">
                            <x-form.input type="textarea"  name="massage" label="{{ __('words.subject') }}" >{{ old('massage')}} </x-form.input>
                        </div>
                        <div class="col-12">
                            <x-form.input type="file" name="image" label="{{ __('words.ticket_image') }}" value="{{ old('Image')}}"/>

                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">{{ __('words.submit_btn') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>