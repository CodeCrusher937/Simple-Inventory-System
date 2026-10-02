<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register -Simple Inventory System</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="auth-container">
        <div class="auth-card">
            <h1>Create Account</h1>
            <p class="subtitle">
                Register as a customer
            </p>
            <form action="action.php" method="POST">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name"  placeholder="Enter your full name">
                </div>

                <div class="form-group">
<label for="phone">Phone Number</label>
<input type="tel" id="phone" name="phone" placeholder="Enter your phone number">
       </div>

    <div class="form-group">
   <label for="email">Email</label>
   <input type="email" id="email" name="email" placeholder="Enter your email">
                </div>

         <div class="form-group">
    <label for="password">Password</label>
  <input type="password" id="password" name="password" placeholder="Enter your password">
                </div>

         <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
  <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password">
                </div>

                <button type="submit" name="register" class="btn">
                    Register
                </button>

            </form>

            <p class="auth-link">Already have an account?<a href="login.php">Login</a>
            </p>
        </div>
    </div>
</body>
</html>