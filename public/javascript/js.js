function updateLabel() {
    var checkbox = document.getElementById("is_registered");
    var label = document.getElementById("registrationLabel");

    if (checkbox.checked) {
        checkbox.value = 1;
        label.innerHTML = 'Registračné číslo: <span class="text-danger">*</span>';
    } else {
        checkbox.value = 0;
        label.innerHTML = 'Registračné číslo: ';
    }
}

