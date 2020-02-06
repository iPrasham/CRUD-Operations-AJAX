<div class="container" id="loginDiv">
<h1>Login here:</h1>
<form method="post">
  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" class="form-control" name="email" id="loginEmail" aria-describedby="emailHelp" required>
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    <span id="loginEmailError"></span>
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" class="form-control" id="loginPassword" required>
    <span id="loginPasswordError"></span>
  </div>
  <button type="button" name="login"  id="loginButton" class="btn btn-primary">Submit</button>
</form>
</div>

