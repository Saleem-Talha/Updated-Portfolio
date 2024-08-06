<section id="contacts" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <figure data-aos="fade-up">
                        <blockquote class="blockquote">
                            <h2 class="text-main bold-text">Contact Me.</h2>
                        </blockquote>
                        <figcaption class="blockquote-footer mb-0 fs-1 text-uppercase">
                            Section 06
                        </figcaption>
                    </figure>
                </div>
                <div class="col-md-12">
                    <div class="card mt-5">
                        <div class="card-body p-0">
                            <!-- Modify the form with an id attribute -->
                            <form id="myForm">
                                <div class="form-floating mb-3" data-aos="fade-up">
                                    <input type="text" class="form-control bg-transparent" id="username" name="username"
                                        placeholder="Username" />
                                    <label for="username" style="color: gray;">Username</label>
                                </div>
                                <div class="form-floating mb-3" data-aos="fade-up">
                                    <input type="email" class="form-control bg-transparent" id="email" name="email"
                                        placeholder="name@example.com" />
                                    <label for="email" style="color: gray;">Email address</label>
                                </div>
                                <div class="form-floating" data-aos="fade-up">
                                    <textarea name="message" id="message" placeholder="Say Hello!"
                                        class="form-control bg-transparent" cols="30" rows="10"
                                        style="height: 100px"></textarea>
                                    <label for="message" style="color: gray;">Enter Message this message will be sent
                                        directly to my mail
                                    </label>
                                </div>
                                <div class="float-end" data-aos="fade-up">
                                    <!-- Call the sendEmail function when the button is pressed -->
                                    <button type="button" class="btn btn-main mt-3 bold-text" onclick="sendEmail()">
                                        Say Hello !
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>