<x-main>
    <section class="bg-primary-3 text-white p-0 o-hidden">
        <div class="container d-flex flex-column justify-content-between text-center py-4 py-md-5">
            <a href="index.html" class="fade-page">
                <img src="assets/img/logos/jumpstart.svg" alt="Jumpstart" class="bg-white" data-inject-svg>
            </a>
            <div class="my-5">
                <div class="row justify-content-center">
                    <div class="col-5 mb-4">
                        <img src="assets/img/illustrations/illustration-4.svg" alt="404 Siden ikke funnet"
                            class="img-fluid">
                    </div>
                    <div class="col-12">
                        <h1>419 - Sesjon utløpt</h1>
                        <div class="lead">Oj, ser ut som din sesjon er utløpt. Klikk knappen under for å starte
                            sesjonen på nytt</div>
                        <a href="{{ route('clear.session') }}" class="btn btn-sm btn-outline-light fade-page">Restart
                            sesjonen</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-main>
