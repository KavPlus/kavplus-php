// Save search params
function goToResults() {
    let d = {
        from: document.getElementById("fromInput").value,
        to: document.getElementById("toInput").value,
        depart: document.getElementById("departDate").value,
        ret: document.getElementById("returnDate").value,
        pax: document.getElementById("passengers").value
    };

    localStorage.setItem("searchData", JSON.stringify(d));
    window.location = "flights-result.php";
}

// Save selected flight
function selectFlight(airline, price, duration) {
    let data = { airline, price, duration };
    localStorage.setItem("selectedFlight", JSON.stringify(data));
    window.location = "booking.php";
}

// Save booking details
function continueToPayment() {
    let d = {
        name: document.getElementById("fullName").value,
        email: document.getElementById("email").value,
        passport: document.getElementById("passport").value,
    };

    localStorage.setItem("bookingData", JSON.stringify(d));
    window.location = "payment.php";
}

// Save payment info
function completePayment() {
    let card = document.getElementById("cardNumber").value;
    localStorage.setItem("paymentCard", card);
    window.location = "booking-confirmed.php";
}
