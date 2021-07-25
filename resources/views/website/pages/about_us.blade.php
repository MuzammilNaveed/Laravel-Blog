
    @include('website/layout/navbar')
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h1 class="w-800 mb-3">About Us</h1>
                <p>
                    <strong> {{$setting->site_name}} </strong> is an online resource providing tutorial articles and open source projects for learning laravel framework.
                </p>

                <p>
                    Our site mainly focuses on making quality learning material for those who are eager to learn laravel. Therefore if you are just getting started or already worked with laravel, you’ll find insightful guides and tutorials to improve your web development skills in laravel.
                </p>

                <div class="bg-light p-3 border-left border-primary text-muted small">
                    “We strive on creating valuable content for online learners, developers and web enthutiasts about Laravel.“
                </div>

            </div>
            <div class="col-md-4">
                @include('website/layout/rightside')
            </div>
        </div>
    </div>

    @include('website/layout/footer')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>    
    <script type="text/javascript" src="{{asset('website/js/menu.js')}}"></script>

</body>
</html>