<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory System</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <h1>Welcome Back</h1>
            <p class="subtitle">
                Login to your account
            </p>

            <form action="action.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password">
                </div>

                <button type="submit" name="login" class="btn">Login</button>
            </form>

            <p class="auth-link">Don't have an account?<a href="register.php">Register</a></p>
        </div>
    </div>
</body>
</html>