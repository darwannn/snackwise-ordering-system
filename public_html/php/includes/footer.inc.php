    <!-- Back to Top -->
    <button class="toTop"><i class="fa fa-chevron-up"></i></button>

    <!-- Footer -->
    <div class="footer">
        &copy; <script>
            document.write(new Date().getFullYear());
        </script> SL Visuals. All Rights Reserved.
    </div>

    <script>
        /* Navigation Bar */
        let toggleButton = document.querySelectorAll('.navigationToggle')[0];
        let nav = document.querySelectorAll('.navigationLinks');
        toggleButton.addEventListener('click', function () {
            for (var i = 0; i < nav.length; i++) {
                nav[i].classList.toggle('navigationToggled');
            }

            let divider = document.querySelectorAll(".divider");
            console.log(divider.length);
            for (var i = 0; i < divider.length; i++) {
                divider[i].classList.toggle("dividerStyle");
                console.log(i);
            }
        });

        /* Back to Top */
            let totop = document.querySelector(".toTop");
            let stickyNavigation = document.querySelector(".navigationContainer");
            totop.addEventListener("click", () => {
                console.log("click");
                window.scrollTo({
                    top: 0,
                    left: 0,
                    behavior: "smooth"
                });
            });

            window.addEventListener("scroll", function () {
                let scroll = this.scrollY;
                if (scroll < 100) {
                    totop.style.visibility = "hidden";
                    totop.style.opacity = "0";
                } else {
                    totop.style.visibility = "visible";
                    totop.style.opacity = "1";
                }
            });
    </script>