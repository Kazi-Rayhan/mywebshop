<x-dashboard.shop>

    <h3>{!! __('words.shop_slider_tsec_title') !!}</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('shop.sliders.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">

                            <div class="col-12">
                                <x-form.input type="file" name="image" label="{!! __('words.slider_image') !!}"
                                    multiple="false" />
                            </div>
                            <div class="col-12">
                                <x-form.input type="text" name="heading" label="{!! __('words.slider_heading') !!}" />
                            </div>
                            <div class="col-12 col-md-6">
                                <x-form.input type="url" name="url" label="{!! __('words.slider_url') !!}" />
                            </div>
                            <div class="col-12 col-md-6">
                                <x-form.input type="text" name="button" label="{!! __('words.slider_button') !!}" />
                            </div>
                            <div class="col-12">
                                <x-form.input type="textarea" name="text" label="{!! __('words.slider_pra') !!}" />
                            </div>
                        </div>
                        <button class="btn btn-primary float-right"> <i class="fa fa-plus-square"
                                aria-hidden="true"></i> {!! __('words.save_btn') !!}</button>
                    </form>
                </div>
            </div>

        </div>

    </div>
    <div class="row mt-3">
        @foreach ($sliders as $slider)
            <div class="col-lg-4">
                <div class="card ">

                    <img class="card-img-top" src="{{ Iziibuy::image($slider->image) }}" alt="Card image cap">
                    <div class="card-footer">
                        <div class="dropdown d-flex gap-2">
                            <button class="btn btn-sm btn-outline-secondary " type="button"
                                id="dropdownMenuButton{{ $slider->id }}" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" data-url="{{ route('shop.sliders.update', $slider) }}"
                                data-heading="{{ $slider->heading }}" data-text="{{ $slider->text }}"
                                data-sliderurl="{{ $slider->url }}" data-sliderbutton="{{ $slider->button }}">
                                <i class="fa fa-cog" aria-hidden="true"></i>
                            </button>
                            <x-helpers.delete :url="route('shop.sliders.destroy', $slider)" :id="$slider->id" />


                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit slider</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="update" action="" method="post">
                            @csrf
                            @method('put')


                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Heading:</label>
                                <input type="text" class="form-control" id="header" name="heading">
                            </div>
                            <x-form.input type="url" id="url" name="url"
                                label="{!! __('words.slider_url') !!}" />

                            <x-form.input type="text" id="button" name="button"
                                label="{!! __('words.slider_button') !!}" />

                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Paragraph:</label>
                                <textarea class="form-control" id="paragraph" name="text"></textarea>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send message</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        @push('scripts')
            <script>
                $('#exampleModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var heading = button.data('heading')
                    var text = button.data('text')
                    var url = button.data('url')
                    var sliderurl = button.data('sliderurl')
                    var sliderbutton = button.data('sliderbutton')

                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    var modal = $(this)
                    modal.find('.modal-body #update').attr('action', url)
                    modal.find('.modal-body #header').val(heading)
                    modal.find('.modal-body #url').val(sliderurl)
                    modal.find('.modal-body #button').val(sliderbutton)
                    modal.find('.modal-body #paragraph').val(text)
                })
            </script>
        @endpush
</x-dashboard.shop>
