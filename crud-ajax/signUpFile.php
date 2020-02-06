<div class="container" id="signUpDiv">
<form id="ajaxForm" method="post" >
   <div class="form-group">
    <label for="name">Name</label>
    <input type="name" class="form-control" id="name"  name="name" aria-describedby="emailHelp" placeholder="Enter name" required>
    <span id="nameError"></span>
  </div>
  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    <span id="signUpEmailError"></span>
  </div> 
  <div class="form-group">
    <label for="phone">Phone</label>
    <input type="text" class="form-control" id="phone"  name="phone"  placeholder="Enter phone" required>
    <span id="phoneError"></span>
  </div>

  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" class="form-control" aria-describedby="passwordHelp" id="password" placeholder="Password" required>
    <small id="passwordHelp" class="form-text text-muted">Password should be more than 8 characters containing atleast 1 special character, atleast 1 digit, atleast 1 small letter and atleast 1 capital letter.</small>
    <span id="signUpPasswordError"></span>
  </div>
  <button type="button" id="signUpButton" name="submit" class="btn btn-primary">Submit</button>
</form>
</div>

