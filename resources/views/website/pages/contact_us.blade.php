
    @include('website/layout/navbar')
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h1 class="w-800 mb-3">Contact Us</h1>
                <p class="small">Feel free to contact us if you have any queries. We will get back to you promptly.  </p>

                <!-- Email: <a href="mailto:muzamilnaveed10@gmail.com">muzamilnaveed10@gmail.com</a> -->

                <div class="card rounded-0 p-3 card_shadow">
                    <form action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="small">Name <span class="text-danger">*</span> </label>
                                    <input type="text" name="name" id="name" class="form-control rounded-0" placeholder="Your Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="small">Email <span class="text-danger">*</span></label>
                                    <input type="text" name="email" id="email" class="form-control rounded-0" placeholder="Your Email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="subject" class="small">Subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control rounded-0" placeholder="Subject">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="message" class="small">Message <span class="text-danger">*</span></label>
                                <textarea name="message" id="message" cols="30" rows="5" class="form-control rounded-0" placeholder="Your Message"></textarea>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm mt-3">Send Message</button>
                    </form>
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