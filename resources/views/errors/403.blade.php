<x-main>
    <section class="bg-primary-3 text-white p-0 o-hidden">
        <div class="container min-vh-100 d-flex flex-column justify-content-between text-center py-4 py-md-5">
            <a href="index.html" class="fade-page">
                <img src="assets/img/logos/jumpstart.svg" alt="Jumpstart" class="bg-white" data-inject-svg>
            </a>
            <div class="my-5">
                <div class="row justify-content-center">
                    <div class="col-5 mb-4">
                        <img src="assets/img/illustrations/illustration-4.svg" alt="403 Forbidden" class="img-fluid">
                    </div>
                    <div class="col-12">
                        <h1>403 - Forbidden</h1>
                        <div class="lead">
                            {{ $exception->getMessage() ?? 'Whoops, it looks like  you don’t have permission to access this page.' }}
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light fade-page">Back to Home</a>
            </div>
        </div>
    </section>
</x-main>
