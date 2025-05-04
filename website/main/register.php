<?php require_once "bootstrap.php"; ?>
<?php include("server.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style1.css">
</head>
<body>
  <div class="text-center" style="padding: 20px">
    <h2>Register</h2>
  </div>

  <div style="padding-left: 40px; padding-right: 50%;">
    <form method="post" action="register.php">
      <?php include('errors.php'); ?>
      
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Username</label>
          <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
        </div>

        <div class="form-group col-md-6">
          <label>Email</label>
          <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
        </div>

        <div class="form-group col-md-6">
          <label>Password</label>
          <input type="password" class="form-control" name="password_1" placeholder="Password">
        </div>

        <div class="form-group col-md-6">
          <label>Confirm Password</label>
          <input type="password" class="form-control" name="password_2" placeholder="Confirm Password">
        </div>

        <div class="form-group col-md-6">
          <label>Address</label>
          <input type="text" class="form-control" name="address_1" placeholder="1234 Main St" value="<?php echo isset($address_1) ? htmlspecialchars($address_1) : ''; ?>">
        </div>

        <div class="form-group col-md-6">
          <label>Address 2</label>
          <input type="text" class="form-control" name="address_2" placeholder="Apartment, studio, or floor" value="<?php echo isset($address_2) ? htmlspecialchars($address_2) : ''; ?>">
        </div>

        <div class="form-group col-md-6">
          <label>City</label>
          <input type="text" class="form-control" name="city" value="<?php echo isset($city) ? htmlspecialchars($city) : ''; ?>">
        </div>

        <div class="form-group col-md-4">
          <label>State</label>
          <select name="state" class="form-control">
            <option value="" selected>Choose...</option>
            <option>Bihar</option>
            <option>Jammu & Kashmir</option>
            <option>Karnataka</option>
            <option>Jharkhand</option>
            <option>Orissa</option>
            <option>Gujarat</option>
            <option>Madhya Pradesh</option>
            <option>Uttar Pradesh</option>
            <option>Tamil Nadu</option>
            <option>Telangana</option>
            <option>Andhra Pradesh</option>
            <option>Uttarakhand</option>
            <option>Kerala</option>
            <option>Haryana</option>
            <option>Punjab</option>
            <option>West Bengal</option>
            <option>Arunachal Pradesh</option>
          </select>
        </div>

        <div class="form-group col-md-2">
          <label>Zip</label>
          <input type="text" class="form-control" name="zip" value="<?php echo isset($zip) ? htmlspecialchars($zip) : ''; ?>">
        </div>

        <div class="form-group col-md-6">
          <button type="submit" class="btn btn-primary" name="reg_user">Register</button>
        </div>

        <div class="form-group col-md-6">
          Already a member? <a href="index.php">Sign in</a>
        </div>
      </div>
      
    </form>
  </div>
</body>
</html>
