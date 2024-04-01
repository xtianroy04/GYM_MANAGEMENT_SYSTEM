// Function for hiding start and end date input field 
document.addEventListener("DOMContentLoaded", function() {
    const customFields = document.getElementById("customFields");
    const periodSelect = document.querySelector("select[name='period']");
    const allowedValues = ['custom', 'Cash', 'GCash', 'Session'];

    function shouldDisplayCustomFields(value) {
        return allowedValues.includes(value);
    }

    customFields.style.display = shouldDisplayCustomFields(periodSelect.value) ? 'block' : 'none';

    periodSelect.addEventListener("change", function() {
        customFields.style.display = shouldDisplayCustomFields(this.value) ? 'block' : 'none';
    });
});


// Fuction for Clear Button
document.addEventListener("DOMContentLoaded", function() {
});

function clearFilters(currentUrl) {
    window.location.href = currentUrl;
}


// Function for hiding year input field if the start and end date inputed
document.addEventListener("DOMContentLoaded", function() {
    const yearField = document.getElementById("yearField");
    const startMonthInput = document.querySelector("input[name='start_month']");
    const endMonthInput = document.querySelector("input[name='end_month']");

    function toggleYearFieldVisibility() {
        if (startMonthInput.value.trim() !== '' || endMonthInput.value.trim() !== '') {
            yearField.style.display = 'none';
        } else {
            yearField.style.display = '';
        }
    }

    toggleYearFieldVisibility(); 

    startMonthInput.addEventListener("input", toggleYearFieldVisibility);
    endMonthInput.addEventListener("input", toggleYearFieldVisibility);
});


// subscribe form
document.addEventListener('DOMContentLoaded', function() {
    var paymentTypeSelect = document.getElementById('payment_type');
    var transactionCodeField = document.getElementById('transaction_code_field');
    var initialDisplayStyle = transactionCodeField.style.display;
    transactionCodeField.style.display = 'none';

    paymentTypeSelect.addEventListener('change', function() {
        var paymentType = this.value;
        if (paymentType === 'Cash' || paymentType === '' || paymentType === null) {
            transactionCodeField.style.display = 'none';
        } else {
            if (initialDisplayStyle !== 'none') {
                transactionCodeField.style.display = initialDisplayStyle;
            } else {
                transactionCodeField.style.display = 'block'; 
            }
        }
    });
});