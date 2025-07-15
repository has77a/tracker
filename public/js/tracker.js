(function(){
    const TRACKER_ENDPOINT = '/api/collect';

    function sendVisit() {
        const params = new URLSearchParams({
            page: window.location.pathname,
            timestamp: Date.now().toString()
        });

        fetch(TRACKER_ENDPOINT + '?' + params.toString(), {
            method: 'GET',
            keepalive: true
        }).catch(console.error);
    }

    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        sendVisit();
    } else {
        window.addEventListener('DOMContentLoaded', sendVisit);
    }
})();
