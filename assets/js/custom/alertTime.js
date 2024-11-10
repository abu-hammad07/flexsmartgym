document.addEventListener('DOMContentLoaded', function() {
    var alertElement = document.getElementById('successAlert');
    var timestampElement = document.getElementById('timestamp');
    
    // Function to update countdown timer
    function updateTimer(remainingTime) {
        timestampElement.textContent = `(${remainingTime} seconds remaining)`;
    }

    // Start countdown timer
    var remainingTime = 5;
    updateTimer(remainingTime);
    var timerInterval = setInterval(function() {
        remainingTime--;
        if (remainingTime > 0) {
            updateTimer(remainingTime);
        } else {
            clearInterval(timerInterval);
            alertElement.classList.add('fade');
            setTimeout(function() {
                alertElement.style.display = 'none';
            }, 1000); // fade duration is 1 second, so hiding after 1 second
        }
    }, 1000); // Update timer every second
});



// document.addEventListener('DOMContentLoaded', function() {
//     var alertErrorElement = document.getElementById('errorAlert');
//     var timestampErrorElement = document.getElementById('timestampError');
    
//     // Function to update countdown timer
//     function updateTimer(remainingTime) {
//         timestampErrorElement.textContent = `(${remainingTime} seconds remaining)`;
//     }

//     // Start countdown timer
//     var remainingTime = 5;
//     updateTimer(remainingTime);
//     var timerInterval = setInterval(function() {
//         remainingTime--;
//         if (remainingTime > 0) {
//             updateTimer(remainingTime);
//         } else {
//             clearInterval(timerInterval);
//             alertErrorElement.classList.add('fade');
//             setTimeout(function() {
//                 alertErrorElement.style.display = 'none';
//             }, 1000); // fade duration is 1 second, so hiding after 1 second
//         }
//     }, 1000); // Update timer every second
// });