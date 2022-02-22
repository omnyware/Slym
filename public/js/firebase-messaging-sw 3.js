importScripts('https://www.gstatic.com/firebasejs/6.3.4/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/6.3.4/firebase-messaging.js');
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
console.log('Worke')
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = 'Olá tudo certo meu amigo';
  const notificationOptions = {
    body: 'Quem acredita sempre alcanca.',
    icon: '/firebase-logo.png'
  };

  return self.registration.showNotification(notificationTitle,
    notificationOptions);
});
