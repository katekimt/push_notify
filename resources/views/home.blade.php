@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <button onclick="startFCM()"
                        class="btn btn-danger btn-flat">Allow notification
                </button>
                <div class="card mt-3">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="{{ route('send.web-notification') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label>Message Title</label>
                                <input type="text" class="form-control" name="title">
                            </div>
                            <div class="form-group">
                                <label>Message Body</label>
                                <textarea class="form-control" name="body"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Send Notification</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        // Import the functions you need from the SDKs you need
        import { initializeApp } from "https://www.gstatic.com/firebasejs/9.14.0/firebase-app.js";
        import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.14.0/firebase-analytics.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
            apiKey: "AIzaSyD1zoNFMiCQ8KxRy5pstYEAyk_Zq8rzUeE",
            authDomain: "test-prod-7747e.firebaseapp.com",
            projectId: "test-prod-7747e",
            storageBucket: "test-prod-7747e.appspot.com",
            messagingSenderId: "984102062791",
            appId: "1:984102062791:web:03fee6769dd9dc90e38ce2",
            measurementId: "G-8X99266TGL"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const analytics = getAnalytics(app);
    </script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <script>
        let firebaseConfig = {
            apiKey: "AIzaSyD1zoNFMiCQ8KxRy5pstYEAyk_Zq8rzUeE",
            authDomain: "test-prod-7747e.firebaseapp.com",
            projectId: "test-prod-7747e",
            storageBucket: "test-prod-7747e.appspot.com",
            messagingSenderId: "984102062791",
            appId: "1:984102062791:web:03fee6769dd9dc90e38ce2",
            measurementId: "G-8X99266TGL"
        };
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        function startFCM() {
            messaging.requestPermission().then(function () {
                return messaging.getToken()
            }).then(function(token) {

                axios.post("{{ route('store.token') }}",{
                    _method:"POST",
                    token
                }).then(({data})=>{
                    console.log(data)
                }).catch(({response:{data}})=>{
                    console.error(data)
                })

            }).catch(function (err) {
                console.log(`Token Error :: ${err}`);
            });
        }

        messaging.onMessage(function (payload) {
            const title = payload.notification.title;
            const options = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(title, options);
        });
    </script>
@endsection
