<?php
// Default values (for when search loads)
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$depart = $_GET['depart'] ?? '';
$trip = $_GET['trip'] ?? 'round';
$adults = $_GET['adults'] ?? 1;
$children = $_GET['children'] ?? 0;
$infants = $_GET['infants'] ?? 0;
$classType = $_GET['class'] ?? 'Economy';
?>

<div class="relative w-full max-w-6xl mx-auto -mt-24 z-20">
    <div class="bg-white rounded-2xl shadow-xl p-6">

        <!-- TRIP TYPE -->
        <div class="flex gap-6 mb-4 text-gray-700">
            <label><input type="radio" name="trip" value="round" checked> Round-trip</label>
            <label><input type="radio" name="trip" value="oneway"> One-way</label>
            <label><input type="radio" name="trip" value="multi"> Multi-city</label>
            <label><input type="checkbox" id="nonstop"> Nonstop</label>
        </div>

        <!-- FORM -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

            <!-- From -->
            <div>
                <label class="block text-sm font-semibold mb-1">From</label>
                <input type="text" id="from" value="<?= $from ?>" class="input-box" placeholder="City or airport">
            </div>

            <!-- To -->
            <div>
                <label class="block text-sm font-semibold mb-1">To</label>
                <input type="text" id="to" value="<?= $to ?>" class="input-box" placeholder="City or airport">
            </div>

            <!-- Travel Date -->
            <div>
                <label class="block text-sm font-semibold mb-1">Travel Date</label>
                <input type="text" id="depart" value="<?= $depart ?>" class="input-box" placeholder="dd/mm/yyyy">
            </div>

            <!-- Passengers -->
            <div class="relative">
                <label class="block text-sm font-semibold mb-1">Travelers</label>

                <button id="travelerBtn" class="input-box flex justify-between items-center">
                    <span id="travelerText"><?= $adults ?> Adult — <?= $classType ?></span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>

                <!-- DROPDOWN -->
                <div id="travelerDropdown"
                     class="hidden absolute w-full bg-white rounded-xl shadow-xl p-4 mt-2 z-40">

                    <p class="text-sm mb-2">Select exact passengers</p>

                    <!-- Adults -->
                    <div class="flex justify-between mb-3">
                        <span>Adults</span>
                        <div class="flex items-center gap-3">
                            <button class="minus" data-type="adults">−</button>
                            <span id="adults"><?= $adults ?></span>
                            <button class="plus" data-type="adults">+</button>
                        </div>
                    </div>

                    <!-- Children -->
                    <div class="flex justify-between mb-3">
                        <span>Children</span>
                        <div class="flex items-center gap-3">
                            <button class="minus" data-type="children">−</button>
                            <span id="children"><?= $children ?></span>
                            <button class="plus" data-type="children">+</button>
                        </div>
                    </div>

                    <!-- Infants -->
                    <div class="flex justify-between mb-3">
                        <span>Infants</span>
                        <div class="flex items-center gap-3">
                            <button class="minus" data-type="infants">−</button>
                            <span id="infants"><?= $infants ?></span>
                            <button class="plus" data-type="infants">+</button>
                        </div>
                    </div>

                    <!-- Class -->
                    <div class="mt-4">
                        <label class="text-sm">Class</label>
                        <select id="classType" class="input-box">
                            <option>Economy</option>
                            <option>Premium Economy</option>
                            <option>Business</option>
                            <option>First Class</option>
                        </select>
                    </div>

                    <button id="travelerDone"
                        class="w-full bg-blue-600 text-white p-2 rounded-lg mt-4 hover:bg-blue-700">
                        Done
                    </button>

                </div>
            </div>

            <!-- SEARCH BUTTON -->
            <div class="flex items-end">
                <button id="searchBtn"
                    class="w-full bg-blue-600 text-white p-3 rounded-xl hover:bg-blue-700">
                    🔍 Search
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.input-box {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #dfe3e6;
    background: #f9fafb;
}
.plus, .minus {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #eef1f4;
    display: flex;
    justify-content: center;
    align-items: center;
}
.plus:hover, .minus:hover {
    background: #dbe2e8;
}
</style>

<script>
let dropdown = document.getElementById("travelerDropdown");
let travelerBtn = document.getElementById("travelerBtn");
let travelerText = document.getElementById("travelerText");

travelerBtn.onclick = () => dropdown.classList.toggle("hidden");

// Close dropdown
document.addEventListener("click", function(event) {
    if (!travelerBtn.contains(event.target) &&
        !dropdown.contains(event.target)) {
        dropdown.classList.add("hidden");
    }
});

// Update counts
document.querySelectorAll(".plus").forEach(btn => {
    btn.onclick = () => updateCount(btn.dataset.type, 1);
});
document.querySelectorAll(".minus").forEach(btn => {
    btn.onclick = () => updateCount(btn.dataset.type, -1);
});

function updateCount(type, delta) {
    let span = document.getElementById(type);
    let value = Math.max(0, parseInt(span.textContent) + delta);
    span.textContent = value;
}

document.getElementById("travelerDone").onclick = () => {
    let a = document.getElementById("adults").textContent;
    let c = document.getElementById("children").textContent;
    let i = document.getElementById("infants").textContent;
    let cls = document.getElementById("classType").value;

    travelerText.textContent = `${a} Adult — ${cls}`;
    dropdown.classList.add("hidden");
};

// Build URL
document.getElementById("searchBtn").onclick = () => {
    let url =
        "flights-result.php?" +
        "from=" + encodeURIComponent(document.getElementById("from").value) +
        "&to=" + encodeURIComponent(document.getElementById("to").value) +
        "&depart=" + encodeURIComponent(document.getElementById("depart").value) +
        "&adults=" + document.getElementById("adults").textContent +
        "&children=" + document.getElementById("children").textContent +
        "&infants=" + document.getElementById("infants").textContent +
        "&class=" + encodeURIComponent(document.getElementById("classType").value);

    window.location.href = url;
};
</script>
