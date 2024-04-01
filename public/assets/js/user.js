function updateCheckboxesFromHiddenField() {
    var capabilitiesText = document.querySelector('input[name="capabilities"]').value;
    var selectedCapabilities = capabilitiesText.split(',').map(function(capability) {
        return capability.trim();
    });

    var checkboxes = document.querySelectorAll('input[name="checkbox[]"]');
    checkboxes.forEach(function(checkbox) {
        switch (checkbox.value) {
            case 'Add New Users':
                checkbox.checked = selectedCapabilities.includes('1');
                break;
            case 'Accept Payments':
                checkbox.checked = selectedCapabilities.includes('2');
                break;
            case 'View Payments':
                checkbox.checked = selectedCapabilities.includes('3');
                break;
            case 'View Report - Checkin':
                checkbox.checked = selectedCapabilities.includes('4');
                break;
            case 'View Report - Members':
                checkbox.checked = selectedCapabilities.includes('5');
                break;
            case 'View Report - Payments':
                checkbox.checked = selectedCapabilities.includes('6');
                break;
            case 'View Report - Cash Flow':
                checkbox.checked = selectedCapabilities.includes('7');
                break;
        }
    });
}

window.onload = function() {
    updateCheckboxesFromHiddenField();
};

function updateHiddenField() {
    var selectedCapabilities = [];
    var checkboxes = document.querySelectorAll('input[name="checkbox[]"]:checked');
    checkboxes.forEach(function(checkbox) {
        switch (checkbox.value) {
            case 'Add New Users':
                selectedCapabilities.push('1');
                break;
            case 'Accept Payments':
                selectedCapabilities.push('2');
                break;
            case 'View Payments':
                selectedCapabilities.push('3');
                break;
            case 'View Report - Checkin':
                selectedCapabilities.push('4');
                break;
            case 'View Report - Members':
                selectedCapabilities.push('5');
                break;
            case 'View Report - Payments':
                selectedCapabilities.push('6');
                break;
            case 'View Report - Cash Flow':
                selectedCapabilities.push('7');
                break;
        }
    });

    document.querySelector('input[name="capabilities"]').value = selectedCapabilities.join(', ');
    
    updateCheckboxesFromHiddenField();
}

var checkboxInputs = document.querySelectorAll('input[name="checkbox[]"]');
checkboxInputs.forEach(function(checkbox) {
    checkbox.addEventListener('click', updateHiddenField);
});
