<x-main>
    <section class="bg-light pb-0">
        <div class="container">
          <div class="row section-title justify-content-center text-center">
            <div class="col-md-9 col-lg-8 col-xl-7">
              <h3 class="display-4">{{ $post->title }}</h3>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-md-10 col-lg-9 col-xl-8">
                {!! $post->body !!}
            </div>
          </div>
        </div>
        <div class="divider divider-bottom bg-primary-3"></div>
      </section>
    </x-main>
