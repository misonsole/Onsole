@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="selectcss/bootstrap-select.css">
<style>
  body
  {
    padding-top: 70px;
  }
</style>
</head>
<body>
<div class="container">
  <div class="form-group">
    <label for="tokens">Key words (data-tokens)</label>
    <select id="tokens" class="selectpicker form-control" multiple data-live-search="true">
      <option data-tokens="first">I actually am called "one"</option>
      <option data-tokens="second">And me "two"</option>
      <option data-tokens="last">I am "three"</option>
    </select>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<script src="selectjs/bootstrap-select.js"></script>
@endsection
