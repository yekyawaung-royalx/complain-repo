<style>
    @import url('https://fonts.googleapis.com/css?family=Playfair+Display:400,900|Poppins:400,500');

    * {
        margin: 0;
        padding: 0;
        text-decoration: none;
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 0;
        background: #f6f6f6;
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
        height: 100vh;
        margin: auto;
        display: flex;
    }

    img {
        max-width: 100%;
    }

    .app {
        background-color: #fff;
        width: 330px;
        height: 570px;
        margin: 2em auto;
        border-radius: 5px;
        padding: 1em;
        position: relative;
        overflow: hidden;
        box-shadow: 0 6px 31px -2px rgba(0, 0, 0, .3);
    }

    a {
        text-decoration: none;
        color: #257aa6;
    }

    p {
        font-size: 13px;
        color: #333;
        line-height: 2;
    }

    .light {
        text-align: right;
        color: #fff;
    }

    .light a {
        color: #fff;
    }

    .bg {
        width: 400px;
        height: 550px;
        background: #257aa6;
        position: absolute;
        top: -5em;
        left: 0;
        right: 0;
        margin: auto;
        background-image: url("background.jpg");
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        clip-path: ellipse(69% 46% at 48% 46%);
    }

    form {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        text-align: center;
        padding: 2em;
    }

    header {
        width: 220px;
        height: 220px;
        margin: 1em auto;
    }

    form input {
        width: 100%;
        padding: 13px 15px;
        margin: 0.7em auto;
        border-radius: 100px;
        border: none;
        background: rgb(255, 255, 255, 0.3);
        font-family: 'Poppins', sans-serif;
        outline: none;
        color: #fff;
    }

    input::placeholder {
        color: #fff;
        font-size: 13px;
    }

    .inputs {
        margin-top: -4em;
    }

    footer {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        padding: 2em;
        text-align: center;
    }

    button {
        width: 100%;
        padding: 13px 15px;
        border-radius: 100px;
        border: none;
        background: #257aa6;
        font-family: 'Poppins', sans-serif;
        outline: none;
        color: #fff;
    }

    @media screen and (max-width: 640px) {
        .app {
            width: 100%;
            height: 100vh;
            border-radius: 0;
        }

        .bg {
            top: -7em;
            width: 450px;
            height: 95vh;
        }

        header {
            width: 90%;
            height: 250px;
        }

        .inputs {
            margin: 0;
        }

        input,
        button {
            padding: 18px 15px;
        }
    }
</style>
<div class="app">

    <div class="bg"></div>

    <form method="POST" action="{{ route('login') }}" id="login-form">
        @csrf
        <header>
            <img src="https://www.royalx.net/assets/images/logo.webp">
        </header>

        <div class="inputs">
            <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') }}" placeholder="name" required autocomplete="email" autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" placeholder="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <p class="light"><a href="#">Forgot password?</a></p>
        </div>
        <footer>
            <button type="submit" id="login">Continue</button>
            <p>Don't have an account? <a href="#">Sign Up</a></p>
        </footer>


</div>
</form>

<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
