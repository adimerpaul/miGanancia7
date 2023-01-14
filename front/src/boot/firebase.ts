// import { boot } from 'quasar/wrappers'
import { initializeApp } from 'firebase/app'

// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries
import { getAuth, onAuthStateChanged } from 'firebase/auth'
import { getFirestore } from 'firebase/firestore'

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: 'AIzaSyCHuqhfGivu81D7jLSnTrTTRnmdQrsu01I',
  authDomain: 'miganancia-915a2.firebaseapp.com',
  projectId: 'miganancia-915a2',
  storageBucket: 'miganancia-915a2.appspot.com',
  messagingSenderId: '580654082824',
  appId: '1:580654082824:web:7768a485f1bcb1d3741abd',
  measurementId: 'G-T5HSEY4WPF'
}

// Initialize Firebase
const app = initializeApp(firebaseConfig)
const db = getFirestore(app)
const auth = getAuth(app)
const user = auth.currentUser

onAuthStateChanged(auth, (user) => {
  if (user) {
    // User is signed in, see docs for a list of available properties
    // https://firebase.google.com/docs/reference/js/firebase.User
    // const uid = user.uid
    console.log('user', user)
    // ...
  } else {
    console.log('no user')
    // User is signed out
    // ...
  }
})
export { db, auth, user }
// "async" is optional;
// more info on params: https://v2.quasar.dev/quasar-cli/boot-files
// export default boot(async (/* { app, router, ... } */) => {
//   // something to do
// })
