importScripts('https://www.gstatic.com/firebasejs/4.8.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/4.8.1/firebase-messaging.js');

// Initialize Firebase
var config = {
  apiKey: "AIzaSyDa3HeGmJKz6rHUYYL41GAH4e74KWRi4-U",
  authDomain: "cms-alarm.firebaseapp.com",
  databaseURL: "https://cms-alarm.firebaseio.com",
  projectId: "cms-alarm",
  storageBucket: "cms-alarm.appspot.com",
  messagingSenderId: "976556625928",
  appId: "1:976556625928:web:a3df6e1e9839699cdcc1bd"
};
firebase.initializeApp(config);

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload){

    const title = "Hello World";
    const options = {
            body: payload.data.status
    };

    return self.registration.showNotification(title,options);
});
