<!DOCTYPE html>
<html>
<head>
<title>Bootstrap-select</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
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
  <form action="{{url('bookss')}}" method="post" enctype="multipart/form-data" class="w-100">
    @csrf
    <div class="form-group">
      <label for="tokens">Key words</label>
      <select name="tokens[]" id="tokens" class="selectpicker form-control" multiple data-live-search="true">
        <option value="first" data-tokens="first">I actually am called "one"</option>
        <option value="second" data-tokens="second">And me "two"</option>
        <option value="last" data-tokens="last">I am "three"</option>
      </select>
    </div>
    <button type="submit">Submit</button>
  </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<script src="selectjs/bootstrap-select.js"></script>
</body>
</html>
