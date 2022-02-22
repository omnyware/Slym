var firebaseConfig = {
	apiKey: "AIzaSyDiSXAP4tJT0ud03dxdlq3ul-0OnrdyMpA",
	authDomain: "hungeron-10bb4.firebaseapp.com",
	databaseURL: "https://hungeron-10bb4.firebaseio.com",
	projectId: "hungeron-10bb4",
	storageBucket: "hungeron-10bb4.appspot.com",
	messagingSenderId: "1067829254496",
	appId: "1:1067829254496:web:4e95fbde248916a0b16605",
	measurementId: "G-5J9R2WC9EV"
};

firebase.initializeApp(firebaseConfig);


const m = firebase.messaging();

m.requestPermission()
.then(function(){

	return m.getToken();

})
.then(function(token){

	var log = $('#log').val()
	let js = {
		token: token,
		cliente_logado: log
	}


	$.get(path+'autenticar/saveTokenWeb', js)
	.done((suc) => {

	})
	.fail((err) => {
		console.log(err)
	})
})
.catch(function(err){
	console.log(err)
})
