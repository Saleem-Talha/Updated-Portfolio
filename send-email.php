 
    <script type="text/javascript">
        (function () {
            // Initialize EmailJS with your User ID
            emailjs.init("atbjzS86Oz4CLJb9-");
        })();

        // Function to send the email
        // Function to send the email
        function sendEmail() {
            // Access form field values using the ids
            var usernameValue = document.getElementById("username").value;
            var emailValue = document.getElementById("email").value;
            var messageValue = document.getElementById("message").value;

            // Clear the form field values
            document.getElementById("username").value = "";
            document.getElementById("email").value = "";
            document.getElementById("message").value = "";

            // Create an emailjs template and send the email using the values
            emailjs.send("service_en14tt4", "template_ssym22n", {
                username: usernameValue,
                email: emailValue,
                message: messageValue
            })
                .then(function (response) {
                    console.log("Email sent successfully:", response);
                    alert('Thanks for visiting my site! Your message has been sent.');
                }, function (error) {
                    console.log("Email send failed:", error);
                    alert('Sorry, there was an error sending your message. Please try again later.');
                });
        }


    </script>