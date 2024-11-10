// Include the HTML code for toast messages
var htmlCode = `
    <div class="snackbar-wrapper-success">
        <div class="snackbar-success">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0,0,256,256"
                style="fill:#40C057;">
                <g fill="#40c057" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
                    stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
                    font-family="none" font-weight="none" font-size="none" text-anchor="none"
                    style="mix-blend-mode: normal">
                    <g transform="scale(10.66667,10.66667)">
                        <path
                            d="M12,2c-5.523,0 -10,4.477 -10,10c0,5.523 4.477,10 10,10c5.523,0 10,-4.477 10,-10c0,-5.523 -4.477,-10 -10,-10zM10,17.414l-4.707,-4.707l1.414,-1.414l3.293,3.293l7.293,-7.293l1.414,1.414z">
                        </path>
                    </g>
                </g>
            </svg>
            <p>مہر بانی کرکے ڈیٹا ایڈ کریں ۔</p>
        </div>
    </div>

    <div class="snackbar-wrapper-danger">
        <div class="snackbar-danger">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 48 48">
                <linearGradient id="wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1" x1="9.858" x2="38.142" y1="9.858"
                    y2="38.142" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#f44f5a"></stop>
                    <stop offset=".443" stop-color="#ee3d4a"></stop>
                    <stop offset="1" stop-color="#e52030"></stop>
                </linearGradient>
                <path fill="url(#wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1)"
                    d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                <path
                    d="M33.192,28.95L28.243,24l4.95-4.95c0.781-0.781,0.781-2.047,0-2.828l-1.414-1.414	c-0.781-0.781-2.047-0.781-2.828,0L24,19.757l-4.95-4.95c-0.781-0.781-2.047-0.781-2.828,0l-1.414,1.414	c-0.781,0.781-0.781,2.047,0,2.828l4.95,4.95l-4.95,4.95c-0.781,0.781-0.781,2.047,0,2.828l1.414,1.414	c0.781,0.781,2.047,0.781,2.828,0l4.95-4.95l4.95,4.95c0.781,0.781,2.047,0.781,2.828,0l1.414-1.414	C33.973,30.997,33.973,29.731,33.192,28.95z"
                    opacity=".05"></path>
                <path
                    d="M32.839,29.303L27.536,24l5.303-5.303c0.586-0.586,0.586-1.536,0-2.121l-1.414-1.414	c-0.586-0.586-1.536-0.586-2.121,0L24,20.464l-5.303-5.303c-0.586-0.586-1.536-0.586-2.121,0l-1.414,1.414	c-0.586,0.586-0.586,1.536,0,2.121L20.464,24l-5.303,5.303c-0.586,0.586-0.586,1.536,0,2.121l1.414,1.414	c0.586,0.586,1.536,0.586,2.121,0L24,27.536l5.303,5.303c0.586,0.586,1.536,0.586,2.121,0l1.414-1.414	C33.425,30.839,33.425,29.889,32.839,29.303z"
                    opacity=".07"></path>
                <path fill="#fff"
                    d="M31.071,15.515l1.414,1.414c0.391,0.391,0.391,1.024,0,1.414L18.343,32.485	c-0.391,0.391-1.024,0.391-1.414,0l-1.414-1.414c-0.391-0.391-0.391-1.024,0-1.414l14.142-14.142	C30.047,15.124,30.681,15.124,31.071,15.515z">
                </path>
                <path fill="#fff"
                    d="M32.485,31.071l-1.414,1.414c-0.391,0.391-1.024,0.391-1.414,0L15.515,18.343	c-0.391-0.391-0.391-1.024,0-1.414l1.414-1.414c0.391-0.391,1.024-0.391,1.414,0l14.142,14.142	C32.876,30.047,32.876,30.681,32.485,31.071z">
                </path>
            </svg>
            <p>مہر بانی کرکے ڈیٹا ایڈ کریں ۔</p>
        </div>
    </div>

    <div class="snackbar-wrapper-warning">
        <div class="snackbar-warning">
            <img width="20" height="20" src="https://img.icons8.com/metro/20/FAB005/high-importance.png"
                alt="high-importance" />
            <p>مہر بانی کرکے ڈیٹا ایڈ کریں ۔</p>
        </div>
    </div>
`;

// Append the HTML code to the body
document.body.innerHTML += htmlCode;

var toastTimeout; // Global variable to hold the timeout for hiding the toast

function showToast(type, message) {
  var bar = document.querySelector(".snackbar-wrapper-" + type);

  return new Promise((resolve) => {
    bar.style.display = "block";
    setTimeout(() => {
      bar.style.opacity = 1;
      bar.style.top = "3vh"; // Adjust this value
      var messageElement = bar.querySelector(".snackbar-" + type + " p");
      messageElement.textContent = message;
      resolve();
    }, 10);
  });
}

function hideToast(type) {
  var bar = document.querySelector(".snackbar-wrapper-" + type);

  return new Promise((resolve) => {
    bar.style.opacity = 0;
    bar.style.top = "-5vh"; // Adjust this value
    setTimeout(() => {
      bar.style.display = "none";
      resolve();
    }, 700);
  });
}

function pauseToast() {
  clearTimeout(toastTimeout); // Clear the timeout to pause the hiding process
}

function resumeToast(type) {
  clearTimeout(toastTimeout); // Clear the timeout to pause the hiding process
  toastTimeout = setTimeout(() => {
    hideToast(type);
  }, 3000); // Continue hiding after 3 seconds (or adjust as needed)
}

function displayToast(type, message) {
  showToast(type, message).then(() => {
    resumeToast(type);
  });
}

// Attach event listeners for pause and resume to all types of toasts
document.addEventListener("DOMContentLoaded", function () {
  var types = ["danger", "warning", "success"];

  types.forEach(function (type) {
    var bar = document.querySelector(".snackbar-wrapper-" + type);

    bar.addEventListener("mouseenter", pauseToast); // Pause when hovering
    bar.addEventListener("mouseleave", function () {
      resumeToast(type);
    }); // Resume when hover ends
  });
});
