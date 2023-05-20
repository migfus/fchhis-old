<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
</head>
<body>
    <center>
      <div>
        <img src="https://fchhis.migfus20.com/images/logo.png" alt="" style="width: 70px; height: 70px; margin-bottom: 20px">
      </div>
      <div>
        Password Recovery Link:
        <a href="{{$data['link']}}" target="_blank" style="background: #F2F2F2; margin-left: .5em">
          {{ $data['link'] }}
        </a>
      </div>
      <div>
        Password Recovery Code:
        <span style="background: #F2F2F2; margin-left: .5em">{{ $data['code'] }}</span>
      </div>
      <br>
      <div>
        If it's not you, someone is trying to access or accidentaly used your email.
      </div>
    </center>
</body>
</html>
