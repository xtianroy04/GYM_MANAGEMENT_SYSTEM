function updateDateTime() {
    var now = new Date();
    var formattedDateTime = now.toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }) + ' - ' + now.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour12: true
    });
    document.getElementById('liveDateTime').innerText = formattedDateTime;
}
updateDateTime();
setInterval(updateDateTime, 1000);