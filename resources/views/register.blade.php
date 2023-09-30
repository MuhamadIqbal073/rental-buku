<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<style>
    body {
        background-color: 	#016081;
    }
    .main {
        height: 100vh;
    }
    .register-box {
        width: 500px;
        border: solid;
        padding: 20px;
        background-color: 	#ecf7f7;
        border-radius: 15px;
        border-color: #ecf7f7;
    }
    form div {
        margin-bottom: 15px;
    }
    h2 {
        text-align: center;
    }
</style>
<body>
    
    <div class="main d-flex flex-column justify-content-center align-items-center">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('status'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
        <div class="register-box">
            <h2>Register</h2>
            <form action="" method="post">
                @csrf
                <div>
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div>
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div>
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control">
                </div>
                <div>
                    <label for="address" class="form-label">Adress</label>
                    <textarea name="address" id="address" class="form-control" required></textarea>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary form-control">Register</button>
                </div>
                <div class="text-center">
                    Sudah punya akun?<a href="login">Login</a>
                </div>
            </form>
        </div>    
    </div>    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>