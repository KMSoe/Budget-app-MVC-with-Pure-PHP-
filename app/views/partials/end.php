<!-- Share App modal -->
<div class="modal" id="share">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="py-3">
                <h5 class="modal-title text-black text-center">Share on</h5>
            </div>
            <div class="modal-body">
                <a href="#">
                    <i class="fab fa-facebook"></i>
                    <p class="text-black">facebook</p>
                </a>
                <a href="#">
                    <i class="fab fa-facebook-messenger"></i>
                    <p class="text-black">Messenger</p>
                </a>
                <a href="#">
                    <i class="fab fa-instagram-square"></i>
                    <p class="text-black">Instagram</p>
                </a>
                <a href="#">
                    <i class="fab fa-twitter-square"></i>
                    <p class="text-black">Twitter</p>
                </a>
            </div>
            <div class="pt-2 pb-3 text-center">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Rate App modal -->
<div class="modal" id="rate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="ps-3 py-3">
                <h5 class="modal-title text-black text-center">Enjoy Our App? Rate!</h5>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-8">
                        <div class="rating mb-1" style="text-align: left;">
                            <i class="fa fa-star" id="star-1"></i>
                            <i class="fa fa-star" id="star-2"></i>
                            <i class="fa fa-star" id="star-3"></i>
                            <i class="fa fa-star" id="star-4"></i>
                            <i class="fa fa-star" id="star-5"></i>
                        </div>
                        <form action="#" class="review-form">
                            <textarea name="" id="" cols="25" rows="3" placeholder="Your Review"></textarea>
                        </form>
                    </div>
                </div>

            </div>
            <div class="text-center pt-2 pb-3">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Later
                </button>
                <button class="ms-3 btn btn-primary" data-bs-dismiss="modal">
                    Submit Review
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

<script src="<?= htmlspecialchars(URLROOT) ?>js/app.js"></script>

</body>

</html>