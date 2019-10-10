// Get Instance ID token. Initially this makes a network call, once retrieved
// subsequent calls to getToken will return from cache.
messaging.getToken().then(function(currentToken) {
	if (currentToken) {
		console.log(currentToken);
		updateUIForPushEnabled(currentToken);
	} else {
		// Show permission request.
		console.log('No Instance ID token available. Request permission to generate one.');
		// Show permission UI.
		updateUIForPushPermissionRequired();
		setTokenSentToServer(false);
	}
}).catch(function(err) {
	console.log('An error occurred while retrieving token. ', err);
	showToken('Error retrieving Instance ID token. ', err);
	setTokenSentToServer(false);
});
function setTokenSentToServer(sent) {
	window.localStorage.setItem('sentToServer', sent ? '1' : '0');
}