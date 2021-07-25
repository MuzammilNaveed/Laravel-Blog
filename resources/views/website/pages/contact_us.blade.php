
    @include('website/layout/navbar')
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h1 class="w-800 mb-3">Contact Us</h1>
                <p>Feel free to contact us if you have any queries. We will get back to you promptly.  </p>

                Email: <a href="mailto:muzamilnaveed10@gmail.com">muzamilnaveed10@gmail.com</a>
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