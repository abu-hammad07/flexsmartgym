<!-- loader  -->
<!-- <div class="loader"></div> -->
<!-- / loader -->

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
            <div>
                Copyright © 2024

                <!-- <script>
                                        document.write(new Date().getFullYear())
                                    </script> -->

                | Developed by <a href="https://nrcodex.com/" target="_blank" class="fw-medium">NR Codex</a>
            </div>
            <div class="d-none d-lg-inline-block">

                <a href="/" class="footer-link me-4">Documentation</a>


                <a href="https://nrcodex.com/contact/" target="_blank" class="footer-link d-none d-sm-inline-block">Support</a>

            </div>
        </div>
    </div>
</footer>
<!-- / Footer -->
<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>

<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>

</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js ../assets/vendor/js/core.js -->
<script src="../assets/js/custom/alertTime.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>


<script src="../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../assets/vendor/libs/popper/popper.js"></script>
<script src="../assets/vendor/js/bootstrap.js"></script>
<script src="../assets/vendor/libs/node-waves/node-waves.js"></script>
<script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../assets/vendor/libs/hammer/hammer.js"></script>
<script src="../assets/vendor/libs/i18n/i18n.js"></script>
<script src="../assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="../assets/vendor/js/menu.js"></script>
<!-- endbuild -->
<!-- Vendors JS -->
<script src="../assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
<script src="../assets/vendor/libs/select2/select2.js"></script>

<!-- Main JS -->
<script src="../assets/js/main.js"></script>
<!-- Page JS -->
<script src="../assets/js/form-wizard-numbered.js"></script>
<script src="../assets/js/extended-ui-perfect-scrollbar.js"></script>
<script src="../assets/js/forms-selects.js"></script>


<!-- Loader JS -->
<script>
    window.addEventListener("load", () => {
        const loader = document.querySelector(".loader");

        loader.classList.add("loader-hide");

        loader.addEventListener("transitionend", () => {
            document.body.removeChild("loader");
        })
    })
</script>
<!-- / Loader JS -->



<script>
    document.addEventListener("DOMContentLoaded", function() {
        animateCounter("card1", 3000);
        animateCounter("card2", 3000);
        animateCounter("card3", 3000);
        animateCounter("card4", 3000);
        animateCounter("card5", 3000);
        animateCounter("card6", 3000);
        animateCounter("card7", 3000);
        animateCounter("card8", 1000);
    });

    function animateCounter(cardId, duration) {
        const counterSpan = document.getElementById(cardId).querySelector(".counter");
        const targetValue = parseInt(counterSpan.innerText.replace(/,/g, "")); // Remove commas

        let startTime;

        function updateCounter(timestamp) {
            if (!startTime) startTime = timestamp;

            const progress = timestamp - startTime;
            const progressFraction = progress / duration;

            currentValue = Math.floor(targetValue * progressFraction);

            counterSpan.innerText = formatNumberWithCommas(currentValue);

            if (progress < duration) {
                requestAnimationFrame(updateCounter);
            } else {
                counterSpan.innerText = formatNumberWithCommas(targetValue);
            }
        }

        requestAnimationFrame(updateCounter);
    }

    function formatNumberWithCommas(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>




</body>

</html>