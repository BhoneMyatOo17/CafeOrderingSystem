<style type="text/css">
    nav{
        box-shadow: none !important;
    }
    footer{
        padding-top: 30px;
    }
</style>
<footer class="mastfoot pb-5 bg-white section-padding pb-0">
            <div class="inner container">
                 <div class="row">
                    <div class="col-lg-4">
                        <div class="footer-widget pr-lg-5 pr-0">
                            <img src="img/logo.png" class="img-fluid footer-logo mb-3" alt="">
                            <p>©The Urban Brew Cafe | Silom, Bangkok<br>
                                Brewed with passion. Served with care.<br>
                                📍 Visit us or order online anytime.<br>
                                📞 Contact: info@theurbanbrew.co.th<br><br>
                                🌐 Follow us:</p>
                            <nav class="nav nav-mastfoot justify-content-start">
                                <a class="nav-link" href="https://facebook.com" target='_blank'>
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a class="nav-link" href="https://twitter.com" target='_blank'>
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a class="nav-link" href="https://instagram.com" target='_blank'>
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a class="nav-link" href="https://www.line.me/en/" target='_blank'>
                                    <i class="fab fa-line"></i>
                                </a>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="footer-widget px-lg-5 px-0">
                            <h4>Open Hours</h4>
                            <ul class="list-unstyled open-hours">
                                <li class="d-flex justify-content-between"><span>Monday</span><span>10:00 - 22:00</span></li>
                                <li class="d-flex justify-content-between"><span>Tuesday</span><span>10:00 - 22:00</span></li>
                                <li class="d-flex justify-content-between"><span>Wednesday</span><span>10:00 - 22:00</span></li>
                                <li class="d-flex justify-content-between"><span>Thursday</span><span>10:00 - 22:00</span></li>
                                <li class="d-flex justify-content-between"><span>Friday</span><span>10:00 - 24:00</span></li>
                                <li class="d-flex justify-content-between"><span>Saturday</span><span>10:00 - 24:00</span></li>
                                <li class="d-flex justify-content-between"><span>Sunday</span><span> 10:00 - 24:00</span></li>
                              </ul>
                        </div>
                    </div>

                    <div class="col-lg-4">
    <div class="footer-widget pl-lg-5 pl-0">
        <h4>Subscribe to our LINE</h4>
        <p>Sign up to our LINE for latest updates and promotions</p>
        <form id="newsletter" onsubmit="return validateLineForm()">
            <div class="form-group">
                <div id="lineError" class="text-danger small mb-2" style="display: none;"></div>
                <input type="text" class="form-control" id="lineId" aria-describedby="lineIdHelp" placeholder="Enter Line ID">
                <small id="lineIdHelp" class="form-text text-muted">Your LINE ID or phone number</small>
            </div>
            <button type="submit" class="btn btn-primary w-100">Subscribe</button>
        </form>
    </div>
</div>

<script>
function validateLineForm() {
    const lineId = document.getElementById('lineId').value.trim();
    const errorElement = document.getElementById('lineError');
    
    errorElement.style.display = 'none';
    
    if (lineId === '') {
        errorElement.textContent = 'Please enter your LINE ID';
        errorElement.style.display = 'block';
        return false;
    }
    
    alert('Thanks for Subscribing.\nYou will receive a message on LINE');
    
    return true;
}

document.getElementById('lineId').addEventListener('input', function() {
    const errorElement = document.getElementById('lineError');
    if (this.value.trim() !== '') {
        errorElement.style.display = 'none';
    }
});
</script>
                    <div class="col-md-12 d-flex align-items-center">
                        <p class="mx-auto text-center mb-0">Copyright 2025 &copy;The Urban Brew. All Right Reserved.</p>
                    </div>
                </div>
            </div>
        </footer>